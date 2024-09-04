<?php

namespace App\Interfaces;

use App\Models\Product;

interface IProductService
{
    function getAllProducts();
    function getProduct(int $id) : Product;
    function getRelatedProducts(int $id);
}
