<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\CouponResource;

class ReportResource extends JsonResource
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
            'reporter' => new UserResource($this->whenLoaded('reporter')),
            'reported_user' => new UserResource($this->whenLoaded('reportedUser')),
            'reported_coupon' => new CouponResource($this->whenLoaded('reportedCoupon')),
            'type' => $this->type,
            'description' => $this->description,
            'status' => $this->status,
            'admin_note' => $this->admin_note,
            'resolved_at' => $this->resolved_at?->toIso8601String(),
            'created_at' => $this->created_at->diffForHumans(),
        ];
    }
}
