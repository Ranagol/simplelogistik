<?php

namespace App\Services\PamyraServices;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Services\PamyraServices\OrderHandler;
use Illuminate\Support\Facades\File;

class OrdersHandler
{
    /**
     * This is a path to the json file with Pamyra orders.
     *
     * @var string
     */
    public string $pathToPamyraData = '/PamyraOrders/Inbox/pamyra.json';

    /**
     * A service that handles the ftp connection, and getting all the files/info from the ftp server.
     *
     * @var FtpConnector
     */
    private FtpConnector $ftpConnector;
    
    /**
     * A service that handles the order data. 
     *
     * @var OrderHandler
     */
    private OrderHandler $orderHandler;

    public function __construct(FtpConnector $ftpConnector, OrderHandler $orderHandler)
    {
        $this->orderHandler = $orderHandler;
        $this->ftpConnector = $ftpConnector;
    }

    /**
     * This is the main function in this class, that triggers all other functions.
     *
     * @return void
     */
    public function handle(): void
    {

        $orders = $this->ftpConnector->handle();


        foreach ($orders as $pamyraOrder) {
            $this->orderHandler->handle($pamyraOrder);
        }

        // $this->archiveJsonFile();
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
            throw new \Exception('The source pamyra.json file could not be found.');
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
        return 'PamyraOrders/Archived/' . $newFileName;
    }
}
