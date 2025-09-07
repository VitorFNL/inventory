<?php

namespace App\UseCases\UpdateProduct;

class UpdateProductInput
{
    public function __construct(
        public int $id,
        public ?string $name,
        public ?string $description,
        public ?float $price,
        public ?int $quantity
    ) {}
}