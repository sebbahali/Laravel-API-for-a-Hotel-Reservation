<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class RoomResource extends JsonResource
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
            'adults' => $this->adults,
            'children' => $this->children,

            'images' => $this->images ? $this->files->map( fn($files) => Storage::disk('public')->url($files)) : null ,

            'hotel' => $this->whenloaded('hotel'),
        ];

    }
}
