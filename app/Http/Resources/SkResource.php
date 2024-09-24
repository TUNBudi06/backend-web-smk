<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SkResource extends JsonResource
{
    /**
     * @OA\Schema(
     *     schema="SkResource",
     *     type="object",
     *
     *     @OA\Property(property="id_sk", type="integer", description="ID of the SkResource"),
     *     @OA\Property(property="title", type="string", description="Title of the SkResource"),
     *     @OA\Property(property="icon_type", type="string", description="Slider"),
     *     @OA\Property(property="description", type="string", description="Description of the SkResource")
     * )
     *
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id_sk' => $this->id_sk,
            'title' => $this->title,
            'icon_type' => 'Slider',
            'description' => $this->description,
        ];
    }
}
