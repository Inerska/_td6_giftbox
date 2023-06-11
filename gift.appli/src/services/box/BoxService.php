<?php

declare(strict_types=1);

namespace gift\app\services\box;

use Exception;
use gift\app\models\Box;
use gift\app\services\IService;
use gift\app\services\PrestationNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Ramsey\Uuid\Uuid;

class BoxService implements IService
{
    static function getById(string $id): array
    {
        try {
            return Box::findOrFail($id)
                ->toArray();
        } catch (ModelNotFoundException $e) {
            throw new PrestationNotFoundException("Coffret inconnu: " . $id);
        }
    }

    static function addSub(array $data): bool
    {
        // TODO: Implement addSub() method.
    }

    static function removeSub(array $data): bool
    {
        // TODO: Implement removeSub() method.
    }

    /**
     * @throws Exception if data is invalid
     */
    static function create(array $data): bool
    {
        if (!isset($data['name'])
            || !isset($data['description'])
            || !isset($data['price'])
            || !isset($data['image'])
            || !isset($data['category_id'])) {
            throw new Exception('Invalid data: name or description or price or image or category_id not provided');
        }

        $name = htmlspecialchars($data['name']);
        $description = htmlspecialchars($data['description']);
        $price = htmlspecialchars($data['price']);
        $image = htmlspecialchars($data['image']);
        $category_id = htmlspecialchars($data['category_id']);

        if ($name !== $data['name']
            || $description !== $data['description']
            || $price !== $data['price']
            || $image !== $data['image']
            || $category_id !== $data['category_id']) {
            throw new Exception('Invalid data: name or description or price or image or category_id contains invalid characters');
        }

        $box = Box::create([
            'id' => Uuid::uuid4()->toString(),
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'image' => $image,
            'category_id' => $category_id
        ]);

        return $box->save();
    }
}