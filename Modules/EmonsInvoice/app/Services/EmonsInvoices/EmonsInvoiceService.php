<?php

namespace Modules\EmonsInvoice\app\Services\EmonsInvoices;

use UConverter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\TmsEmonsInvoiceRequest;
use App\Models\TmsEmonsInvoice;

/**
 * This class is triggered by the hanldeEmonsInvoices command. This coordinates the whole process of
 * getting the emons invoices from the ftp server, transforming them into an array, and writing them
 * into the database, by triggering other helper classes.
 */
class EmonsInvoiceService
{
    /**
     * The FtpHandlerEmons instance.
     */
    protected $emonsFtpHandler;

    public function __construct()
    {
        $this->emonsFtpHandler = new FtpHandlerEmons();
    }
    
    /**
     * This is the main method of this class. It will trigger all other helper methods.
     *
     * @return void
     */
    public function handle(): void
    {
        echo 'Command triggered. ' . PHP_EOL;

        // $ftp_server = "ftp.simplelogistik.de";
        // $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
        // $login = ftp_login($ftp_conn, 'simplv_14', 'VQw5fXLT4VSUBeFQ');
        // $mode = ftp_pasv($ftp_conn, TRUE);//"Passive mode turned on.";
        // if ($login) {
        //     echo "Login successful!" . PHP_EOL;//login successful, this is ok
        // } else {
        //     echo "Login failed!" . PHP_EOL;
        // }
        // $contents = ftp_nlist($ftp_conn, "./Rechnungen/Copies");//this is false, as in false = means error
        // var_dump($contents);
        // ftp_close($ftp_conn);

        try {
            $files = Storage::disk('emons')->files('/');// League\Flysystem\UnableToListContents. Unable to list contents for '', shallow listing. Reason: ftp_raw(): Connection timed out
            dd($files); 
        } catch (\Throwable $th) {
            echo "Error: " . $th->getMessage();
            // throw $th;
        }
        

        // $invoices = $this->emonsFtpHandler->getEmonsInvoices();
    }

    
    


}