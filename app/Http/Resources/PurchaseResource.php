<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\CouponResource;

class PurchaseResource extends JsonResource
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
            'buyer' => new UserResource($this->whenLoaded('buyer')),
            'seller' => new UserResource($this->whenLoaded('seller')),
            'coupon' => new CouponResource($this->whenLoaded('coupon')),
            'financials' => [
                'coins_spent' => (int) $this->coins_spent,
                'seller_earned' => (int) $this->seller_coins_earned,
                'platform_cut' => (int) $this->platform_coins_cut,
            ],
            'status' => $this->status,
            'revealed_at' => $this->revealed_at?->toIso8601String(),
            'grace_period_ends_at' => $this->grace_period_ends_at?->toIso8601String(),
            'confirmed_at' => $this->confirmed_at?->toIso8601String(),
            'created_at' => $this->created_at->diffForHumans(),
        ];
    }
}
