<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_ptk extends Model
{
    use HasFactory;

    protected $table = 'tb_ptk';

//    protected $guarded = ['id_pengumuman'];

    protected $primaryKey = 'id';

    protected $fillable = [
        'nama',
        'nip',
        'nuptk',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'foto',
    ];

    public $timestamps = false;
}
