<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PengumumanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id_pengumuman' => $this->id_pengumuman,
            'pengumuman_nama' => $this->pengumuman_nama,
            'pengumuman_target' => $this->pengumuman_target,
            'pengumuman_date' => $this->pengumuman_date,
            'pengumuman_time' => $this->pengumuman_time,
        ];
    }
}
