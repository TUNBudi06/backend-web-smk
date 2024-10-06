<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\File;

/**
 * @OA\Schema(
 *     schema="Ekstra",
 *     type="object",
 *
 *     @OA\Property(property="id_extra", type="integer", example=1),
 *     @OA\Property(property="extra_name", type="string", example="Basketball"),
 *     @OA\Property(property="icon_type", type="string", example="Ekstra"),
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
        $image_logo = 'img/extrakurikuler/logo/'.$this->extra_logo;
        $extra_logo = File::exists(public_path($image_logo)) ? $image_logo : 'img/no_image.png';

        $image_cover = 'img/extrakurikuler/cover/'.$this->extra_image;
        $extra_image = File::exists(public_path($image_cover)) ? $image_cover : 'img/no_image.png';

        preg_match_all('/<iframe.*?src=["\'](.*?)["\'].*?>/i', $this->extra_text, $matches);
        $iframeUrls = isset($matches[1]) ? $matches[1] : [];
    
        $cleanText = preg_replace('/<iframe.*?>.*?<\/iframe>/i', '', $this->extra_text);
    
        $cleanText = strip_tags(html_entity_decode(str_replace(["\r", "\n", "\t"], '', $cleanText)));
    
        if (!empty($iframeUrls)) {
            $iframeLinks = implode("\n", array_map(fn($url) => "URL: " . $url, $iframeUrls));
            $cleanText .= "\n" . $iframeLinks;
        }

        return [
            'id_extra' => $this->id_extra,
            'extra_name' => $this->extra_name,
            'icon_type' => 'Ekstra',
            'extra_text' => $cleanText,
            'extra_type' => $this->extra_type,
            'extra_logo' => $extra_logo,
            'extra_image' => $extra_image,
            'instagram' => $this->instagram,
            'telegram' => $this->telegram,
            'extra_hari' => $this->extra_hari,
        ];
    }
}
