<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InventoryResource extends JsonResource
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
            'product' => [
                'id' => $this->product->id,
                'sku' => $this->product->sku,
                'name' => $this->product->name,
                'description' => $this->product->description,
            ],
            'quantity' => $this->quantity,
            'price_per_unit' => $this->price_per_unit,
            'location' => $this->location,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
