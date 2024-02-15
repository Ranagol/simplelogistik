<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class PamyraOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pamyraorders {behave=run : (behave=setting)} {detail=none : (detail=enable/disable) Enables or disables the cronjob. }
                                         {-h|--help?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info(json_encode($this->arguments()));
        $this->info('Start: ' . $this->description);
        if ($this->argument('behave') == 'setting') {
            $this->info('Setting the cronjob to ' . $this->argument('detail'));
            if ($this->argument('detail') == 'enable') {
                $this->enableCronjob('// Pamyra cronjob');
                $this->info('Cronjob enabled');
            } else {
                $this->disableCronjob('// Pamyra cronjob');
                $this->info('Cronjob disabled');
            }
        } else {
            $this->info('Ping...');
            Log::debug('Ping-Test is running.');
        }
        $this->info('End: ' . $this->description);
    }

    /**
     * Enable the cronjob
     * @param string $name
     */
    private function enableCronjob(string $name) {
        $cronContent = '';

        $cronFile = base_path() . '/app/Console/Kernel.php';
        $fpCron = fopen($cronFile, 'r');

        while ($line = fgets($fpCron)) {
            if (strpos($line, $name) !== false) {
                $cronContent .= $line;
                $line = fgets($fpCron);
                $cronContent .= str_replace('//', '', $line);
            } else {
                $cronContent .= $line;
            }
        }
        fclose($fpCron);
        file_put_contents($cronFile, $cronContent);
    }

    /**
     * Disable the cronjob
     * @param string $name
     */
    private function disableCronjob(string $name) {
        $cronContent = '';

        $cronFile = base_path() . '/app/Console/Kernel.php';
        $fpCron = fopen($cronFile, 'r');

        while ($line = fgets($fpCron)) {
            if (strpos($line, $name) !== false) {
                $cronContent .= $line;
                $line = fgets($fpCron);
                $cronContent .= '//' . $line;
            } else {
                $cronContent .= $line;
            }
        }
        fclose($fpCron);
        file_put_contents($cronFile, $cronContent);
    }
}
