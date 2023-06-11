<?php

namespace gift\app\models;

use gift\app\models\Prestation;
use Illuminate\Database\Eloquent\Model;

class Box extends Model
{

    protected $table = 'box';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = "string";
    protected $fillable = ['id', 'libelle', 'description', 'kdo', 'message_kdo', 'token', 'statut', 'montant'];

    const CREATED = 1;
    const VALIDATED = 2;
    const PAYED = 3;
    const DELIVERED = 4;
    const USD = 5;

    public function prestations(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Prestation::class, 'box2presta', 'box_id', 'presta_id')
            ->withPivot('quantite')
            ->as('contenu');
    }
}