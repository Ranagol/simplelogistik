<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Services\PamyraServices\OrdersHandler;

class HandlePamyraOrders extends Command
{
    /**
     * The name and signature of the console command.
     * We trigger this command with: 'sail artisan handle-pamyra-orders'.
     *
     * @var string
     */
    protected $signature = 'handlePamyraOrders';

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
        $ordersHandler->handle();
        $this->info('Handling Pamyra orders has ended.');
    }
}
