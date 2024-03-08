<?php

namespace App\Services;

use App\Models\TmsOrder;
use App\Models\TmsOrderHistory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\TmsOrderHistoryRequest;

class OrderHistoryCreator {

    /**
     * Validation rules.
     *
     * @var array
     */
    private array $validationRules;

    public function __construct()
    {
        /**
         * We copy here the validation rules from the TmsOrderHistoryRequest. Because we want to use them
         * in this class. And we can't use them directly from the TmsOrderHistoryRequest, because it is
         * a FormRequest. And we can't use a FormRequest in a class. So, we copy the rules here.
         */
        $tmsOrderHistoryRequest = new TmsOrderHistoryRequest();
        $this->validationRules = $tmsOrderHistoryRequest->orderHistoryRules();
    }

    /**
     * Undocumented function
     *
     * @param TmsOrder $order
     * @param string $action            store | update
     * @param integer|null $userId
     * @param string|null $cronJobName
     * @return void
     */
    public function createOrderHistory(
        TmsOrder $order,
        string $action,
        int $userId = null,
        string $cronJobName = null
    ): void
    {
        //Set, format data for order history
        $orderHistory = [
            'order_status_id' => 1,//we might need a dynamic getter here, because for update we need to get the new status
            'details' => $action,
            'additional_cost' => null,
            'order_id' => $order->id,
            'forwarder_id' => $order->forwarder_id,
            'customer_id' => $order->customer_id,
            'forwarding_contract_id' => null,//can we delete this column from the tms_order_histories? This info should not be stored here.
            'user_id' => $userId,
            'cron_job_name' => $cronJobName,
            'previous_state' => null,
        ];

        //Validate
        $this->validate($orderHistory);

        //Create a new order history
        TmsOrderHistory::create($orderHistory);
    }

    /**
     * Validates the address data from Pamyra.
     * 
     * @Christoph said, that temporarily we just need to throw a simple basic exception if the 
     * validation fails. Later we will handle this with monitoring.
     *
     * @param array $addressPamyra
     * @throws \Exception
     * @return void
     */
    private function validate(array $addressPamyra): void
    {
        // Validate the data
        $validator = Validator::make($addressPamyra, $this->validationRules);

        // Throw an exception if validation fails
        if ($validator->fails()) {
            echo $validator->errors()->first() . PHP_EOL;
            Log::error($validator->errors()->first());
        }
    }
}