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
        //call parent constructor
        parent::__construct('PamyraOrders');
    }

    /**
     * This is the main function in this class, that triggers all other functions.
     *
     * @return array
     */
    public function getPamyraOrders(): array
    {
        //Get all file list from ftp
        $allFilesInFtpServer = $this->getFileList();

        //Filter out only those files that are Pamyra orders (which have json in their name), ignore all the other files
        $pamyraFileNames = $this->filterFiles($allFilesInFtpServer, $this->desiredFileType);


        dd($pamyraFileNames);//************* */

        //If there are no pamyra files, we can stop the process here
        $this->checkPamyraFiles($pamyraFileNames);

        //Will collect all pamyra orders from all pamyra json files from the ftp server into an array
        $pamyraOrders = $this->handlePamyraFiles($pamyraFileNames);

        return $pamyraOrders;
    }

    /**
     * If there are any pamyra files at all, we can continue. If there are no pamyra files, we can stop
     * the process here.
     *
     * @param array $pamyraFileNames
     * @return void
     */
    private function checkPamyraFiles(array $pamyraFileNames): void
    {
        if (empty($pamyraFileNames)) {
            echo 'No Pamyra files found on FTP server.' . PHP_EOL;
            Log::info('No Pamyra files found on FTP server.');
            exit;
        }
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

    /**
     * This function transforms the source path into target path. AKa creates a new name from the old
     * name.
     * Old source name example: upload/PAM240206-1452140740.json
     * New target name example: 
     * ./documents/PamyraOrdersArchived/2024_02_07_PAM240206-1452140740.json
     *
     * @param string $fileName
     * @return string
     */


    
    //***********************REFACTORED, NICE BUT NOT WORKNING*************** */
    // public function __construct($connectionName = 'PamyraOrders')
    // {
    //     //call parent constructor
    //     parent::__construct($connectionName = 'PamyraOrders');

    //     //Set the path where the file will be stored in our archive.
    //     $this->newFilePath = 'PamyraOrders/Archived';
        
    //     /**
    //      * This is individual for every ftp server, because of individual credentials.
    //      */
    //     $this->createFtpServerStorage();
    // }

    // /**
    //  * This is not inherited from the parent, because it is individual for every ftp server.
    //  * However the helper function in this function are inherited from the parent, becase these
    //  * helpers are the same for every ftp server.
    //  * This is the main function in this class, that triggers all other functions.
    //  *
    //  * @return array
    //  */
    // public function getPamyraOrders(): array
    // {
    //     // dd('getPamyraOrders triggered');
    //     //Get file list from ftp target (all files, no matter what type they are)
    //     $allFilesInFtpServer = $this->getFileList();
    //     dd($allFilesInFtpServer);
    //     //Filter out only those files that are Pamyra orders (which have json in their name), ignore all the other files
    //     $pamyraFileNames = $this->filterFiles($allFilesInFtpServer, '.json');

    //     //If there are no pamyra files, we can stop the process here
    //     $this->checkIsThisEmpty($pamyraFileNames);

    //     /**
    //      * Will collect all pamyra orders from all pamyra json files from the ftp server into an 
    //      * array. This function is not inherited from FtphandlerBase, because we have to handle the
    //      * pamyra orders in a special way.
    //      */
    //     $pamyraOrders = $this->handlePamyraFiles($pamyraFileNames);

    //     return $pamyraOrders;
    // }

    // /**
    //  * Will collect all pamyra orders from all pamyra json files from the ftp server into an array.
    //  * Here we loop through every pamyra json file, and extract its content into an array.
    //  * The end goal is to have all pamyra orders from all pamyra json files in one php array.
    //  *
    //  * @param array $pamyraFileNames    All pamyra json file names
    //  * @return array
    //  */
    // private function handlePamyraFiles(array $pamyraFileNames): array
    // {
    //     $pamyraOrders = [];

    //     foreach ($pamyraFileNames as $pamyraJsonFile) {
    //         $pamyraOrders[] = $this->ftpServerStorage->json($pamyraJsonFile);
    //     }

    //     return $pamyraOrders;
    // }

    // /**
    //  * Creates individual ftp server storage, necessary for the ftp connection and file manupulation.
    //  * We get the credentials from the parent class for this to be done.
    //  *
    //  * @return void
    //  */
    // private function createFtpServerStorage(): void
    // {
    //     $this->ftpServerStorage = Storage::createFtpDriver([
    //         'host' => $this->tmsFtpCredential->host,
    //         'username' => $this->tmsFtpCredential->username,
    //         'password' => $this->tmsFtpCredential->password,
    //         'port' => intval($this->tmsFtpCredential->port),
    //         'root' => $this->tmsFtpCredential->path,
    //         'throw' => true,
    //     ]);
    // }
}
