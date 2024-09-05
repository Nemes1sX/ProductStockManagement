<?php

namespace App\Services;

use App\Interfaces\IImportProductService;
use App\Models\Tag;
use Illuminate\Support\Carbon;
use App\Models\Product;


class ImportProductService implements IImportProductService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function importProducts(array $importProducts) : void
    {
        if (count($importProducts) == 0) {
            return;
        }    
        foreach ($importProducts as $importProduct) {
            $product = Product::firstOrCreate(
                ['sku' => $importProduct->sku],
                [
                 'description' => $importProduct->description,
                 'size' => $importProduct->size,
                 'photo' => $importProduct->photo,    
                ]
                );
            foreach ($importProduct->tags as $productTag) {
                $tag = Tag::firstOrCreate(['name' => $productTag->title], []);
                $product->tags()->syncWithoutDetaching($tag->id);
            }
        }
    }
}
