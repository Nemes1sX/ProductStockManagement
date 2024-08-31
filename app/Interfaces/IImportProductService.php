<?php

namespace App\Interfaces;

interface IImportProductService
{
    function ImportProducts(array $importProducts) : array;
}
