<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\TmsFtpCredential;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\FilesystemAdapter;

class FtpHandlerBase
{

    //Set the connection name for the ftp server.
    protected string $connectionName;

    protected string $connectionMode;

    /**
     * This is the path where the file will be stored in our archive.
     *
     * @var string
     */
    protected string $newFilePath;

    /**
     * Stores the ftp credentials for the connection.
     *
     * @var TmsFtpCredential
     */
    protected TmsFtpCredential $tmsFtpCredential;

    /**
     * This is the Pamyra FTP server instance/storage, created from Storage::build..., that we will 
     * use to access the orders.
     */
    protected FilesystemAdapter $ftpServerStorage;

    /**
     * Stores all relevant json file name from the ftp server, from where we will write
     * Pamyra orders to the database. Later, when this is done, we will need these file names
     * again, because we have to copy these files from the ftp server into our app, and then we have
     * to delete these files from the ftp server.
     *
     * @var array
     */
    protected array $filteredFileNames;

    /**
     * Here we set if the connection mode is test or live, and get the ftp credentials from the database.
     */
    public function __construct(string $connectionName)
    {
        $this->connectionName = $connectionName;
        $this->setConnectionMode();
        $this->getFtpCredentials();
    }

    private function setConnectionMode(): void
    {
        //Set whether the connection is live or test, based on the environment
        config('app.env') === 'local' ? $this->connectionMode = 'test': $this->connectionMode = 'live';
    }

    private function getFtpCredentials(): void
    {
        //Get the ftp credentials from the database
        $this->tmsFtpCredential = TmsFtpCredential::where('name', $this->connectionName)
                                                    ->where('connection_mode', $this->connectionMode)
                                                    ->firstOrFail();
    }


    /**
     * This is the first step here. Get the list of all files in the ftp server. This might include
     * jpg files, txt files. Because of this, we will want to filter out only the json files, that 
     * contain the pamyra orders - in one of the steps after this.
     *
     * @return array    An array with all file names on the ftp server.
     */
    public function getFileList($ftpServer): array
    {
        // dd('getFileList triggered', $this->ftpServerStorage);//this line works
        //Get the list of all files in the ftp server
        try {

            //Typed property App\Services\FtpHandlerBase::$ftpServerStorage must not be accessed before initialization
            // $allFileNames = $this->ftpServerStorage->allFiles();//this line does not work. It quetly give no feedback, nothing happens., without any feedback.
            $allFileNames = $ftpServer->allFiles();//this line does not work. It quetly give no feedback, nothing happens., without any feedback.


            //This feedback appears after a minute of waiting:
            //app/Services/FtpHandlerBase.phpError: Unable to list contents for '', deep listing
            //Reason:Unable to connect to host beta.simplelogistik.de at port 7876.

            dd($allFileNames);//this is never reached
            return $allFileNames;
            
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage() . PHP_EOL;
            Log::error('Error: ' . $e->getMessage());
        }
    }

    /**
     * When we get a list of filenames currently on the ftp server, we want only the pamyra json files,
     * that contain the orders. These have 2 distinct characteristics:
     * 1. They are json files or csv files or...
     * So, we want to get these specific files, and ignore all the rest.
     *
     * @param array $allFileNames
     * @param string $desiredFileType
     * @return array
     */
    public function filterFiles(array $allFileNames, string $desiredFileType): array
    {
        $filteredFileNames = array_filter($allFileNames, function ($fileName, $desiredFileType) {
            return strpos($fileName, $desiredFileType) !== false;
        });

        $this->filteredFileNames = $filteredFileNames;

        return $filteredFileNames;
    }

    /**
     * If there are any pamyra files at all, we can continue. If there are no pamyra files, we can stop
     * the process here.
     *
     * @param array $fileNames
     * @return void
     */
    protected function checkIsThisEmpty(array $fileNames): void
    {
        if (empty($fileNames)) {
            echo 'No files found on FTP server.' . PHP_EOL;
            Log::info('No files found on FTP server.');
            exit;
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
     * @return string                   The new file name
     */
    protected function createNewFileName(string $fileName): string
    {
        return $this->newFilePath . Carbon::now()->format('Y_m_d') . '_' . basename($fileName); 
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
    // public function moveAndArchiveFilesFromFtp(): void
    // {
    //     echo 'Moving files from FTP server to our app started.' . PHP_EOL;

    //     foreach ($this->filteredFileNames as $fileName) {

    //         //Check if file exists on ftp server
    //         if($this->ftpServerStorage->exists($fileName)) {
    //             echo $fileName . ' exists on FTP server!' . PHP_EOL;
    //             Log::info($fileName . ' exists on FTP server!');
    //         }

    //         try {

    //             // Read the file content from the sftp ftpServerStorage
    //             $fileContent = $this->ftpServerStorage->get($fileName);

    //             //Write the file to ./documents/... dir.
    //             $isWritten = Storage::disk('documents')->put(
    //                 $this->createNewFileName($fileName),
    //                 $fileContent
    //             );

    //             if($isWritten) {
    //                 echo $fileName . ' was written to the local disk.' . PHP_EOL;
    //                 Log::info($fileName . ' was written to the local disk.');
    //             }

    //         } catch (\Throwable $th) {

    //             Log::error('Error: ' . $th->getMessage());
    //             echo 'Error: ' . $th->getMessage() . PHP_EOL;

    //         } finally {
                
    //             //Delete the original json file from the ftp server
    //             $isDeleted = $this->ftpServerStorage->delete($fileName);
    //             if($isDeleted) {
    //                 echo $fileName . ' was deleted from FTP server.' . PHP_EOL;
    //                 echo PHP_EOL;
    //             } else {
    //                 Log::error($fileName . ' can not be deleted from FTP server');
    //                 echo $fileName . ' can not be deleted from FTP server' . PHP_EOL;
    //             }
    //         }
    //     }

    //     echo 'Moving files from FTP server to our app ended.' . PHP_EOL;
    // }
}