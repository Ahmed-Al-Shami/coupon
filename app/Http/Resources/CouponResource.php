<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserResource;

class CouponResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'owner' => new UserResource($this->whenLoaded('user')),
            'place' => [
                'name' => $this->place_name,
                'category' => $this->place_category,
                'address' => $this->place_address,
                'location' => [
                    'lat' => (float) $this->latitude,
                    'lng' => (float) $this->longitude,
                ],
            ],
            'discount' => [
                'value' => (float) $this->discount_value,
                'type' => $this->discount_type,
            ],
            'price' => (int) $this->coins_price,
            'expiry_date' => $this->expiry_date->toDateString(),
            'image_url' => $this->image_path ? asset('storage/' . $this->image_path) : null,
            'status' => $this->status,
            'is_verified' => (bool) $this->is_verified,
            'distance' => $this->when(isset($this->distance), round((float) $this->distance, 2)),
            'created_at' => $this->created_at->diffForHumans(),
        ];
    }
}
