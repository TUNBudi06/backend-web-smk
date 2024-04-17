<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JurusanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id_jurusan' => $this->id_jurusan,
            'jurusan_nama' => $this->jurusan_nama,
            'jurusan_short' => $this->jurusan_short,
            'jurusan_thumbnail' => $this->jurusan_thumbnail,
            'id_prodi' => $this->prodis->prodi_name,
            'jurusan_text' => $this->jurusan_text,
        ];
    }
}
