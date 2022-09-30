<?php

namespace App\Intefaces;

interface IProductService
{
    function ImportProducts(array $importProducts) : array;
    function GetAllProducts();
}
