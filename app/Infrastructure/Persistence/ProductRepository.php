<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Entities\Product;

interface ProductRepository
{
    public function findById(int $id): ?Product;
    public function findAll(): array;
    public function save(Product $product): void;
}