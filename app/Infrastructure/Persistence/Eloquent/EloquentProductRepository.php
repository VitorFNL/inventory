<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Entities\Product;
use App\Infrastructure\Persistence\ProductRepository;
use App\Models\EloquentProduct;

class EloquentProductRepository implements ProductRepository
{
    private function mapToDomain(EloquentProduct $product): Product
    {
        return Product::create(
            $product->name,
            $product->price,
            $product->quantity,
            $product->id,
            $product->description
        );
    }

    public function findById(int $id): ?Product
    {
        $eloquent_product = EloquentProduct::find($id);

        if (!$eloquent_product) {
            return null;
        }

        return $this->mapToDomain($eloquent_product);
    }

    public function findAll(): array
    {
        $eloquent_products = EloquentProduct::all();

        $products = $eloquent_products->map(function (EloquentProduct $product) {
            return $this->mapToDomain($product);
        })->toArray();

        return $products;
    }

    public function save(Product $product): void
    {
        EloquentProduct::updateOrCreate(
            ['id' => $product->getId()],
            [
                'name' => $product->getName(),
                'description' => $product->getDescription(),
                'price' => $product->getPrice(),
                'quantity' => $product->getQuantity()
            ]
        );
    }
}