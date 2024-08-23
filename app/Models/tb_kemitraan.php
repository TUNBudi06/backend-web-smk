<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_kemitraan extends Model
{
    use HasFactory;

    protected $table = 'tb_kemitraans';

    protected $primaryKey = 'id_kemitraan';

    protected $fillable = [
        'kemitraan_name',
        'kemitraan_logo',
        'kemitraan_thumbnail',
        'kemitraan_description',
        'kemitraan_city',
        'kemitraan_location_detail',
    ];

    public $timestamps = true;

    public function positions()
    {
        return $this->hasMany(tb_position::class, 'kemitraan_id', 'id_kemitraan');
    }

    public function lokers()
    {
        return $this->hasMany(tb_loker::class, 'kemitraan_id', 'id_kemitraan');
    }
}
