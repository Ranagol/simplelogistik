<?php

namespace Modules\PamyraOrder\app\Services\PamyraServices;

use App\Models\TmsOrder;
use App\Models\TmsAddress;
use App\Models\TmsPartner;
use App\Models\TmsPamyraOrder;
use App\Models\TmsOrderAddress;
use App\Models\TmsTransportRule;
use Illuminate\Support\Facades\Log;
use Modules\PamyraOrder\app\Services\PamyraServices\OrderService;
use Modules\PamyraOrder\app\Services\PamyraServices\ParcelService;
use Modules\PamyraOrder\app\Services\PamyraServices\AddressService;
use Modules\PamyraOrder\app\Services\PamyraServices\CustomerService;
use Modules\PamyraOrder\app\Services\PamyraServices\PamyraOrderService;
use Modules\PamyraOrder\app\Services\PamyraServices\OrderAddressService;
use Modules\PamyraOrder\app\Services\PamyraServices\OrderHistoryService;
use Modules\PamyraOrder\app\Services\PamyraServices\OrderAttributeService;

/**
 * When writing data from Pamyra json files to our database, we have an array on Pamyra order
 * object. We loop through this array and for each pamyra oder we call this class to handle it.
 * This class handles everything regarindg pamyra order writing to db
 */
class OrderHandler {

    /**
     * Partners are for example: Emons, DHL, DPD, Pamyra, etc.
     *
     * @var integer | null
     */
    private int $partnerId;
    private int $customerId;
    private TmsAddress $headquarter;//this is used, don't delete it
    // private TmsOrderAddress $billingAddress;
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
        //If not specified otherwise, the default partner is Pamyra
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
        // $this->handleAddresses($pamyraOrder);//TmsAddress
        $this->handleOrder($pamyraOrder);
        $this->handleParcels($pamyraOrder);
        $this->handlePamyraOrder($pamyraOrder);
        $this->handleOrderAttributes($pamyraOrder);
        $this->handleOrderAddresses($pamyraOrder);//TmsOrderAddress
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
        //Headquarter address that belongs to the customer (TmsAddress table)
        $this->headquarter = $this->addressService->handle(
            $pamyraOrder,
            $pamyraOrder['Customer'], 
            true,//isHeadquarter
            false,//isBilling
            false,//isPickup
            false,//isDelivery
            $this->customerId,
            $this->partnerId
        );

        //Billing address that belongs to the customer (TmsAddress table)
        $this->addressService->handle(
            $pamyraOrder,
            $pamyraOrder['Customer'], 
            false,//isHeadquarter
            true,//isBilling
            false,//isPickup
            false,//isDelivery
            $this->customerId,
            $this->partnerId
        );

        //Pickup address that belongs to TmsCustomer model (in TmsAddress table)
        $this->addressService->handle(
            $pamyraOrder,
            $pamyraOrder['Sender'], 
            false,//isHeadquarter
            false,//isBilling
            true,//isPickup
            false,//isDelivery
            $this->customerId,
            $this->partnerId
        );

        //Delivery address that belongs to TmsCustomer model (in TmsAddress table)
        $this->addressService->handle(
            $pamyraOrder,
            $pamyraOrder['Receiver'], 
            false,//isHeadquarter
            false,//isBilling
            false,//isPickup
            true,//isDelivery
            $this->customerId,
            $this->partnerId
        );
    }

    private function handleOrder(array $pamyraOrder): void
    {
        $this->order = $this->orderService->handle(
            $pamyraOrder, 
            $this->customerId, 
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

        //Create billing address that belongs to the order (TmsOrderAddress table)
        $this->orderAddressService->handle(
            $pamyraOrder['Customer'], 
            $pamyraOrder['DeliveryDate'],
            $this->order->id,
            $this->customerId,
            $this->partnerId,
            TmsOrderAddress::ADDRESS_TYPES[2],//billing address
            $pamyraOrder['OrderNumber']
        );
    }

    /**
     * Here we handle the order attributes. 
     *
     * @param array $pamyraOrder
     * @return void
     */
    private function handleOrderAttributes(array $pamyraOrder): void
    {
        $this->orderAttributeService->handle($pamyraOrder, $this->order);
    }

    /**
     * We create an order history for the given order.
     *
     * @param array $pamyraOrder
     * @return void
     */
    private function createOrderHistory(array $pamyraOrder): void
    {
        $this->orderHistoryService->createOrderHistory(
            $pamyraOrder['OrderNumber'] ?? 'missing order number',
            $this->customerId, 
            $this->order->id
        );
    }
}