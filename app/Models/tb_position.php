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
        'position_description',
        'kemitraan_id',
    ];

    public $timestamps = true;
}
