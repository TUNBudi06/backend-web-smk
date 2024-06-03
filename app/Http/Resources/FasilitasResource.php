<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="FasilitasResource",
 *     type="object",
 *     @OA\Property(
 *         property="id_facility",
 *         type="integer",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="facility_name",
 *         type="string",
 *         example="Lab Komputer"
 *     ),
 *     @OA\Property(
 *         property="facility_image",
 *         type="string",
 *         example="lab_komputer.png"
 *     ),
 *     @OA\Property(
 *         property="prodi",
 *         type="object",
 *         @OA\Property(property="id", type="integer", example=1),
 *         @OA\Property(property="nama_prodi", type="string", example="Teknik Informatika"),
 *         @OA\Property(property="prodi_short", type="string", example="TI")
 *     ),
 *     @OA\Property(
 *         property="facility_text",
 *         type="string",
 *         example="Laboratorium komputer dengan fasilitas lengkap."
 *     )
 * )
 */
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
            'prodi' => $this->prodis ? [
                'id' => $this->prodis->id_prodi,
                'nama_prodi' => $this->prodis->prodi_name,
                'prodi_short' => $this->prodis->prodi_short,
            ] : null,
            'facility_text' => $this->facility_text,
        ];
    }
}
