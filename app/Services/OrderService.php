<?php

namespace App\Services;

use App\Models\TmsOrder;
use App\Models\TmsParcel;
use App\Models\TmsAddress;
use App\Models\TmsNativeOrder;
use App\Models\TmsPamyraOrder;
use App\Models\TmsOrderAddress;
use App\Http\Resources\TmsOrderIndexCollection;

/**
 * This class contains helper methods for the TmsOrderController.
 */
class OrderService
{   
    /**
     * Returns records for records list (Index.vue component). The only reason why we use this
     * function here and not the one inherited from the parent is the 
     * ->with('contactAddresses')
     * line. We must return customers with contact addresses.
     *
     * @param string|null $searchTerm
     * @param string|null $sortColumn
     * @param string|null $sortOrder
     * @param integer|null $newItemsPerPage
     */
    //@return AnonymousResourceCollection
    public function getRecords(

        string $searchTerm = null, 
        // array $searchColumns = [
        //     'order_number', //not a relationship
        //     'customer_reference',//not a relationship notice the singular form
        //     'customers__first_name',//relationship, notice the plural
        //     'customers__last_name'//relationship
        // ], 
        string $sortColumn = null, 
        string $sortOrder = null, 
        int $newItemsPerPage = null,
    )/*: AnonymousResourceCollection*/
    {
        $records = TmsOrder::query()

            // If there is a search term defined...
            ->when($searchTerm, function($query, $searchTerm) {

                /**
                 * This is a bit tricky.
                 * Here we use a model scope. The model scope code is defined in the relevant model.
                 * https://laravel.com/docs/10.x/eloquent#local-scopes
                 */
                $query->searchBySearchTerm($searchTerm);
            })
            
            /**
             * SORTING
             * When there is $sortColumn and $sortOrder defined
             */
            ->when($sortColumn, function($query, $sortColumn) use ($sortOrder) {
                $query->orderBy($sortColumn, $sortOrder);
            }, function ($query) {

                //... but if sort is not specified, please return sort by id and descending.
                return $query->orderBy('id', 'desc');
            })

            //we need these relationships. Not all columns, only the selected ones.
            ->with(
                [
                    'parcels',
                    'orderAddresses',
                    'forwarder',
                    'customer',
                    'pamyraOrder',
                    'nativeOrder',
                    'orderHistoryLatest',
                ]
            )
            
            /**
             * PAGINATION
             * If it is not otherwise specified, paginate by 10 items per page.
             */
            ->paginate($newItemsPerPage ? $newItemsPerPage : 10)

            /**
             * Include the query string too into pagination data links for page 1,2,3,4... 
             * And the url will now include this too: http://127.0.0.1:8000/users?search=a&page=2 
             */
            ->withQueryString();

        $records = new TmsOrderIndexCollection($records);
        
        return $records;
    }















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