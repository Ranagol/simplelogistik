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
            
            'id' => ['nullable', 'integer', 'exists:tms_addresses,id'],
            'customer_id' => ['nullable', 'integer', 'exists:tms_customers,id'],
            'forwarder_id' => ['nullable', 'integer', 'exists:tms_forwarders,id'],
            'country_id' => ['nullable', 'integer', 'exists:tms_countries,id'], 
            'partner_id' => [ 'nullable', 'integer', 'exists:tms_partners,id'],// is this is causing the problem?????????

            'company_name' => ['required', 'string', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'street' => ['required', 'string', 'max:200'],
            'house_number' => ['required', 'string', 'max:200'],
            'zip_code' => ['required', 'string', 'max:20'],
            'city' => ['required', 'string', 'max:100'],
            'state' => ['required', 'string', 'max:100'],
            'address_additional_information' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'max:100'],

            'is_pickup' => ['required', 'boolean'],
            'is_delivery' => ['required', 'boolean'],
            'is_billing' => ['required', 'boolean'],
            'is_headquarter' => ['required', 'boolean'],

            //We attach this country with the appends trick in the TmsAddress
            'country' => ['required', 'array'],

            //We attach this customer with the appends trick in the TmsAddress
            'customer' => ['required', 'array'],

            //We attach this forwarder with the appends trick in the TmsAddress
            'forwarder' => ['required', 'array'],

            //We attach this partner with the appends trick in the TmsAddress
            'partner' => ['required', 'array'],
        ];
    }
}
