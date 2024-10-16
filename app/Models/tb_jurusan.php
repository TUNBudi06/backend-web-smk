<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_jurusan extends Model
{
    use HasFactory;

    protected $table = 'tb_jurusan';

    //    protected $guarded = ['id_jurusan'];

    protected $primaryKey = 'id_jurusan';

    const CREATED_AT = 'jurusan_timestamp';

    protected $fillable = [
        'jurusan_nama',

        'jurusan_short',

        'jurusan_thumbnail',

        'jurusan_text',

        'id_prodi',

        'jurusan_logo',
    ];

    public $timestamps = false;

    public function prodis()
    {
        return $this->belongsTo(tb_prodi::class, 'id_prodi', 'id_prodi');
    }
}
