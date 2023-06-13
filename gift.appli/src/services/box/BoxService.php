<?php

declare(strict_types=1);

namespace gift\app\services\box;

use Exception;
use gift\app\models\Box;
use gift\app\services\PrestationNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Ramsey\Uuid\Uuid;
use UserHasAlreadyBoxException;

final class BoxService
{
    protected BoxService $instance;

    public function __construct()
    {
        $this->instance = $this ?? new BoxService();
    }

    /**
     * @return BoxService
     */
    public static function getInstance(): BoxService
    {
        return self::$instance
            ?? new BoxService();
    }

    public static function addService(string $serviceId, string $boxId): bool
    {
        try {
            $box = self::getById($boxId);
            $box->prestations()->attach($serviceId);

            return true;
        } catch (PrestationNotFoundException $prestationNotFoundException) {
            return false;
        }
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
        ]);

        $box->save();

        $_SESSION['box'] = $box;

        return $box;
    }
}