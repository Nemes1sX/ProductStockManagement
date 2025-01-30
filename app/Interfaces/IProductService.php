<?php

namespace App\Interfaces;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface IProductService
{
    public function getAllProducts(): LengthAwarePaginator;

    public function getProduct(Product $product): Product;

    public function getRelatedProducts(): Collection;
}
