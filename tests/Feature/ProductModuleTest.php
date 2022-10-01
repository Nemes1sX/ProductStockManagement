<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductModuleTest extends TestCase
{

    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_all_products()
    {
        Product::factory()->create();

        $this->json('GET', "api/product/index", ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [[
                    'id',
                    'sku',
                    'size',
                    'description',
                    'photo',
                    'stocks_count'
                ]]
            ]);
    }

    public function test_import_product_command()
    {
        $this->artisan('command:ImportProduct')->assertSuccessful();
    }

    public function test_import_product_stocks_command()
    {
        $this->artisan('command:ImportProduct');
        $this->artisan('command:ImportStock')->assertSuccessful();
    }

}
