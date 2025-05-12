<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BasicInformationModel extends Model
{
    protected $table = 'tb_basic-information';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'logo',
        'url',
        'alias_name',
    ];

    public string $path = 'img/basic/';

    public function logo(): string
    {
        return $this->path.$this->logo;
    }

    public $timestamps = true;
}
