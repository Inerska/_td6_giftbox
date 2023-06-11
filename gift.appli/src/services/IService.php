<?php

namespace gift\app\services;

interface IService
{
    static function create(array $data): bool;

    static function getById(string $id): array;

    static function addSub(array $data): bool;

    static function removeSub(array $data): bool;
}