<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FtpHandlerEmons extends FtpHandlerBase
{
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

    public function convertCsvToArray(array $csvFileNames): array
    {
        $emonsInvoices = [];

        foreach ($csvFileNames as $csvFileName) {
            $stream = $this->ftpServer->readStream($csvFileName);
            $invoicesFromStream = $this->transformCsvToArray($stream, $csvFileName);
            $emonsInvoices = array_merge($emonsInvoices, $invoicesFromStream);
        }
        
        return $emonsInvoices;
    }
    
    private function transformCsvToArray($stream, string $csvFileName): array
    {
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
        while (($rowInCsvFile = fgetcsv($stream, null, '|')) !== false) {

            //Every row/line in the csv file is an invoice. We will store here the invoice data.
            $invoice = [];
            
            /**
             * Every row in a csv file must have 12 fields, separated by a |. If the number of 
             * fields in the line is not 12, we skip this line, and log an error.
             */
            if (count($rowInCsvFile) !== 12) {
                $message =  "Invalid number of fields in the csv file row. The csv file name is: " . $csvFileName;
                echo $message . PHP_EOL;
                Log::error($message);
                continue;
            }

            /**
             * $this->keys contains the future column names in the database table. We have to replace
             * the numeric keys in $rowInCsvFile with the keys from $this->keys.
             * While we are doing this, we do another thing at the same time: we encode the content
             * from csv file to UTF-8. This is necessary, because the content from the csv file is
             * encoded in ISO-8859-1, and we must store it in the database in UTF-8.
             */
            foreach ($this->keys as $key => $value) {

                try {

                    /**
                     * mb_convert_encoding - not working
                     * UConverter::transcode(($rowInCsvFile[$key]), 'ISO-8859-1', 'UTF-8'); - not working
                     * $invoice[$value] = utf8_encode($rowInCsvFile[$key]);//working, but deprecated
                     * $invoice[$value] = iconv('ISO-8859-1', 'UTF-8', $rowInCsvFile[$key]);//this works perfectly
                     */
                    $invoice[$value] = iconv('ISO-8859-1', 'UTF-8', $rowInCsvFile[$key]);

                } catch (\Exception $e) {
                    $message = 'Wrong the the data structure of the csv file with the name ' . $csvFileName . '. The error is: ' . $e->getMessage() . PHP_EOL;

                    echo $message;
                    Log::error($message);
                    continue;
                }
            }
            $invoices[] = $invoice;
        }
        fclose($stream);
        return $invoices;
    }
}