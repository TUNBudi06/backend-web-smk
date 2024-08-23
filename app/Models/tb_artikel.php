<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_artikel extends Model
{
    use HasFactory;

    protected $table = 'tb_artikel';

    protected $fillable = [
        'artikel_title',
        'artikel_level',
        'id_category',
        'category_name',
        'artikel_text',
        'artikel_image',
        'artikel_viewer',
    ];

    protected $attributes = [
        'artikel_viewer' => 0,
    ];

    protected $primaryKey = 'id_artikel';

    public $timestamps = false;

    const CREATED_AT = 'artikel_timestamp';

    public function category_artikel()
    {
        return $this->belongsTo(tb_category_artikel::class, 'id_category', 'id_category');
    }
}
