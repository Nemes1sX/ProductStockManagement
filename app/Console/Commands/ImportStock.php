<?php

namespace App\Console\Commands;

use App\Interfaces\IImportProductStockService;
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

    protected IImportProductStockService $productStockService;

    public function __construct(IImportProductStockService $productStockService)
    {
        parent::__construct();

        $this->productStockService = $productStockService;
    }

    public function handle()
    {
        $data = json_decode(file_get_contents(storage_path()."/stocks.json"));

        $this->productStockService->importProductsStock($data);

        $this->info('Product stock was successfully imported');
    }
}
