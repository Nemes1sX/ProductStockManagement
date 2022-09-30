<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Intefaces\IProductService;

class ProductsApiController extends Controller
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