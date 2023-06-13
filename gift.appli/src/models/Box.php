<?php

namespace gift\app\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Box extends Model
{

    public const CREATED = 1;
    public const VALIDATED = 2;
    public const PAYED = 3;
    public const DELIVERED = 4;
    public const USD = 5;
    public $incrementing = false;
    public $keyType = 'string';
    protected $table = 'box';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'libelle', 'description', 'kdo', 'message_kdo', 'token', 'statut', 'montant'];

    public function prestations(): BelongsToMany
    {
        return $this->belongsToMany(Prestation::class, 'box2presta', 'box_id', 'presta_id')
            ->withPivot('quantite')
            ->as('contenu');
    }
}