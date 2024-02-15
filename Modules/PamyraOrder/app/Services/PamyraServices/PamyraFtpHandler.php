<?php

namespace Modules\PamyraOrder\app\Services\PamyraServices;

use Exception;
use Carbon\Carbon;
use App\Models\TmsFtpCredential;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * This class connects to an sftp server, and handles files from here.
 */
class PamyraFtpHandler
{
    /**
     * Stores all relevant json file name from the ftp server, from where we will write
     * Pamyra orders to the database. Later, when this is done, we will need these file names
     * again, because we have to copy these files from the ftp server into our app, and then we have
     * to delete these files from the ftp server.
     *
     * @var array
     */
    private array $filteredFileNames;

    /**
     * This is the Pamyra FTP server instance, that we will use to access the orders.
     *
     */
    private $pamyraFtpServer;

    private string $connectionName;

    public function __construct()
    {
        //Set whether the connection is live or test, based on the environment
        if(env('APP_ENV') === 'local') {
            $this->connectionName = 'PamyraOrdersTest';
        } else {
            $this->connectionName = 'PamyraOrdersLive';
        }

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
        // dd($allFilesInFtpServer);

        //Filter out only those files that are Pamyra orders (which have json in their name), ignore all the other files
        $pamyraFileNames = $this->filterJsonFiles($allFilesInFtpServer);
        dd($pamyraFileNames);

        //If there are no pamyra files, we can stop the process here
        $this->checkPamyraFiles($pamyraFileNames);

        //Will collect all pamyra orders from all pamyra json files from the ftp server into an array
        $pamyraOrders = $this->handlePamyraFiles($pamyraFileNames);

        return $pamyraOrders;
    }

    /**
     * This is the first step here. Get the list of all files in the ftp server. This might include
     * jpg files, txt files. Because of this, we will want to filter out only the json files, that 
     * contain the pamyra orders - in one of the steps after this.
     *
     * @return array    An array with all file names on the ftp server.
     */
    private function getFileList(): array
    {
        //Get the list of all files in the ftp server
        try {
            $allFileNames = $this->pamyraFtpServer->allFiles();
            return $allFileNames;
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage() . PHP_EOL;
            Log::error('Error: ' . $e->getMessage());
        }
    }

    /**
     * When we get a list of filenames currently on the ftp server, we want only the pamyra json files,
     * that contain the orders. These have 2 distinct characteristics:
     * 1. They are json files
     * So, we want to get these specific files, and ignore all the rest.
     *
     * @param array $allFileNames
     * @return array
     */
    private function filterJsonFiles(array $allFileNames): array
    {
        $filteredFileNames = array_filter($allFileNames, function ($fileName) {
            return strpos($fileName, '.json') !== false;
        });

        $this->filteredFileNames = $filteredFileNames;

        return $filteredFileNames;
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
            $pamyraOrders[] = $this->pamyraFtpServer->json($pamyraJsonFile);

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
            if($this->pamyraFtpServer->exists($fileName)) {
                echo $fileName . ' exists on FTP server!' . PHP_EOL;
            }

            try {

                // Read the file content from the sftp pamyraFtpServer
                $fileContent = $this->pamyraFtpServer->get($fileName);

                //Write the file to the loca->pamyraFtpServer, with renaming.
                $isWritten = Storage::disk('local')->put(
                    $this->createNewFileName($fileName),
                    $fileContent
                );

                if($isWritten) {
                    echo $fileName . ' was written to the local disk.' . PHP_EOL;
                }

            } catch (\Throwable $th) {

                echo 'Error: ' . $th->getMessage() . PHP_EOL;

            } finally {
                
                //Delete the original json file from the ftp server
                $isDeleted = $this->pamyraFtpServer->delete($fileName);
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
     * storage/app/PamyraOrders/Archived/2024_02_07_PAM240206-1452140740.json
     *
     * @param string $fileName
     * @return string
     */
    private function createNewFileName(string $fileName): string
    {
        return 'PamyraOrders/Archived/' . Carbon::now()->format('Y_m_d') . '_' . basename($fileName); 
    }
}
