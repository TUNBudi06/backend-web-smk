<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_event extends Model
{
    use HasFactory;

    protected $table = 'tb_event';

    protected $guarded = ['id_event'];

    // protected $primaryKey = 'id_event';

    public $timestamps = false;
}
