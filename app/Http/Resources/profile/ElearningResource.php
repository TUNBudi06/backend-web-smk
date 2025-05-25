<?php

namespace App\Http\Resources\profile;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\File;

/**
 * @OA\Schema(
 *     schema="ElearningResource",
 *     type="object",
 *     required={"id", "title", "desc", "btn_label", "btn_url", "subtitle", "body_desc", "body_url"},
 *
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="title", type="string", example="Akademik"),
 *     @OA\Property(property="desc", type="string", example="Deskripsi utama e-learning."),
 *     @OA\Property(property="btn_label", type="string", example="Mulai Belajar"),
 *     @OA\Property(property="btn_url", type="string", example="https://www.smkn1purwosari.sch.id/public/mulai"),
 *     @OA\Property(property="subtitle", type="string", example="Subjudul Konten"),
 *     @OA\Property(property="body_desc", type="string", example="Deskripsi konten utama e-learning."),
 *     @OA\Property(property="body_url", type="string", example="https://www.smkn1purwosari.sch.id/public/konten"),
 *
 *     @OA\Property(
 *         property="badge",
 *         type="array",
 *         nullable=true,
 *         @OA\Items(ref="#/components/schemas/BadgeResource")
 *     )
 * )
 */

class ElearningResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $thumbnail = $this->thumbnail
            ? (File::exists(public_path('img/e-learning/' . $this->thumbnail))
                ? 'img/e-learning/' . $this->thumbnail
                : 'img/no_image.png')
            : 'img/no_image.png';
        $btn_icon = $this->btn_icon
            ? (File::exists(public_path('img/badge/' . $this->btn_icon))
                ? 'img/badge/' . $this->btn_icon
                : 'img/no_image.png')
            : 'img/no_image.png';

        $base = [
            'id' => $this->id,
            'title' => $this->title,
            'desc' => $this->desc,
            'btn_label' => $this->btn_label,
            'btn_url' => $this->btn_url,
            'subtitle' => $this->subtitle,
            'body_desc' => $this->body_desc,
            'body_url' => $this->body_url,
        ];

        if ($this->badges->isNotEmpty()) {
            $base['badge'] = BadgeResource::collection($this->badges);
        }

        return $base;
    }
}
