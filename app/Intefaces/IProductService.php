<?php

namespace App\Intefaces;

use App\Models\Product;

interface IProductService
{
    function ImportProducts(array $importProducts) : array;
    function GetAllProducts();
    function GetProduct(int $id) : Product;
    function GetRelatedProducts(int $id);
}
