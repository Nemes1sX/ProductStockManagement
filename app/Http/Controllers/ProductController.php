<?php

namespace App\Http\Controllers;

use App\Intefaces\IProductService;
use Illuminate\Http\Request;

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
        $product = $this->productService->GetProduct($id);
        $relatedProducts = $this->productService->GetRelatedProducts($product->id);

        return view('product.show', compact('product', 'relatedProducts'));
    }

}
