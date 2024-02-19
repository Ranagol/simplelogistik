<?php

namespace Modules\PamyraOrder\app\Services\PamyraServices;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Services\FtpHandlerBase;

/**
 * This class connects to an sftp server, and handles files from here.
 */
class PamyraFtpHandler extends FtpHandlerBase
{
    public function __construct()
    {
        //Set the connection name for the ftp server. Defined in .env, and in config/ftp.php
        $this->connectionName = config('ftp.pamyraOrdersFtp');

        //Get the ftp credentials from the database
        $ftpCredential = TmsFtpCredential::where('name', 'PamyraOrdersTest')->firstOrFail();

        //Create a new pamyraFtpServer instance, with pamyra ftp credentials, for accessing orders.
        $this->pamyraFtpServer = Storage::build(
            [
                'driver' => 'sftp',
                'host' => $ftpCredential->host,
                'username' => $ftpCredential->username,
                'password' => $ftpCredential->password,
                'port' => intval($ftpCredential->port),
                'root' => $ftpCredential->path,
                'throw' => true
            ]
        );
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
        $pamyraFileNames = $this->filterFiles($allFilesInFtpServer, '.json');

        //If there are no pamyra files, we can stop the process here
        $this->checkIsThisEmpty($pamyraFileNames);

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
            $pamyraOrders[] = $this->ftpServerStorage->json($pamyraJsonFile);
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
            if($this->ftpServerStorage->exists($fileName)) {
                echo $fileName . ' exists on FTP server!' . PHP_EOL;
                Log::info($fileName . ' exists on FTP server!');
            }

            try {

                // Read the file content from the sftp ftpServerStorage
                $fileContent = $this->ftpServerStorage->get($fileName);

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
                $isDeleted = $this->ftpServerStorage->delete($fileName);
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
     * @param string $fileName          The old file name
     * @param string $newFilePath       The path where the file will be stored in our archive
     * @return string                   The new file name
     */
    private function createNewFileName(string $fileName, string $newFilePath): string
    {
        return 'PamyraOrdersArchived/' . Carbon::now()->format('Y_m_d') . '_' . basename($fileName); 
    }
}
