<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TrxProductResource extends JsonResource
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
            'user_id' => $this->user_id,
            'alamat' => $this->alamat,
            'total' => $this->total,
            'status' => $this->status,
            'jasa_pasang' => $this->jasa_pasang,
            'pembayaran' => $this->pembayaran,
            'created_at' => $this->created_at,
            'product' =>  new ItemsResource($this->whenLoaded('items')),
        ];
    }
}
