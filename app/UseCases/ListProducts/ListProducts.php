<?php

namespace App\UseCases\ListProducts;

use App\Filters\FilterFactory;
use App\Infrastructure\Persistence\ProductRepository;

class ListProducts
{
    public function __construct(
        private ProductRepository $productRepository,
        private FilterFactory $filterFactory
    ) {}

    public function execute(ListProductsInput $input): array
    {
        $filters = $this->filterFactory->createFromDTO($input);

        $products = $this->productRepository->findAll($filters);

        return $products;
    }
}