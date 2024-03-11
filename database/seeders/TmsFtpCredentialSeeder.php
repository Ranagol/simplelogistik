<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TmsFtpCredential;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TmsFtpCredentialSeeder extends Seeder
{
    /**
     * This here should be a constant, but it can't be because it uses config() and env() functions.
     * So, it is a private property instead with a getter. 
     * We set the value of this property in the constructor. Because this is the only place for
     * us to use config() and env() functions, so we could pull in username and password from config, 
     * from .env file.
     *
     * @var array
     */
    private array $ftpConnnectionDetails;
    
    /**
     * So, construct pulls in the username and password from config, from .env file, and creates
     * the array of ftp connection details. When this is done, with a getter we can access this array,
     * and use it in the seeder.
     */
    public function __construct()
    {
        $this->ftpConnnectionDetails = [
            [
                'name' => 'PamyraOrders',
                'connection_mode' => 'test',
                'driver' => 'sftp',
                'host' => 'beta.simplelogistik.de',
                'port' => 7876,
                'username' => config('ftp.pamyraFtpUsername'),
                'password' => config('ftp.pamyraFtpPassword'),
                'path' => 'upload/andor',
                'passive' => false,
                'ssl' => false,
                'throw' => true,//in test/local mode, throw error if file not found. In live mode, don't throw error.
                'comment' => 'Test comment.',
            ],
            [
                'name' => 'PamyraOrders',
                'connection_mode' => 'live',
                'driver' => 'sftp',
                'host' => 'beta.simplelogistik.de',
                'port' => 7876,
                'username' => config('ftp.pamyraFtpUsername'),
                'password' => config('ftp.pamyraFtpPassword'),
                'path' => 'upload',
                'passive' => false,
                'ssl' => false,
                'throw' => false,//in test/local mode, throw error if file not found. In live mode, don't throw error.
                'comment' => 'Test comment.',
            ],
            [
                'name' => 'EmonsInvoices',
                'connection_mode' => 'test',
                'driver' => 'ftp',
                'host' => 'ftp.simplelogistik.de',
                'port' => null,
                'username' => config('ftp.emonsFtpUsername'),
                'password' => config('ftp.emonsFtpPassword'),
                'path' => 'Rechnungen/Copies',
                'passive' => true,
                'ssl' => true,
                'throw' => true,//in test/local mode, throw error if file not found. In live mode, don't throw error.
                'comment' => 'Emons FTP server must have ssl and passive mode enabled.',
            ],
            [
                'name' => 'EmonsInvoices',
                'connection_mode' => 'live',
                'driver' => 'ftp',
                'host' => 'ftp.simplelogistik.de',
                'port' => null,
                'username' => config('ftp.emonsFtpUsername'),
                'password' => config('ftp.emonsFtpPassword'),
                'path' => 'Rechnungen',
                'passive' => true,
                'ssl' => true,
                'throw' => false,//in test/local mode, throw error if file not found. In live mode, don't throw error.
                'comment' => 'Emons FTP server must have ssl and passive mode enabled.',
            ],
        ];
    }

    /**
     * Run the database seeds. Gets the credentials, and for every credential record, creates a new
     * record in the tms_ftp_credentials table.
     */
    public function run(): void
    {
        foreach($this->ftpConnnectionDetails as $ftpCredential) {
            TmsFtpCredential::create($ftpCredential);
        }
    }
}
