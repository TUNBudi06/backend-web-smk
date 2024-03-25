<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_pengumuman extends Model
{
    use HasFactory;

    protected $table = 'tb_pengumuman';

    protected $guarded = ['id_pengumuman'];

    // protected $primaryKey = 'id_pengumuman';

    public $timestamps = false;
}
