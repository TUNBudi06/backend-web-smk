<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_pemberitahuan_type extends Model
{
    protected $table = "tb_pemberitahuan_type";
    protected $primaryKey = "id_pemberitahuan_type";

    protected $fillable = [
        "pemberitahuan_type_name"
    ];
}
