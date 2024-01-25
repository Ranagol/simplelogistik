<?php

namespace App\Services\PamyraServices;

class OrderHandler {

    private array $pamyraOrder;
    private int $customerId;
    private int $senderId;
    private int $receiverId;

    //services
    private CustomerService $customerService;

    public function __construct()
    {
        
        $this->customerService = new CustomerService();
    }

    public function handle(array $pamyraOrder)
    {
        $this->pamyraOrder = $pamyraOrder;

        //customer
        //FOR NOW DO ALL THIS WITHOUT CHECK FOR ALREADY EXISTING DATA IN DB

        $this->customerId = $this->customerService->handle($pamyraOrder['customer']);
        $this->senderId = $this->customerService->handle($pamyraOrder['sender']);
        $this->receiverId = $this->customerService->handle($pamyraOrder['receiver']);



        //addresses (billing and headquarter)
        //contacts
        //order
        //order_attributes
        //parcels
        //pamyra_order
        //order_addresses (pickup and delivery)
    }
}