<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_extra extends Model
{
    use HasFactory;

    protected $table = 'tb_extra';

    //    protected $guarded = ['id_extra'];

    protected $primaryKey = 'id_extra';

    const CREATED_AT = 'extra_timestamp';

    protected $fillable = [
        'extra_name',

        'extra_text',

        'extra_type',

        'extra_logo',

        'extra_image',

        'instagram',

        'telegram',

        'extra_hari',
    ];

    public $timestamps = false;
}
