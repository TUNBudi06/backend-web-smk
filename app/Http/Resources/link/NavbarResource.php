<?php

namespace App\Http\Resources\link;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="NavbarResource",
 *     type="object",
 *     required={"id", "title", "order"},
 *
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="title", type="string", example="Akademik"),
 *     @OA\Property(property="order", type="integer", example=1),
 *     @OA\Property(property="route", type="string", example="https://www.smkn1purwosari.sch.id/public/", nullable=true),
 *     @OA\Property(
 *         property="sub_navbar",
 *         type="array",
 *         nullable=true,
 *         @OA\Items(ref="#/components/schemas/SubNavbarResource")
 *     )
 * )
 */

class NavbarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $base = [
            'id' => $this->id,
            'title' => $this->title,
            'order' => $this->order,
        ];

        if ($this->subNavbars->isNotEmpty()) {
            $base['sub_navbar'] = SubNavbarResource::collection($this->subNavbars);
        } else {
            $base['route'] = $this->route;
        }

        return $base;
    }
}
