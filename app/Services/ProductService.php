<?php

namespace App\Services;

use App\Intefaces\IProductService;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Tag;
use Carbon\Carbon;

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
            if (count($tags) >= 1) {
                for ($i = 0; $i < count($data); $i++) {
                    $existingProduct = Product::where('sku', $data[$i]['sku'])->first();
                    if (!$existingProduct) {
                        continue;
                    }
                    for ($j = 0; $j < count($tags); $j++) {
                        for ($k = 0; $k < count($tags[$j]); $k++) {
                            $existingTag = Tag::where('name', $tags[$j][$k]->title)->first();
                            if (!$existingTag) {
                                $newTag = Tag::create(['name' => $tags[$j][$k]->title]);
                                $existingProduct->tags()->attach($newTag->id);
                            } else {
                                $existingProduct->tags()->attach($existingTag->id);
                            }
                        }
                    }
                }
            }
        }

        return $data;
    }

    public function GetAllProducts()
    {
        return Product::withCount('stocks')->get();
    }

    public function GetProduct(int $id) : Product
    {
        return Product::where('id', $id)->withCount('stocks')->first();
    }

    public function GetRelatedProducts(int $id)
    {
        return Product::all()->random(3);
    }
}
