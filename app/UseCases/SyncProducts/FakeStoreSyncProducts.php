<?php

namespace App\UseCases\SyncProducts;

use App\Domain\Entities\Product;
use App\Infrastructure\Persistence\ProductRepository;
use Illuminate\Support\Facades\Http;

class FakeStoreSyncProducts implements SyncProductsInterface
{
    public function __construct(
        private ProductRepository $productRepository
    ) {}

    public function execute(): SyncProductsOutput
    {
        $response = Http::timeout(30)->get("https://fakestoreapi.com/products");

        if (!$response->successful()) {
            throw new \Exception("Erro ao consultar a API: " . $response->status(), $response->getStatusCode());
        }

        $apiProducts = $response->json();

        $this->productRepository->deleteWithoutExternalId();

        $products = [];
        foreach ($apiProducts as $apiProduct) {
            $product = Product::create(
                id: null,
                name: $apiProduct['title'],
                price: $apiProduct['price'],
                quantity: $apiProduct['rating']['count'] ?? 1,
                description: $apiProduct['description'],
                external_id: $apiProduct['id'],
            );
            
            $product = $this->productRepository->save($product);

            $products[] = $product->toArray();
        }

        return new SyncProductsOutput($products);
    }
}
