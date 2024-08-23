<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="PDResource",
 *     type="object",
 *
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="nisn", type="string", example="1234567890"),
 *     @OA\Property(property="nis", type="string", example="12345"),
 *     @OA\Property(property="nama", type="string", example="John Doe"),
 *     @OA\Property(property="kelas", type="string", example="10A"),
 *     @OA\Property(property="tempat_lahir", type="string", example="Jakarta"),
 *     @OA\Property(property="tanggal_lahir", type="string", format="date", example="2000-01-01"),
 *     @OA\Property(property="agama", type="string", example="Islam"),
 *     @OA\Property(property="gender", type="string", example="Laki-laki"),
 *     @OA\Property(property="telp", type="string", example="081234567890"),
 *     @OA\Property(property="alamat", type="string", example="Jl. Kebon Jeruk No. 1")
 * )
 */
class PDResource extends JsonResource
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
            'nisn' => $this->nisn,
            'nis' => $this->nis,
            'nama' => $this->nama,
            'kelas' => $this->kelas,
            'tempat_lahir' => $this->tempat_lahir,
            'tanggal_lahir' => $this->tanggal_lahir,
            'agama' => $this->agama,
            'gender' => $this->gender,
            'telp' => $this->telp,
            'alamat' => $this->alamat,
        ];
    }
}
