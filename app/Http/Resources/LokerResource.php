<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\File;

/**
 * @OA\Schema(
 *     schema="Loker",
 *     type="object",
 *
 *     @OA\Property(property="id_loker", type="integer", example=1),
 *     @OA\Property(property="loker_thumbnail", type="string", example="img/loker/image.png"),
 *     @OA\Property(property="loker_type", type="string", example="Kasir/Sales/Marketing"),
 *     
 *     @OA\Property(
 *         property="position",
 *         type="object",
 *         @OA\Property(property="id_position", type="integer", example=1),
 *         @OA\Property(property="position_name", type="string", example="Operator"),
 *         @OA\Property(property="position_type", type="string", example="Full-time"),
 *     ),
 *     
 *     @OA\Property(
 *         property="kemitraan",
 *         type="object",
 *         @OA\Property(property="id_kemitraan", type="integer", example=1),
 *         @OA\Property(property="kemitraan_name", type="string", example="Inafood"),
 *         @OA\Property(property="kemitraan_description", type="string", example="A partnership with Inafood"),
 *         @OA\Property(property="kemitraan_logo", type="string", example="img/kemitraan/logo.png"),
 *         @OA\Property(property="kemitraan_thumbnail", type="string", example="img/kemitraan/thumbnail.png"),
 *     ),
 *     
 *     @OA\Property(property="loker_available", type="string", example="Tersedia"),
 * )
 */
class LokerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $thumbnailPath = 'img/loker/'.$this->loker_thumbnail;
        $loker_thumbnail = File::exists(public_path($thumbnailPath)) ? $thumbnailPath : 'img/no_image.png';

        return [
            'id_loker' => $this->id_loker,
            'loker_thumbnail' => $loker_thumbnail,
            'loker_type' => $this->loker_type,
            'position' => [
                'id_position' => $this->position->id_position,
                'position_name' => $this->position->position_name,
                'position_type' => $this->position->position_type,
            ],
            'kemitraan' => [
                'id_kemitraan' => $this->kemitraan->id_kemitraan,
                'kemitraan_name' => $this->kemitraan->kemitraan_name,
                'kemitraan_description' => $this->kemitraan->kemitraan_description,
                'kemitraan_logo' => $this->kemitraan->kemitraan_logo,
                'kemitraan_thumbnail' => $this->kemitraan->kemitraan_thumbnail,
            ],
            'loker_available' => $this->loker_available,
        ];
    }
}
