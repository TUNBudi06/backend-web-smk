<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_gallery extends Model
{
    use HasFactory;

    protected $table = 'tb_gallery';

    protected $primaryKey = 'id_gallery';

    protected $fillable = [
        'gallery_title',
        'id_category',
        'gallery_text',
        'gallery_location',
        'gallery_file',
        'file_type',
    ];

    public $timestamps = false;

    public function category_gallery()
    {
        return $this->belongsTo(tb_category_gallery::class, 'id_category', 'id_category');
    }
}
