<?php

namespace App\Services;

use App\Intefaces\IProductService;
use App\Models\Product;
use Carbon\Carbon;

class ProductService implements IProductService
{
    public function ImportProducts(array $importProducts) : array
    {
        $data = [];
        foreach ($importProducts as $product) {
            $existingProductSku = Product::where('sku', $product->sku)->first();
            if (!$existingProductSku) {
                $data[] = [
                    'sku' => $product->sku,
                    'size' => $product->size,
                    'description' => $product->description,
                    'photo' => $product->photo,
                    'updated_at' => Carbon::createFromFormat('Y-m-d', $product->updated_at)
                ];
            }
        }

        if (count($data) >= 1) {
            foreach (array_chunk($data, 1000) as $chunk) {
                Product::insert($chunk);
            }
        }

        return $data;
    }
}
