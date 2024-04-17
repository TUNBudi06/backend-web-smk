<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProdiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id_prodi' => $this->id_prodi,
            'prodi_name' => $this->prodi_name,
            'prodi_short' => $this->prodi_short,
        ];
    }
}
