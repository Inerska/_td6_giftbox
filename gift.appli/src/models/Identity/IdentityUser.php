<?php

declare(strict_types=1);

namespace gift\app\models\Identity;

use Illuminate\Database\Eloquent\Model;

class IdentityUser extends Model
{
    public $timestamps = false;
    protected $table = 'user';
    protected $primaryKey = 'id';
    protected $fillable = ['pseudo', 'email', 'password', 'created_at', 'updated_at'];
}