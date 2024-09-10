<?php

namespace App\Models\url;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_other extends Model
{

    protected $table = 'tb_other';

    protected $primaryKey = 'id_link';

    protected $fillable = [
        'id_link',
        'title',
        'description',
        'is_used',
        'type',
        'url',
    ];
}
