<?php

namespace App\Services\PamyraServices;

use App\Models\TmsAddress;
use App\Models\TmsOrder;
use App\Models\TmsOrderAddress;
use App\Models\TmsPartner;
use App\Services\PamyraServices\CustomerService;
use App\Services\PamyraServices\AddressService;
use App\Services\PamyraServices\OrderService;
use App\Services\PamyraServices\ParcelService;
use App\Services\PamyraServices\PamyraOrderService;
use App\Services\PamyraServices\OrderAddressService;


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
    private TmsAddress $headquarter;//this is used, don't delete it
    private TmsAddress $billingAddress;
    private TmsOrder $order;
    
    private CustomerService $customerService;
    private AddressService $addressService;
    private OrderService $orderService;
    private ParcelService $parcelService;
    private PamyraOrderService $pamyraOrderService;
    private OrderAddressService $orderAddressService;
    private OrderAttributeService $orderAttributeService;

    /**
     * We use a lot of helper classes here. To get them, we use dependency injection.
     *
     * @param CustomerService $customerService
     * @param AddressService $addressService
     * @param OrderService $orderService
     * @param ParcelService $parcelService
     * @param PamyraOrderService $pamyraOrderService
     * @param OrderAddressService $orderAddressService
     * @param OrderAttributeService $orderAttributeService
     */
    public function __construct(
        CustomerService $customerService,
        AddressService $addressService,
        OrderService $orderService,
        ParcelService $parcelService,
        PamyraOrderService $pamyraOrderService,
        OrderAddressService $orderAddressService,
        OrderAttributeService $orderAttributeService
    )
    {
        //We must find our partner. In this case, this is always Pamyra.
        $this->partnerId = TmsPartner::where('company_name', 'Pamyra')
                ->where('id', 1)
                ->firstOrFail()
                ->id;

        //Setting dependencies through dependency injection.
        $this->customerService = $customerService;
        $this->addressService = $addressService;
        $this->orderService = $orderService;
        $this->parcelService = $parcelService;
        $this->pamyraOrderService = $pamyraOrderService;
        $this->orderAddressService = $orderAddressService;
        $this->orderAttributeService = $orderAttributeService;

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
        $this->handleOrderAddresses($pamyraOrder);//pickup and delivery from TmsOrderAddress
        $this->handleOrderAttributes($pamyraOrder);
    }
    
    /**
     * Here we create a customer.
     * Important: we do not handle here addresses, so the pickup and delivery addresses are not
     * created here. They are created in the handleOrdersAddresses() function. Also, the billing
     * and headquarter addresses are not created here. They are created in the handleAddresses()
     * function.
     * 
     * @param array $pamyraOrder
     * @return void
     */
    private function handleCustomer(array $pamyraOrder): void
    {
        $this->customerId = $this->customerService->handle($pamyraOrder['customer']);
    }

    /**
     * addresses (billing and headquarter)
     * We need both the customer and the customer.address here. From this, we create headquarter
     * and billing addresses. Here we have 3 cases:
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
            $this->customerId,
            $this->partnerId
        );

        $this->billingAddress = $this->addressService->handle(
            $pamyraOrder['customer'], 
            false,//isHeadquarter
            true,//isBilling
            $this->customerId,
            $this->partnerId
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

    /**
     * Here we create the pickup and delivery addresses.
     * The address_type for pickup is 3 and for delivery is 4.
     *
     * @param array $pamyraOrder
     * @return void
     */
    private function handleOrderAddresses(array $pamyraOrder): void
    {
        //Create a pickup address in OrderAddresses table.
        $this->orderAddressService->handle(
            $pamyraOrder['sender'],
            $pamyraOrder['pickupDate'],
            $this->order->id, 
            $this->customerId,
            $this->partnerId, 
            TmsOrderAddress::ADDRESS_TYPES[3]//pickup address
        );

        //Create a delivery address in OrderAddresses table.
        $this->orderAddressService->handle(
            $pamyraOrder['receiver'],
            $pamyraOrder['deliveryDate'],
            $this->order->id, 
            $this->customerId,
            $this->partnerId, 
            TmsOrderAddress::ADDRESS_TYPES[4]//delivery address
        );
    }

    private function handleOrderAttributes(array $pamyraOrder): void
    {
        $this->orderAttributeService->handle($pamyraOrder, $this->order);
    }
}