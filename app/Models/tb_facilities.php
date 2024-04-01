<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_facilities extends Model
{
    use HasFactory;

    protected $table = 'tb_facilities';

    //    protected $guarded = ['id_facility'];

    protected $primaryKey = 'id_facility';

    protected $fillable = [
        'facility_name',

        'facility_image',

        'facility_text',

        'id_prodi',
    ];

    public $timestamps = false;

    public function prodis()
    {
        return $this->belongsTo(tb_prodi::class, 'id_prodi', 'id_prodi');
    }
}
