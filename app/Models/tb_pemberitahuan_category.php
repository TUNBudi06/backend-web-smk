<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_pemberitahuan_category extends Model
{
    protected $table = "tb_pemberitahuan_category";
    protected $primaryKey = "id_pemberitahuan_category";

    protected $fillable = [
        "pemberitahuan_category_name"
    ];

    public function tb_pemberitahuans()
    {
        return $this->hasMany(tb_pemberitahuan_type::class);
    }
}
