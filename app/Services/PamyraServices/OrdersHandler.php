<?php

namespace App\Services\PamyraServices;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Services\PamyraServices\OrderHandler;
use Illuminate\Support\Facades\File;

class OrdersHandler
{

    public string $pathToPamyraData = '/PamyraOrders/Inbox/pamyra.json';
    
    private OrderHandler $orderHandler;

    public function __construct(OrderHandler $orderHandler)
    {
        $this->orderHandler = $orderHandler;
    }

    /**
     * This is the main function in this class, that triggers all other functions.
     *
     * @return void
     */
    public function handle(): void
    {
        echo 'Handling Pamyra data has started.' . PHP_EOL;

        // $pamyraOrders = $this->readJsonFile();

        // foreach ($pamyraOrders as $pamyraOrder) {
        //     $this->orderHandler->handle($pamyraOrder);
        // }

        echo 'Handling Pamyra data has ended.' . PHP_EOL;

        $this->archiveJsonFile();
    }

    /**
     * We receive from pamyra a json file. Here one array contains all order objects. This function
     * can read this json file and return all the data from it into a php array.
     *
     * @return array
     */
    private function readJsonFile(): array
    {
        // dump($this->pathToPamyraData);
        $json = file_get_contents($this->pathToPamyraData);
        return json_decode($json, true);
    }

    /**
     * After we have handled all the orders, we rename and archive the json file.
     *
     * @return void
     */
    private function archiveJsonFile(): void
    {
        $targetPath = $this->createTargetPath();

        //Here we just check if the source file exists at '/PamyraOrders/Inbox/pamyra.json'
        if (Storage::disk('local')->exists($this->pathToPamyraData)) {
            Storage::move($this->pathToPamyraData, $targetPath);
        } else {
            throw new \Exception('The source pamyra.json file could not be moved to the archive folder.');
        }
    }

    /**
     * We create a new file name with a new target path for the archived file. It will be named like this: 
     * '2021_07_01_pamyra_orders.json'. 
     *
     * @return string
     */
    private function createTargetPath(): string
    {
        $todayDate = Carbon::now()->format('Y_m_d');
        $newFileName = $todayDate . '_pamyra_orders' . '.json';
        $targetPath = 'PamyraOrders/Archived/' . $newFileName;

        return $targetPath;
    }

}



