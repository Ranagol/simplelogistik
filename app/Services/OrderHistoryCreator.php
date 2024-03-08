<?php

namespace App\Services;

use App\Models\TmsOrder;
use App\Models\TmsOrderHistory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\TmsOrderHistoryRequest;

/**
 * Creates a new order history for an order. In average, this could happend in the TmsOrderController,
 * in the store() and update() methods. But, we want to keep the TmsOrderController as clean as possible.
 */
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
     * Creates order history record.
     *
     * @param TmsOrder $order
     * @param string $action            store | update
     * @param integer|null $userId
     * @param string|null $cronJobName
     * @param TmsOrder|null $previousState
     * @return void
     */
    public function createOrderHistory(
        TmsOrder $order,
        string $action,
        int $userId = null,
        string $cronJobName = null,
        TmsOrder|null $previousState = null
    ): void
    {

        //Set, format data for order history
        $orderHistory = [
            'order_status_id' => $this->setOrderStatusId($action, $order),
            'details' => $action,
            'additional_cost' => null,
            'order_id' => $order->id,
            'forwarder_id' => $order->forwarder_id,
            'customer_id' => $order->customer_id,
            'forwarding_contract_id' => null,//TODO ANDOR: can we delete this column from the tms_order_histories? This info should not be stored here.
            'user_id' => $userId,
            'cronjob_name' => $cronJobName,
            'previous_state' => $previousState,
        ];

        //Validate
        $this->validate($orderHistory);

        //Create a new order history
        TmsOrderHistory::create($orderHistory);
    }

    /**
     * Set the order status id. If the action is store, then the status is 1 (new order). If the action
     * is update, then the status is the current status of the order.
     *
     * @param string $action
     * @param TmsOrder $tmsOrder
     * @return integer
     */
    private function setOrderStatusId(string $action, TmsOrder $tmsOrder): int
    {
        if ($action === 'store') {

            //With store() we create a new order. So, the status is 1 (new order
            return 1;

        } else if ($action === 'update') {

            //With update() we update an existing order. So, we return the current status of the order.
            return $tmsOrder->order_status_id;

        } else {
            throw new \Exception('Invalid action name. Action can be only store or update');
        }
    }

    /**
     * Validates the address data from Pamyra.
     * 
     * @Christoph said, that temporarily we just need to throw a simple basic exception if the 
     * validation fails. Later we will handle this with monitoring.
     *
     * @param array $orderHistory
     * @return void
     */
    private function validate(array $orderHistory): void
    {
        // Validate the data
        $validator = Validator::make($orderHistory, $this->validationRules);

        if ($validator->fails()) {
            echo $validator->errors()->first() . PHP_EOL;
            Log::error($validator->errors()->first());
            // throw new \Exception($validator->errors()->first());
        }
    }
}