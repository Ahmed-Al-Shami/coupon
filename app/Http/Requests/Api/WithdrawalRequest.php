<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class WithdrawalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'coins_amount' => 'required|integer|min:500',
            'payment_method' => 'required|in:bank_transfer,vodafone_cash,instapay',
            'payment_details' => 'required|array',
            'payment_details.phone_number' => 'required_if:payment_method,vodafone_cash',
            'payment_details.account_number' => 'required_if:payment_method,bank_transfer',
            'payment_details.bank_name' => 'required_if:payment_method,bank_transfer',
        ];
    }
}
