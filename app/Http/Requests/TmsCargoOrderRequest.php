<?php

namespace App\Http\Requests;

use App\Http\Requests\ValidationRules\ParcelValidationRule;
use App\Http\Requests\TmsParcelRequest;
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
        $parcelRequest = new TmsParcelRequest();

        return [

            //CARGO ORDER VALIDATION
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

            //PARCEL VALIDATION
            'parcels.*.tms_cargo_order_id' => 'required|integer|exists:tms_cargo_orders,id',
            'parcels.*.is_hazardous' => 'boolean',
            'parcels.*.information' => 'required|string|max:255',
            'parcels.*.p_name' => 'required|string|max:255',
            'parcels.*.p_height' => 'required|numeric|between:0,9999999999.99',
            'parcels.*.p_length' => 'required|numeric|between:0,9999999999.99',
            'parcels.*.p_width' => 'required|numeric|between:0,9999999999.99',
            'parcels.*.p_number' => 'required|string|max:255',//This is a property of Pamyra orders. Number is an index of transport objects.
            'parcels.*.p_stackable' => 'boolean',
            'parcels.*.p_weight' => 'required|numeric|between:0,9999999999.99',
        ];
    }

    /**
     * Sometimes we need custom validation erros messages, instead of the default ones, that Laravel
     * provides. This method is used to override the default messages. 
     * n Laravel, you can customize the validation error messages by overriding the messages method 
     * in your form request class. Here's how you can do it for the parcels.*.p_name field:
     * 
     * In this example, the keys of 
     * the array returned by the messages method correspond to the validation rules for the 
     * parcels.*.p_name field. The values of the array are the custom error messages for these 
     * validation rules. When validation fails, Laravel will use these custom error messages instead 
     * of the default ones.
     *
     * @return void
     */
    public function messages()
    {
        return [

            'parcels.*.tms_cargo_order_id.required' => 'The cargo order ID field is required.',
            'parcels.*.tms_cargo_order_id.integer' => 'The cargo order ID must be an integer.',
            'parcels.*.tms_cargo_order_id.exists' => 'The cargo order ID must exist in the tms_cargo_orders table.',
            'parcels.*.is_hazardous.boolean' => 'The is_hazardous field must be true or false.',
            'parcels.*.information.required' => 'The information field is required.',
            'parcels.*.information.string' => 'The information must be a string.',
            'parcels.*.information.max' => 'The information may not be greater than 255 characters.',
            'parcels.*.p_name.required' => 'The parcel type field is required.',
            'parcels.*.p_name.string' => 'The parcel type must be a string.',
            'parcels.*.p_name.max' => 'The parcel type may not be greater than 255 characters.',
            'parcels.*.p_height.required' => 'The height field is required.',
            'parcels.*.p_height.numeric' => 'The height must be a number.',
            'parcels.*.p_height.between' => 'The height must be between 0 and 9999999999.99.',
            'parcels.*.p_length.required' => 'The length field is required.',
            'parcels.*.p_length.numeric' => 'The length must be a number.',
            'parcels.*.p_length.between' => 'The length must be between 0 and 9999999999.99.',
            'parcels.*.p_width.required' => 'The width field is required.',
            'parcels.*.p_width.numeric' => 'The width must be a number.',
            'parcels.*.p_width.between' => 'The width must be between 0 and 9999999999.99.',
            'parcels.*.p_number.required' => 'The number field is required.',
            'parcels.*.p_number.string' => 'The number must be a string.',
            'parcels.*.p_number.max' => 'The number may not be greater than 255 characters.',
            'parcels.*.p_stackable.boolean' => 'The stackable field must be true or false.',
            'parcels.*.p_weight.required' => 'The weight field is required.',
            'parcels.*.p_weight.numeric' => 'The weight must be a number.',
            'parcels.*.p_weight.between' => 'The weight must be between 0 and 9999999999.99.',
        ];
    }
}
