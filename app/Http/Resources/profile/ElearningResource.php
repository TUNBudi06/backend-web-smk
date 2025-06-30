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
 *     @OA\Property(property="thumbnail", type="string", example="no_image.png"),
 *     @OA\Property(property="desc", type="string", example="Deskripsi utama e-learning."),
 *     @OA\Property(property="btn_label", type="string", example="Mulai Belajar"),
 *     @OA\Property(property="btn_url", type="string", example="https://www.smkn1purwosari.sch.id/public/mulai"),
 *     @OA\Property(property="btn_icon", type="string", example="no_image.png"),
 *     @OA\Property(property="btn_label_2", type="string", example="Mulai Aksi"),
 *     @OA\Property(property="btn_url_2", type="string", example="https://www.smkn1purwosari.sch.id/public/aksi"),
 *     @OA\Property(property="btn_icon_2", type="string", example="no_image.png"),
 *     @OA\Property(property="subtitle", type="string", example="Subjudul Konten"),
 *     @OA\Property(property="body_desc", type="string", example="no_image.png"),
 *     @OA\Property(property="body_thumbnail", type="string", example="Deskripsi konten utama e-learning."),
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
        $body_thumbnail = $this->body_thumbnail
            ? (File::exists(public_path('img/e-learning/' . $this->body_thumbnail))
                ? 'img/e-learning/' . $this->body_thumbnail
                : 'img/no_image.png')
            : 'img/no_image.png';
        $btn_icon = $this->btn_icon
            ? (File::exists(public_path('img/e-learning/' . $this->btn_icon))
                ? 'img/e-learning/' . $this->btn_icon
                : 'img/no_image.png')
            : 'img/no_image.png';
        $btn_icon_2 = $this->btn_icon_2
            ? (File::exists(public_path('img/e-learning/' . $this->btn_icon_2))
                ? 'img/e-learning/' . $this->btn_icon_2
                : 'img/no_image.png')
            : 'img/no_image.png';

        $base = [
            'id' => $this->id,
            'title' => $this->title,
            'thumbnail' => $thumbnail,
            'desc' => $this->desc,
            'btn_label' => $this->btn_label,
            'btn_url' => $this->btn_url,
            'btn_icon' => $btn_icon,
            'btn_label_2' => $this->btn_label_2,
            'btn_url_2' => $this->btn_url_2,
            'btn_icon_2' => $btn_icon_2,
            'subtitle' => $this->subtitle,
            'body_desc' => $this->body_desc,
            'body_thumbnail' => $body_thumbnail,
            'body_url' => $this->body_url,
        ];

        if ($this->badges->isNotEmpty()) {
            $base['badge'] = BadgeResource::collection($this->badges);
        }

        return $base;
    }
}
