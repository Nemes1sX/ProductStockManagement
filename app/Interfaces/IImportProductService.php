<?php

namespace App\Interfaces;

interface IImportProductService
{
    public function importProducts(array $importProducts): void;
}
