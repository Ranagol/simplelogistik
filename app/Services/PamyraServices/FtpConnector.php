<?php

namespace App\Services\PamyraServices;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * Handles all ftp related actions, like getting and formatting data from the FTP server.
 * All in all, it returns a nested array of pamyra orders. It is nested, because there might be
 * multiple json files with orders, and each file might have multiple orders.
 * Reminder: Pamyra orders are in a json file
 */
class FtpConnector
{
    /**
     * This is the main function in this class, that triggers all other functions.
     *
     * @return array
     */
    public function handle(): array
    {
        $allFileNames = $this->getFileList();
        // dd($allFileNames);
        $pamyraFileNames = $this->filterFileNames($allFileNames);
        // dd($pamyraFileNames);
        $pamyraOrders = $this->handlePamyraFiles($pamyraFileNames);
        // dump($pamyraOrders);
        Log::debug($pamyraOrders);
        // dd($pamyraOrders);

        return $pamyraOrders;
    }

    /**
     * Get the list of all files in the ftp server.
     *
     * @return array
     */
    private function getFileList(): array
    {
        //Get the list of all files in the ftp server
        try {
            $allFileNames = Storage::disk('sftp')->allFiles();
            return $allFileNames;
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage() . PHP_EOL;
        }
    }

    /**
     * When we get a list of filenames currently on the ftp server, we want only the pamyra json files,
     * that contain the orders. These have 2 distinct characteristics:
     * 1. They are json files
     * 2. They all have the string '/PAM' in their name
     * 
     * So, we want to get these specific files, and ignore all the rest.
     *
     * @param array $allFileNames
     * @return array
     */
    private function filterFileNames(array $allFileNames): array
    {
        return array_filter($allFileNames, function ($fileName) {
            return strpos($fileName, '.json') !== false && strpos($fileName, 'upload/PAM') !== false;
        });
    }

    private function handlePamyraFiles(array $pamyraFileNames): array
    {
        $pamyraOrders = [];

        foreach ($pamyraFileNames as $pamyraJsonFile) {
            $pamyraOrders[] = Storage::disk('sftp')->json($pamyraJsonFile);
        }
        return $pamyraOrders;
    }

}
