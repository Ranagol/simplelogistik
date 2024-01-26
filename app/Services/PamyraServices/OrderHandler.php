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
    private TmsAddress $headquarterAndBillingAddress;
    
    private CustomerService $customerService;
    private AddressService $addressService;

    public function __construct()
    {
        $this->customerService = new CustomerService();
        $this->addressService = new AddressService();
    }

    /**
     * This is the main function in this class, that triggers all other functions.
     *
     * @param array $pamyraOrder
     * @return void
     */
    public function handle(array $pamyraOrder): void
    {
        $this->handleCustomer($pamyraOrder);
        $this->handleAddresses($pamyraOrder);//only billing and headquarter from TmsAddress
        
        

        //contacts

        //order
        //in the moment that I am looking on the pamyra json I see there is a field with oderPdf. The data from this field schould go to (base_path).documents.orders.pamyra  name of File then $orderNumer .".pdf"
        
        
        //order_attributes
        //parcels
        //pamyra_order
        //order_addresses (pickup and delivery)
    }

    private function handleCustomer(array $pamyraOrder): void
    {
        $this->customerId = $this->customerService->handle($pamyraOrder['customer']);
        $this->senderId = $this->customerService->handle($pamyraOrder['sender']);
        $this->receiverId = $this->customerService->handle($pamyraOrder['receiver']);
    }

    /**
     * addresses (billing and headquarter)
     * We need both the customer and the customer.address here. From this, we create headquarter
     * and billing addresses. Here we have 3 cases:
     * 1. The customer has a headquarter and a billing address. Then we create both addresses.
     * 2. The customer has only a headquarter address. Then we create only the headquarter
     * address.
     * 3. The customer has only a billing address. Then we create only the billing address.
     * 
     * @param array $pamyraOrder
     * @return void
     */
    private function handleAddresses(array $pamyraOrder): void
    {
        
        $this->headquarter = $this->addressService->handle(
            $pamyraOrder['customer'], 
            true,//isHeadquarter
            false,//isBilling
            $this->customerId
        );

        $this->billingAddress = $this->addressService->handle(
            $pamyraOrder['customer'], 
            false,//isHeadquarter
            true,//isBilling
            $this->customerId
        );

    }
}