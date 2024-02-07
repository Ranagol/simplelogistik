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
        // DB::table('tms_emons_invoices')->insert($invoices);
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
            $invoices[] = $rowInCsvFile;
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


}