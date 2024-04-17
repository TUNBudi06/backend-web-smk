<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FasilitasResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id_facility' => $this->id_facility,
            'facility_name' => $this->facility_name,
            'facility_image' => $this->facility_image,
            'id_prodi' => $this->prodis->prodi_name,
            'facility_text' => $this->facility_text,
        ];
    }
}
