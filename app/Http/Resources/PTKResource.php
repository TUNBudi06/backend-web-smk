<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="PTKResource",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="nama", type="string", example="Jane Doe"),
 *     @OA\Property(property="nip", type="string", example="123456789"),
 *     @OA\Property(property="nuptk", type="string", example="987654321"),
 *     @OA\Property(property="tempat_lahir", type="string", example="Bandung"),
 *     @OA\Property(property="tanggal_lahir", type="string", format="date", example="1980-05-15"),
 *     @OA\Property(property="jenis_kelamin", type="string", example="Perempuan"),
 *     @OA\Property(property="alamat", type="string", example="Jl. Merdeka No. 10")
 * )
 */
class PTKResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nama' => $this->nama,
            'nip' => $this->nip,
            'nuptk' => $this->nuptk,
            'tempat_lahir' => $this->tempat_lahir,
            'tanggal_lahir' => $this->tanggal_lahir,
            'jenis_kelamin' => $this->jenis_kelamin,
            'alamat' => $this->alamat,
        ];
    }
}
