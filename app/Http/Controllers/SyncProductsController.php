<?php

namespace App\Http\Controllers;

use App\UseCases\SyncProducts\SyncProductsInterface;
use Illuminate\Http\Request;

class SyncProductsController extends Controller
{
    public function __construct(
        public SyncProductsInterface $syncProducts
    ) {}

    public function __invoke()
    {
        $response = $this->syncProducts->execute();

        return response()->json(['products' => $response->products]);
    }
}
