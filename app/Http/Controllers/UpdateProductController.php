<?php

namespace App\Http\Controllers;

use App\UseCases\UpdateProduct\UpdateProduct;
use App\UseCases\UpdateProduct\UpdateProductInput;
use Illuminate\Http\Request;

class UpdateProductController extends Controller
{
    public function __construct(
        private UpdateProduct $updateProduct
    ) {}

    public function __invoke(Request $request)
    {
        try {
            $request->validate([
                'name' => 'sometimes|string',
                'description' => 'sometimes|string',
                'price' => 'sometimes|numeric|min:0',
                'quantity' => 'sometimes|integer|min:0',
            ]);
    
            $this->updateProduct->execute(new UpdateProductInput(
                id: (int) $request->route('id'),
                name: $request->input('name'),
                description: $request->input('description'),
                price: $request->input('price'),
                quantity: $request->input('quantity')
            ));

            return response()->json(['message' => 'Product updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error updating product: ' . $e->getMessage()], $e->getCode() ?: 500);
        }
    }
}
