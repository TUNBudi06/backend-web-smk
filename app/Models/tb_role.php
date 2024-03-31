<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tb_role extends Model
{
    protected $table = "tb_user_roles";
    protected $primaryKey = "id_role";
    protected $hidden = ["user_access"];

    protected $fillable = [
        "name",
        "user_access"
    ];

    public function user()
    {
        return $this->hasMany(User::class,"role","id_role");
    }
}
