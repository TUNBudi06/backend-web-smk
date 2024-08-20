<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\File;

/**
 * @OA\Schema(
 *     schema="Kemitraan",
 *     type="object",
 *     @OA\Property(property="id_kemitraan", type="integer", example=1),
 *     @OA\Property(property="kemitraan_name", type="string", example="Inafood/Honda/Mayora"),
 *     @OA\Property(property="kemitraan_logo", type="string", example="logo.png"),
 *     @OA\Property(property="kemitraan_thumbnail", type="string", example="image.png"),
 *     @OA\Property(property="kemitraan_description", type="string", example="This industry is..."),
 *     @OA\Property(property="kemitraan_city", type="string", example="Kabupaten/Kota"),
 *     @OA\Property(property="kemitraan_location_detail", type="string", example="Provinsi, Kabupaten/Kota, Kecamatan"),
 * )
 */
class KemitraanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $image_logo = 'img/kemitraan/logo/' . $this->kemitraan_logo;
        $kemitraan_logo = File::exists(public_path($image_logo)) ? $image_logo : 'img/no_image.png';

        $image_cover = 'img/kemitraan/cover/' . $this->kemitraan_thumbnail;
        $kemitraan_thumbnail = File::exists(public_path($image_cover)) ? $image_cover : 'img/no_image.png';

        $cleanText = strip_tags(html_entity_decode(str_replace(["\r", "\n"], '', $this->text)));

        return [
            'id_kemitraan' => $this->id_kemitraan,
            'kemitraan_name' => $this->kemitraan_name,
            'kemitraan_logo' => $kemitraan_logo,
            'kemitraan_thumbnail' => $kemitraan_thumbnail,
            'kemitraan_description' => $cleanText,
            'kemitraan_city' => $this->kemitraan_city,
            'kemitraan_location_detail' => $this->kemitraan_location_detail,
        ];
    }
}
