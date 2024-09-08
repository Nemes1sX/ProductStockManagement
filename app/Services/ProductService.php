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

    public function getProduct(Product $product) : Product
    {
        return $product->loadCount('stocks');
    }

    public function getRelatedProducts(int $id)
    {
        return Product::all()->random(3);
    }
}
