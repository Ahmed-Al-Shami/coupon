<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ReportRequest extends FormRequest
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
            'reported_user_id' => 'required_without_all:reported_coupon_id,reported_purchase_id|exists:users,id',
            'reported_coupon_id' => 'required_without_all:reported_user_id,reported_purchase_id|exists:coupons,id',
            'reported_purchase_id' => 'required_without_all:reported_user_id,reported_coupon_id|exists:coupon_purchases,id',
            'type' => 'required|in:fake_coupon,used_coupon,offensive_content,fraud,other',
            'description' => 'required|string|max:1000',
            'evidence_images' => 'nullable|array',
            'evidence_images.*' => 'image|max:2048',
        ];
    }
}
