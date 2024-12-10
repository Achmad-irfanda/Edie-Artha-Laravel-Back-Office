<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
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
        $image = 'https://i.ibb.co.com/nfKQJdQ/user.png';
        if ($this->image != null) {
            $image = 'http://192.168.0.105:8000'  . asset($this->image);
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'nohp' => $this->nohp,
            'alamat' => $this->alamat,
            'jk' => $this->jk,
            'image' => $image,

        ];
    }
}
