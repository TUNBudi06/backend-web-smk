<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="Ekstra",
 *     type="object",
 *     @OA\Property(property="id_extra", type="integer", example=1),
 *     @OA\Property(property="extra_name", type="string", example="Basketball"),
 *     @OA\Property(property="extra_text", type="string", example="Basketball club for all grades."),
 *     @OA\Property(property="extra_type", type="string", example="Sport"),
 *     @OA\Property(property="extra_logo", type="string", example="logo.png"),
 *     @OA\Property(property="extra_image", type="string", example="image.png"),
 *     @OA\Property(property="instagram", type="string", example="https://instagram.com/basketball"),
 *     @OA\Property(property="telegram", type="string", example="https://telegram.me/basketball"),
 *     @OA\Property(property="extra_hari", type="string", example="Monday and Thursday"),
 * )
 */
class EkstraResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id_extra' => $this->id_extra,
            'extra_name' => $this->extra_name,
            'extra_text' => $this->extra_text,
            'extra_type' => $this->extra_type,
            'extra_logo' => $this->extra_logo,
            'extra_image' => $this->extra_image,
            'instagram' => $this->instagram,
            'telegram' => $this->telegram,
            'extra_hari' => $this->extra_hari,
        ];
    }
}
