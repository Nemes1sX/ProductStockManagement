<?php

namespace App\Http\Controllers;

use App\Intefaces\IProductService;

class ProductsController extends Controller
{
    public function __construct(IProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $products = $this->productService->GetAllProducts();

        return response()->json([
            'data' => $products
        ], 200);
    }
}
