<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreCouponRequest extends FormRequest
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
            'title' => 'required|string|max:100',
            'description' => 'required|string|max:500',
            'place_name' => 'required|string|max:100',
            'place_category' => 'required|in:restaurant,cafe,shopping,entertainment,health,other',
            'place_address' => 'required|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'discount_value' => 'required|numeric|min:1',
            'discount_type' => 'required|in:percentage,fixed',
            'expiry_date' => 'required|date|after:+3days',
            'coupon_code' => 'required|string|max:100',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'coins_price' => 'required|integer|min:10', // Default min price
        ];
    }
}
