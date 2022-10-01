<?php

namespace App\Services;

use App\Intefaces\IProductService;
use App\Models\Product;
use App\Models\Stock;
use Carbon\Carbon;

class ProductService implements IProductService
{
    public function ImportProducts(array $importProducts) : array
    {
        $data = [];
        foreach ($importProducts as $product) {
            $existingProduct = Product::where('sku', $product->sku)->first();
            if (!$existingProduct) {
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

    public function ImportProductsStock(array $importStocks)
    {
        $data = [];
        foreach ($importStocks as $importStock)
        {
            $existingProduct = Product::where('sku', $importStock->sku)->first();
            if ($existingProduct) {
                $data[] = [
                    'city' => $importStock->city,
                    'quantity' => $importStock->stock,
                    'product_id' => $existingProduct->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }

            if(count($data) >= 1) {
                foreach (array_chunk($data, 1000) as $chunk) {
                    Stock::insert($chunk);
                }
            }
        }

        return $data;
    }

    public function GetAllProducts()
    {
        return Product::withCount('stocks')->get();
    }

    public function GetProduct(int $id): Product
    {
        return Product::find($id);
    }

    public function GetRelatedProducts(int $id)
    {
        return Product::all()->random(3);
    }
}
