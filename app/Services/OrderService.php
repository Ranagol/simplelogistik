<?php

namespace App\Services;

use App\Models\TmsOrder;
use App\Models\TmsParcel;
use App\Models\TmsAddress;

/**
 * This class contains helper methods for the TmsOrderController.
 */
class OrderService
{
    public function handleHeadquarter(array $orderFromRequest): void
    {

        /**
         * If the order has a headquarter address... Do create or update for the headquarter address,
         * depending if the headquarter address already exists in the db or not. This will be 
         * recognised by the id column.
         * We can use updateOrCreate() here and not upsert(), because we have only one headquarter.
         */
        if (!empty($orderFromRequest['customer']['headquarter'])) {

            $headquarter = $orderFromRequest['customer']['headquarter'];

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