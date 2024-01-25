<?php

namespace App\Console\Commands;

use App\Services\PamyraServices\OrdersHandler;
use Illuminate\Console\Command;

class HandlePamyraOrders extends Command
{
    /**
     * The name and signature of the console command.
     * We trigger this command with: 'sail artisan handle-pamyra-orders'.
     *
     * @var string
     */
    protected $signature = 'handle-pamyra-orders';

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
        $ordersHandler->handle();
    }
}
