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
 *     @OA\Property(
 *           property="published_by",
 *           type="object",
 *           @OA\Property(property="name", type="string", example="Humas"),
 *           @OA\Property(property="img", type="string", example="img/no_image.png"),
 *       ),
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
        $thumbnail = $this->thumbnail
            ? (File::exists(public_path('img/berita/' . $this->thumbnail))
                ? 'img/berita/' . $this->thumbnail
                : 'img/no_image.png')
            : 'img/no_image.png';

        preg_match_all('/<iframe.*?src=["\'](.*?)["\'].*?>/i', $this->text, $matches);
        $iframeUrls = isset($matches[1]) ? $matches[1] : [];
        $cleanText = preg_replace('/<iframe.*?>.*?<\/iframe>/i', '', $this->text);
        $cleanText = str_replace(["\r", "\n", "\t"], '', $cleanText);

        $image = [$thumbnail];
        $imageList = array_merge($image, $iframeUrls);

        return [
            'id_pemberitahuan' => $this->id_pemberitahuan,
            'nama' => $this->nama,
            'thumbnail' => $imageList,
            'icon_type' => 'News',
            'text' => $cleanText,
            'level' => $this->level,
            'published_by' => $this->published_by ? [
                'name' => $this->publishedUser->name,
                'img' => $this->publishedUser->image ? $this->publishedUser->image : 'img/no_image.png',
            ] : [
                'name' => 'Humas',
                'img' => 'img/no_image.png',
            ],
            'jurnal_by' => $this->jurnal_by ?? '-',
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
