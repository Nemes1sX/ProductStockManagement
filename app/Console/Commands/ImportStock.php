<?php

namespace App\Console\Commands;

use App\Intefaces\IProductService;
use Illuminate\Console\Command;

class ImportStock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:ImportStock';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports existing product stock';

    /**
     * Execute the console command.
     *
     * @return int
     */

    protected IProductService $productService;

    public function __construct(IProductService $productService)
    {
        parent::__construct();

        $this->productService = $productService;
    }

    public function handle()
    {
        $data = json_decode(file_get_contents(storage_path()."/stocks.json"));

        $this->productService->ImportProductsStock($data);

        $this->info('Product stock was successfully imported');
    }
}
