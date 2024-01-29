<?php

namespace App\Services\PamyraServices;

use App\Models\TmsAddress;
use App\Models\TmsOrder;
use App\Models\TmsPartner;
use App\Services\PamyraServices\CustomerService;
use App\Services\PamyraServices\AddressService;
use App\Services\PamyraServices\OrderService;
use App\Services\PamyraServices\ParcelService;
use App\Services\PamyraServices\PamyraOrderService;

/**
 * When writing data from Pamyra json files to our database, we have an array on Pamyra order
 * object. We loop through this array and for each pamyra oder we call this class to handle it.
 * This class handles everything regarindg pamyra order writing to db
 */
class OrderHandler {

    /**
     * Pamyra partner should have id = 1 always. But, just in case, in the __construct() we
     * searh for the partner id by name 'Pamyra'. And we store it in this variable.
     *
     * @var integer
     */
    private int $partnerId;

    private int $customerId;
    private int $senderId;
    private int $receiverId;
    private TmsAddress $headquarter;
    private TmsAddress $billingAddress;
    private TmsOrder $order;
    
    private CustomerService $customerService;
    private AddressService $addressService;
    private OrderService $orderService;
    private ParcelService $parcelService;
    private PamyraOrderService $pamyraOrderService;

    public function __construct()
    {
        $this->partnerId = TmsPartner::where('company_name', 'Pamyra')->first()->id;
        $this->customerService = new CustomerService();
        $this->addressService = new AddressService();
        $this->orderService = new OrderService();
        $this->parcelService = new ParcelService();
        $this->pamyraOrderService = new PamyraOrderService();
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
        $this->handleOrder($pamyraOrder);
        $this->handleParcels($pamyraOrder);
        $this->handlePamyraOrder($pamyraOrder);
        
        
        //order_attributes//TODO ANDOR ask C. Do we need to unify, uniformize, normalize the order_attributes? Currently pamyra has order attributes. We have none defined so far. 
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

    private function handleOrder(array $pamyraOrder): void
    {
        $this->order = $this->orderService->handle(
            $pamyraOrder, 
            $this->customerId, 
            $this->billingAddress->id,
            $this->partnerId
        );
    }

    private function handleParcels(array $pamyraOrder): void
    {
        $this->parcelService->handle($pamyraOrder, $this->order->id);
    }

    private function handlePamyraOrder(array $pamyraOrder): void
    {
        $this->pamyraOrderService->handle($pamyraOrder, $this->order->id);
    }
}