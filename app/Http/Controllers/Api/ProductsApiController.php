<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductsResource;
use App\Interfaces\IProductService;
use App\Models\Product;

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
            'data' => ProductsResource::collection($products)
        ], 200);
    }

    public function updateStock(Product $product)
    {
        $product = $this->productService->getProduct($product);

        return response()->json([
           'stock_count' => $product->stocks_count
        ], 200);
    }

}
