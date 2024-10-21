<?php

namespace App\Interfaces;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface IProductService
{
    function getAllProducts() : LengthAwarePaginator;
    function getProduct(Product $product) : Product;
    function getRelatedProducts() : Collection;
}
