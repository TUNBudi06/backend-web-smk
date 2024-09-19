<?php

namespace App\Models\link;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_footer extends Model
{
    protected $primaryKey = 'id_footer';

    protected $fillable = [
        'label',
        'url',
        'type',
    ];

    protected $table = 'tb_footers';
}
