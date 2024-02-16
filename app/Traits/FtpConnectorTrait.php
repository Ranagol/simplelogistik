<?php

namespace App\Traits;

use App\Models\TmsFtpCredential;
use Illuminate\Support\Facades\Storage;

trait FtpConnectorTrait
{
    /**
     * @var string
     */
    private string $connectionNameTest;

    /**
     * @var string
     */
    private string $connectionNameLive;

    /**
     * $connectionNameTest is the name of the connection to the test ftp server dir.
     * $connectionNameLive is the name of the connection to the live ftp server dir.
     * $connectionName is either test name (when the app is in local environment) or live name 
     * (when the app is in production environment)
     * 
     * @var string
     */
    private string $connectionName;

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

    public function connect(string $ftpCredentialName): void
    {
        $this->getTestConnectionName($ftpCredentialName);
        $this->getLiveConnectionName($ftpCredentialName);
        $this->setConnectionName();
        $this->getFtpCredentials();
        $this->createFtpServerStorage();
    }

    private function getTestConnectionName(string $ftpCredentialName): void
    {
        $this->connectionNameTest = TmsFtpCredential::where('name', $ftpCredentialName)
                                                ->where('type', 'test')
                                                ->firstOrFail();
    }

    private function getLiveConnectionName(string $ftpCredentialName): void
    {
        $this->connectionNameLive = TmsFtpCredential::where('name', $ftpCredentialName)
                                                ->where('type', 'live')
                                                ->firstOrFail();
    }

    private function setConnectionName(): void
    {
        //Set whether the connection is live or test, based on the environment
        if(env('APP_ENV') === 'local') {
            $this->connectionName = $this->connectionNameTest;
        } else {
            $this->connectionName = $this->connectionNameLive;
        }
    }

    private function getFtpCredentials(): void
    {
        //Get the ftp credentials from the database
        $this->tmsFtpCredential = TmsFtpCredential::where('name', $this->connectionName)->firstOrFail();
    }

    private function createFtpServerStorage(): void
    {
        //Create a new ftpServerStorage instance, with pamyra ftp credentials, for accessing orders.
        $this->ftpServerStorage = Storage::build(
            [
                'driver' => 'sftp',
                'host' => $this->ftpCredential->host,
                'username' => $this->ftpCredential->username,
                'password' => $this->ftpCredential->password,
                'port' => intval($this->ftpCredential->port),
                'root' => $this->ftpCredential->path,
                'throw' => true
            ]
        );
    }
}