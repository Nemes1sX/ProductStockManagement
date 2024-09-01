<?php

namespace App\Http\Controllers;

use App\Interfaces\IProductService;

class ProductController extends Controller
{
    private readonly IProductService $productService;

    public function __construct(IProductService $productService)
    {
        $this->productService = $productService;

    }

    public function index()
    {
        return view('products.index');
    }

    public function show(int $id)
    {
        $product = cache()->remember('product-index', 60*1, function () use ($id) {
           return $this->productService->GetProduct($id);
        });
        $relatedProducts = $this->productService->GetRelatedProducts($product->id);

        return view('products.show', compact('product', 'relatedProducts'));
    }

}
