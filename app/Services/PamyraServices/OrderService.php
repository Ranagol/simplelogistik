<?php

namespace App\Services\PamyraServices;

use App\Models\TmsOrder;
use App\Http\Requests\TmsOrderRequest;
use Illuminate\Support\Facades\Validator;

class OrderService {

    /**
     * Validation rules.
     * This is just a temporary solution. We are supposed to use the OrderRequest class validation 
     * here. However, that is something that will be soon changed, because of the changes in the FE.
     * //TODO ANDOR
     * 
     * @var array
     */
    private array $validationRules = [
        'customer.id' => ['nullable', 'integer'],
        'customer.company_name' => ['required', 'string', 'max:255'],
        'contact_id' => ['nullable', 'integer'],
        'partner_id' => ['nullable', 'integer'],
        
        //ORDER VALIDATION (from orders table)
        'type_of_transport' => ['required', 'string', 'max:200'],
        'origin' => ['required', 'string', 'max:255'],
        'status' => ['required', 'string', 'max:255'],
        'customer_reference' => ['required', 'string', 'max:255'],
        'provision' => ['nullable', 'numeric', 'between:0,99.99'],
        'order_edited_events' => ['nullable', 'json'],
        'currency' => ['nullable', 'string', 'max:50'],
        'order_date' => ['required', 'date'],
        'purchase_price' => ['nullable', 'string', 'max:200'],
        'month_and_year' => ['nullable', 'string', 'max:255'],
        
        'avis_customer_phone' => ['nullable', 'string', 'max:200'],
        'avis_sender_phone' => ['nullable', 'string', 'max:200'],
        'avis_receiver_phone' => ['nullable', 'string', 'max:200'],
        
        'payment_method' => ['required', 'string', 'min:2', 'max:100'],
        'easy_bill_customer_id' => ['nullable', 'integer', 'min:1'],
    ];


    public function handle(array $pamyraOrder, int $customerId, int $billingAddressId): TmsOrder
    {
        //TODO ANDOR: in the moment that I am looking on the pamyra json I see there is a field with oderPdf. The data from this field schould go to (base_path).documents.orders.pamyra  name of File then $orderNumer .".pdf"
        $this->checkForDuplicate($pamyraOrder, $customerId, $billingAddressId);
        $order = $this->createOrder($pamyraOrder);
        return $order;
    }

    private function checkForDuplicate(array $pamyraOrder, int $customerId, int $billingAddressId)
    {
        $duplicateOrder = TmsOrder::where('customer_id', $customerId)
                            ->where('order_number', $pamyraOrder['orderNumber'])
                            ->where('billing_address_id', $billingAddressId)
                            ->first();

        if($duplicateOrder) {
            echo 'Order with order number ' . $pamyraOrder['orderNumber'] . ' already exists.' . PHP_EOL;
            throw new \Exception('Order with order number ' . $pamyraOrder['orderNumber'] . ' already exists.');
        }
    }

    private function createOrder(array $pamyraOrder): TmsOrder
    {
        $order = TmsOrder::create([
            'order_number' => $pamyraOrder['order_number'],
            'customer_id' => $pamyraOrder['customer_id'],
            'sender_id' => $pamyraOrder['sender_id'],
            'receiver_id' => $pamyraOrder['receiver_id'],
            'order_date' => $pamyraOrder['order_date'],
            'order_type' => $pamyraOrder['order_type'],
            'order_origin' => $pamyraOrder['order_origin'],
            'order_pdf' => $pamyraOrder['order_pdf'],
            'order_attributes' => $pamyraOrder['order_attributes'],
            'parcels' => $pamyraOrder['parcels'],
            'pamyra_order' => $pamyraOrder['pamyra_order'],
            'order_addresses' => $pamyraOrder['order_addresses'],
        ]);

        $this->validate($order->toArray());//for validation we must transform model to array

        return $order;
    }

    private function validate(array $orderArray): void
    {
        // Validate the data
        $validator = Validator::make($orderArray, $this->validationRules);

        // If the validation fails, throw an exception
        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first());
        }
    }
}