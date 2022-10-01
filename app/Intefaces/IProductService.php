<?php

namespace App\Intefaces;

use App\Models\Product;

interface IProductService
{
    function ImportProducts(array $importProducts) : array;
    function ImportProductsStock(array $importStocks);
    function GetAllProducts();
    function GetProduct(int $id) : Product;
    function GetRelatedProducts(int $id);
}
