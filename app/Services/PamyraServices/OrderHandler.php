<?php

namespace App\Services\PamyraServices;

use App\Models\TmsAddress;
use App\Services\PamyraServices\CustomerService;
use App\Services\PamyraServices\AddressService;

class OrderHandler {

    private int $customerId;
    private int $senderId;
    private int $receiverId;
    private TmsAddress $headquarter;
    private TmsAddress $billingAddress;
    
    private CustomerService $customerService;
    private AddressService $addressService;

    public function __construct()
    {
        $this->customerService = new CustomerService();
        $this->addressService = new AddressService();
    }

    public function handle(array $pamyraOrder)
    {
        /**
         * Customer creating.
         */
        $this->customerId = $this->customerService->handle($pamyraOrder['customer']);
        $this->senderId = $this->customerService->handle($pamyraOrder['sender']);
        $this->receiverId = $this->customerService->handle($pamyraOrder['receiver']);
        
        /**
         * addresses (billing and headquarter)
         * We need both the customer and the customer.address here. From this, we create headquarter
         * and billing addresses.
         */
        $this->headquarter = $this->addressService->handle($pamyraOrder['customer'], 'headquarter', $this->customerId);
        $this->billingAddress = $this->addressService->handle($pamyraOrder['customer'], 'billing', $this->customerId);

        //contacts

        //order
        //in the moment that I am looking on the pamyra json I see there is a field with oderPdf. The data from this field schould go to (base_path).documents.orders.pamyra  name of File then $orderNumer .".pdf"
        
        
        //order_attributes
        //parcels
        //pamyra_order
        //order_addresses (pickup and delivery)
    }
}