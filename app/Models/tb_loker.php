<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tb_loker extends Model
{
    protected $table = 'tb_lokers';

    protected $primaryKey = 'id_loker';

    protected $fillable = [
        'loker_thumbnail',
        'loker_description',
        'position_id',
        'kemitraan_id',
        'loker_available',
        'loker_for',
    ];

    public $timestamps = true;

    public function position()
    {
        return $this->belongsTo(tb_position::class, 'position_id', 'id_position');
    }

    public function kemitraan()
    {
        return $this->belongsTo(tb_kemitraan::class, 'kemitraan_id', 'id_kemitraan');
    }
}
