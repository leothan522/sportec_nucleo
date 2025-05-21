<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prensa extends Model
{
    //
    protected $table = 'prensa';
    protected $fillable = [
        'cedula',
        'id_medio',
        'certificado',
        'cpn',
        'descrip',
    ];
}
