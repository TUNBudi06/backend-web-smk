<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_custom_badge extends Model
{
    use HasFactory;

    protected $table = 'tb_custom_badges';

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
}
