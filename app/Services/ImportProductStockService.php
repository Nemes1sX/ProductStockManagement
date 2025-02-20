<?php

namespace App\Services;

use App\Interfaces\IImportProductStockService;
use App\Models\Product;
use App\Models\Stock;

class ImportProductStockService implements IImportProductStockService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function importProductsStock(array $importStocks): void
    {
        if (count($importStocks) === 0) {
            return;
        }
        $data = [];
        foreach ($importStocks as $importStock) {
            $existingProduct = Product::where('sku', $importStock->sku)->first();
            if ($existingProduct) {
                $data[] = [
                    'city' => $importStock->city,
                    'quantity' => $importStock->stock,
                    'product_id' => $existingProduct->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        if (count($data) === 0) {
            return;
        }

        foreach (array_chunk($data, 1000) as $chunk) {
            Stock::insert($chunk);
        }
    }
}
