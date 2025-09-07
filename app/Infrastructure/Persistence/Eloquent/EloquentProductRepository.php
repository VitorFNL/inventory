<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Entities\Product;
use App\Filters\FilterInterface;
use App\Infrastructure\Persistence\ProductRepository;
use App\Models\EloquentProduct;

class EloquentProductRepository implements ProductRepository
{
    private function mapToDomain(EloquentProduct $product): Product
    {
        $product->price = floatval($product->price);

        return Product::create(
            name: $product->name,
            price: $product->price,
            quantity: $product->quantity,
            id: $product->id,
            description: $product->description
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

    /**
     *
     * @param FilterInterface[] $filters
     */
    public function findAll(array $filters): array
    {
        $query = EloquentProduct::query();

        foreach ($filters as $filterData) {
            $filterData['filter']->apply($query, $filterData['value']);
        }

        $query->orderBy('id', 'asc');

        $products = $query->get()->map(function (EloquentProduct $product) {
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