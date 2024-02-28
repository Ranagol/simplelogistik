<?php

namespace Modules\EmonsInvoice\app\Services\EmonsInvoices;

use UConverter;
use CsvToArrayConverter;
use App\Models\TmsEmonsInvoice;
use App\Services\FtpHandlerBase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\TmsEmonsInvoiceRequest;

/**
 * This class is triggered by the hanldeEmonsInvoices command. This coordinates the whole process of
 * getting the emons invoices from the ftp server, transforming them into an array, and writing them
 * into the database, by triggering other helper classes.
 */
class EmonsInvoiceService
{
    // private DbWriter $dbWriter;
    // // private CsvToArrayConverter $csvToArrayConverter;
    // private $ftpHandlerBase;

    // public function __construct(DbWriter $dbWriter, CsvToArrayConverter $csvToArrayConverter)
    // {
    //     $this->dbWriter = $dbWriter;
    //     $this->csvToArrayConverter = $csvToArrayConverter;
    //     $this->ftpHandlerBase = new FtpHandlerBase(
    //         'EmonsInvoices',
    //         'EmonsInvoicesArchived/',
    //         '.csv'
    //     );
    // }
    
    // /**
    //  * This is the main method of this class. It will trigger all other helper methods.
    //  *
    //  * @return void
    //  */
    // public function handle(): void
    // {
    //     //Gets all the csv file names from the ftp server
    //     $csvFileNames = $this->ftpHandlerBase->handle();

    //     //Gets all the invoices from all the csv files from the ftp server
    //     $invoices = $this->ftpHandlerBase->csvToArrayConvert($csvFileNames);

    //     //We loop through all the invoices and write each one to the database
    //     foreach ($invoices as $invoice) {
    //         // $this->writeToDb($invoice);
    //     }

    //     //We archive all the csv files in the app from the ftp server
    //     $this->ftpHandlerBase->archiveFiles();

    // }

    
    


}