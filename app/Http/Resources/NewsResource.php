<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\File;

/**
 * @OA\Schema(
 *     schema="NewsResource",
 *     type="object",
 *     title="News Resource",
 *
 *     @OA\Property(property="id_pemberitahuan", type="integer", example=1),
 *     @OA\Property(property="nama", type="string", example="Berita Terbaru"),
 *     @OA\Property(property="thumbnail", type="string", example="img/berita/thumbnail.jpg"),
 *     @OA\Property(property="text", type="string", example="Konten berita..."),
 *     @OA\Property(property="level", type="string", example="1"),
 *     @OA\Property(property="location", type="string", example="Jakarta"),
 *     @OA\Property(property="category", type="object",
 *         @OA\Property(property="id", type="integer", example=1),
 *         @OA\Property(property="nama", type="string", example="Kategori A"),
 *         @OA\Property(property="color", type="string", example="#FF0000"),
 *     ),
 *     @OA\Property(property="viewer", type="integer", example=100),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2023-09-19T12:00:00Z"),
 *     @OA\Property(property="published_by", type="string", example="Admin"),
 *     @OA\Property(property="jurnal_by", type="string", example="Jurnal B")
 * )
 */
class NewsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $thumbnailPath = 'img/berita/'.$this->thumbnail;
        $thumbnail = File::exists(public_path($thumbnailPath)) ? $thumbnailPath : 'img/no_image.png';

        preg_match_all('/<iframe.*?src=["\'](.*?)["\'].*?>/i', $this->text, $matches);
        $iframeUrls = isset($matches[1]) ? $matches[1] : [];
    
        $cleanText = preg_replace('/<iframe.*?>.*?<\/iframe>/i', '', $this->text);
    
        $cleanText = strip_tags(html_entity_decode(str_replace(["\r", "\n", "\t"], '', $cleanText)));
    
        if (!empty($iframeUrls)) {
            $iframeLinks = implode("\n", array_map(fn($url) => "URL: " . $url, $iframeUrls));
            $cleanText .= "\n" . $iframeLinks;
        }

        return [
            'id_pemberitahuan' => $this->id_pemberitahuan,
            'nama' => $this->nama,
            'thumbnail' => $thumbnail,
            'icon_type' => 'News',
            'text' => $cleanText,
            'level' => $this->level,
            'published_by' => $this->published_by,
            'jurnal_by' => $this->jurnal_by,
            'location' => $this->location,
            'category' => [
                'id' => $this->kategori->id_pemberitahuan_category,
                'nama' => $this->kategori->pemberitahuan_category_name,
                'color' => $this->kategori->pemberitahuan_category_color,
            ],
            'viewer' => $this->viewer,
            'created_at' => $this->created_at,
        ];
    }
}
