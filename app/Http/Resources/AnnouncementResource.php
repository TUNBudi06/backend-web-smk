<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="Announcement",
 *     @OA\Property(property="id_pemberitahuan", type="integer", example=1),
 *     @OA\Property(property="nama", type="string", example="Pengumuman Penting"),
 *     @OA\Property(property="target", type="string", example="Semua"),
 *     @OA\Property(property="date", type="string", example="2023-01-01"),
 *     @OA\Property(property="time", type="string", example="12:00"),
 *     @OA\Property(property="text", type="string", example="Ini adalah teks pengumuman."),
 *     @OA\Property(property="category", type="object",
 *         @OA\Property(property="id", type="integer", example=1),
 *         @OA\Property(property="nama", type="string", example="Kategori A")
 *     ),
 *     @OA\Property(property="created_at", type="string", example="2023-01-01T12:00:00Z")
 * )
 */
class AnnouncementResource extends JsonResource
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
            'title' => $this->nama,
            'target' => $this->target,
            'date' => $this->date,
            'time' => $this->time,
            'text' => $this->text,
            'category' => $this->kategori ? [
                'id' => $this->kategori->id_pemberitahuan_category,
                'nama' => $this->kategori->pemberitahuan_category_name,
            ] : null,
            'created_at' => $this->created_at,
        ];
    }
}
