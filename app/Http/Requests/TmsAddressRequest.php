<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TmsAddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * This function is triggered, when we do in the controller the form validation, with
     * TmsAddressRequest $request. But, this function can't be re-used on other places. So, we put
     * our validation rules in the addressRules function. Because the rule is reusable. As a result,
     * of all this...
     * 1 - this rules() function is triggered, when we do in the controller the form validation, with
     * TmsAddressRequest $request.
     * 2 - this addressRules() function we call in our code, when we want to reuse the address
     * validation in other controller than the TmsAddressController.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return $this->addressRules();
    }

    /**
     * This is reusable!
     *
     * @return void
     */
    public function addressRules()
    {
        return [
            /**
             * The id must be nullable, because of create. But must be validated, because of edit.
             */
            'id' => ['nullable', 'integer', 'exists:tms_addresses,id'],
            'company_name' => ['required', 'string', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'address_type' => ['required', 'string', 'max:255'], //this is a mutator. TmsAddress::setAddressTypeAttribute() will be called.
            'street' => ['required', 'string', 'max:200'],
            'house_number' => ['required', 'string', 'max:200'],
            'zip_code' => ['required', 'string', 'max:20'],
            'city' => ['required', 'string', 'max:100'],
            'country_id' => ['required', 'string'], //this is a mutator. TmsAddress::setCountryIdAttribute() will be called.
            'state' => ['required', 'string', 'max:100'],
            'phone' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'max:100'],
            'address_additional_information' => ['required', 'string', 'max:255'],
            'customer_id' => ['required', 'integer', 'exists:tms_customers,id'],
            'forwarder_id' => ['required', 'integer', 'exists:tms_forwarders,id'],

            //TODO ANDOR
            // I stopped here, with these issues:
            // "customer.headquarter.country": "The customer.headquarter.country field is required.",
            // "pickup_address.company_name": "The company name field is required.",
            // "pickup_address.country": "The pickup_address.country field is required.",
            // "delivery_address.country": "The delivery_address.country field is required."
            // SOMETHING DOES NOT WORK IN WITH COUNTRY VALIDATION. I NEED TO FIX THIS.
        ];
    }
}
