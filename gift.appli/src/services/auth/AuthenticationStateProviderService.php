<?php

declare(strict_types=1);

namespace gift\app\services\auth;

use gift\app\infrastructure\exceptions\auth\EmailAlreadyExistsException;
use gift\app\infrastructure\exceptions\auth\EmailDoesNotExistException;
use gift\app\infrastructure\exceptions\auth\InvalidPasswordException;
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

    /**
     * @throws EmailDoesNotExistException
     * @throws InvalidPasswordException
     */
    public function signIn(string $email, string $password): bool
    {
        $userArray = $this->repository->first(fn(IdentityUser $user) => $user->email === $email);

        if (!$userArray) {
            throw new EmailDoesNotExistException('Email does not exist');
        }

        $user = $this->createUserFromData($userArray);

        if (!password_verify($password, $user->password)) {
            throw new InvalidPasswordException('Invalid password');
        }

        $_SESSION['user'] = $user;

        return true;
    }

    private function createUserFromData(array $data): IdentityUser
    {
        $user = new IdentityUser();
        $user->pseudo = $data['pseudo'];
        $user->id = $data['id'];
        $user->email = $data['email'];
        $user->password = $data['password'];

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

    public function user(): ?IdentityUser
    {
        return $_SESSION['user'] ?? null;
    }
}