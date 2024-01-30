<?php

namespace App\Http\Requests;

use App\Http\Requests\TmsParcelRequest;
use App\Http\Requests\TmsAddressRequest;
use App\Http\Requests\TmsNativeOrderRequest;
use App\Http\Requests\TmsPamyraOrderRequest;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\ValidationRules\ParcelValidationRule;

class TmsOrderRequest extends FormRequest
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
    public function rules()
    {
       return $this->orderRules();
    }

    public function orderRules()
    {
        return [

            'company_name' => ['nullable', 'string', 'max:255'],
            'contact_id' => ['nullable', 'integer'],
            'partner_id' => ['nullable', 'integer'],
            'type_of_transport' => ['nullable', 'string', 'max:200'],
            'origin' => ['required', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:255'],
            'customer_reference' => ['nullable', 'string', 'max:255'],
            'provision' => ['nullable', 'numeric', 'between:0,99.99'],
            'order_edited_events' => ['nullable', 'json'],
            'currency' => ['nullable', 'string', 'max:50'],
            'order_date' => ['required', 'date'],
            'purchase_price' => ['nullable', 'numeric'],
            'month_and_year' => ['nullable', 'string', 'max:255'],
            'payment_method' => ['required', 'numeric'],
            'easy_bill_customer_id' => ['nullable', 'integer', 'min:1'],

            // //NATIVE ORDER VALIDATION (from native_orders table)
            // 'native_order' => 'nullable|array',
            // 'native_order.*' => $TmsNativeOrderRequest->nativeOrderRules(),

            // //PAMYRA ORDER VALIDATION (from pamyra_orders table)
            // 'pamyra_order' => 'nullable|array',
            // 'pamyra_order.*' => $TmsPamyraOrderRequest->pamyraOrderRules(),

            //PARCEL VALIDATION (parcels is an array of objects, hence the * to symbolize the parcel object in parcels array)
            // 'parcels.*.id' => 'nullable|integer',
            // 'parcels.*.tms_order_id' => 'required|integer|exists:tms_orders,id',
            // 'parcels.*.is_hazardous' => 'boolean',
            // 'parcels.*.information' => 'required|string|max:255',
            // 'parcels.*.p_name' => 'required|string|max:255',
            // 'parcels.*.p_height' => 'required|numeric|between:0,9999999999.99',
            // 'parcels.*.p_length' => 'required|numeric|between:0,9999999999.99',
            // 'parcels.*.p_width' => 'required|numeric|between:0,9999999999.99',
            // 'parcels.*.p_number' => 'required|string|max:255',//This is a property of Pamyra orders. Number is an index of transport objects.
            // 'parcels.*.p_stackable' => 'boolean',
            // 'parcels.*.p_weight' => 'required|numeric|between:0,9999999999.99',
            
            /**
             * HEADQUARTER ADDRESS VALIDATION (HEADQUARTER IS A PROPERTY OF CUSTOMER)
             * For any nested stuff under pickup_address, use the * to symbolize it, and the 
             * addressRules() function to check it. So, the * is essential here!
             * 
             * $addressRequest->addressRules() is reused TmsAddressRequest.
             */
            // 'customer.headquarter' => 'array',
            // // 'customer.headquarter.company_name' => 'required|string|max:255',//this works
            // 'customer.headquarter' => $addressRequest->addressRules(),//this doesn't work
            
            /**
             * PICKUP ADDRESS VALIDATION
             * For any nested stuff under pickup_address, use the * to symbolize it, and the 
             * addressRules() function to check it. So, the * is essential here!
             * 
             * $addressRequest->addressRules() is reused TmsAddressRequest.
             */
            // 'pickup_addresses' => 'array',
            // 'pickup_addresses.*' => $addressRequest->addressRules(),
            
            /**
             * DELIVERY ADDRESS VALIDATION
             * For any nested stuff under pickup_address, use the * to symbolize it, and the 
             * addressRules() function to check it. So, the * is essential here!
             * 
             * $addressRequest->addressRules() is reused TmsAddressRequest.
             */
            // 'delivery_addresses' => 'array',
            // 'delivery_addresses.*' => $addressRequest->addressRules(),

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
            // Parcel custom validation error messages
            'parcels.*.tms_order_id.required' => 'The cargo order ID field is required.',
            'parcels.*.tms_order_id.integer' => 'The cargo order ID must be an integer.',
            'parcels.*.tms_order_id.exists' => 'The cargo order ID must exist in the tms_orders table.',
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

            // Customer custom validation error messages
            'customer.company_name.required' => 'The company name field is required.',
            'customer.company_name.string' => 'The company name must be a string.',
            'customer.company_name.max' => 'The company name may not be greater than 255 characters.',
            'customer.headquarter.company_name.required' => 'The company name field is required.',
            'customer.headquarter.company_name.string' => 'The company name must be a string.',
            'customer.headquarter.company_name.max' => 'The company name may not be greater than 255 characters.',
            'customer.headquarter.first_name.required' => 'The first name field is required.',
            'customer.headquarter.first_name.string' => 'The first name must be a string.',
            'customer.headquarter.first_name.max' => 'The first name may not be greater than 255 characters.',
            'customer.headquarter.last_name.required' => 'The last name field is required.',
            'customer.headquarter.last_name.string' => 'The last name must be a string.',
            'customer.headquarter.last_name.max' => 'The last name may not be greater than 255 characters.',
            'customer.headquarter.address_type.required' => 'The address type field is required.',
            'customer.headquarter.address_type.string' => 'The address type must be a string.',
            'customer.headquarter.address_type.max' => 'The address type may not be greater than 255 characters.',
            'customer.headquarter.street.required' => 'The street field is required.',
            'customer.headquarter.street.string' => 'The street must be a string.',
            'customer.headquarter.street.max' => 'The street may not be greater than 255 characters.',
            'customer.headquarter.house_number.required' => 'The house number field is required.',
            'customer.headquarter.house_number.string' => 'The house number must be a string.',
            'customer.headquarter.house_number.max' => 'The house number may not be greater than 255 characters.',
            'customer.headquarter.zip_code.required' => 'The zip code field is required.',
            'customer.headquarter.zip_code.string' => 'The zip code must be a string.',
            'customer.headquarter.zip_code.max' => 'The zip code may not be greater than 255 characters.',
            'customer.headquarter.city.required' => 'The city field is required.',
            'customer.headquarter.city.string' => 'The city must be a string.',
            'customer.headquarter.city.max' => 'The city may not be greater than 255 characters.',
            'customer.headquarter.state.required' => 'The state field is required.',
            'customer.headquarter.state.string' => 'The state must be a string.',
            'customer.headquarter.state.max' => 'The state may not be greater than 255 characters.',
            'customer.headquarter.phone.required' => 'The phone field is required.',
            'customer.headquarter.phone.string' => 'The phone must be a string.',
            'customer.headquarter.phone.max' => 'The phone may not be greater than 255 characters.',
            'customer.headquarter.email.required' => 'The email field is required.',
            'customer.headquarter.email.string' => 'The email must be a string.',
            'customer.headquarter.email.max' => 'The email may not be greater than 255 characters.',
            'customer.headquarter.address_additional_information.string' => 'The address additional information must be a string.',
            'customer.headquarter.address_additional_information.max' => 'The address additional information may not be greater than 255 characters.',
            'customer.headquarter.country_id.required' => 'The country ID field is required.',
            'customer.headquarter.customer_id.required' => 'The customer ID field is required.',
            'customer.headquarter.customer_id.exists' => 'The customer ID must exist in the tms_customers table.',
            'customer.headquarter.forwarder_id.required' => 'The forwarder ID field is required.',
            'customer.headquarter.forwarder_id.exists' => 'The forwarder ID must exist in the tms_forwarders table.',
            // 'customer.headquarter.partner_id.required' => 'THIS IS THE ISSUE HERE.',


            // Pickup address custom validation error messages
            'pickup_address.company_name.required' => 'The company name field is required.',
            'pickup_address.company_name.required' => 'The company name field is required.',
            'pickup_address.company_name.string' => 'The company name must be a string.',
            'pickup_address.company_name.max' => 'The company name may not be greater than 255 characters.',
            'pickup_address.company_name.required' => 'The company name field is required.',
            'pickup_address.company_name.string' => 'The company name must be a string.',
            'pickup_address.company_name.max' => 'The company name may not be greater than 255 characters.',
            'pickup_address.first_name.required' => 'The first name field is required.',
            'pickup_address.first_name.string' => 'The first name must be a string.',
            'pickup_address.first_name.max' => 'The first name may not be greater than 255 characters.',
            'pickup_address.last_name.required' => 'The last name field is required.',
            'pickup_address.last_name.string' => 'The last name must be a string.',
            'pickup_address.last_name.max' => 'The last name may not be greater than 255 characters.',
            'pickup_address.address_type.required' => 'The address type field is required.',
            'pickup_address.address_type.string' => 'The address type must be a string.',
            'pickup_address.address_type.max' => 'The address type may not be greater than 255 characters.',
            'pickup_address.street.required' => 'The street field is required.',
            'pickup_address.street.string' => 'The street must be a string.',
            'pickup_address.street.max' => 'The street may not be greater than 255 characters.',
            'pickup_address.house_number.required' => 'The house number field is required.',
            'pickup_address.house_number.string' => 'The house number must be a string.',
            'pickup_address.house_number.max' => 'The house number may not be greater than 255 characters.',
            'pickup_address.zip_code.required' => 'The zip code field is required.',
            'pickup_address.zip_code.string' => 'The zip code must be a string.',
            'pickup_address.zip_code.max' => 'The zip code may not be greater than 255 characters.',
            'pickup_address.city.required' => 'The city field is required.',
            'pickup_address.city.string' => 'The city must be a string.',
            'pickup_address.city.max' => 'The city may not be greater than 255 characters.',
            'pickup_address.state.required' => 'The state field is required.',
            'pickup_address.state.string' => 'The state must be a string.',
            'pickup_address.state.max' => 'The state may not be greater than 255 characters.',
            'pickup_address.phone.required' => 'The phone field is required.',
            'pickup_address.phone.string' => 'The phone must be a string.',
            'pickup_address.phone.max' => 'The phone may not be greater than 255 characters.',
            'pickup_address.email.required' => 'The email field is required.',
            'pickup_address.email.string' => 'The email must be a string.',
            'pickup_address.email.max' => 'The email may not be greater than 255 characters.',
            'pickup_address.address_additional_information.string' => 'The address additional information must be a string.',
            'pickup_address.address_additional_information.max' => 'The address additional information may not be greater than 255 characters.',
            'pickup_address.country_id.required' => 'The country ID field is required.',
            'pickup_address.customer_id.required' => 'The customer ID field is required.',
            'pickup_address.customer_id.exists' => 'The customer ID must exist in the tms_customers table.',
            'pickup_address.forwarder_id.required' => 'The forwarder ID field is required.',
            'pickup_address.forwarder_id.exists' => 'The forwarder ID must exist in the tms_forwarders table.',

            // Delivery address custom validation error messages
            'delivery_address.company_name.required' => 'The company name field is required.',
            'delivery_address.company_name.required' => 'The company name field is required.',
            'delivery_address.company_name.string' => 'The company name must be a string.',
            'delivery_address.company_name.max' => 'The company name may not be greater than 255 characters.',
            'delivery_address.company_name.required' => 'The company name field is required.',
            'delivery_address.company_name.string' => 'The company name must be a string.',
            'delivery_address.company_name.max' => 'The company name may not be greater than 255 characters.',
            'delivery_address.first_name.required' => 'The first name field is required.',
            'delivery_address.first_name.string' => 'The first name must be a string.',
            'delivery_address.first_name.max' => 'The first name may not be greater than 255 characters.',
            'delivery_address.last_name.required' => 'The last name field is required.',
            'delivery_address.last_name.string' => 'The last name must be a string.',
            'delivery_address.last_name.max' => 'The last name may not be greater than 255 characters.',
            'delivery_address.address_type.required' => 'The address type field is required.',
            'delivery_address.address_type.string' => 'The address type must be a string.',
            'delivery_address.address_type.max' => 'The address type may not be greater than 255 characters.',
            'delivery_address.street.required' => 'The street field is required.',
            'delivery_address.street.string' => 'The street must be a string.',
            'delivery_address.street.max' => 'The street may not be greater than 255 characters.',
            'delivery_address.house_number.required' => 'The house number field is required.',
            'delivery_address.house_number.string' => 'The house number must be a string.',
            'delivery_address.house_number.max' => 'The house number may not be greater than 255 characters.',
            'delivery_address.zip_code.required' => 'The zip code field is required.',
            'delivery_address.zip_code.string' => 'The zip code must be a string.',
            'delivery_address.zip_code.max' => 'The zip code may not be greater than 255 characters.',
            'delivery_address.city.required' => 'The city field is required.',
            'delivery_address.city.string' => 'The city must be a string.',
            'delivery_address.city.max' => 'The city may not be greater than 255 characters.',
            'delivery_address.state.required' => 'The state field is required.',
            'delivery_address.state.string' => 'The state must be a string.',
            'delivery_address.state.max' => 'The state may not be greater than 255 characters.',
            'delivery_address.phone.required' => 'The phone field is required.',
            'delivery_address.phone.string' => 'The phone must be a string.',
            'delivery_address.phone.max' => 'The phone may not be greater than 255 characters.',
            'delivery_address.email.required' => 'The email field is required.',
            'delivery_address.email.string' => 'The email must be a string.',
            'delivery_address.email.max' => 'The email may not be greater than 255 characters.',
            'delivery_address.address_additional_information.string' => 'The address additional information must be a string.',
            'delivery_address.address_additional_information.max' => 'The address additional information may not be greater than 255 characters.',
            'delivery_address.country_id.required' => 'The country ID field is required.',
            'delivery_address.customer_id.required' => 'The customer ID field is required.',
            'delivery_address.customer_id.exists' => 'The customer ID must exist in the tms_customers table.',
            'delivery_address.forwarder_id.required' => 'The forwarder ID field is required.',
            'delivery_address.forwarder_id.exists' => 'The forwarder ID must exist in the tms_forwarders table.',
        ];
    }
}

