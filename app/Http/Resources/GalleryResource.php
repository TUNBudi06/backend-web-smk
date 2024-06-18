<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\File;

/**
 * @OA\Schema(
 *     schema="Galeri",
 *     type="object",
 *     @OA\Property(property="id_gallery", type="integer", example=1),
 *     @OA\Property(property="gallery_title", type="string", example="Kegiatan MPLS"),
 *     @OA\Property(property="gallery_text", type="string", example="MPLS dilaksanakan pada tanggal..."),
 *     @OA\Property(property="gallery_location", type="string", example="SMKN 1 Purwosari"),
 *     @OA\Property(property="id_category", type="string", example="MPLS/Kelas/dll"),
 *     @OA\Property(property="gallery_file", type="string", example="image.png"),
 *     @OA\Property(property="file_type", type="string", example="jpg/png/dll"),
 * )
 */

class GalleryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $cleanText = strip_tags(html_entity_decode($this->gallery_text));

        return [
            'id_gallery' => $this->id_gallery,
            'gallery_title' => $this->gallery_title,
            'gallery_text' => $cleanText,
            'gallery_location' => $this->gallery_location,
            'id_category' => $this->id_category,
            'gallery_file' => $this->gallery_file,
            'file_type' => $this->file_type,
        ];
    }
}
