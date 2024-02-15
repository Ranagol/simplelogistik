<?php

namespace Modules\PamyraOrder\app\Services\PamyraServices;

use App\Models\TmsOrder;
use App\Models\TmsAddress;
use App\Models\TmsPartner;
use App\Models\TmsPamyraOrder;
use App\Models\TmsOrderAddress;
use Illuminate\Support\Facades\Log;
use Modules\PamyraOrder\app\Services\PamyraServices\OrderService;
use Modules\PamyraOrder\app\Services\PamyraServices\ParcelService;
use Modules\PamyraOrder\app\Services\PamyraServices\AddressService;
use Modules\PamyraOrder\app\Services\PamyraServices\CustomerService;
use Modules\PamyraOrder\app\Services\PamyraServices\PamyraOrderService;
use Modules\PamyraOrder\app\Services\PamyraServices\OrderAddressService;
use Modules\PamyraOrder\app\Services\PamyraServices\OrderAttributeService;
use Modules\PamyraOrder\app\Services\PamyraServices\OrderHistoryService;

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
    private OrderHistoryService $orderHistoryService;

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
        OrderAttributeService $orderAttributeService,
        OrderHistoryService $orderHistoryService
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
        $this->orderHistoryService = $orderHistoryService;
    }

    /**
     * This is the main function in this class, that triggers all other functions.
     *
     * @param array $pamyraOrder
     * @return void
     */
    public function handle(array $pamyraOrder): void
    {
        $isDuplicate = $this->checkForDuplicate($pamyraOrder);

        if($isDuplicate){
            return;
        }

        $this->handleCustomer($pamyraOrder);
        $this->handleAddresses($pamyraOrder);//only billing and headquarter from TmsAddress
        $this->handleOrder($pamyraOrder);
        $this->handleParcels($pamyraOrder);
        $this->handlePamyraOrder($pamyraOrder);
        $this->handleOrderAddresses($pamyraOrder);//pickup and delivery from TmsOrderAddress
        $this->handleOrderAttributes($pamyraOrder);

        $this->createOrderHistory($pamyraOrder);
    }

    /**
     * Checks for duplicate in the database. These are the rules, how the duplicate cases are handled:
     * 
     * pamyraOrder: this is the only way to check, if the order already exists in the db. Checking 
     * this is the first thing to do, before anything else. If there is a duplicate pamyra order,
     * then we return, and stop the creating of the given order. We also log this. However, all other
     * pamyra orders, that are not duplicates will be created.
     * 
     * customer: don't create it, if the same object already exists in db.
     * addresses: don't create it, if the same object already exists in db.
     * orders: no checking.
     * parcels: no checking, because none of the parcel columns is unique
     * orderAddresses:  don't create it, if the same object already exists in db.
     * orderAttributes: we can't check for duplicates here
     * 
     *
     * @param array $pamyraOrder
     * @return bool
     */
    private function checkForDuplicate(array $pamyraOrder): bool
    {
        $pamyraOrderDuplicate = TmsPamyraOrder::where('order_number', $pamyraOrder['OrderNumber'])->first();

        if ($pamyraOrderDuplicate) {
            echo 'Order with order number ' 
                    . $pamyraOrder['OrderNumber'] 
                    . ' already exists.' . PHP_EOL;
            Log::alert('Order with order number ' 
                    . $pamyraOrder['OrderNumber'] 
                    . ' already exists.' . PHP_EOL);

            return true;
        }

        return false;
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
        $this->customerId = $this->customerService->handle($pamyraOrder['Customer']);
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
            $pamyraOrder['Customer'], 
            true,//isHeadquarter
            false,//isBilling
            $this->customerId,
            $this->partnerId
        );

        $this->billingAddress = $this->addressService->handle(
            $pamyraOrder['Customer'], 
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
            $pamyraOrder['Sender'],
            $pamyraOrder['PickupDate'],
            $this->order->id, 
            $this->customerId,
            $this->partnerId, 
            TmsOrderAddress::ADDRESS_TYPES[3],//pickup address
            $pamyraOrder['OrderNumber']
        );

        //Create a delivery address in OrderAddresses table.
        $this->orderAddressService->handle(
            $pamyraOrder['Receiver'],
            $pamyraOrder['DeliveryDate'],
            $this->order->id, 
            $this->customerId,
            $this->partnerId, 
            TmsOrderAddress::ADDRESS_TYPES[4],//delivery address
            $pamyraOrder['OrderNumber']
        );
    }

    private function handleOrderAttributes(array $pamyraOrder): void
    {
        $this->orderAttributeService->handle($pamyraOrder, $this->order);
    }

    private function createOrderHistory(array $pamyraOrder): void
    {
        $this->orderHistoryService->createOrderHistory(
            $pamyraOrder['OrderNumber'] ?? 'missing order number',
            $this->customerId, 
            $this->order->id
        );
    }
}