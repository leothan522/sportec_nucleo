<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carnet extends Model
{
    //
    protected $table = 'carnets';
    protected $fillable = [
        'PIN',
        'active',
        'fecha_emision',
        'cedula_asociada',
    ];
}
