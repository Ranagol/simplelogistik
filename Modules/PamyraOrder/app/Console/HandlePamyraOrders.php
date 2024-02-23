<?php

namespace Modules\PamyraOrder\app\Console;

use Illuminate\Console\Command;
use App\Models\TmsFtpCredential;
use Illuminate\Support\Facades\Log;
use Modules\PamyraOrder\app\Services\PamyraServices\OrdersHandler;

class HandlePamyraOrders extends Command
{
    /**
     * The name and signature of the console command.
     * We trigger this command with: 'sail artisan handlePamyraOrders'.
     *
     * @var string
     */
    protected $signature = 'handlePamyraOrders {behave=run : (behave=setting)} {detail=none : (detail=enable/disable) Enables or disables the cronjob. }
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
    public function handle(OrdersHandler $ordersHandler): void
    {
        $this->info('Handling Pamyra orders has started.');
        
        if ($this->argument('behave') == 'setting') {
            $this->info('Setting the cronjob to ' . $this->argument('detail'));
            if ($this->argument('detail') == 'enable') {
                $this->enableCronjob('// Handle Pamyra orders');
                $this->info('Cronjob enabled');
            } else {
                $this->disableCronjob('// Handle Pamyra orders');
                $this->info('Cronjob disabled');
            }
        } else {

            /**
             * This is the main function in this class, that triggers all other functions. It also uses
             */
            $ordersHandler->handle();

            
            $this->info('Handling PamyraOrder...');
            Log::debug('Handling PamyraOrder is running.');
        }
        
        $this->info('Handling Pamyra orders has ended.');
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
