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
            echo 'Order with order number ' . $pamyraOrder['OrderNumber'] . ' already exists.' . PHP_EOL;
            throw new \Exception("Pamyra order with order_id = $orderId already exists in the database.");
        }
    }

    private function createPamyraOrder(
        array $pamyraOrder, 
        int $orderId
    ): void
    {
        $pamyraOrderArray = [
            'order_id' => $orderId,
            'calculation_model_name' => $pamyraOrder['CalculationModelName'],
            'order_number' => $pamyraOrder['OrderNumber'],
            'order_pdf' => $pamyraOrder['OrderPdf'],
            'payment_method' => $pamyraOrder['PaymentMethod'],
            'date_of_sale' => $this->formatPamyraDateTime($pamyraOrder['DateOfSale']),
            // 'date_of_cancellation' => $pamyraOrder['DateOfCancellation'],
            'description_of_transport' => $pamyraOrder['DescriptionOfTransport'],
            'particularities' => $pamyraOrder['Particularities'],
            'loading_meter' => $pamyraOrder['LoadingMeter'],
            'square_meter' => $pamyraOrder['SquareMeter'],
            'total_weight' => $pamyraOrder['TotalWeight'],
            'qubic_meter' => $pamyraOrder['QubicMeter'],
            'calculated_transport_price' => $pamyraOrder['CalculatedTransportPrice'],
            'transport_price_gross' => $pamyraOrder['TransportPriceGross'],
            'transport_price_vat' => $pamyraOrder['TransportPriceVat'],
            'transport_price_net' => $pamyraOrder['TransportPriceNet'],
            'customized_price_change' => $pamyraOrder['CustomizedPriceChange'],
            'customized_price_mode' => $pamyraOrder['CustomizedPriceMode'],
            'discount' => $pamyraOrder['Discount'],
            'price_gross' => $pamyraOrder['PriceGross'],
            'price_vat' => $pamyraOrder['PriceVat'],
            'price_net' => $pamyraOrder['PriceNet'],
            'price_fuel_surcharge' => $pamyraOrder['PriceFuelSurcharge'],
            'vat_rate' => $pamyraOrder['VatRate'],
            'value_insured' => $pamyraOrder['ValueInsured'],
            'value_of_goods' => $pamyraOrder['ValueOfGoods'],
            'distance_km' => $pamyraOrder['DistanceKm'],
            'duration_minutes' => $pamyraOrder['DurationMinutes'],
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