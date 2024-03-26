<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_news extends Model
{
    use HasFactory;

    protected $table = 'tb_news';

    protected $fillable = [
        'news_title',
        'news_level',
        'id_category',
        'news_content',
        'news_location',
        'news_image',
        'news_viewer'
    ];

    protected $primaryKey = 'id_news';

    public $timestamps = false;

    const CREATED_AT = "news_timestamp";

    public function category_news()
    {
        return $this->belongsTo(tb_category_news::class, 'id_category', 'id_category');
    }
}
