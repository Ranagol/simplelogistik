<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TmsOrderHistoryRequest extends FormRequest
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
        return $this->orderHistoryRules();
    }

    /**
     * This is reusable!
     *
     * @return void
     */
    public function orderHistoryRules()
    {
        return [
            'order_status_id' => ['required', 'integer', 'exists:tms_order_statuses,id'],
            'details' => ['nullable', 'string', 'max:255'],
            'additional_cost' => ['nullable', 'numeric', 'between:0,99999999.99'],
            'order_id' => ['required', 'integer', 'exists:tms_orders,id'],
            'forwarder_id' => ['nullable', 'integer', 'exists:tms_forwarders,id'],
            'customer_id' => ['required', 'integer', 'exists:tms_customers,id'],
            'forwarding_contract_id' => ['nullable', 'integer', 'exists:tms_forwarding_contracts,id'],
            'user_id' => ['nullable', 'integer', 'exists:users,id'],
            'cron_job_name' => ['nullable', 'string', 'max:255'],
            'previous_state' => ['nullable', 'string', 'max:255'],
        ];
    }
}
