<?php

namespace Modules\PamyraOrder\app\Services\PamyraServices;

use Modules\PamyraOrder\app\Services\PamyraServices\OrderHandler;
// use Modules\PamyraOrder\app\Services\PamyraServices\FtpHandlerPamyra;
use App\Services\FtpHandlerPamyra;

class OrdersHandler
{
    /**
     * A class that handles the ftp connection, and getting all the files/info from the ftp server.
     *
     * @var FtpHandlerPamyra
     */
    private FtpHandlerPamyra $ftpHandlerPamyra;
    
    /**
     * A service that handles the order data. 
     *
     * @var OrderHandler
     */
    private OrderHandler $orderHandler;

    public function __construct(OrderHandler $orderHandler)
    {
        $this->orderHandler = $orderHandler;

        /**
         * Here we create a new instance of the FtpHandlerPamyra class.
         */
        $this->ftpHandlerPamyra = new FtpHandlerPamyra(
            'PamyraOrders', 
            'PamyraOrdersArchived/',
            '.json'
        );
    }

    /**
     * This is the main function in this class, that triggers all other functions.
     *
     * @return void
     */
    public function handle(): void
    {
        //Gets all the json file names from the ftp server
        $jsonFileNames = $this->ftpHandlerPamyra->handle();

        //Gets all the orders from all the json files from the ftp server
        $orders = $this->ftpHandlerPamyra->jsonToArrayConvert($jsonFileNames);

        //We loop through all the orders and write each one to the database
        foreach ($orders as $pamyraOrder) {
            $this->orderHandler->handle($pamyraOrder);
        }

        //We archive all the json files in the app from the ftp server
        $this->ftpHandlerPamyra->archiveFiles();
    }
}
