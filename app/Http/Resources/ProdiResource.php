<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="Prodi",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="nama_prodi", type="string", example="Teknik Informatika"),
 *     @OA\Property(property="prodi_short", type="string", example="TI"),
 * )
 */
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
