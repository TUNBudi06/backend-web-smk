<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tb_pemberitahuan_category extends Model
{
    protected $table = 'tb_pemberitahuan_category';

    protected $primaryKey = 'id_pemberitahuan_category';

    protected $fillable = [
        'pemberitahuan_category_name',
        'pemberitahuan_category_color',
    ];

    public function tb_pemberitahuans()
    {
        return $this->hasMany(tb_pemberitahuan_type::class);
    }

    public function tipe()
    {
        return $this->belongsTo(tb_pemberitahuan_type::class, 'type', 'id_pemberitahuan_type');
    }
}
