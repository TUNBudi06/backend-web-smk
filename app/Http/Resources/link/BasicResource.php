<?php

namespace App\Http\Resources\link;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="BasicResource",
 *     type="object",
 *
 *     @OA\Property(property="id", type="integer", example=1),
 *                      @OA\Property(property="name", type="string", example="Twitter/X"),
 *                      @OA\Property(property="alias", type="string", example="twitter"),
 *                      @OA\Property(property="link", type="string", example="https://twitter.com/yourcompany"),
 *                      @OA\Property(
 *                          property="logo",
 *                          type="string",
 *                          nullable=true,
 *                          example="http://your-domain.com/storage/logos/twitter-logo.png"
 *                      ),
 * )
 */
class BasicResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'alias' => $this->alias_name,
            'link' => $this->url,
        ];

        if ($this->logo) {
            $data['logo'] = asset($this->logo);
        } else {
            $data['logo'] = null;
        }

        return $data;
    }
}
