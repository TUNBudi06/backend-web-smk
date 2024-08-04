<?php

namespace App\Models\url;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_komite extends Model
{
    use HasFactory;

    protected $table = 'tb_komites';

    protected $primaryKey = 'id_komite';

    protected $fillable = [
        'komite_url',
    ];
}
