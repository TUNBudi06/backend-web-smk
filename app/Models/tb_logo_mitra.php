<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tb_logo_mitra extends Model
{
    protected $table = 'tb_logo_mitras';

    protected $primaryKey = 'id_logo_mitra';

    protected $fillable = [
        'nama_mitra',
        'logo_mitra',
        'width',
        'height',
    ];

    public $timestamps = true;

    protected $casts = [
        'width' => 'integer',
        'height' => 'integer',
    ];
}
