<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Entities\User;
use App\Infrastructure\Persistence\UserRepository;
use App\Models\EloquentUser;
use Illuminate\Support\Facades\Auth;

class EloquentUserRepository implements UserRepository
{
    private function mapToDomain(EloquentUser $user): User
    {
        return User::create(
            id: $user->id,
            name: $user->name,
            email: $user->email
        );
    }

    public function findById(int $id): ?User
    {
        $eloquent_user = EloquentUser::where('id', $id)->first();

        if (!$eloquent_user) {
            return null;
        }

        return $this->mapToDomain($eloquent_user);
    }

    public function findByEmail(string $email): ?User
    {
        $eloquent_user = EloquentUser::where('email', $email)->first();

        if (!$eloquent_user) {
            return null;
        }

        return $this->mapToDomain($eloquent_user);
    }

    public function save(User $user): void
    {
        EloquentUser::updateOrCreate(
            ['id' => $user->getId()],
            [
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'password' => $user->getPassword()
            ]
        );
    }
}
