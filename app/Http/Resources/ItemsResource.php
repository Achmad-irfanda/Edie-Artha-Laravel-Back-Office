<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemsResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'varian' => $this->varian,
            'kuantitas' => $this->kuantitas,
            'harga' => $this->harga,
            'total' => $this->total,
            'rating' => $this->rating,
            'created_at' => $this->created_at,
        ];
    }
}
