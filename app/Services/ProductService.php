<?php

namespace App\Services;

use App\Interfaces\IProductService;
use App\Models\Product;

class ProductService implements IProductService
{
    
    public function GetAllProducts()
    {
        return Product::withCount('stocks')->get();
    }

    public function GetProduct(int $id) : Product
    {
        return Product::where('id', $id)->withCount('stocks')->first();
    }

    public function GetRelatedProducts(int $id)
    {
        return Product::all()->random(3);
    }
}
