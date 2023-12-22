<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TmsCargoOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type_of_transport' => 'required|string|max:200',
            'origin' => 'required|string|max:255',
            'customer_reference' => 'required|string|max:255',
            'provision' => 'nullable|numeric|between:0,99.99',
            'order_edited_events' => 'nullable|json',
            'currency' => 'nullable|string|max:50',
            'order_date' => 'required|date',
            'purchase_price' => 'nullable|string|max:200',
            'month_and_year' => 'nullable|string|max:255',
            'customer_id' => 'required|exists:tms_customers,id',
            'contact_id' => 'required|exists:tms_contacts,id',
            'pickup_address_id' => 'required|exists:tms_addresses,id',
            'delivery_address_id' => 'required|exists:tms_addresses,id',

            'avis_customer_phone' => 'nullable|string|max:200',
            'avis_sender_phone' => 'nullable|string|max:200',
            'avis_receiver_phone' => 'nullable|string|max:200',

            'p_calculation_model_name' => 'nullable|string|max:255',
            'p_order_number' => 'nullable|string|max:255',
            'p_order_pdf' => 'nullable|string|max:255',
            'p_payment_method' => 'required|string|max:255',
            'p_date_of_sale' => 'required|date',
            'p_date_of_cancellation' => 'nullable|date_format:Y-m-d',
            'p_pickup_date_from' => 'nullable|date',
            'p_pickup_date_to' => 'nullable|date',
            'p_pickup_comments' => 'nullable|string|max:255',
            'p_delivery_date_from' => 'nullable|date',
            'p_delivery_date_to' => 'nullable|date',
            'p_delivery_comments' => 'nullable|string|max:255',
            'p_description_of_transport' => 'nullable|string|max:255',
            'p_particularities' => 'nullable|string|max:255',

            'p_loading_meter' => 'nullable|string|max:255',
            'p_square_meter' => 'nullable|string|max:255',
            'p_total_weight' => 'nullable|string|max:255',
            'p_qubic_meter' => 'nullable|string|max:255',
            
            'p_calculated_transport_price' => 'nullable|string|max:255',
            'p_transport_price_gross' => 'nullable|string|max:255',

            'p_transport_price_vat' => 'nullable|string|max:255',
            'p_transport_price_net' => 'nullable|string|max:255',
            
            'p_customized_price_change' => 'nullable|string|max:255',
            'p_customized_price_mode' => 'nullable|string|max:255',
            'p_discount' => 'nullable|string|max:255',
            'p_price_gross' => 'nullable|string|max:255',
            'p_price_vat' => 'nullable|string|max:255',
            'p_price_net' => 'nullable|string|max:255',
            'p_price_fuel_surcharge' => 'nullable|string|max:255',
            'p_vat_rate' => 'nullable|string|max:255',
            'p_value_insured' => 'nullable|string|max:255',
            'p_value_of_goods' => 'nullable|string|max:255',
            'p_distance_km' => 'required|string|max:255',
            'p_duration_minutes' => 'nullable|string|max:255',
        ];
    }
}
