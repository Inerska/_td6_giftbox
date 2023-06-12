<?php

declare(strict_types=1);

namespace gift\app\services\auth;

use gift\app\models\Identity\IdentityUser;

class AuthenticationStateProviderService
{
    public function __construct(protected IdentityUser $identityUser)
    {
    }

    public function signUp($username, $password)
    {
        $this->identityUser->create([
            'username' => $username,
            'password' => password_hash($password, PASSWORD_ARGON2ID)
        ]);
    }

    public function user(): ?IdentityUser
    {
        return $_SESSION['user'] ?? null;
    }
}