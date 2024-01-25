<?php

namespace App\Services\PamyraServices;

use App\Services\PamyraServices\OrderHandler;

class OrdersHandler
{
    private string $pathToPamyraData;
    private OrderHandler $orderHandler;

    public function __construct()
    {
        /**
         * returns the path to the pamyra.json file in the root directory of your Laravel 
         * application.
         */
        $this->pathToPamyraData = base_path('pamyra_response.json');
        $this->orderHandler = new OrderHandler();
    }

    /**
     * This is the main function in this class, that triggers all other functions.
     *
     * @return void
     */
    public function handle(): void
    {
        echo 'Handling Pamyra data has started.' . PHP_EOL;

        $pamyraOrders = $this->readJsonFile();

        foreach ($pamyraOrders as $pamyraOrder) {
            $this->orderHandler->handle($pamyraOrder);
        }

        echo 'Handling Pamyra data has ended.' . PHP_EOL;
    }

    /**
     * We receive from pamyra a json file. Here one array contains all order objects. This function
     * can read this json file and return all the data from it into a php array.
     *
     * @return array
     */
    private function readJsonFile(): array
    {
        $json = file_get_contents($this->pathToPamyraData);
        return json_decode($json, true);
    }
}