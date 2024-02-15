<?php

namespace Modules\PamyraOrder\app\Services\PamyraServices;

use Modules\PamyraOrder\app\Services\PamyraServices\OrderHandler;

class OrdersHandler
{
    /**
     * A service that handles the ftp connection, and getting all the files/info from the ftp server.
     *
     * @var PamyraFtpHandler
     */
    private pamyraFtpHandler $pamyraFtpHandler;
    
    /**
     * A service that handles the order data. 
     *
     * @var OrderHandler
     */
    private OrderHandler $orderHandler;

    public function __construct(PamyraFtpHandler $pamyraFtpHandler, OrderHandler $orderHandler)
    {
        $this->orderHandler = $orderHandler;
        $this->pamyraFtpHandler = $pamyraFtpHandler;
    }

    /**
     * This is the main function in this class, that triggers all other functions.
     *
     * @return void
     */
    public function handle(): void
    {
        //Gets all the orders from all the PAM json files from the ftp server
        $orders = $this->pamyraFtpHandler->getPamyraOrders();

        //We loop through all the orders and write each one to the database
        // foreach ($orders as $pamyraOrder) {
        //     $this->orderHandler->handle($pamyraOrder);
        // }

        //We archive all the json files in the app from the ftp server
        // $this->PamyraFtpHandler->archiveJsonFiles();
    }
}
