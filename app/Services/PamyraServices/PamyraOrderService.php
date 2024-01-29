<?php

namespace App\Services\PamyraServices;

use App\Models\TmsPamyraOrder;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\TmsPamyraOrderRequest;
use Illuminate\Support\Facades\Validator;

class PamyraOrderService {

    private string $houseNumber;
    private string $street;
    private int $countryId;
    private int $partnerId;

    /**
     * Validation rules from TmsPamyraOrderRequest.
     *
     * @var array
     */
    private array $validationRules;

    public function __construct()
    {
        /**
         * We copy here the validation rules from the TmsPamyraOrderRequest. Because we want to use them
         * in this class. And we can't use them directly from the TmsPamyraOrderRequest, because it is
         * a FormRequest. And we can't use a FormRequest in a class. So, we copy the rules here.
         */
        $tmsAddressRequest = new TmsPamyraOrderRequest();
        $this->validationRules = $tmsAddressRequest->addressRules();
    }
}