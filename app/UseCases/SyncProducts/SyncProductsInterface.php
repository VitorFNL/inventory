<?php

namespace App\UseCases\SyncProducts;

use App\Infrastructure\Persistence\ProductRepository;

interface SyncProductsInterface
{
    public function __construct(ProductRepository $productRepository);

    public function execute(): SyncProductsOutput;
}
