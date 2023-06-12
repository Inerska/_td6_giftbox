<?php

declare(strict_types=1);

namespace gift\app\services;

interface IRepository
{
    public function getAll(): ?array;

    public function getById(int $id): ?array;

    public function create(array $data);

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;

    public function any(callable $predicate): bool;

    public function first(callable $predicate): ?array;
}
