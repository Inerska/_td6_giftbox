<?php

namespace gift\app\services;

use Exception;
use gift\app\models\Categorie;
use gift\app\models\Prestation;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PrestationsService
{
    public static function getPrestationById(string $id): array
    {
        try {
            return Prestation::findOrFail($id)
                ->toArray();
        } catch (ModelNotFoundException $e) {
            throw new PrestationNotFoundException('Prestation inconnue: ' . $id);
        }
    }

    public function getCategories(): array
    {
        return Categorie::all()->toArray();
    }

    public function getCategorieById(int $id): array
    {
        try {
            return Categorie::findOrFail($id)
                ->toArray();
        } catch (ModelNotFoundException $e) {
            throw new PrestationNotFoundException('Catégorie inconnue: ' . $id);
        }
    }

    public static function getPrestationsByCategorie(int $categ_id): array
    {
        try {
            return Categorie::findOrFail($categ_id)
                ->prestations()
                ->get()
                ->toArray();

        } catch (ModelNotFoundException $e) {
            throw new PrestationNotFoundException('Catégorie inconnue ou sans prestation: ' . $categ_id);
        }
    }

    /**
     * @throws Exception if data is invalid
     */
    public static function createCategory(array $data): bool
    {
        if (!isset($data['libelle']) || !isset($data['description'])) {
            throw new Exception('Invalid data: libelle or description not provided');
        }

        $libelle = htmlspecialchars($data['libelle']);
        $description = htmlspecialchars($data['description']);

        if ($libelle !== $data['libelle']
            || $description !== $data['description']) {
            throw new Exception('Invalid data: libelle or description contains invalid characters');
        }

        $category = Categorie::create([
            'libelle' => $libelle,
            'description' => $description
        ]);

        return $category->save();
    }

}