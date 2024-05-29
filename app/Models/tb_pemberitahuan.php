<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_pemberitahuan extends Model
{
    protected $table = 'tb_pemberitahuan'; // Define the table name

    protected $primaryKey = 'id_pemberitahuan'; // Define the primary key

    protected $fillable = [
        'nama',
        'target',
        'thumbnail',
        'banner',
        'date',
        'time',
        'text',
        'level',
        'location',
        'type',
        'category',
        'viewer',
        'created_by',
        'approved',
        'Approved_by',
    ];

    public $timestamps = true;

    // Define relationships
    public function relationships()
    {
        return [
            'jenis' => $this->belongsTo(tb_pemberitahuan_type::class, 'type', 'id_pemberitahuan_type'),
            'kategori' => $this->belongsTo(tb_pemberitahuan_category::class, 'category', 'id_pemberitahuan_category'),
            'approver' => $this->belongsTo(tb_admin::class, 'Approved_by', 'id_admin'),
        ];
    }

    public function kategori()
    {
        return $this->belongsTo(tb_pemberitahuan_category::class, 'category', 'id_pemberitahuan_category');
    }
}
