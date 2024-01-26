<?php

namespace App\Services\PamyraServices;

use App\Services\PamyraServices\CustomerService;
use App\Services\PamyraServices\AddressService;

class OrderHandler {

    private array $pamyraOrder;
    private int $customerId;
    private int $senderId;
    private int $receiverId;
    
    private CustomerService $customerService;
    private AddressService $addressService;

    public function __construct()
    {
        $this->customerService = new CustomerService();
        $this->addressService = new AddressService();
    }

    public function handle(array $pamyraOrder)
    {
        $this->pamyraOrder = $pamyraOrder;

        //customer handling
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