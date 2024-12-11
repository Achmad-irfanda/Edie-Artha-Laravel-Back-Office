<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        // $image = 'http://192.168.0.105:8000'  . asset($this->thumbnail);
        $image = 'http://10.0.2.2:8000'  . asset($this->thumbnail);
        return [
            'id' => $this->id,
            'kode' => $this->kode,
            'nama' => $this->nama,
            'deskripsi' => $this->deskripsi,
            'varian' => $this->varian,
            'harga' => $this->harga,
            'status' => $this->status,
            'stok' => $this->stok,
            'thumbnail' => $image,
            'image' => new ImageResource($this->whenLoaded('image')),
        ];
    }
}
