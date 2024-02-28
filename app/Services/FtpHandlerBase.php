<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\TmsFtpCredential;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\FilesystemAdapter;

class FtpHandlerBase
{
    /**
     * The connection name for the ftp server. Example: PamyraOrders
     *
     * @var string
     */
    protected string $connectionName;

    /**
     * This is the connection mode. It can be test or live.
     *
     * @var string
     */
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
    protected FilesystemAdapter $ftpServer;

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
     * Here we set if the connection mode is test or live, and get the ftp credentials from the 
     * database.
     */
    public function __construct(string $connectionName, string $newFilePath)
    {
        $this->connectionName = $connectionName;
        $this->newFilePath = $newFilePath;
        $this->setConnectionMode();
        $this->getFtpCredentials();
        $this->createFtpServerStorage();
    }

    /**
     * Set whether the connection is live or test, based on the .env file
     *
     * @return void
     */
    private function setConnectionMode(): void
    {
        //Set whether the connection is live or test, based on the environment
        config('app.env') === 'local' ? $this->connectionMode = 'test': $this->connectionMode = 'live';
    }

    /**
     * Get the ftp credentials from the database
     *
     * @return void
     */
    private function getFtpCredentials(): void
    {
        //Get the ftp credentials from the database
        $this->tmsFtpCredential = TmsFtpCredential::where('name', $this->connectionName)
                                                    ->where('connection_mode', $this->connectionMode)
                                                    ->firstOrFail();
    }

    /**
     * Create the ftp server storage instance
     *
     * @return void
     */
    private function createFtpServerStorage(): void
    {
        $this->ftpServer = Storage::build(
            [
                'driver' => $this->tmsFtpCredential->driver,
                'host' => $this->tmsFtpCredential->host,
                'username' => $this->tmsFtpCredential->username,
                'password' => $this->tmsFtpCredential->password,
                'port' => $this->tmsFtpCredential->port,
                'root' => $this->tmsFtpCredential->path,
                'passive' => $this->tmsFtpCredential->passive,
                'ssl' => $this->tmsFtpCredential->ssl,
                'throw' => $this->tmsFtpCredential->throw,
            ]
        );
    }

    /**
     * This is the first step here. Get the list of all files in the ftp server. This might include
     * jpg files, txt files. Because of this, we will want to filter out only the json files, that 
     * contain the pamyra orders - in one of the steps after this.
     *
     * @return array    An array with all file names on the ftp server.
     */
    public function getFileList(): array
    {
        // dump($this->connectionName);
        // dump($this->connectionMode);
        // dump($this->newFilePath);
        // dump($this->tmsFtpCredential);
        // dump($this->ftpServer);

        echo 'getFileList() triggered.' . PHP_EOL;
        //Get the list of all files in the ftp server
        try {

            $allFileNames = $this->ftpServer->allFiles();
            dd($allFileNames);
            return $allFileNames;
            
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage() . PHP_EOL;
            Log::error('Error: ' . $e->getMessage());
        }
    }

    /**
     * When we get a list of filenames currently on the ftp server, we want only specific files
     * formats. Example, for the pamyra orders, we want only the json files. This function filters
     * out only the files that have the desired file type.
     *
     * @param array $allFileNames
     * @param string $desiredFileType
     * @return array
     */
    public function filterFiles(array $allFileNames, string $desiredFileType): array
    {
        $filteredFileNames = array_filter(
            $allFileNames, 
            function ($fileName) use ($desiredFileType){
                return strpos($fileName, $desiredFileType) !== false;
            }
        );

        //We need this data later, for deleting the files from the ftp server
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
    protected function checkIfServerEmpty(array $fileNames): void
    {
        if (empty($fileNames)) {
            $message = 'No desired files found on FTP server.';
            echo $message . PHP_EOL;
            Log::info($message);
            exit;
        }
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
    public function archiveFiles(): void
    {
        echo 'Moving files from FTP server to our app started.' . PHP_EOL;

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

        echo 'Moving files from FTP server to our app ended.' . PHP_EOL;
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
}