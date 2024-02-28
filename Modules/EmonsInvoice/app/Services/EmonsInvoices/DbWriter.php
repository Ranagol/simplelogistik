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
 * Extracts data from csv file, transforms it into an array, and writes it into the database.
 */
class DbWriter
{
    private array $validationRules;

    /**
     * We import this way the validation rules from the TmsEmonsInvoiceRequest class. This will be
     * needed, when we write data into the tms_emons_invoices table.
     */
    public function __construct()
    {
        $tmsEmonsInvoiceRequest = new TmsEmonsInvoiceRequest();
        $this->validationRules = $tmsEmonsInvoiceRequest->emonsInvoiceRules();
    }

    public function createInvoice(array $invoice): void
    {
        $isDuplicate = $this->checkForDuplicates($invoice);

        if (!$isDuplicate) {
            $validator = Validator::make($invoice, $this->validationRules);
        
            /**
             * If the validation fails, we log the error and continue to the next invoice, skipping 
             * the faulty one.
             */
            if ($validator->fails()) {
                Log::error($validator->errors()->first());
                echo $validator->errors()->first() . ' In order number ' . $invoice['order_number'] . PHP_EOL;
            }

            TmsEmonsInvoice::create($invoice);
        }
    }

    private function checkForDuplicates(array $invoice): bool
    {
        $orderNumber = $invoice['order_number'];

        $invoiceDuplicate= TmsEmonsInvoice::where('order_number', $orderNumber)->get();
        // dd($invoiceDuplicate);

        if (!$invoiceDuplicate->empty()){
            $message = 'The order number ' . $orderNumber . ' already exists in the database.';
            echo $message . PHP_EOL;
            Log::info($message);
            return true;
        }

        return false;
    }

    



    

}