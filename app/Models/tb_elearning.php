<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_elearning extends Model
{
    use HasFactory;

    protected $table = 'tb_elearnings';

    protected $primaryKey = 'id';

    protected $fillable = [
        'thumbnail',
        'title',
        'desc',
        'btn_label',
        'btn_icon',
        'btn_url',
        'subtitle',
        'body_desc',
        'body_url',
    ];

    public $timestamps = true;

    public function badges()
    {
        return $this->hasMany(tb_badge::class, 'elearning_id');
    }
}
