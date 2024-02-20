<?php

namespace Modules\EmonsInvoice\app\Services\EmonsInvoices;

use App\Services\FtpHandlerBase;

class FtpHandlerEmons extends FtpHandlerBase{

    /**
     * Stores all relevant json file name from the ftp server, from where we will write
     * Pamyra orders to the database. Later, when this is done, we will need these file names
     * again, because we have to copy these files from the ftp server into our app, and then we have
     * to delete these files from the ftp server.
     *
     * @var array
     */
    protected array $filteredFileNames;

    public function __construct()
    {   
        // parent::__construct();
    }

    public function handle()
    {
        // //Get all file list from ftp
        // $allFilesInFtpServer = $this->getFileList();

        // // //Filter out only those files that are Emons invoices (which have csv in their name), ignore all the other files
        // $csvFileNames = $this->filterFiles($allFilesInFtpServer, '.csv');

        // // //If there are no emons files, we can stop the process here
        // $this->checkIsThisEmpty($csvFileNames);

        // //Will collect all emons invoices from all emons csv files from the ftp server into an array
        // $this->getCsvFiles($csvFileNames);
    }

    private function getCsvFiles(array $csvFileNames)
    {
        // $csvFiles = [];

        // foreach($csvFileNames as $csvFileName) {
        //     //Copy the csv file from the ftp server to the app/documents/EmonsInvoicesArchive
        //     //Here we need logic to be made
        // }
        // return $csvFiles;
    }


}