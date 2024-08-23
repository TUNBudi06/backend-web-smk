<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_pengumuman extends Model
{
    use HasFactory;

    protected $table = 'tb_pengumuman';

    //    protected $guarded = ['id_pengumuman'];

    protected $primaryKey = 'id_pengumuman';

    const CREATED_AT = 'pengumuman_timestamp';

    protected $fillable = [
        'pengumuman_nama',

        'pengumuman_target',

        'pengumuman_text',

        'pengumuman_date',

        'pengumuman_time',
    ];

    public $timestamps = false;
}
