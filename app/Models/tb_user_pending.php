<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tb_user_pending extends Model
{
    protected $table = 'tb_user_pendings';

    protected $primaryKey = 'id_user';

    protected $fillable = [
        'name',
        'username',
        'email',
        'NIP',
        'foto_ktp',
        'email_verified_at',
        'verified_user',
        'approved_by',
        'password',
    ];

    protected $hidden = [
        'password',
    ];
}
