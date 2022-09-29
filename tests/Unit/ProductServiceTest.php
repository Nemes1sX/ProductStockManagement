<?php

namespace Tests\Unit;

use App\Services\ProductService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $productService;

    public function setUp(): void
    {
        parent::setUp();

        //$this->productService = $this->app->make(ProductService::class);
    }

    public function test_product_import_service_successfully_all_product_import() : void
    {
        $data = '[{
            "sku": "T-1",
            "size": "XL",
            "description": "Test",
            "photo": "http://dummyimage.com/218x100.png/5fa2dd/ffffff",
            "updated_at": "2022-06-01"
            },
            {
            "sku": "T-2",
            "size": "L",
            "description": "Test1",
            "photo": "http://dummyimage.com/218x100.png/5fa2dd/ffffff",
            "updated_at": "2022-05-31"
            }]';

        $productService = new ProductService();
        $data = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $data);
        $data = json_decode($data);
        $products = $productService->ImportProducts($data);

        $this->assertEquals(count($products), count($data));
    }

    public function test_product_import_service_dont_import_duplicate_product() : void
    {
        $data = '[{
            "sku": "T-1",
            "size": "XL",
            "description": "Test",
            "photo": "http://dummyimage.com/218x100.png/5fa2dd/ffffff",
            "updated_at": "2022-06-01"
            },
            {
            "sku": "T-2",
            "size": "L",
            "description": "Test1",
            "photo": "http://dummyimage.com/218x100.png/5fa2dd/ffffff",
            "updated_at": "2022-05-31"
            }]';

        $productService = new ProductService();
        $data = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $data);
        $data = json_decode($data);
        $productService->ImportProducts($data);

        $data = '[{
            "sku": "T-1",
            "size": "XL",
            "description": "Test",
            "photo": "http://dummyimage.com/218x100.png/5fa2dd/ffffff",
            "updated_at": "2022-06-01"
            }]';
        $data = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $data);
        $data = json_decode($data);
        $products = $productService->ImportProducts($data);



        $this->assertEquals(0, count($products));
    }
}
