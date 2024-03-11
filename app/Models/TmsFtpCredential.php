<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmsFtpCredential extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = 'tms_ftp_credentials';

    protected $casts = [
        'passive' => 'boolean',
        'ssl' => 'boolean',
        'throw' => 'boolean',
    ];

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
    // public function __construct()
    // {
    //     $this->ftpConnnectionDetails = [
    //         [
    //             'name' => 'PamyraOrders',
    //             'connection_mode' => 'test',
    //             'driver' => 'sftp',
    //             'host' => 'beta.simplelogistik.de',
    //             'port' => 7876,
    //             'username' => config('ftp.pamyraFtpUsername'),
    //             'password' => config('ftp.pamyraFtpPassword'),
    //             'path' => 'upload/andor',
    //             'passive' => false,
    //             'ssl' => false,
    //             'throw' => true,//in test/local mode, throw error if file not found. In live mode, don't throw error.
    //             'comment' => 'Test comment.',
    //         ],
    //         [
    //             'name' => 'PamyraOrders',
    //             'connection_mode' => 'live',
    //             'driver' => 'sftp',
    //             'host' => 'beta.simplelogistik.de',
    //             'port' => 7876,
    //             'username' => config('ftp.pamyraFtpUsername'),
    //             'password' => config('ftp.pamyraFtpPassword'),
    //             'path' => 'upload',
    //             'passive' => false,
    //             'ssl' => false,
    //             'throw' => false,//in test/local mode, throw error if file not found. In live mode, don't throw error.
    //             'comment' => 'Test comment.',
    //         ],
    //         [
    //             'name' => 'EmonsInvoices',
    //             'connection_mode' => 'test',
    //             'driver' => 'ftp',
    //             'host' => 'ftp.simplelogistik.de',
    //             'port' => null,
    //             'username' => config('ftp.emonsFtpUsername'),
    //             'password' => config('ftp.emonsFtpPassword'),
    //             'path' => 'Rechnungen/Copies',
    //             'passive' => true,
    //             'ssl' => true,
    //             'throw' => true,//in test/local mode, throw error if file not found. In live mode, don't throw error.
    //             'comment' => 'Emons FTP server must have ssl and passive mode enabled.',
    //         ],
    //         [
    //             'name' => 'EmonsInvoices',
    //             'connection_mode' => 'live',
    //             'driver' => 'ftp',
    //             'host' => 'ftp.simplelogistik.de',
    //             'port' => null,
    //             'username' => config('ftp.emonsFtpUsername'),
    //             'password' => config('ftp.emonsFtpPassword'),
    //             'path' => 'Rechnungen',
    //             'passive' => true,
    //             'ssl' => true,
    //             'throw' => false,//in test/local mode, throw error if file not found. In live mode, don't throw error.
    //             'comment' => 'Emons FTP server must have ssl and passive mode enabled.',
    //         ],
    //     ];
    // }

    // /**
    //  * Get the value of ftpConnnectionDetails
    //  */ 
    // public function getFtpConnectionDetails()
    // {
    //     return $this->ftpConnnectionDetails;
    // }
}
