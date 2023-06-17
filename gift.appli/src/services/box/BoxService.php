<?php

declare(strict_types=1);

namespace gift\app\services\box;

use Exception;
use gift\app\models\Box;
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

    public function addService(string $serviceId, string $boxId, int $quantity): bool
    {
        var_dump($serviceId, $boxId, $quantity);

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

    public static function getById(string $id): Box
    {
        try {
            return Box::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new PrestationNotFoundException('Coffret inconnu: ' . $id);
        }
    }

    public static function removeService(array $data): bool
    {
        throw new Exception('Not implemented');
    }

    /**
     * @throws Exception if data is invalid
     */
    public static function create(array $data): Box
    {
        if (isset($_SESSION['box'])) {
            throw new UserHasAlreadyBoxException('Box already exists');
        }

        if (!isset($data['name'])
            || !isset($data['description'])) {
            throw new Exception('Invalid data: name or description or montant or image or category_id not provided');
        }

        $name = htmlspecialchars($data['name']);
        $description = htmlspecialchars($data['description']);
        $montant = $data['montant'] ?? 0;
        $statut = $data['statut'] ?? Box::CREATED;
        $message = htmlspecialchars($data['message']) ?? '';

        if ($name !== $data['name']
            || $description !== $data['description']) {
            throw new Exception('Invalid data: name or description or montant or statut or category_id contains invalid characters');
        }

        $box = Box::create([
            'id' => Uuid::uuid4()->toString(),
            'token' => base64_encode($name),
            'libelle' => $name,
            'description' => $description,
            'montant' => $montant,
            'statut' => $statut,
            'message' => $message
        ]);

        $box->save();

        $_SESSION['box'] = $box;

        return $box;
    }

    public function cart(): ?Box
    {
        if (!isset($_SESSION['box'])) {
            return null;
        }

        return $_SESSION['box'];
    }
}