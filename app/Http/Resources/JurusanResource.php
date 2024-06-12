<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="Jurusan",
 *     type="object",
 *     @OA\Property(property="id_jurusan", type="integer", example=1),
 *     @OA\Property(property="jurusan_nama", type="string", example="Teknik Informatika"),
 *     @OA\Property(property="jurusan_short", type="string", example="TI"),
 *     @OA\Property(property="jurusan_thumbnail", type="string", example="http://example.com/images/thumbnail.jpg"),
 *     @OA\Property(
 *         property="prodi",
 *         type="object",
 *         nullable=true,
 *         @OA\Property(property="id", type="integer", example=1),
 *         @OA\Property(property="nama_prodi", type="string", example="Teknik Informatika"),
 *         @OA\Property(property="prodi_short", type="string", example="TI"),
 *     ),
 *     @OA\Property(property="jurusan_text", type="string", example="Deskripsi jurusan Teknik Informatika"),
 * )
 */
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
            'prodi' => $this->prodis ? [
                'id' => $this->prodis->id_prodi,
                'nama_prodi' => $this->prodis->prodi_name,
                'prodi_short' => $this->prodis->prodi_short,
            ] : null,
            'jurusan_text' => $this->jurusan_text,
        ];
    }
}
