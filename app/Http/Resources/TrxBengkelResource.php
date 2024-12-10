<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TrxBengkelResource extends JsonResource
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
            'kendala' => $this->kendala,
            'deskripsi' => $this->deskripsi,
            'jenis_kendaraan' => $this->jenis_kendaraan,
            'plat_nomor' => $this->plat_nomor,
            'rating' => $this->rating,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'mekanik' =>  new MekanikResource($this->whenLoaded('mekanik')),
        ];
    }
}
