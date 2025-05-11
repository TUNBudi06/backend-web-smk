<?php

namespace App\Http\Resources\link;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
        return [
            'id' => $this->id,
            'title' => $this->title,
            'icon' => $this->icon,
            'route' => $this->route,
            'navbar_id' => (string) $this->navbar_id,
        ];
    }
}
