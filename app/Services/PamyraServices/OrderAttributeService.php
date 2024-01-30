<?php

namespace App\Services\PamyraServices;

use App\Http\Requests\TmsCustomerRequest;
use App\Models\TmsCustomer;
use Illuminate\Support\Facades\Validator;

class OrderAttributeService {

    /**
     * Validation rules from TmsCustomerRequest.
     *
     * @var array
     */
    private array $validationRules;

    public function __construct()
    {
        /**
         * We copy here the validation rules from the TmsCustomerRequest. Because we want to use them
         * in this class. And we can't use them directly from the TmsCustomerRequest, because it is
         * a FormRequest. And we can't use a FormRequest in a class. So, we copy the rules here.
         */
        // $tmsCustomerRequest = new TmsCustomerRequest();
        // $this->validationRules = $tmsCustomerRequest->customerRules();
    }

    public function handle(array $pamyraOrder, int $orderId): void
    {
        $orderAttributes = $pamyraOrder['attributes'];
        foreach($orderAttributes as $orderAttribute) {
            $this->createOrderAttribute($orderAttribute, $orderId);
        }
    }

    private function createOrderAttribute(array $orderAttribute, int $orderId): void
    {
        //No need for duplicate checking here, becase we already checked if the order is a duplicate.

        //Can't continue, first we must here define the tables + pivot tables.
        $orderAttributeArray = [

        ];
    }
}