<?php

namespace App\Services\PamyraServices;

use DateTime;

/**
 * Formats dates from Pamyra json data to our database format.
 */
trait DateFormatterTrait
{
    public function formatPamyraDateTime(

        /**
         * dateOfSales from Pamyra json data is in this format.
         */
        string $date, 

        /**
         * dateOfSales from Pamyra json data is in this format.
         */
        string $inputFormat = 'd.m.Y H:i', 

        /**
         * We use this format in our database.
         */
        string $outputFormat = 'Y-m-d H:i:s'
    )
    {
        $dateTime = DateTime::createFromFormat($inputFormat, $date);
        $formattedDate = $dateTime->format($outputFormat);
        return $formattedDate;
    }
}