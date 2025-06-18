<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_sub_navbar extends Model
{
    use HasFactory;

    protected $table = 'tb_sub_navbars';

    protected $primaryKey = 'id';

    protected $fillable = [
        'navbar_id',
        'title',
        'route',
        'description',
        'icon',
        'icon_id',
        'order',
    ];

    public $timestamps = true;

    public function navbar()
    {
        return $this->belongsTo(tb_navbar::class, 'navbar_id');
    }

    public function icon()
    {
        return $this->belongsTo(tb_badge::class, 'icon_id');
    }
}
