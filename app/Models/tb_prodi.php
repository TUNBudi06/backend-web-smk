<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_prodi extends Model
{
    use HasFactory;

    protected $table = 'tb_prodi';

    protected $fillable = [
        'prodi_name',
        'prodi_short',
        'prodi_color'
    ];

    protected $primaryKey = 'id_prodi';

    public $timestamps = false;

    public function jurusans()
    {
        return $this->hasMany(tb_jurusan::class);
    }
}
