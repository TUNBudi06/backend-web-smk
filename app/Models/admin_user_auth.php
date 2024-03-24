<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class admin_user_auth extends Authenticatable
{
    protected $table = "tb_admin";
    public $timestamps = false;
    protected $hidden = ["password"];
}
