<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Entities\User;

interface UserRepository
{
    public function findById(int $id): ?User;
    public function findByEmail(string $email): ?User;
    public function save(User $user): void;
}