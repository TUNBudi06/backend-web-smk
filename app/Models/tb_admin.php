<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authincatable;

class tb_admin extends Authincatable
{
    protected $table = 'tb_admins';

    protected $primaryKey = 'id_admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'image',
        'name',
        'username',
        'email',
        'token',
        'role',
        'email_verified_at',
        'created_by',
        'verified_user',
        'password',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'token',
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
