<?php

namespace App\Services\PamyraServices;

use App\Models\TmsPamyraOrder;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\TmsPamyraOrderRequest;
use Illuminate\Support\Facades\Validator;
use App\Services\PamyraServices\DateFormatterTrait;

class PamyraOrderService {

    use DateFormatterTrait;

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
        $tmsPamyraOrderRequest = new TmsPamyraOrderRequest();
        $this->validationRules = $tmsPamyraOrderRequest->pamyraOrderRules();
    }

    public function handle(
        array $pamyraOrder, 
        int $orderId
    )
    {
        $this->checkForDuplicate($pamyraOrder, $orderId);
        $this->createPamyraOrder($pamyraOrder, $orderId);
    }

    private function checkForDuplicate(
        array $pamyraOrder, 
        int $orderId
    ): void
    {
        $pamyraOrder = TmsPamyraOrder::where('order_id', $orderId)->first();
        if ($pamyraOrder) {
            throw new \Exception("Pamyra order with order_id = $orderId already exists in the database.");
            //TODO ANDOR ask C. How to handle if there is a pamyra order duplicate already in db? 
            //Write info into logs. Send an email to admin. Later solve with monitoring.
            //Write all this down into dockblock.
        }
    }

    private function createPamyraOrder(
        array $pamyraOrder, 
        int $orderId
    ): void
    {
        $pamyraOrderArray = [
            'order_id' => $orderId,
            'calculation_model_name' => $pamyraOrder['calculationModelName'],
            'order_number' => $pamyraOrder['orderNumber'],
            'order_pdf' => $pamyraOrder['orderPdf'],
            'payment_method' => $pamyraOrder['paymentMethod'],
            'date_of_sale' => $this->formatPamyraDateTime($pamyraOrder['dateOfSale']),
            'date_of_cancellation' => $pamyraOrder['dateOfCancellation'],

            /**
             * //TODO ANDOR ask C. should pickup and delivery details belong to the pamyra_orders SEE WRITINGS ANDOR
             * like now, or should they belong to addresses? When this is decided, then handle these
             * commented lines, and put them where they will belong.
             * pickup and delivery details should now belong to orderAddresses. Remove these
             * column from orders table. And add them to orderAddresses table. Because this is only
             * for pickup and delivery addresses!!!!
             * Because of this, orderAddresses must use his own rules from now on. Because the
             * table structure has become different from tms_addresses.
             */
            // 'pickup_date_from' => $pamyraOrder['pickupDate']['dateFrom'] . ' ' . $pamyraOrder['pickupDate']['timeFromFrom'],
            // 'pickup_date_to' => $pamyraOrder['pickupDate']['dateTo'] . ' ' . $pamyraOrder['pickupDate']['timeFromTo'],
            // 'pickup_comments' => $pamyraOrder['pickupDate']['asString'],
            // 'delivery_date_from' => $pamyraOrder['deliveryDate']['dateFrom'] . ' ' . $pamyraOrder['deliveryDate']['timeFromFrom'],
            // 'delivery_date_to' => $pamyraOrder['deliveryDate']['dateTo'] . ' ' . $pamyraOrder['deliveryDate']['timeFromTo'],
            // 'delivery_comments' => $pamyraOrder['deliveryDate']['asString'],
            // 'description_of_transport' => $pamyraOrder['descriptionOfTransport'],

            'particularities' => $pamyraOrder['particularities'],
            'loading_meter' => $pamyraOrder['loadingMeter'],
            'square_meter' => $pamyraOrder['squareMeter'],
            'total_weight' => $pamyraOrder['totalWeight'],
            'qubic_meter' => $pamyraOrder['qubicMeter'],
            'calculated_transport_price' => $pamyraOrder['calculatedTransportPrice'],
            'transport_price_gross' => $pamyraOrder['transportPriceGross'],
            'transport_price_vat' => $pamyraOrder['transportPriceVat'],
            'transport_price_net' => $pamyraOrder['transportPriceNet'],
            'customized_price_change' => $pamyraOrder['customizedPriceChange'],
            'customized_price_mode' => $pamyraOrder['customizedPriceMode'],
            'discount' => $pamyraOrder['discount'],
            'price_gross' => $pamyraOrder['priceGross'],
            'price_vat' => $pamyraOrder['priceVat'],
            'price_net' => $pamyraOrder['priceNet'],
            'price_fuel_surcharge' => $pamyraOrder['priceFuelSurcharge'],
            'vat_rate' => $pamyraOrder['vatRate'],
            'value_insured' => $pamyraOrder['valueInsured'],
            'value_of_goods' => $pamyraOrder['valueOfGoods'],
            'distance_km' => $pamyraOrder['distanceKm'],
            'duration_minutes' => $pamyraOrder['durationMinutes'],
        ];

        $this->validate($pamyraOrderArray);

        $pamyraOrder = TmsPamyraOrder::create($pamyraOrderArray);
    }

    /**
     * @Christoph said, that temporarily we just need to throw a simple basic exception if the 
     * validation fails. Later we will handle this with monitoring.
     *
     * @param array $pamyraOrderArray
     * @return void
     */
    private function validate(array $pamyraOrderArray): void
    {
        $validator = Validator::make($pamyraOrderArray, $this->validationRules);
        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first());
        }
    }
}