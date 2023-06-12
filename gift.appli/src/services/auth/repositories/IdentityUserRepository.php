<?php

declare(strict_types=1);

namespace gift\app\services\auth\repositories;

use gift\app\models\Identity\IdentityUser;
use gift\app\services\IRepository;

final class IdentityUserRepository implements IRepository
{
    public function getAll(): ?array
    {
        $users = IdentityUser::all();

        return !empty($users)
            ? $users->toArray()
            : null;
    }

    public function getById(int $id): ?array
    {
        $user = IdentityUser::find($id);

        return $user
            ? $user->toArray()
            : null;
    }

    public function create(array $data): bool
    {
        return IdentityUser::create($data) != null;
    }

    public function update(int $id, array $data): bool
    {
        $user = IdentityUser::find($id);

        return $user
            ? $user->update($data)
            : false;
    }

    public function delete(int $id): bool
    {
        return (bool)IdentityUser::destroy($id);
    }

    public function any(callable $predicate): bool
    {
        $users = IdentityUser::all();

        return $users->filter($predicate)->isNotEmpty();
    }
}
