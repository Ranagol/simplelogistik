<?php

namespace Modules\PamyraOrder\app\Services\PamyraServices;

use Modules\PamyraOrder\app\Services\PamyraServices\OrderHandler;
use Modules\PamyraOrder\app\Services\PamyraServices\FtpHandlerPamyra;

class OrdersHandler
{
    /**
     * A service that handles the ftp connection, and getting all the files/info from the ftp server.
     *
     * @var FtpHandlerPamyra
     */
    private ftpHandlerPamyra $ftpHandlerPamyra;
    
    /**
     * A service that handles the order data. 
     *
     * @var OrderHandler
     */
    private OrderHandler $orderHandler;

    public function __construct(FtpHandlerPamyra $ftpHandlerPamyra, OrderHandler $orderHandler)
    {
        $this->orderHandler = $orderHandler;
        $this->ftpHandlerPamyra = $ftpHandlerPamyra;
    }

    /**
     * This is the main function in this class, that triggers all other functions.
     *
     * @return void
     */
    public function handle(): void
    {

        // dd('orderShandler->handle triggered');
        //Gets all the orders from all the PAM json files from the ftp server
        $orders = $this->ftpHandlerPamyra->getPamyraOrders();
        dd('this is not displayed?');
        // dd($orders);

        //We loop through all the orders and write each one to the database
        foreach ($orders as $pamyraOrder) {
            $this->orderHandler->handle($pamyraOrder);
        }

        //We archive all the json files in the app from the ftp server
        $this->ftpHandlerPamyra->moveAndArchiveFilesFromFtp();
    }
}
