<?php

namespace App\UseCases\SyncProducts;

class SyncProductsOutput
{
    public function __construct(
        /**
         * @var \App\Domain\Entities\Product[]
         */
        public array $products
    ) {}
}