<?php

namespace App\Services;

use App\Interfaces\IProductService;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ProductService implements IProductService
{
    public function getAllProducts(): LengthAwarePaginator
    {
        return Product::withCount('stocks')->paginate(10);
    }

    public function getProduct(Product $product): Product
    {
        return $product->loadCount('stocks');
    }

    public function getRelatedProducts(): Collection
    {
        return Product::all()->random(3);
    }
}
