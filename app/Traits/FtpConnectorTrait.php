<?php

namespace App\Traits;

use App\Models\TmsFtpCredential;
use Illuminate\Support\Facades\Storage;

trait FtpConnectorTrait
{
    /**
     * 
     * @var string
     */
    private string $connectionName;

    private string $connectionMode;

    /**
     * Stores the ftp credentials for the connection.
     *
     * @var TmsFtpCredential
     */
    private TmsFtpCredential $tmsFtpCredential;

    /**
     * This is the Pamyra FTP server instance/storage, that we will use to access the orders.
     */
    private $ftpServerStorage;

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
        if(env('APP_ENV') === 'local') {
            $this->connectionMode = 'test';
        } else {
            $this->connectionMode = 'live';
        }
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
}