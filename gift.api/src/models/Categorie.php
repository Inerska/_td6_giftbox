<?php

declare(strict_types=1);

namespace gift\api\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categorie extends Model
{

    public $timestamps = false;
    protected $table = 'categorie';
    protected $primaryKey = 'id';
    protected $fillable = ['libelle', 'description'];

    public function prestations(): HasMany
    {
        return $this->hasMany(Prestation::class, 'cat_id');
    }

}