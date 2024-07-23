<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_loker extends Model
{
    protected $table = 'tb_lokers';

    protected $primaryKey = 'id_loker';

    protected $fillable = [
        'loker_thumbnail',
        'loker_type',
        'position_id',
        'kemitraan_id',
        'loker_available',
    ];

    public $timestamps = true;
}
