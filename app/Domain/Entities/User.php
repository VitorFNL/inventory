<?php

namespace App\Domain\Entities;

class User
{
    private function __construct(
        private string $name,
        private string $email,
        private ?int $id,
        private ?string $password,
    ) {}

    public static function create(
        string $name,
        string $email,
        ?int $id = null,
        ?string $password = null,
    ): self {
        if ($id === null && $password === null) {
            throw new \InvalidArgumentException('Password is required for new users.');
        }

        return new self(
            id: $id,
            name: $name,
            email: $email,
            password: $password
        );
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}