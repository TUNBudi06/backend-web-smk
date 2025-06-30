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

    public function elearnings()
    {
        return $this->belongsToMany(tb_elearning::class, 'badge_elearning', 'badge_id', 'elearning_id');
    }
}
