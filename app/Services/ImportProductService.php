<?php

namespace App\Services;

use App\Interfaces\IImportProductService;
use App\Models\Product;
use App\Models\Tag;

class ImportProductService implements IImportProductService
{
    public function importProducts(array $importProducts): void
    {
        if (count($importProducts) == 0) {
            return;
        }

        $skus = array_column($importProducts, 'sku');
        $tagTitles = [];
        foreach ($importProducts as $importProduct) {
            foreach ($importProduct->tags as $tag) {
                $tagTitles[] = $tag->title;
            }
        }
        $tagTitles = array_unique($tagTitles);

        $existingProducts = Product::whereIn('sku', $skus)->select('id', 'sku')->get()->keyBy('sku');
        $existingTags = Tag::whereIn('name', $tagTitles)->select('id', 'name')->get()->keyBy('name');

        $newProducts = [];
        $newTags = [];

        foreach ($importProducts as $importProduct) {
            if (! isset($existingProducts[$importProduct->sku])) {
                $newProducts[] = [
                    'sku' => $importProduct->sku,
                    'description' => $importProduct->description,
                    'size' => $importProduct->size,
                    'photo' => $importProduct->photo,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        if (! empty($newProducts)) {
            foreach (array_chunk($newProducts, 1000) as $chunk) {
                Product::insert($chunk);
                $existingProducts = Product::whereIn('sku', $skus)->select('id', 'name')->get()->keyBy('sku');
            }
        }

        foreach ($importProducts as $importProduct) {
            foreach ($importProduct->tags as $tag) {
                if (! isset($existingTags[$tag->title])) {
                    $newTags[] = ['name' => $tag->title, 'created_at' => now(), 'updated_at' => now()];
                }
            }
        }

        if (! empty($newTags)) {
            foreach (array_chunk($newTags, 1000) as $chunk) {
                Tag::insert($newTags);
                $existingTags = Tag::whereIn('name', $tagTitles)->select('id', 'sku')->get()->keyBy('name');
            }
        }

        foreach ($importProducts as $importProduct) {
            $product = $existingProducts[$importProduct->sku];
            $tagIds = [];

            foreach ($importProduct->tags as $tag) {
                $tagIds[] = $existingTags[$tag->title]->id;
            }

            if (! empty($tagIds)) {
                $product->tags()->syncWithoutDetaching($tagIds);
            }
        }
    }
}
