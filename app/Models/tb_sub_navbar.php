<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_sub_navbar extends Model
{
    use HasFactory;

    protected $table = 'tb_sub_navbars';

    protected $primaryKey = 'id_sub_navbar';

    protected $fillable = [
        'navbar_id',
        'title',
        'route',
        'icon',
        'order',
    ];

    public $timestamps = true;

    public function navbar()
    {
        return $this->belongsTo(tb_navbar::class, 'navbar_id');
    }
}
