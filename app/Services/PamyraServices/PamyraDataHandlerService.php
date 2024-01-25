<?php

namespace App\Services\PamyraServices;

use PHPUnit\Event\Runtime\PHP;

class PamyraDataHandlerService
{
    private string $pathToPamyraData;

    public function __construct()
    {
        /**
         * returns the path to the pamyra.json file in the root directory of your Laravel 
         * application.
         */
        $this->pathToPamyraData = base_path('pamyra_response.json');
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
        dump($pamyraOrders);
        $this->handlePamyraOrders($pamyraOrders);

        echo 'Handling Pamyra data has ended.' . PHP_EOL;
    }

    /**
     * This function loops through all pamyra orders and triggers the function
     * handlePamyraOrder() for each order.
     *
     * @param array $pamyraOrders
     * @return void
     */
    private function handlePamyraOrders(array $pamyraOrders): void
    {
        foreach ($pamyraOrders as $pamyraOrder) {
            $this->handlePamyraOrder($pamyraOrder);
        }
    }

    /**
     * This function handles one pamyra order. Here you can do whatever you want with the data.
     *
     * @param array $pamyraOrder
     * @return void
     */
    private function handlePamyraOrder(array $pamyraOrder): void
    {
        //customer
        //addresses (billing and headquarter)
        //contacts
        //order
        //order_attributes
        //parcels
        //pamyra_order
        //order_addresses (pickup and delivery)
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