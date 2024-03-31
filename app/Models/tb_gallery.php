<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tb_gallery extends Model
{


    protected $table = 'tb_gallery';

    protected $fillable = [
        'gallery_title',
        'id_category',
        'gallery_text',
        'gallery_location',
        'gallery_file',
        'file_type',
    ];

    protected $primaryKey = 'id_gallery';

    public $timestamps = false;

    const CREATED_AT = "gallery_timestamp";

    public function category_gallery()
    {
        return $this->belongsTo(tb_category_gallery::class, 'id_category', 'id_category');
    }
}
