<?php

namespace App\Models\url;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_alert extends Model
{
    use HasFactory;

    protected $table = 'tb_alerts';

    protected $primaryKey = 'id_alert';

    protected $fillable = [
        'alert_title',
        'alert_url',
        'alert_background_color',
        'alert_button_color',
        'alert_button_text',
    ];

    public $timestamps = true;
}
