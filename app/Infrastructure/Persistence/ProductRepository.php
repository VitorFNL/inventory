<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Entities\Product;
use App\Filters\FilterInterface;

interface ProductRepository
{
    public function findById(int $id): ?Product;
    /**
     *
     * @param FilterInterface[] $filters
     */
    public function findAll(array $filters): array;
    public function save(Product $product): void;
}