<?php

namespace Modules\PamyraOrder\app\Services\PamyraServices;

use App\Services\FtpHandlerBase;

/**
 * This class connects to an sftp server, and handles files from here.
 */
class FtpHandlerPamyra extends FtpHandlerBase
{
    /**
     * Pamyra orders have .json extension. We want files only with json extension.
     *
     * @var string
     */
    private $desiredFileType = '.json';

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
        parent::__construct('PamyraOrders', 'PamyraOrdersArchived/');
    }

    /**
     * This is the main function in this class, that triggers all other functions. It also uses 
     * a lot of functions from the parent class.
     *
     * @return array
     */
    public function getPamyraOrders(): array
    {
        //Get all file list from ftp
        $allFilesInFtpServer = $this->getFileList();

        //Filter out only those files that are Pamyra orders (which have json in their name), ignore all the other files
        $pamyraFileNames = $this->filterFiles($allFilesInFtpServer, $this->desiredFileType);

        //If there are no pamyra files, we can stop the process here
        $this->checkIfServerEmpty($pamyraFileNames);

        //Will collect all pamyra orders from all pamyra json files from the ftp server into an array
        $pamyraOrders = $this->handlePamyraFiles($pamyraFileNames);

        return $pamyraOrders;
    }

    /**
     * Will collect all pamyra orders from all pamyra json files from the ftp server into an array.
     * Here we loop through every pamyra json file, and extract its content into an array.
     * The end goal is to have all pamyra orders from all pamyra json files in one php array.
     * 
     * This function is specific only to Pamyra orders.
     *
     * @param array $pamyraFileNames    All pamyra json file names
     * @return array
     */
    private function handlePamyraFiles(array $pamyraFileNames): array
    {
        $pamyraOrders = [];

        foreach ($pamyraFileNames as $pamyraJsonFile) {
            $pamyraOrders[] = $this->ftpServer->json($pamyraJsonFile);

        }

        return $pamyraOrders;
    }
}
