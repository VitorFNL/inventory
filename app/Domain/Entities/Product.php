<?php

namespace App\Domain\Entities;

class Product
{
    private function __construct(
        private string $name,
        private float $price,
        private int $quantity,
        private ?int $id = null,
        private ?string $description = null,
    ) {}

    public static function create(
        string $name,
        float $price,
        int $quantity,
        ?int $id,
        ?string $description,
    ): self {
        if ($price < 0 || $quantity < 0) {
            throw new \InvalidArgumentException('Price and quantity must be non-negative.');
        }

        return new self(
            id: $id,
            name: $name,
            description: $description,
            price: $price,
            quantity: $quantity,
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}