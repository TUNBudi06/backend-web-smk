<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_position extends Model
{
    use HasFactory;

    protected $table = 'tb_positions';

    protected $primaryKey = 'id_position';

    protected $fillable = [
        'position_name',
        'position_type',
        'kemitraan_id',
    ];

    public $timestamps = true;

    public function kemitraan()
    {
        return $this->belongsTo(tb_kemitraan::class, 'kemitraan_id', 'id_kemitraan');
    }

    // Relasi ke tb_loker
    public function lokers()
    {
        return $this->hasMany(tb_loker::class, 'position_id', 'id_position');
    }
}
