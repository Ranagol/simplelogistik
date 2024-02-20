<?php

namespace Modules\PamyraOrder\app\Services\PamyraServices;

use Carbon\Carbon;
use App\Models\TmsFtpCredential;
use App\Services\FtpHandlerBase;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * This class connects to an sftp server, and handles files from here.
 */
class FtpHandlerPamyra extends FtpHandlerBase
{
    

    public function __construct($connectionName = 'PamyraOrders')
    {
        //call parent constructor
        parent::__construct($connectionName = 'PamyraOrders');

        //Set the path where the file will be stored in our archive.
        $this->newFilePath = 'PamyraOrders/Archived';
        
        /**
         * This is individual for every ftp server, because of individual credentials.
         */
        $this->createFtpServerStorage();
        
    }

    /**
     * This is not inherited from the parent, because it is individual for every ftp server.
     * However the helper function in this function are inherited from the parent, becase these
     * helpers are the same for every ftp server.
     * This is the main function in this class, that triggers all other functions.
     *
     * @return array
     */
    public function getPamyraOrders(): array
    {
        // dd('getPamyraOrders triggered');
        //Get file list from ftp target (all files, no matter what type they are)
        $allFilesInFtpServer = $this->getFileList();
        dd($allFilesInFtpServer);
        //Filter out only those files that are Pamyra orders (which have json in their name), ignore all the other files
        $pamyraFileNames = $this->filterFiles($allFilesInFtpServer, '.json');

        //If there are no pamyra files, we can stop the process here
        $this->checkIsThisEmpty($pamyraFileNames);

        /**
         * Will collect all pamyra orders from all pamyra json files from the ftp server into an 
         * array. This function is not inherited from FtphandlerBase, because we have to handle the
         * pamyra orders in a special way.
         */
        $pamyraOrders = $this->handlePamyraFiles($pamyraFileNames);

        return $pamyraOrders;
    }

    /**
     * Will collect all pamyra orders from all pamyra json files from the ftp server into an array.
     * Here we loop through every pamyra json file, and extract its content into an array.
     * The end goal is to have all pamyra orders from all pamyra json files in one php array.
     *
     * @param array $pamyraFileNames    All pamyra json file names
     * @return array
     */
    private function handlePamyraFiles(array $pamyraFileNames): array
    {
        $pamyraOrders = [];

        foreach ($pamyraFileNames as $pamyraJsonFile) {
            $pamyraOrders[] = $this->ftpServerStorage->json($pamyraJsonFile);
        }

        return $pamyraOrders;
    }

    /**
     * Creates individual ftp server storage, necessary for the ftp connection and file manupulation.
     * We get the credentials from the parent class for this to be done.
     *
     * @return void
     */
    private function createFtpServerStorage(): void
    {
        $this->ftpServerStorage = Storage::createFtpDriver([
            'host' => $this->tmsFtpCredential->host,
            'username' => $this->tmsFtpCredential->username,
            'password' => $this->tmsFtpCredential->password,
            'port' => intval($this->tmsFtpCredential->port),
            'root' => $this->tmsFtpCredential->path,
            'throw' => true,
        ]);
    }
}
