<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_navbar extends Model
{
    use HasFactory;

    protected $table = 'tb_navbars';

    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'route',
        'is_dropdown',
        'order',
    ];

    public $timestamps = true;

        public function subNavbars()
    {
        return $this->hasMany(tb_sub_navbar::class, 'navbar_id');
    }
}
