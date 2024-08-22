<?php

namespace App\Models\url;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_video extends Model
{
    use HasFactory;

    protected $table = 'tb_videos';

    protected $primaryKey = 'id_video';

    protected $fillable = [
        'video_url',
        'video_title',
    ];
}
