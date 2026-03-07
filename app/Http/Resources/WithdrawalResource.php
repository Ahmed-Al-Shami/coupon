<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WithdrawalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'coins' => (int) $this->coins_amount,
            'money' => [
                'amount' => (float) $this->real_money_amount,
                'currency' => 'EGP',
                'rate' => (float) $this->exchange_rate,
            ],
            'payment' => [
                'method' => $this->payment_method,
                'details' => $this->id === auth()->id() || auth()->user()?->is_verified ? $this->payment_details : null, // Privacy
            ],
            'status' => $this->status,
            'admin_note' => $this->admin_note,
            'processed_at' => $this->processed_at?->toIso8601String(),
            'created_at' => $this->created_at->toIso8601String(),
        ];
    }
}
