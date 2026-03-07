<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->when($this->id === auth()->id(), $this->email),
            'phone' => $this->when($this->id === auth()->id(), $this->phone),
            'coins_balance' => (int) $this->coins_balance,
            'is_verified' => (bool) $this->is_verified,
            'is_banned' => (bool) $this->is_banned,
            'reports_count' => (int) $this->reports_count,
            'last_login_at' => $this->last_login_at?->diffForHumans(),
            'created_at' => $this->created_at->diffForHumans(),
        ];
    }
}
