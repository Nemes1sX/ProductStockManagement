<?php

namespace App\Interfaces;

interface IImportProductService
{
    function importProducts(array $importProducts) : array;
}
