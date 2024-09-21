<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_perangkatAjar extends Model
{
    use HasFactory;

    public $table = 'tb_perangkat_ajars';

    protected $primaryKey = 'id_pa';

    protected $fillable = [
        'title',
        'description',
        'type',
        'url'
    ];
}
