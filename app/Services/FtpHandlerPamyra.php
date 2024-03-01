<?php

namespace App\Services;

use App\Services\FtpHandlerBase;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FtpHandlerPamyra extends FtpHandlerBase
{
    /**
     * Will collect all pamyra orders from all pamyra json files from the ftp server into an array.
     * Here we loop through every pamyra json file, and extract its content into an array.
     * The end goal is to have all pamyra orders from all pamyra json files in one php array.
     * 
     * This function is specific only to Pamyra orders.
     *
     * @param array $pamyraFileNames    All pamyra json file names
     * @return array
     */
    public function jsonToArrayConvert(array $pamyraFileNames): array
    {
        $pamyraOrders = [];

        foreach ($pamyraFileNames as $pamyraJsonFile) {
            $pamyraOrders[] = $this->ftpServer->json($pamyraJsonFile);

        }

        return $pamyraOrders;
    }
}