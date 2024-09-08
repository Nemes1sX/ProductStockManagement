<?php

namespace App\Interfaces;

use App\Models\Product;

interface IProductService
{
    function getAllProducts();
    function getProduct(Product $product) : Product;
    function getRelatedProducts(int $id);
}
