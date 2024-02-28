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

    /**
     * This is the main method of this class. It will trigger all other helper methods.
     *
     * @return void
     */
    // public function handle(): void
    // {
    //     // $invoices = $this->getFileFromEmons();

    //     $invoices = $this->transformCsvToArray();

    //     $this->checkIfInvoicesExist($invoices);

    //     $invoices = $this->removeDuplicates($invoices);

    //     $this->createInvoices($invoices);

    //     $this->archiveFile();
    // }

    

    /**
     * Checks if there are any invoices in the csv file. If not, it logs it.
     *
     * @param array $invoices
     * @return void
     */
    private function checkIfInvoicesExist(array $invoices): void
    {
        if (empty($invoices)) {
            $message = 'No invoices found in the csv file.';
            echo $message . PHP_EOL;;
            Log::info($message);
            exit;
        }
    }

    /**
     * Checks if there are any duplicates in the csv file. If there are, it removes them from the array.
     * The duplicates will be logged, and then removed from the array. So we will write only the
     * non-duplicates to the database.
     *
     * @param array $invoices
     * @return array
     */
    private function removeDuplicates(array $invoices): array
    {
        //Get all our already existing order numbers from emons_invoices table
        $orderNumbers = DB::table('tms_emons_invoices')->pluck('order_number')->toArray();

        //Array of order numbers that already exist in the database - duplicates
        $duplicateOrderNumbers = array_intersect($orderNumbers, array_column($invoices, 'order_number'));

        if (!empty($duplicateOrderNumbers)) {
            // throw new \Exception('The following order numbers already exist in the database: ' . implode(', ', $duplicateOrderNumbers));
            echo 'The following order numbers already exist in the database: ' . implode(', ', $duplicateOrderNumbers) . PHP_EOL;
            Log::error("The following order numbers already exist in the database: " . implode(', ', $duplicateOrderNumbers));
        }

        //Remove duplicates from the array
        $invoices = array_filter(
            $invoices, 
            function ($invoice) use ($duplicateOrderNumbers) {

                return !in_array(
                    $invoice['order_number'], 
                    $duplicateOrderNumbers
                );
            }
        );

        return $invoices;
    }

    private function createInvoices(array $invoices): void
    {
        foreach ($invoices as $invoice) {

            $validator = Validator::make($invoice, $this->validationRules);
            
            /**
             * If the validation fails, we log the error and continue to the next invoice, skipping 
             * the faulty one.
             */
            if ($validator->fails()) {
                Log::error($validator->errors()->first());
                echo $validator->errors()->first() . ' In order number ' . $invoice['order_number'] . PHP_EOL;
                continue;
            }
    
            TmsEmonsInvoice::create($invoice);
        }
    }

}