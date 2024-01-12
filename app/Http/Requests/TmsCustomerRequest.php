<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TmsCustomerRequest extends FormRequest
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
            // General customer data
            'company_name' => 'required|string|min:2|max:100',
            'first_name' => 'required|string|min:2|max:200',
            'last_name' => 'required|string|min:2|max:200',
            'email' => 'required|email|max:100',
            'phone' => 'required|string|min:2|max:100',
            'rating' => 'required|integer|between:1,5',
            'tax_number' => 'required|string|min:2|max:50',
            'internal_id' => 'required|string|min:2|max:100',
            'payment_time' => 'required|integer',

            //We attach this forwarder with the appends trick in the TmsAddress
            'forwarder' => ['required', 'array'],

            // Special individual settings for a customer
            'auto_book_as_private' => 'boolean',
            'dangerous_goods' => 'boolean',
            'bussiness_customer' => 'boolean',
            'debt_collection' => 'boolean',
            'direct_debit' => 'boolean',
            'manual_collective_invoicing' => 'boolean',
            'paypal' => 'boolean',
            'sofort' => 'boolean',
            'amazon' => 'boolean',
            'vorkasse' => 'boolean',
            'private_customer' => 'boolean',
            'invoice_customer' => 'boolean',
            'poor_payment_morale' => 'boolean',
            'can_login' => 'boolean',
            
            /**
             * These will work with mutators defined in model
             * customer_type must be a string during validation. Example: 'Bussiness customer'.
             * Only after validation it will be converted to an integer. Example: 1.
             */
            'customer_type' => 'required|string|min:2|max:100',
            'invoice_dispatch' => 'required|string|min:2|max:100',
            'invoice_shipping_method' => 'required|string|min:2|max:100',
            'payment_method' => 'required|string|min:2|max:100',

        ];
    }
}
