<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EkstraResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id_extra' => $this->id_extra,
            'extra_name' => $this->extra_name,
            'extra_text' => $this->extra_text,
            'extra_type' => $this->extra_type,
            'extra_logo' => $this->extra_logo,
            'extra_image' => $this->extra_image,
            'instagram' => $this->instagram,
            'telegram' => $this->telegram,
            'extra_hari' => $this->extra_hari,
        ];
    }
}
