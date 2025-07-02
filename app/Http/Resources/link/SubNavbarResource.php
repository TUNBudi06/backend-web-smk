<?php

namespace App\Http\Resources\link;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

/**
 * @OA\Schema(
 *     schema="SubNavbarResource",
 *     type="object",
 *     required={"id", "title", "icon", "route", "navbar_id"},
 *
 *     @OA\Property(property="id", type="integer", example=2),
 *     @OA\Property(property="title", type="string", example="Jadwal Pelajaran"),
 *     @OA\Property(property="icon", type="string", example="Book"),
 *     @OA\Property(property="route", type="string", example="https://www.smkn1purwosari.sch.id/public/"),
 *     @OA\Property(property="description", type="string", example="Schedule of lessons"),
 *     @OA\Property(property="type", type="string", example="1")
 * )
 */
class SubNavbarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $icon = $this->icon
            ? (File::exists(public_path('img/navbar/' . $this->icon))
                ? 'img/navbar/' . $this->icon
                : 'img/no_image.png')
            : 'img/no_image.png';

        $base = [
            'id' => $this->id,
            'title' => $this->title,
            'icon' => $icon,
            'route' => $this->route,
            'description' => $this->description,
            'navbar_id' => (string) $this->navbar_id,
        ];

        if (Str::contains(Str::lower($this->title), 'e-learn')) {
            $base['children'] = \App\Models\tb_elearning::all()->map(function ($e) {
                return [
                    'id' => $e->id,
                    'title' => $e->title,
                    'route' => str()->slug($e->title),
                    'description' => Str::limit($e->desc, 50, '...'),
                    'icon' => File::exists(public_path('img/e-learning/' . $e->thumbnail))
                        ? 'img/e-learning/' . $e->thumbnail
                        : 'img/no_image.png',
                ];
            });
        }

        return $base;
    }
}
