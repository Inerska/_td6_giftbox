<?php

declare(strict_types=1);

namespace gift\app\services\auth;

use gift\app\infrastructure\exceptions\auth\EmailAlreadyExistsException;
use gift\app\models\Identity\IdentityUser;
use gift\app\services\auth\repositories\IdentityUserRepository;
use gift\app\services\IRepository;

class AuthenticationStateProviderService
{
    private static ?AuthenticationStateProviderService $instance = null;
    protected IdentityUser $identityUser;
    private IRepository $repository;

    public function __construct(IdentityUser $identityUser = null)
    {
        $this->repository = new IdentityUserRepository();
        $this->identityUser = $identityUser ?? new IdentityUser();

        if (self::$instance === null) {
            self::$instance = $this;
        }
    }

    public static function getInstance(): AuthenticationStateProviderService
    {
        return self::$instance ?? new AuthenticationStateProviderService();
    }

    /**
     * @throws EmailAlreadyExistsException
     */
    public function signUp(string $pseudonyme, string $email, string $password): bool
    {
        if ($this->repository->any(fn(IdentityUser $user) => $user->email === $email)) {
            throw new EmailAlreadyExistsException('Email already exists');
        }

        $user = $this->repository->create([
            'pseudo' => $pseudonyme,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_ARGON2ID),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        $_SESSION['user'] = $user;

        return $user;
    }

    public function isAuthenticated(): bool
    {
        return isset($_SESSION['user']);
    }

    public function signOut()
    {
        unset($_SESSION['user']);
    }
}