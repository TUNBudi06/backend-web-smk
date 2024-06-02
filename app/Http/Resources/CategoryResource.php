<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="CategoryResource",
 *     type="object",
 *     title="Category Resource",
 *     properties={
 *         @OA\Property(property="id_pemberitahuan_category", type="integer"),
 *         @OA\Property(property="nama", type="string"),
 *         @OA\Property(property="tipe", type="object",
 *             @OA\Property(property="id", type="integer"),
 *             @OA\Property(property="nama", type="string")
 *         )
 *     }
 * )
 */
class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id_pemberitahuan_category' => $this->id_pemberitahuan_category,
            'nama' => $this->pemberitahuan_category_name,
            'tipe' => $this->tipe ? [
                'id' => $this->tipe->id_pemberitahuan_type,
                'nama' => $this->tipe->pemberitahuan_type_name,
            ] : null,
        ];
    }
}
