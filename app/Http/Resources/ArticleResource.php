<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\File;

/**
 * @OA\Schema(
 *     schema="ArticleResource",
 *     type="object",
 *
 *     @OA\Property(
 *         property="id_pemberitahuan",
 *         type="integer",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="nama",
 *         type="string",
 *         example="Artikel Penting"
 *     ),
 *     @OA\Property(
 *         property="thumbnail",
 *         type="string",
 *         example="img/artikel/gambar.jpg"
 *     ),
 *     @OA\Property(
 *         property="icon_type",
 *         type="string",
 *         example="Articles"
 *     ),
 *     @OA\Property(
 *         property="target",
 *         type="string",
 *         example="Semua"
 *     ),
 *     @OA\Property(
 *         property="date",
 *         type="string",
 *         example="2023-01-01"
 *     ),
 *     @OA\Property(
 *         property="time",
 *         type="string",
 *         example="12:00"
 *     ),
 *     @OA\Property(
 *         property="text",
 *         type="string",
 *         example="Ini adalah teks artikel."
 *     ),
 *          @OA\Property(
 *          property="level",
 *          type="integer",
 *          example=1
 *      ),
 *      @OA\Property(
 *          property="published_by",
 *          type="object",
 *          @OA\Property(property="name", type="string", example="Humas"),
 *          @OA\Property(property="img", type="string", example="img/no_image.png"),
 *      ),
 *      @OA\Property(
 *          property="jurnal_by",
 *          type="string",
 *          example="Jurnal A"
 *      ),
 *      @OA\Property(
 *          property="viewer",
 *          type="integer",
 *          example=100
 *      ),
 *     @OA\Property(
 *         property="category",
 *         type="object",
 *         @OA\Property(property="id", type="integer", example=1),
 *         @OA\Property(property="nama", type="string", example="Kategori A"),
 *         @OA\Property(property="color", type="string", example="#FF0000"),
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         example="2023-01-01T12:00:00Z"
 *     )
 * )
 */
class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $thumbnailPath = 'img/artikel/'.$this->thumbnail;
        $thumbnail = File::exists(public_path($thumbnailPath)) ? $thumbnailPath : 'img/no_image.png';

        preg_match_all('/<iframe.*?src=["\'](.*?)["\'].*?>/i', $this->text, $matches);
        $iframeUrls = isset($matches[1]) ? $matches[1] : [];
        $cleanText = preg_replace('/<iframe.*?>.*?<\/iframe>/i', '', $this->text);
        $cleanText = str_replace(["\r", "\n", "\t"], '', $cleanText);

        return [
            'id_pemberitahuan' => $this->id_pemberitahuan,
            'nama' => $this->nama,
            'thumbnail' => $thumbnail,
            'icon_type' => 'Articles',
            'date' => $this->date,
            'text' => $cleanText,
            'iframe'=> $iframeUrls ?? null,
            'level' => $this->level,
            'published_by' => $this->published_by ? [
                'name' => $this->publishedUser->name,
                'img' => $this->publishedUser->image ? $this->publishedUser->image : 'img/no_image.png',
            ] : [
                'name' => 'Humas',
                'img' => 'img/no_image.png',
            ],
            'jurnal_by' => $this->jurnal_by ?? '-',
            'category' => $this->kategori ? [
                'id' => $this->kategori->id_pemberitahuan_category,
                'nama' => $this->kategori->pemberitahuan_category_name,
                'color' => $this->kategori->pemberitahuan_category_color,
            ] : null,
            'viewer' => $this->viewer,
            'created_at' => $this->created_at,
        ];
    }
}
