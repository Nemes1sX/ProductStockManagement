<?php

namespace App\Http\Controllers;

use App\Intefaces\IProductService;

class ProductController extends Controller
{
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

        //dd($product->stocks_count);
        return view('products.show', compact('product', 'relatedProducts'));
    }

}
