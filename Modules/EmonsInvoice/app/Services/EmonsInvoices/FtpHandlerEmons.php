<?php

namespace Modules\EmonsInvoice\app\Services\EmonsInvoices;

use App\Services\FtpHandlerBase;

class FtpHandlerEmons extends FtpHandlerBase 
{

    /**
     * We want only csv files, they contain the Emons invoices.
     *
     * @var string
     */
    private $desiredFileType = '.csv';

    public function __construct()
    {   
        /**
         * Calls parent constructor by giving the connection name as an argument.
         * The parent constructor will do a lot of things in the backgorund:
         * 1. Sets connection name. Example: PamyraOrders
         * 2. Sets connection mode. Example: test or live
         * 3. Gets ftp credentials from the database
         * 4. Creates a new instance of the ftp server, that we will use to access the orders
         * 5. Sets the path where the file will be stored in our archive
         */
        parent::__construct('EmonsInvoices', 'EmonsInvoicesArchived/');
    }

    public function getEmonsInvoices(): array
    {
        //Get all file list from ftp
        $allFilesInFtpServer = $this->getFileList();
        dd($allFilesInFtpServer);

        //Filter out only those files that are Emons invoices (which have csv in their name), ignore all the other files
        $emonsInvoiceFileNames = $this->filterFiles($allFilesInFtpServer, $this->desiredFileType);

        //If there are no emons invoices, we can stop the process here
        $this->checkIfServerEmpty($emonsInvoiceFileNames);

        //Will collect all emons invoices from all emons csv files from the ftp server into an array
        $emonsInvoices = $this->extractInvoices($emonsInvoiceFileNames);

        return $emonsInvoices;
    }

    private function extractInvoices(array $csvFileNames)
    {
        $csvFiles = [];

        foreach($csvFileNames as $csvFileName) {
            //Copy the csv file from the ftp server to the app/documents/EmonsInvoicesArchive
            //Here we need logic to be made
        }
        return $csvFiles;
    }


}