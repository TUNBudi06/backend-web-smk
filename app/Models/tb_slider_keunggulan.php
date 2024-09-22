<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_slider_keunggulan extends Model
{
    use HasFactory;
    protected $table = 'tb_slider_keunggulan';
    protected $primaryKey = 'id_sk';
    protected $fillable = ['title','description'];
}
