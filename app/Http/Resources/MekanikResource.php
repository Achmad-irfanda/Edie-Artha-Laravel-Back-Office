<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MekanikResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $image = 'http://192.168.0.105:8000' . asset($this->image);
        return [
            'id' => $this->id,
            'nama' => $this->nama,
            'nohp' => $this->nohp,
            'jabatan' => $this->jabatan,
            'image' => $image,
        ];
    }
}
