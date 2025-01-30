<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductsResource;
use App\Interfaces\IImportProductService;
use App\Interfaces\IProductService;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class ProductsApiController extends Controller
{
    protected readonly IProductService $productService;

    protected readonly IImportProductService $importProductService;

    public function __construct(IProductService $productService, IImportProductService $importProductService)
    {
        $this->productService = $productService;
        $this->importProductService = $importProductService;
    }

    public function index(): JsonResponse
    {
        $products = $this->productService->getAllProducts();

        return response()->json([
            'data' => ProductsResource::collection($products),
            'current_page' => $products->currentPage(),
            'total_records' => $products->total(),
            'total_pages' => $products->lastPage(),
            'prev_page_url' => $products->previousPageUrl(),
            'next_page_url' => $products->nextPageUrl(),
        ], 200);
    }

    public function updateStock(Product $product): JsonResponse
    {
        $product = $this->productService->getProduct($product);

        return response()->json([
            'stock_count' => $product->stocks_count,
        ], 200);
    }
}
