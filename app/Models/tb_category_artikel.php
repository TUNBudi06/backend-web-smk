<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_category_artikel extends Model
{
    use HasFactory;

    protected $table = 'tb_category_artikel';

    protected $fillable = ['category_name'];

    protected $primaryKey = 'id_category';

    public $timestamps = false;

    public function artikels()
    {
        return $this->hasMany(tb_artikel::class);
    }
}
