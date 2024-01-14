<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
class HotelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     *   
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'discreption' => $this->discreption,
            'image' => Storage::disk('public')->url($this->image),//generate a public URL
            'address' => $this->address,
            'rooms' => $this->whenloaded('rooms'),//only if it has been loaded
        ];
    }
}
