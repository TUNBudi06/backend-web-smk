<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="NewsResource",
 *     type="object",
 *     title="News Resource",
 *     properties={
 *         @OA\Property(property="id_pemberitahuan", type="integer"),
 *         @OA\Property(property="nama", type="string"),
 *         @OA\Property(property="thumbnail", type="string"),
 *         @OA\Property(property="text", type="string"),
 *         @OA\Property(property="level", type="string"),
 *         @OA\Property(property="location", type="string"),
 *         @OA\Property(property="category", type="object",
 *             @OA\Property(property="id", type="integer"),
 *             @OA\Property(property="nama", type="string")
 *         ),
 *         @OA\Property(property="viewer", type="integer"),
 *         @OA\Property(property="created_at", type="string", format="date-time"),
 *     }
 * )
 */
class NewsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id_pemberitahuan' => $this->id_pemberitahuan,
            'nama' => $this->nama,
            'thumbnail' => 'img/berita/' . $this->thumbnail,
            'text' => $this->text,
            'level' => $this->level,
            'location' => $this->location,
            'category' => [
                'id' => $this->kategori->id_pemberitahuan_category,
                'nama' => $this->kategori->pemberitahuan_category_name,
            ],
            'viewer' => $this->viewer,
            'created_at' => $this->created_at,
        ];
    }
}
