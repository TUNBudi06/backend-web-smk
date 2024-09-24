<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="Position",
 *     type="object",
 *
 *     @OA\Property(property="id_position", type="integer", example=1),
 *     @OA\Property(property="position_name", type="string", example="Operator/Engineer/Finance"),
 *     @OA\Property(property="icon_type", type="string", example="Posisi"),
 *     @OA\Property(property="position_type", type="string", example="Fulltime/Parttime/Internship"),
 *     @OA\Property(property="kemitraan_id", type="string", example="Inafood/Honda/Mayora"),
 * )
 */
class PosisiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id_position' => $this->id_position,
            'position_name' => $this->position_name,
            'icon_type' => 'Posisi',
            'position_type' => $this->position_type,
            'kemitraan_id' => $this->kemitraan_id,
        ];
    }
}
