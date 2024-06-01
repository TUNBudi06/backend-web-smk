<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id_pemberitahuan_category' => $this->id_pemberitahuan_category,
            'nama' => $this->pemberitahuan_category_name,
            'tipe' => $this->tipe ? [
                'id' => $this->tipe->id_pemberitahuan_type,
                'nama' => $this->tipe->pemberitahuan_type_name,
            ] : null,
        ];
    }
}
