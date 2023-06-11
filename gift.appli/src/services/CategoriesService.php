<?php

namespace gift\app\services;

use gift\app\models\Categorie;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoriesService
{

    public static function getCategories(): array
    {
        return Categorie::all()->toArray();
    }

    public static function getCategorieById(int $id): array
    {
        try {
            return Categorie::findOrFail($id)->toArray();
        } catch (ModelNotFoundException $e) {
            throw new CategorieNotFoundException("Catégorie inconnue: ". $id);
        }
    }

}