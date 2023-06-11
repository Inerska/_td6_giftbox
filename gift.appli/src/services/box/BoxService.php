<?php

declare(strict_types=1);

namespace gift\app\services\box;

use Exception;
use gift\app\models\Box;
use gift\app\services\PrestationNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Ramsey\Uuid\Uuid;

class BoxService
{
    static function addService(int $serviceId, string $boxId): bool
    {
        try {
            $box = self::getById($boxId);
            $box->prestations()->attach($serviceId);

            return true;
        } catch (PrestationNotFoundException $prestationNotFoundException) {
            return false;
        }
    }

    static function getById(string $id): array
    {
        try {
            return Box::findOrFail($id)
                ->toArray();
        } catch (ModelNotFoundException $e) {
            throw new PrestationNotFoundException("Coffret inconnu: " . $id);
        }
    }

    static function removeService(array $data): bool
    {
        throw new Exception('Not implemented');
    }

    /**
     * @throws Exception if data is invalid
     */
    static function create(array $data): bool
    {
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
            'token' => base64_encode($name . $description),
            'libelle' => $name,
            'description' => $description,
            'montant' => $montant,
            'statut' => $statut,
        ]);

        return $box->save();
    }
}