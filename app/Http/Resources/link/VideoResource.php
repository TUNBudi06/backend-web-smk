<?php

namespace App\Http\Resources\link;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="VideoResource",
 *     type="object",
 *
 *     @OA\Property(
 *         property="id_video",
 *         type="integer",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="video_title",
 *         type="string",
 *         example="Opening MPLS"
 *     ),
 *     @OA\Property(
 *         property="icon_type",
 *         type="string",
 *         example="Video"
 *     ),
 *     @OA\Property(
 *     property="video_description",
 *     type="string",
 *     example="Opening MPLS"
 *      ),
 *
 *     @OA\Property(
 *         property="video_url",
 *         type="string",
 *         example="https://..."
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         example="2023-01-01T12:00:00Z"
 *     )
 * )
 */
class VideoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id_video' => $this->id_link,
            'video_title' => $this->title,
            'icon_type' => 'Video',
            'video_url' => $this->url,
            'updated_at' => $this->updated_at,
        ];
    }
}
