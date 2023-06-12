<?php

declare(strict_types=1);

namespace gift\api\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Prestation extends Model
{

    public $timestamps = false;
    public $incrementing = false;
    public $keyType = 'string';
    protected $table = 'prestation';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'libelle', 'description', 'url', 'unite', 'tarif', 'img', 'cat_id'];

    public function categorie(): BelongsTo
    {
        return $this->belongsTo(Categorie::class, 'cat_id');
    }

}