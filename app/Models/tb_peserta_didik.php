<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_peserta_didik extends Model
{
    use HasFactory;

    protected $table = 'tb_peserta_didik';

    protected $primaryKey = 'id';

    const CREATED_AT = 'peserta_didik_timestamp';

    protected $fillable = [
        'nisn',

        'nis',

        'nama',

        'kelas',

        'tempat_lahir',

        'tanggal_lahir',

        'agama',

        'gender',

        'telp',

        'alamat',

    ];

    public $timestamps = false;
}
