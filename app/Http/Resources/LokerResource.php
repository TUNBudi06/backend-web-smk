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
 *     @OA\Property(property="position_id", type="string", example="Operator/Engineer/Finance"),
 *     @OA\Property(property="kemitraan_id", type="string", example="Inafood/Honda/Mayora"),
 *     @OA\Property(property="loker_available", type="string", example="Tersedia/Tidak Tersedia"),
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
            'position_id' => $this->position_id,
            'kemitraan_id' => $this->kemitraan_id,
            'loker_available' => $this->loker_available,
        ];
    }
}
