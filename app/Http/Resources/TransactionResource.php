<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            'type' => $this->type,
            'source' => $this->source,
            'amount' => (int) $this->amount,
            'balances' => [
                'before' => (int) $this->balance_before,
                'after' => (int) $this->balance_after,
            ],
            'description' => $this->description,
            'created_at' => $this->created_at->toIso8601String(),
        ];
    }
}
