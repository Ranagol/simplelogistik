<?php

namespace App\Services;

use App\Models\TmsOrder;
use App\Models\TmsParcel;
use App\Models\TmsAddress;
use App\Models\TmsNativeOrder;
use App\Models\TmsPamyraOrder;
use App\Models\TmsOrderAddress;
use App\Http\Resources\IndexCollection;

/**
 * This class contains helper methods for the TmsOrderController.
 */
class OrderService
{   
    public function handleNativeOrder(array $orderFromRequest): void
    {
            
        /**
        * If the order has a native order... Do create or update for the native order,
        * depending if the native order already exists in the db or not. This will be 
        * recognised by the id column.
        * We can use updateOrCreate() here and not upsert(), because we have only one native order.
        */
        if (!empty($orderFromRequest['native_order'])) {

            $nativeOrder = $orderFromRequest['native_order'];

            TmsNativeOrder::updateOrCreate(
                // Check if we have this id on the db
                ['id' => $nativeOrder['id']],
                //if no, create new. If yes, update. For this use the values from $nativeOrder.
                $nativeOrder
            );
        }
    }

    public function handlePamyraOrder(array $orderFromRequest): void
    {
            
        /**
        * If the order has a pamyra order... Do create or update for the pamyra order,
        * depending if the pamyra order already exists in the db or not. This will be 
        * recognised by the id column.
        * We can use updateOrCreate() here and not upsert(), because we have only one pamyra order.
        */
        if (!empty($orderFromRequest['pamyra_order'])) {

            $pamyraOrder = $orderFromRequest['pamyra_order'];

            TmsPamyraOrder::updateOrCreate(
                // Check if we have this id on the db
                ['id' => $pamyraOrder['id']],
                //if no, create new. If yes, update. For this use the values from $pamyraOrder.
                $pamyraOrder
            );
        }
    }

    public function handleDeliveryAddresses(array $orderFromRequest): void
    {

        /**
         * If the order has a delivery address... Do create or update for the delivery address,
         * depending if the delivery address already exists in the db or not. This will be 
         * recognised by the id column.
         */
        if (!empty($orderFromRequest['delivery_addresses'])) {

            $deliveryAddresses = $orderFromRequest['delivery_addresses'];

            foreach ($deliveryAddresses as $deliveryAddress) {

                /**
                 * Handle the deliveryAddress country_id. The deliveryAddress country_id is not very
                 * useful in the FE (though it is in the BE). We send an country object from the BE,
                 * that contains again the country_id and the country_name. Which makes this object
                 * very useful, because we can use it in the el-select. However, once the edit 
                 * request is sent, and we are on the backend, we need to have the country_id
                 * in order to save the deliveryAddress. So, we need to get the country_id from the
                 * country object, and save it in the deliveryAddress array.
                 */
                $deliveryAddress['country_id'] = $deliveryAddress['country']['id'];

                /**
                 * Warning! Headquarter id TmsAddress. Pickup and delivery addresses are TmsOrderAddress.
                 */
                TmsOrderAddress::updateOrCreate(
                    // Check if we have this id on the db
                    ['id' => $deliveryAddress['id']],
                    //if no, create new. If yes, update. For this use the values from $deliveryAddress.
                    $deliveryAddress
                );
            }
        }
    }

    public function handlePickupAddresses(array $orderFromRequest): void
    {
        /**
         * If the order has a pickup address... Do create or update for the pickup address,
         * depending if the pickup address already exists in the db or not. This will be 
         * recognised by the id column.
         */
        if (!empty($orderFromRequest['pickup_addresses'])) {

            $pickupAddresses = $orderFromRequest['pickup_addresses'];

            foreach ($pickupAddresses as $pickupAddress) {

                /**
                 * Handle the pickupAddress country_id. The pickupAddress country_id is not very
                 * useful in the FE (though it is in the BE). We send an country object from the BE,
                 * that contains again the country_id and the country_name. Which makes this object
                 * very useful, because we can use it in the el-select. However, once the edit 
                 * request is sent, and we are on the backend, we need to have the country_id
                 * in order to save the pickupAddress. So, we need to get the country_id from the
                 * country object, and save it in the pickupAddress array.
                 */
                $pickupAddress['country_id'] = $pickupAddress['country']['id'];

                /**
                 * Warning! Headquarter id TmsAddress. Pickup and delivery addresses are TmsOrderAddress.
                 */
                TmsOrderAddress::updateOrCreate(
                    // Check if we have this id on the db
                    ['id' => $pickupAddress['id']],
                    //if no, create new. If yes, update. For this use the values from $pickupAddress.
                    $pickupAddress
                );
            }
        }
    }

    /**
     * Handles the headquarter address update or create, inside the order update or create.
     *
     * @param array $orderFromRequest
     * @return void
     */
    public function handleHeadquarter(array $orderFromRequest): void
    {

        /**
         * If the order has a headquarter address... Do create or update for the headquarter address,
         * depending if the headquarter address already exists in the db or not. This will be 
         * recognised by the id column.
         * We can use updateOrCreate() here and not upsert(), because we have only one headquarter.
         */
        if (!empty($orderFromRequest['customer']['headquarter'])) {

            //Get headquarter data from the request
            $headquarter = $orderFromRequest['customer']['headquarter'];

            /**
             * Handle the headquarter country_id. The headquarter country_id is not very
             * useful in the FE (though it is in the BE). We send an country object from the BE,
             * that contains again the country_id and the country_name. Which makes this object
             * very useful, because we can use it in the el-select. However, once the edit 
             * request is sent, and we are on the backend, we need to have the country_id
             * in order to save the headquarter. So, we need to get the country_id from the
             * country object, and save it in the headquarter array.
             */
            $headquarter['country_id'] = $headquarter['country']['id'];

            /**
             * Warning! Headquarter id TmsAddress. Pickup and delivery addresses are TmsOrderAddress.
             */
            TmsAddress::updateOrCreate(
                // Check if we have this id on the db
                ['id' => $headquarter['id']],
                //if no, create new. If yes, update. For this use the values from $headquarter.
                $headquarter
            );
        }
    }

    public function handleParcel(array $orderFromRequest): void
    {

        /**
         * If the order has parcels... Do create or update for each parcel, depending if the parcel
         * already exists in the db or not. This will be recognised by the id column.
         */
        if (!empty($orderFromRequest['parcels'])) {

        $parcels = $orderFromRequest['parcels'];

            //Warning: upsert() can't work with mutators!
            TmsParcel::upsert(
                //1-An array of records that should be updated or created.
                $parcels,
                //2-The column(s) that should be used to determine if a record already exists.
                'id',
                //3-The column(s) that should be updated if a matching record already exists.
                [
                    "is_hazardous",
                    "information",
                    "p_name",
                    "p_height",
                    "p_length",
                    "p_width",
                    "p_number",
                    "p_stackable",
                    "p_weight",
                ]
            );
        }
    }
}