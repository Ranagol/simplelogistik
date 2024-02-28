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
     * This array is crucial for transforming the csv file into an array with the right names for
     * the keys. The keys are the column names in the database table. So, in the end we will have
     * something like this example: customer_city => 'Großrinderfeld [Gerchsheim]'.
     *
     * @var array
     */
    private array $keys = [
        0 => 'emons_invoice_number',
        1 => 'billing_date',
        2 => 'order_number',
        3 => 'customer_name',
        4 => 'customer_country_code',
        5 => 'customer_zip_code',
        6 => 'customer_city',
        7 => 'receiver_name',
        8 => 'receiver_country_code',
        9 => 'receiver_zip_code',
        10 => 'receiver_city',
        11 => 'netto_price',
    ];

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
    public function handle(): void
    {
        // $invoices = $this->getFileFromEmons();

        $invoices = $this->transformCsvToArray();

        $this->checkIfInvoicesExist($invoices);

        $invoices = $this->removeDuplicates($invoices);

        $this->createInvoices($invoices);

        // $this->archiveFile();
    }

    
    
    /**
     * We use raw php to read the csv file, because the Storage facade does not want to recognize
     * any paths, that otherwise work with raw php.
     *
     * @return array
     */
    private function getFileFromEmons()
    {

    }

    private function transformCsvToArray(): array
    {
        $path = storage_path('/app/EmonsInvoice/Inbox/emonsInvoices.CSV');
        $file = fopen($path, 'r');
        $invoices = [];

        /**
         * We read the csv file row/line by row/line, and transform each row/line into an array.
         * Every row/line is one invoice. Insid the row/line, the columns are separated by a pipe '|'.
         * So we must use the pipe as the delimiter argument for the fgetcsv function.
         * $rowInCsvFile looks like this:
         * array:12 [
         *     0 => "0201002145"
         *     1 => "2023-01-16"
         *     2 => "437560"
         *     3 => "AUTO-PALAK - Pawel Palak"
         *     4 => "DE"
         *     5 => "97950"
         *     6 => "Gro�rinderfeld [Gerchsheim]"
         *     7 => "J�rg Schneider"
         *     8 => "DE"
         *     9 => "02733"
         *     10 => "Cunewalde"
         *     11 => "42.00"
         *   ]
         */
        while (($rowInCsvFile = fgetcsv($file, null, '|')) !== false) {

            //Every row/line in the csv file is an invoice. We will store here the invoice data.
            $invoice = [];
            

            /**
             * $this->keys contains the future column names in the database table. We have to replace
             * the numeric keys in $rowInCsvFile with the keys from $this->keys.
             * While we are doing this, we do another thing at the same time: we encode the content
             * from csv file to UTF-8. This is necessary, because the content from the csv file is
             * encoded in ISO-8859-1, and we must store it in the database in UTF-8.
             */
            foreach ($this->keys as $key => $value) {

                /**
                 * mb_convert_encoding - not working
                 * UConverter::transcode(($rowInCsvFile[$key]), 'ISO-8859-1', 'UTF-8'); - not working
                 * $invoice[$value] = utf8_encode($rowInCsvFile[$key]);//working, but deprecated
                 * $invoice[$value] = iconv('ISO-8859-1', 'UTF-8', $rowInCsvFile[$key]);//this works perfectly
                 */
                $invoice[$value] = iconv('ISO-8859-1', 'UTF-8', $rowInCsvFile[$key]);

            }

            $invoices[] = $invoice;
        }

        fclose($file);

        return $invoices;
    }

    /**
     * Checks if there are any invoices in the csv file. If not, it throws an exception.
     *
     * @param array $invoices
     * @throws \Exception
     * @return void
     */
    private function checkIfInvoicesExist(array $invoices): void
    {
        if (empty($invoices)) {
            throw new \Exception('No invoices found in the csv file.');
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