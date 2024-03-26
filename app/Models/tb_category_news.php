<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_category_news extends Model
{
    use HasFactory;

    protected $table = 'tb_category_news';

    protected $fillable = ['category_name'];
    
    protected $primaryKey = 'id_category';

    public $timestamps = false;
}
