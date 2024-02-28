<?php

namespace Modules\EmonsInvoice\app\Services\EmonsInvoices;

use CsvToArrayConverter;
use App\Services\FtpHandlerBase;
use App\Services\FtpHandlerEmons;

/**
 * This class is triggered by the hanldeEmonsInvoices command. This coordinates the whole process of
 * getting the emons invoices from the ftp server, transforming them into an array, and writing them
 * into the database, by triggering other helper classes.
 */
class EmonsInvoiceService
{
    // private DbWriter $dbWriter;
    private FtpHandlerEmons $ftpHandlerEmons;

    private DbWriter $dbWriter;

    public function __construct(DbWriter $dbWriter)
    {
        $this->dbWriter = $dbWriter;
        $this->ftpHandlerEmons = new FtpHandlerEmons(
            'EmonsInvoices',
            'EmonsInvoicesArchived/',
            '.csv'
        );
    }
    
    /**
     * This is the main method of this class. It will trigger all other helper methods.
     *
     * @return void
     */
    public function handle(): void
    {
        //Gets all the csv file names from the ftp server
        $csvFileNames = $this->ftpHandlerEmons->handle();//DONE
        // dd($csvFileNames);

        //Gets all the invoices from all the csv files from the ftp server
        $invoices = $this->ftpHandlerEmons->convertCsvToArray($csvFileNames);//DONE
        // dd($invoices);

        //We loop through all the invoices and write each one to the database
        foreach ($invoices as $invoice) {
            $this->dbWriter->createInvoice($invoice);
        }

        //We archive all the csv files in the app from the ftp server
        // $this->ftpHandlerEmons->archiveFiles();

    }
}