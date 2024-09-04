<?php

namespace App\Services;

use App\Interfaces\IProductService;
use App\Models\Product;

class ProductService implements IProductService
{
    
    public function getAllProducts()
    {
        return Product::withCount('stocks')->get();
    }

    public function getProduct(int $id) : Product
    {
        return Product::where('id', $id)->withCount('stocks')->first();
    }

    public function getRelatedProducts(int $id)
    {
        return Product::all()->random(3);
    }
}
