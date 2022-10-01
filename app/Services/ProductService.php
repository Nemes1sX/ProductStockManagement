<?php

namespace App\Services;

use App\Intefaces\IProductService;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class ProductService implements IProductService
{
    public function ImportProducts(array $importProducts) : array
    {
        $data = [];
        $tags = [];
        foreach ($importProducts as $product) {
            $existingProduct = Product::where('sku', $product->sku)->first();
            if (!$existingProduct) {
                $data[] = [
                    'sku' => $product->sku,
                    'size' => $product->size,
                    'description' => $product->description,
                    'photo' => $product->photo,
                    'updated_at' => Carbon::createFromFormat('Y-m-d', $product->updated_at),
                ];
                $tags[] = $product->tags;
            }
        }

        if (count($data) >= 1) {
            foreach (array_chunk($data, 1000) as $chunk) {
                Product::insert($chunk);
            }
            for ($i=0; $i<count($data)-1; $i++) {
                if (count($tags) == 0) {
                   continue;
                }
                $existingProduct = Product::where('sku', $data[$i]['sku'])->get();
                if (!$existingProduct) {
                    continue;
                }
                for ($j=0; $j<count($tags)-1; $j++) {
                    for ($k=0; $k<count($tags[$j])-1; $k++) {
                        $existingTag = Tag::where('name', $tags[$j][$k]->title)->first();
                        if (!$existingTag) {
                            $newTag = Tag::create(['name' => $tags[$j][$k]->title]);
                            $newTag->products()->attach($existingProduct->id);
                        } else {
                            $existingTag->products()->attach($existingProduct->id);
                        }
                    }
                }
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
