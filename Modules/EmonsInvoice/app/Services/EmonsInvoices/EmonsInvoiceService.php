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
        $invoices = $this->emonsFtpHandler->getEmonsInvoices();
    }

    
    


}