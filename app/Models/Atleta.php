<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Atleta extends Model
{
    //
    protected $table = 'atletas';
    protected $fillable = [
        'id_participante',
        'cedula',
        'id_deporte',
        'id_modalidad',
        'marca',
        'obs',
    ];
}
