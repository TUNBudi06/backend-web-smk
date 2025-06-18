<?php

namespace App\Http\Resources\link;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\File;

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

        return [
            'id' => $this->id,
            'title' => $this->title,
            'icon' => $icon,
            'route' => $this->route,
            'description' => $this->description,
            'navbar_id' => (string) $this->navbar_id,
        ];
    }
}
