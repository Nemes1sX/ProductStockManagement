<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Services\ImportProductService;
use App\Services\ImportProductStockService;
use App\Services\ProductService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_service_successfully_all_product_import(): void
    {
        $data = '[{
            "sku": "T-1",
            "size": "XL",
            "description": "Test",
            "photo": "http://dummyimage.com/218x100.png/5fa2dd/ffffff",
               "tags": [
      {
        "title": "Cookley"
      }
    ],
            "updated_at": "2022-06-01"
            },
            {
            "sku": "T-2",
            "size": "L",
            "description": "Test1",
            "photo": "http://dummyimage.com/218x100.png/5fa2dd/ffffff",
                   "tags": [
      {
        "title": "Cookley"
      }
    ],
            "updated_at": "2022-05-31"
            }]';

        $importProductsService = new ImportProductService;
        $data = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $data);
        $data = json_decode($data);
        $products = $importProductsService->importProducts($data);

        $products = json_encode($products);
        $products = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $products);
        $products = json_decode($products);

        $this->assertEquals(count($products), count($data));
        foreach ($products as $product) {
            $this->assertDatabaseHas('products', [
                'sku' => $product->sku,
                'size' => $product->size,
                'description' => $product->description,
                'photo' => $product->photo,
                'updated_at' => $product->updated_at,
            ]);
        }
    }

    public function test_product_service_dont_import_duplicate_product(): void
    {
        $data = '[{
            "sku": "T-1",
            "size": "XL",
            "description": "Test",
            "photo": "http://dummyimage.com/218x100.png/5fa2dd/ffffff",
                "tags": [
      {
        "title": "Cookley"
      }
    ],
            "updated_at": "2022-06-01"
            },
            {
            "sku": "T-2",
            "size": "L",
            "description": "Test1",
            "photo": "http://dummyimage.com/218x100.png/5fa2dd/ffffff",
                "tags": [
      {
        "title": "Cookley"
      }
    ],
            "updated_at": "2022-05-31"
            }]';

        $importProductsService = new ImportProductService;
        $data = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $data);
        $data = json_decode($data);
        $importProductsService->importProducts($data);

        $data = '[{
            "sku": "T-1",
            "size": "XL",
            "description": "Test",
            "photo": "http://dummyimage.com/218x100.png/5fa2dd/ffffff",
                "tags": [
      {
        "title": "Cookley"
      }
    ],
            "updated_at": "2022-06-01"
            }]';
        $data = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $data);
        $data = json_decode($data);
        $products = $importProductsService->importProducts($data);

        $this->assertEquals(0, count($products));
    }

    public function test_product_service_get_products_if_list_not_empty()
    {
        Product::factory(1)->create();
        $productService = new ProductService;
        $products = $productService->getAllProducts();

        $this->assertEquals(1, count($products));
    }

    public function test_product_service_get_products_if_list_empty()
    {
        $productService = new ProductService;
        $products = $productService->getAllProducts();

        $this->assertEquals(0, count($products));
    }

    public function test_product_service_return_related_products()
    {
        $products = Product::factory(4)->create();

        $productService = new ProductService;
        $relatedProducts = $productService->getRelatedProducts($products->first()->id);

        $this->assertEquals(3, count($relatedProducts));
    }

    public function test_product_service_get_product_if_it_find()
    {
        $product = Product::factory(1)->create();

        $productService = new ProductService;
        $findProduct = $productService->getProduct($product->first()->id);

        $this->assertEquals($product->first()->id, $findProduct->id);
        $this->assertEquals($product->first()->sku, $findProduct->sku);
        $this->assertEquals($product->first()->size, $findProduct->size);
        $this->assertEquals($product->first()->description, $findProduct->description);
        $this->assertEquals($product->first()->photo, $findProduct->photo);
    }

    public function test_product_service_import_successfully_product_stocks()
    {
        $product = Product::factory(1)->create();
        $quantity = rand(10, 99);
        $stock = '[{
                    "sku": "'.$product->first()->sku.'",
                    "city": "'.fake()->city().'",
                    "stock": "'.$quantity.'"
                  }]';
        $stock = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $stock);
        $stock = json_decode($stock);
        $importProductStockSerivce = new ImportProductStockService;
        $importProductStockSerivce->importProductsStock($stock);

        $this->assertDatabaseHas('stocks', [
            'quantity' => $quantity,
        ]);
    }
}
