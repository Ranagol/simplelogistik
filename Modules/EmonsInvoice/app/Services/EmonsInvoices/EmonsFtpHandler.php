<?php

namespace Modules\EmonsInvoice\app\Services\EmonsInvoices;

use App\Models\TmsFtpCredential;
use Illuminate\Support\Facades\Storage;

class EmonsFtpHandler {

    private array $filteredFileNames;
    private $emonsFtpServer;
    private string $connectionName;

    public function __construct() {
        
        if(env('APP_ENV') === 'local') {
            $this->connectionName = 'EmonsInvoicesTest';
        } else {
            $this->connectionName = 'EmonsInvoicesLive';
        }

        $ftpCredential = TmsFtpCredential::where('name', $this->connectionName)->firstOrFail();

        $this->emonsFtpServer = Storage::build(
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
}