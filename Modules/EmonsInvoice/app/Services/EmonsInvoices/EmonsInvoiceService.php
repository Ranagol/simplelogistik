<?php

namespace Modules\EmonsInvoice\app\Services\EmonsInvoices;

use Illuminate\Support\Facades\DB;
use App\Http\Requests\TmsEmonsInvoiceRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class EmonsInvoiceService
{
    private array $validationRules;

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
     * This is where we can find the original csv file, that contains all the invoices.
     * storage/app/EmonsInvoice/Inbox/emonsInvoices.CSV
     *
     * @var string
     */
    private string $sourcePath = 'app/EmonsInvoice/Inbox/emonsInvoices.CSV';

    /**
     * This is where we will move the original csv file, after we have processed it.
     *
     * @var string
     */
    private string $targetPath = '/EmonsInvoice/Archive';

    public function __construct()
    {
        $tmsEmonsInvoiceRequest = new TmsEmonsInvoiceRequest();
        $this->validationRules = $tmsEmonsInvoiceRequest->emonsInvoiceRules();//this does not work with injection
    }

    public function handle(): void
    {
        // echo "EmonsInvoiceService triggered" . PHP_EOL;
        // $invoices = $this->getFileFromEmons();
        $invoices = $this->transformCsvToArray();
        // $this->checkForDuplicates($invoices);
        // $this->validateEmonsInvoices($invoices);
        DB::table('tms_emons_invoices')->insert($invoices);
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
         */
        while (($rowInCsvFile = fgetcsv($file, null, '|')) !== false) {

            // $rowInCsvFile = array_map('utf8_encode', $rowInCsvFile);//TODO ANDOR ENCODING 1 (not working)this encoding is not working. We have to find a solution for this.

            //Every row/line in the csv file is an invoice. We will store here the invoice data.
            $invoice = [];
            

            /**
             * $rowInCsvFile looks like this:
             * *
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
            foreach ($this->keys as $key => $value) {
                // $invoice[$value] = $rowInCsvFile[$key];//original working code without encoding
                $invoice[$value] = mb_convert_encoding($rowInCsvFile[$key], 'ISO-8859-2', 'UTF-8');//TODO ANDOR ENCODING 2 (not working)
            }

            $invoices[] = $invoice;
        }

        fclose($file);

        return $invoices;
    }


    private function checkForDuplicates($invoices)
    {

    }

    private function validateEmonsInvoices(array $invoices)
    {
        $validator = Validator::make($invoices, $this->validationRules);
        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first());
        }
    }

    private function archiveFile()
    {

    }

    // /**
    //  * getting CSV array with UTF-8 encoding
    //  *
    //  * @param   resource    &$handle
    //  * @param   integer     $length
    //  * @param   string      $separator
    //  *
    //  * @return  array|false
    //  */
    // private function fgetcsvUTF8(&$handle, $length, $separator = ';')
    // {
    //     if (($buffer = fgets($handle, $length)) !== false)
    //     {
    //         $buffer = $this->autoUTF($buffer);
    //         return str_getcsv($buffer, $separator);
    //     }
    //     return false;
    // }

    // /**
    //  * automatic convertion windows-1250 and iso-8859-2 info utf-8 string
    //  *
    //  * @param   string  $s
    //  *
    //  * @return  string
    //  */
    // private function autoUTF($s)
    // {
    //     return iconv('WINDOWS-1250', 'UTF-8', $s);

    //     // detect UTF-8
    //     if (preg_match('#[\x80-\x{1FF}\x{2000}-\x{3FFF}]#u', $s))
    //         return $s;

    //     // detect WINDOWS-1250
    //     if (preg_match('#[\x7F-\x9F\xBC]#', $s))
    //         return iconv('WINDOWS-1252', 'UTF-8', $s);

    //     // assume ISO-8859-2
    //     return iconv('ISO-8859-2', 'UTF-8', $s);
    // }


}