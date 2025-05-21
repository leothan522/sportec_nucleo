<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Acceso extends Model
{
    //
    protected $table = 'acceso';
    protected $fillable = [
        'cedula',
        'comedor',
        'ceremonia',
        'anti_doping',
        'villa',
    ];
}
