<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\File;

/**
 * @OA\Schema(
 *     schema="FasilitasResource",
 *     type="object",
 *
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
 *         example="img/fasilitas/lab_komputer.png"
 *     ),
 *     @OA\Property(
 *         property="icon_type",
 *         type="string",
 *         example="Fasilitas"
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
        $thumbnailPath = 'img/fasilitas/'.$this->facility_image;
        $facility_image = File::exists(public_path($thumbnailPath)) ? $thumbnailPath : 'img/no_image.png';

        $cleanText = str_replace(["\r", "\n", "\t"], '', $this->extra_text);

        return [
            'id_facility' => $this->id_facility,
            'facility_name' => $this->facility_name,
            'facility_image' => $facility_image,
            'icon_type' => 'Facilities',
            'prodi' => $this->prodis ? [
                'id' => $this->prodis->id_prodi,
                'nama_prodi' => $this->prodis->prodi_name,
                'prodi_short' => $this->prodis->prodi_short,
            ] : null,
            'facility_text' => $cleanText,
        ];
    }
}
