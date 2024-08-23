<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="CategoryGalleryResource",
 *     type="object",
 *     title="Category Gallery Resource",
 *     properties={
 *
 *         @OA\Property(property="id_category", type="integer"),
 *         @OA\Property(property="category_name", type="string"),
 *     }
 * )
 */
class CategoryGalleryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id_category' => $this->id_category,
            'category_name' => $this->category_name,
        ];
    }
}
