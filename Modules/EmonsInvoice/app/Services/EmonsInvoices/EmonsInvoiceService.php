<?php

namespace Modules\EmonsInvoice\app\Services\EmonsInvoices;

use UConverter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\TmsEmonsInvoiceRequest;
use App\Models\TmsEmonsInvoice;

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
        $this->emonsFtpHandler->handle();
    }

    
    


}