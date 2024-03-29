<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_pemberitahuan extends Model
{
    protected $table = 'tb_pemberitahuan';

    protected $primaryKey = 'id_pemberitahuan';

    public $timestamps = true;

    protected $fillable = [
        'pemberitahuan_nama',
        'pemberitahuan_target',
        'pemberitahuan_date',
        'pemberitahuan_time',
        'pemberitahuan_text',
    ];
}
