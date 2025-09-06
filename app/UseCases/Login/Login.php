<?php

namespace App\UseCases\Login;

use App\Domain\Entities\User;
use App\Infrastructure\Persistence\UserRepository;
use Illuminate\Support\Facades\Auth;

class Login
{
    public function __construct(
        private UserRepository $userRepository
    ) {}
    public function execute(LoginInput $input): ?User
    {
        $credentials = [
            'email' => $input->email,
            'password' => $input->password
        ];

        if (!Auth::attempt($credentials)) {
            return null;
        }

        $laravel_user = Auth::user();

        return $this->userRepository->findById($laravel_user->id);
    }
}