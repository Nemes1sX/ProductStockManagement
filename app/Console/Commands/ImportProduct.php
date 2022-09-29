<?php

namespace App\Console\Commands;

use App\Intefaces\IProductService;
use Illuminate\Console\Command;

class ImportProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:importProduct';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import products from JSON';

    /**
     * Execute the console command.
     *
     * @return int
     */

    protected $productService;

    public function __construct(IProductService $productService)
    {
        parent::__construct();

        $this->productService = $productService;
    }

    public function handle()
    {
        $data = json_decode(file_get_contents(storage_path()."/products.json"));

        $this->productService->ImportProducts($data);

        $this->info("Importing products was successfully");
    }
}
