<?php

namespace Modules\EmonsInvoice\app\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Modules\EmonsInvoice\app\Services\EmonsInvoices\EmonsInvoiceService;


class GetEmonsInvoices extends Command
{
    /**
     * The name and signature of the console command.
     * To enable this modul: sail artisan module:enable EmonsInvoice
     * To disable this modul: sail artisan module:disable EmonsInvoice
     * To run this command: sail artisan getEmonsInvoices
     */
    protected $signature = 'getEmonsInvoices';

    /**
     * The console command description.
     */
    protected $description = 'Get Emons Invoices from Emons FTP server, and writes them to the database.';

    /**
     * The EmonsInvoiceService instance.
     */
    protected $emonsInvoiceService;

    /**
     * Create a new command instance.
     */
    public function __construct(EmonsInvoiceService $emonsInvoiceService)
    {
        parent::__construct();
        $this->emonsInvoiceService = $emonsInvoiceService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Getting Emons Invoices...');
        // $this->emonsInvoiceService->handle();
        $this->info('Emons Invoices written into db.');
    }

}
