<?php

namespace App\Services\PamyraServices;

use DateTime;
use App\Models\TmsOrder;
use App\Models\TmsCustomer;
use App\Models\TmsPamyraOrder;
use App\Http\Requests\TmsOrderRequest;
use App\Http\Requests\TmsParcelRequest;
use App\Models\TmsParcel;
use Illuminate\Support\Facades\Validator;

class ParcelService {

    /**
     * Validation rules from TmsParcelRequest.
     *
     * @var array
     */
    private array $validationRules;

    public function __construct()
    {
        /**
         * We copy here the validation rules from the TmsAddressRequest. Because we want to use them
         * in this class. And we can't use them directly from the TmsAddressRequest, because it is
         * a FormRequest. And we can't use a FormRequest in a class. So, we copy the rules here.
         */
        $tmsParcelRequest = new TmsParcelRequest();
        $this->validationRules = $tmsParcelRequest->parcelRules();
    }

    /**
     * We do not check for parcel duplicates. None of the parcel fields are unique. The is no point 
     * in checking for duplicates for parcels.
     *
     * @param array $pamyraOrder
     * @param integer $orderId
     * @return void
     */
    public function handle(
        array $pamyraOrder,
        int $orderId
    ): void
    {
        $parcels = $pamyraOrder['transportobjects'];
        foreach ($parcels as $parcel) {
            $this->create($parcel, $orderId);
        }
    }

    /**
     * Create a new parcel in the database.
     *
     * @param array $parcel
     * @param integer $orderId
     * @return void
     */
    private function create(
        array $parcel,
        int $orderId
    ): TmsParcel
    {
        $parcelArray = [
            'tms_order_id' => $orderId,
            'name' => $parcel['name'],
            'height' => $parcel['height'],
            'length' => $parcel['length'],
            'width' => $parcel['width'],
            'number' => $parcel['number'],
            'stackable' => $parcel['stackable'],
            'weight' => $parcel['weight'],
        ];

        $this->validate($parcelArray);

        $parcel = TmsParcel::create($parcelArray);

        return $parcel;
    }

    /**
     * Validate the parcel array.
     * 
     * @Christoph said, that temporarily we just need to throw a simple basic exception if the 
     * validation fails. Later we will handle this with monitoring.
     *
     * @param array $parcelArray
     * @return void
     */
    private function validate(array $parcelArray): void
    {
        // Validate the data
        $validator = Validator::make($parcelArray, $this->validationRules);

        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first());
        }
    }
}