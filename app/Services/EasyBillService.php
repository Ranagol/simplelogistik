<?php

namespace App\Services;

use App\Models\TmsOrder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Process;

class EasyBillService
{
    /**
     * Handles the order update or create.
     *
     * @param array $orderFromRequest
     * @return void
     */
    public function callEasyBillApi(TmsOrder $newlyCreatedRecord): void
    {
        /**
         * Call the Esaybill API to create a new invoice.
         */
        $id = $newlyCreatedRecord->id;
        $result = $this->execute('cd ..; php artisan sendinvoices orderId ' . $id . ';');
        /**
         * Todo: 
         * - check if the API call was successful.
         * - store result in session.
         * - display result in FE.
         */
    }

    /**
     * Execute a command in the terminal.
     *
     * @param [type] $cmd
     * @return string
     */
    public function execute($cmd): string
    {
        $process = Process::fromShellCommandline($cmd);

        $processOutput = '';

        $captureOutput = function ($type, $line) use (&$processOutput) {
            $processOutput .= $line;
        };

        $process->setTimeout(null)
            ->run($captureOutput);

        if ($process->getExitCode()) {
            $exception = new \Exception($cmd . " - " . $processOutput);
            report($exception);

            throw $exception;
        }

        return $processOutput;
    }
}