<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;


class StoreRoomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'adults' => $this->adults,
            'children' => $this->children,

          'images' =>$this->when($request->hasfile('images'),function () {

                return $this->files->map(fn($files) => Storage::disk('public')->url($files));
                  
                 }) ,

            'hotel' => $this->whenloaded('hotel'),
        ];
    }
}
