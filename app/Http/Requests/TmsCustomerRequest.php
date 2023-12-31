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
            'company_name' => 'required|string|min:2|max:100',
            // 'company_name' => 'boolean',//just for testing validation

            'first_name' => 'required|string|min:2|max:200',
            'last_name' => 'required|string|min:2|max:200',
            'email' => 'required|email|max:100',
            'rating' => 'required|integer|between:1,5',
            'tax_number' => 'required|string|min:2|max:50',
            'internal_cid' => 'required|string|min:2|max:100',//****************** */

            'auto_book_as_private' => 'nullable|boolean',
            'dangerous_goods' => 'nullable|boolean',
            'bussiness_customer' => 'nullable|boolean',
            'debt_collection' => 'nullable|boolean',
            'direct_debit' => 'nullable|boolean',
            'manual_collective_invoicing' => 'nullable|boolean',
            'paypal' => 'nullable|boolean',
            'sofort' => 'nullable|boolean',
            'amazon' => 'nullable|boolean',
            'vorkasse' => 'nullable|boolean',
            'private_customer' => 'nullable|boolean',
            'invoice_customer' => 'nullable|boolean',
            'poor_payment_morale' => 'nullable|boolean',
            'can_login' => 'nullable|boolean',
            
            /**
             * These will work with mutators defined in model
             * customer_type must be a string during validation. Example: 'Bussiness customer'.
             * Only after validation it will be converted to an integer. Example: 1.
             */
            'customer_type' => 'required|string|min:2|max:100',
            'invoice_dispatch' => 'required|string|min:2|max:100',
            'invoice_shipping_method' => 'required|string|min:2|max:100',
            'payment_method' => 'required|string|min:2|max:100',
            // 'payment_method' => 'required|boolean',//this here is to trigger validation error

        ];
    }
}
