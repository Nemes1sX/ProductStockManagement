<?php

namespace App\Interfaces;

interface IImportProductStockService
{
    function ImportProductsStock(array $importStocks) : void;
}
