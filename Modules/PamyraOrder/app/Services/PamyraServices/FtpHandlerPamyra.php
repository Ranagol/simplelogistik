<?php

namespace Modules\PamyraOrder\app\Services\PamyraServices;

use Carbon\Carbon;
use App\Models\TmsFtpCredential;
use App\Services\FtpHandlerBase;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


use Exception;

/**
 * This class connects to an sftp server, and handles files from here.
 */
class FtpHandlerPamyra extends FtpHandlerBase
{
    private $desiredFileType = '.json';

    public function __construct()
    {
        //call parent constructor by giving the connection name
        parent::__construct('PamyraOrders');
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

    /*
     * After we have handled all the orders (so every order is written from pamyra json file into
     * our database), we 
     * 1. copy the files from the ftp server to our app
     * 2. rename these files so they have the date in their name
     * 3. archive these files in storage/app/PamyraOrders/Archived
     * 4. delete these files from the ftp server
     *
     * @return void
     */
    public function archiveJsonFiles(): void
    {
        foreach ($this->filteredFileNames as $fileName) {

            //Check if file exists on ftp server
            if($this->ftpServer->exists($fileName)) {
                echo $fileName . ' exists on FTP server!' . PHP_EOL;
                Log::info($fileName . ' exists on FTP server!');
            }

            try {

                // Read the file content from the sftp ftpServer
                $fileContent = $this->ftpServer->get($fileName);

                //Write the file to ./documents/... dir.
                $isWritten = Storage::disk('documents')->put(
                    $this->createNewFileName($fileName),
                    $fileContent
                );

                if($isWritten) {
                    echo $fileName . ' was written to the local disk.' . PHP_EOL;
                    Log::info($fileName . ' was written to the local disk.');
                }

            } catch (\Throwable $th) {

                Log::error('Error: ' . $th->getMessage());
                echo 'Error: ' . $th->getMessage() . PHP_EOL;

            } finally {
                
                //Delete the original json file from the ftp server
                $isDeleted = $this->ftpServer->delete($fileName);
                if($isDeleted) {
                    echo $fileName . ' was deleted from FTP server.' . PHP_EOL;
                    echo PHP_EOL;
                } else {
                    Log::error($fileName . ' can not be deleted from FTP server');
                    echo $fileName . ' can not be deleted from FTP server' . PHP_EOL;
                }
            }
        }
    }    
}
