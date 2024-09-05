<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\IProductService;

class ProductsApiController extends Controller
{
    protected IProductService $productService;

    public function __construct(IProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $products = $this->productService->getAllProducts();

        return response()->json([
            'data' => $products
        ], 200);
    }

    public function updateStock(int $id)
    {
        $product = $this->productService->getProduct($id);

        return response()->json([
           'stock_count' => $product->stocks_count
        ], 200);
    }

}
