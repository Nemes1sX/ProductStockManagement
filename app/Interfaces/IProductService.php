<?php

namespace App\Intefaces;

use App\Models\Product;

interface IProductService
{
    function GetAllProducts();
    function GetProduct(int $id) : Product;
    function GetRelatedProducts(int $id);
}
