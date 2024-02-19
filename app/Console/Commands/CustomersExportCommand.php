<?php

namespace App\Console\Commands;

use App\Models\TmsAddress;
use App\Models\TmsCountry;
use App\Models\TmsCustomer;
use App\Services\CustomerExportService;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class CustomersExportCommand extends Command
{
    protected $exportedIds = [];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'customers-export';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export all Customers to a CSV file that are changed or new since the last export.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $customerExportService = new CustomerExportService();

        $this->info('Exporting Customers to CSV file...');

        $info = $customerExportService->exportCustomers();
        $this->exportedIds = $info['exportedIds'];

        $customerExportService->makeDirectory();

        if (count($this->exportedIds) > 0) {
            $customerExportService->saveCsv();
            $this->info('Exported IDs: ' . json_encode($this->exportedIds));
        } else {
            $this->info('No new or changed customers found.');
        }        
        $this->info('Done!');
    }    
}
