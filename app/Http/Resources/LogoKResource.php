<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\File;
use OpenApi\Annotations as OA;

class LogoKResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    /**
     * @OA\Schema(
     *     schema="LogoKResource",
     *     type="object",
     *     @OA\Property(property="id_logo_mitra", type="integer", example=1),
     *     @OA\Property(property="nama_mitra", type="string", example="Inafood/Honda/Mayora"),
     *     @OA\Property(property="logo_mitra", type="string", example="img/mitra/logo.png"),
     *     @OA\Property(property="width", type="integer", example=128),
     *     @OA\Property(property="height", type="integer", example=128),
     * )
     */
    public function toArray(Request $request): array
    {
        $image = 'img/mitra/'.$this->logo_mitra;
        $imageUrl = File::exists(public_path($image)) ? $image : 'img/no_image.png';

        return [
            'id_logo_mitra' => $this->id_logo_mitra,
            'nama_mitra' => $this->nama_mitra,
            'logo_mitra' => $imageUrl,
            'width' => $this->width,
            'height' => $this->height,
        ];
    }
}
