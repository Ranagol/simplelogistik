<?php

namespace App\Services;

use App\Models\TmsFtpCredential;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FtpHandlerBase
{
    /**
     * @var string
     */
    protected string $connectionName;

    protected string $connectionMode;

    /**
     * Stores the ftp credentials for the connection.
     *
     * @var TmsFtpCredential
     */
    protected TmsFtpCredential $tmsFtpCredential;

    /**
     * This is the Pamyra FTP server instance/storage, that we will use to access the orders.
     */
    protected $ftpServerStorage;

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
     * This is the main function in this trait, that triggers all other functions.
     *
     * @param string $connectionName
     * @return void
     */
    public function connect(string $connectionName): void
    {
        $this->connectionName = $connectionName;
        $this->setConnectionMode();
        $this->getFtpCredentials();
        $this->createFtpServerStorage();
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

    private function createFtpServerStorage(): void
    {
        // dd($this->tmsFtpCredential);//ez itt ok

        //Create a new ftpServerStorage instance, with pamyra ftp credentials, for accessing orders.
        $this->ftpServerStorage = Storage::build(
            [
                'driver' => $this->tmsFtpCredential->driver,
                'host' => $this->tmsFtpCredential->host,
                'username' => $this->tmsFtpCredential->username,
                'password' => $this->tmsFtpCredential->password,
                'port' => intval($this->tmsFtpCredential->port),
                'root' => $this->tmsFtpCredential->path,
                'throw' => true
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
        //Get the list of all files in the ftp server
        try {
            $allFileNames = $this->ftpServerStorage->allFiles();
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
}