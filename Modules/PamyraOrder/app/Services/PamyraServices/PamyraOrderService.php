<?php

namespace Modules\PamyraOrder\app\Services\PamyraServices;

use App\Models\TmsPamyraOrder;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\TmsPamyraOrderRequest;
use Modules\PamyraOrder\app\Services\PamyraServices\DateFormatterTrait;

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

    /**
     * The main function in this class, that triggers all other functions.
     * We do not check here for duplicate pamyra order, since we already did that in the OrderHandler 
     * class, at the very beginning, as first step.
     *
     * @param array $pamyraOrder
     * @param integer $orderId
     * @return void
     */
    public function handle(
        array $pamyraOrder, 
        int $orderId
    )
    {
        $this->createPamyraOrder($pamyraOrder, $orderId);
    }

    private function createPamyraOrder(
        array $pamyraOrder, 
        int $orderId
    ): void
    {
        $pamyraOrderArray = [
            'order_id' => $orderId,
            'calculation_model_name' => $pamyraOrder['CalculationModelName'] ?? null,
            'order_number' => $pamyraOrder['OrderNumber'] ?? null,//Pamyra order number
            'order_pdf' => $pamyraOrder['OrderPdf'] ?? null,
            'payment_method' => $pamyraOrder['PaymentMethod'] ?? null,
            'date_of_sale' => $this->formatPamyraDateTime($pamyraOrder['DateOfSale']),
            // 'date_of_cancellation' => $pamyraOrder['DateOfCancellation'],
            'description_of_transport' => $pamyraOrder['DescriptionOfTransport'] ?? null,
            'particularities' => $pamyraOrder['Particularities'] ?? null,
            'loading_meter' => $pamyraOrder['LoadingMeter'] ?? null,
            'square_meter' => $pamyraOrder['SquareMeter'] ?? null,
            'total_weight' => $pamyraOrder['TotalWeight'] ?? null,
            'qubic_meter' => $pamyraOrder['QubicMeter'] ?? null,
            'calculated_transport_price' => $pamyraOrder['CalculatedTransportPrice'] ?? null,
            'transport_price_gross' => $pamyraOrder['TransportPriceGross'] ?? null,
            'transport_price_vat' => $pamyraOrder['TransportPriceVat'] ?? null,
            'transport_price_net' => $pamyraOrder['TransportPriceNet'] ?? null,
            'customized_price_change' => $pamyraOrder['CustomizedPriceChange'] ?? null,
            'customized_price_mode' => $pamyraOrder['CustomizedPriceMode'] ?? null,
            'discount' => $pamyraOrder['Discount'] ?? null,
            'price_gross' => $pamyraOrder['PriceGross'] ?? null,
            'price_vat' => $pamyraOrder['PriceVat'] ?? null,
            'price_net' => $pamyraOrder['PriceNet'] ?? null,
            'price_fuel_surcharge' => $pamyraOrder['PriceFuelSurcharge'] ?? null,
            'vat_rate' => $pamyraOrder['VatRate'] ?? null,
            'value_insured' => $pamyraOrder['ValueInsured'] ?? null,
            'value_of_goods' => $pamyraOrder['ValueOfGoods'] ?? null,
            'distance_km' => $pamyraOrder['DistanceKm'] ?? null,
            'duration_minutes' => $pamyraOrder['DurationMinutes'] ?? null,
        ];

        $this->validate($pamyraOrderArray);

        $pamyraOrder = TmsPamyraOrder::create($pamyraOrderArray);
    }

    /**
     * @Christoph said, that temporarily we just need to throw a simple basic exception if the 
     * validation fails. Later we will handle this with monitoring.
     *
     * @param array $pamyraOrderArray
     * @throws \Exception
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