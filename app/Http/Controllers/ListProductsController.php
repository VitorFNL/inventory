<?php

namespace App\Http\Controllers;

use App\Enums\QueryOrderEnum;
use App\UseCases\ListProducts\ListProducts;
use App\UseCases\ListProducts\ListProductsInput;
use Illuminate\Http\Request;

class ListProductsController extends Controller
{
    public function __construct(
        private ListProducts $listProducts
    ) {}

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $request->validate([
                'nameFilter' => 'sometimes|string',
                'descriptionFilter' => 'sometimes|string',
                'priceOrderFilter' => 'sometimes|string|in:asc,desc',
            ]);

            $priceOrder = request('priceOrderFilter');

            $orderEnum = $priceOrder ? QueryOrderEnum::from($priceOrder) : null;
            
            // Pegar parâmetros diretamente da URL usando request() helper
            $products = $this->listProducts->execute(new ListProductsInput(
                nameFilter: request('nameFilter') ?: null,
                descriptionFilter: request('descriptionFilter') ?: null,
                priceOrderFilter: $orderEnum
            ));
            
            return view('products.index', [
                'products' => $products,
            ]);
        } catch (\Exception $e) {
            dd($e->getMessage());
            return back()->withErrors([
                'list_products' => 'Erro ao listar produtos: ' . $e->getMessage(),
            ]);
        }
    }
}
