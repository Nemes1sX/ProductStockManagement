<?php

namespace App\Console\Commands;

use App\Interfaces\IImportProductService;
use Illuminate\Console\Command;

class ImportProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:I
    mportProduct';

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

    protected IImportProductService $importProductService;

    public function __construct(IImportProductService $importProductService)
    {
        parent::__construct();

        $this->importProductService= $importProductService;
    }

    public function handle()
    {
        $data = json_decode(file_get_contents(storage_path()."/products.json"));

        $this->importProductService->importProducts($data);

        $this->info("Importing products was successfully");
    }
}
