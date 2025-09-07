<?php

namespace App\UseCases\UpdateProduct;

use App\Domain\Entities\Product;
use App\Infrastructure\Persistence\ProductRepository;
use InvalidArgumentException;

class UpdateProduct
{
    public function __construct(
        private ProductRepository $productRepository
    ) {}

    public function execute(UpdateProductInput $updateProduct): bool
    {
        $product = $this->productRepository->findById($updateProduct->id);

        if (!$product) {
            throw new InvalidArgumentException("Product with ID {$updateProduct->id} not found.", 404);
        }

        $newProduct = Product::create(
            id: $updateProduct->id,
            name: $updateProduct->name ?: $product->getName(),
            description: $updateProduct->description ?: $product->getDescription(),
            price: $updateProduct->price ?: $product->getPrice(),
            quantity: $updateProduct->quantity ?: $product->getQuantity()
        );

        $this->productRepository->save($newProduct);

        return true;
    }
}