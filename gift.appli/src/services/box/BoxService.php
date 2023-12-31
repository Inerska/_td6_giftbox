<?php

declare(strict_types=1);

namespace gift\app\services\box;

use Exception;
use gift\app\models\Box;
use gift\app\models\Prestation;
use gift\app\services\PrestationNotFoundException;
use gift\app\services\PrestationsService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Ramsey\Uuid\Uuid;
use UserHasAlreadyBoxException;

final class BoxService
{
    private static ?BoxService $instance = null;

    private function __construct()
    {
    }

    /**
     * @return BoxService
     */
    public static function getInstance(): BoxService
    {
        if (self::$instance === null) {
            self::$instance = new BoxService();
        }

        return self::$instance;
    }

    public static function getById(string $id): Box
    {
        try {
            return Box::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new PrestationNotFoundException('Coffret inconnu: ' . $id);
        }
    }

    public static function removeService(string $box_id, string $presta_id): array
    {
        $box = Box::findOrFail($box_id);

        $box->prestations()->detach($presta_id);

        $box->load('prestations');

        $_SESSION['box'] = $box;

        return $box->prestations->toArray();
    }

    /**
     * @throws Exception if data is invalid
     */
    public static function create(array $data): Box
    {
        if (isset($_SESSION['box'])) {
            throw new UserHasAlreadyBoxException('Box already exists');
        }

        if (!isset($data['name']) || !isset($data['description'])) {
            throw new Exception('Invalid data: name or description or montant or image or category_id not provided');
        }

        $name = htmlspecialchars($data['name']);
        $description = htmlspecialchars($data['description']);
        $montant = $data['montant'] ?? 0;
        $statut = $data['statut'] ?? Box::CREATED;
        $message = htmlspecialchars($data['message']) ?? '';

        if ($name !== $data['name'] || $description !== $data['description']) {
            throw new Exception('Invalid data: name or description or montant or statut or category_id contains invalid characters');
        }

        $box = Box::create(['id' => Uuid::uuid4()->toString(), 'token' => base64_encode($name), 'libelle' => $name, 'description' => $description, 'montant' => $montant, 'statut' => $statut, 'message' => $message]);

        $box->save();

        $_SESSION['box'] = $box;

        return $box;
    }

    /**
     * @throws PrestationNotFoundException
     */
    public static function payBox($boxId)
    {
        $box = self::getById($boxId);

        if ($box === null) {
            throw new Exception("Box not found.");
        }

        $box->paid = true;

        $box->save();

        $_SESSION['box'] = $box;
        $_SESSION['box']['paid'] = true;

        return true;
    }

    public static function isPaid(): bool
    {
        if (!isset($_SESSION['box'])) {
            return false;
        }

        return $_SESSION['box']['paid'] ?? false;
    }

    /**
     * @throws PrestationNotFoundException
     */
    public static function updatePrestationQuantity(string $cartId, string $prestaId, int $quantity): bool
    {
        $box = self::getById($cartId);

        if (!$box->prestations()->where('presta_id', $prestaId)->exists()) {
            throw new PrestationNotFoundException('Prestation not found in box: ' . $prestaId);
        }

        $box->prestations()->updateExistingPivot($prestaId, ['quantite' => $quantity]);

        $_SESSION['box'] = $box;

        return true;
    }



    public function addService(string $serviceId, string $boxId, int $quantity): bool
    {
            try {
            $box = Box::findOrFail($boxId);
        } catch (ModelNotFoundException $e) {
            throw new Exception('Box not found: ' . $boxId);
        }

        try {
            $service = PrestationsService::getPrestationById($serviceId);
        } catch (ModelNotFoundException $e) {
            throw new Exception('Service not found: ' . $serviceId);
        }

        if ($service === null) {
            throw new Exception('Service not found (null): ' . $serviceId);
        }

        if ($box->prestations()->where('presta_id', $serviceId)->exists()) {
            $result = $box->prestations()->updateExistingPivot($serviceId, ['quantite' => $quantity]);

        } else {
            $result = $box->prestations()->attach($serviceId, ['quantite' => $quantity]);
        }


        $box->montant += intval($service['tarif']) * $quantity;
        $box->save();

        $box->load('prestations');
        $_SESSION['box'] = $box;

        return true;
    }

    public function getFormattedCart(): ?array
    {
        $box = $this->cart();

        if (!$box) {
            return null;
        }

        $prestationsCount = [];
        $totalPrice = 0.0;

        foreach ($box->prestations->toArray() as $prestation) {

            $prestationId = $prestation['id'];

            if (!isset($prestationsCount[$prestationId])) {

                $prestationsCount[$prestationId] = [
                    'libelle' => $prestation['libelle'],
                    'tarif' => floatval($prestation['tarif']),
                    'img' => $prestation['img'],
                    'quantite' => 0,
                    'total' => 0.0,
                ];
            }

            $prestationsCount[$prestationId]['quantite'] += $prestation['contenu']['quantite'];
            $prestationsCount[$prestationId]['total'] += floatval($prestation['tarif']) * $prestation['contenu']['quantite'];
            $totalPrice += $prestationsCount[$prestationId]['total'];
        }

        return ['prestations' => $prestationsCount, 'totalPrice' => $totalPrice];
    }



    public function cart(): ?Box
    {
        if (!isset($_SESSION['box'])) {
            return null;
        }

        return $_SESSION['box'];
    }
}