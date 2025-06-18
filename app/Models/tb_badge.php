<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_badge extends Model
{
    use HasFactory;

    protected $table = 'tb_badges';

    protected $primaryKey = 'id';

    protected $fillable = [
        'elearning_id',
        'label',
        'icon',
    ];

    public $timestamps = true;

    public function elearning()
    {
        return $this->belongsTo(tb_elearning::class, 'elearning_id');
    }

    public function subNavbar()
    {
        return $this->hasMany(tb_sub_navbar::class, 'icon_id');
    }
}
