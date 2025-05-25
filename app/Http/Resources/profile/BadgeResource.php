<?php

namespace App\Http\Resources\profile;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\File;

/**
 * @OA\Schema(
 *     schema="BadgeResource",
 *     type="object",
 *     required={"id", "label", "icon", "elearning_id"},
 *
 *     @OA\Property(property="id", type="integer", example=2),
 *     @OA\Property(property="label", type="string", example="Jadwal Pelajaran"),
 *     @OA\Property(property="icon", type="string", example="Book"),
 *     @OA\Property(property="elearning_id", type="string", example="1"),
 *     @OA\Property(property="type", type="string", example="1")
 * )
 */

class BadgeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $icon = $this->icon
            ? (File::exists(public_path('img/badge/' . $this->icon))
                ? 'img/badge/' . $this->icon
                : 'img/no_image.png')
            : 'img/no_image.png';

        return [
            'id' => $this->id,
            'label' => $this->label,
            'icon' => $icon,
            'elearning_id' => (string) $this->elearning_id,
        ];
    }
}
