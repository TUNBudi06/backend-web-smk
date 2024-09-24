<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class perangkatAjarResource extends JsonResource
{
    /**
     * @OA\Schema(
     *     schema="PerangkatAjarResource",
     *     type="object",
     *
     *     @OA\Property(property="id_pa", type="integer", description="ID of the Perangkat Ajar"),
     *     @OA\Property(property="title", type="string", description="Title of the Perangkat Ajar"),
     *     @OA\Property(property="description", type="string", description="Description of the Perangkat Ajar"),
     *     @OA\Property(property="type", type="string", description="Type of the Perangkat Ajar"),
     *     @OA\Property(property="url", type="string", format="url", description="URL of the Perangkat Ajar")
     * )
     *
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id_pa' => $this->id_pa,
            'title' => $this->title,
            'icon_type' => 'perangkat ajar',
            'description' => $this->description,
            'type' => $this->type,
            'url' => $this->url,
        ];
    }
}
