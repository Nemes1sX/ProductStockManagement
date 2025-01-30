<?php

namespace App\Interfaces;

interface IImportProductStockService
{
    public function ImportProductsStock(array $importStocks): void;
}
