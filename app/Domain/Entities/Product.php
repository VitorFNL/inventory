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
        private ?string $external_id = null
    ) {}

    public static function create(
        string $name,
        float $price,
        int $quantity,
        ?int $id = null,
        ?string $description,
        ?string $external_id = null
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
            external_id: $external_id
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

    public function getExternalId(): ?string
    {
        return $this->external_id;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'external_id' => $this->external_id,
        ];
    }
}