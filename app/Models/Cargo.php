<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    //
    protected $table = 'cargos';
    protected $fillable = [
        'id_seguridad',
        'cod_cargo',
        'cargo',
        'descrip',
        'nombre_cargo',
        'activo',
        'color',
        'letra',
        'hotel',
        'palco',
        'transporte',
        'num2',
        'num3',
        'num4',
        'num5',
        'num6',
        'comida',
        'acceso1',
        'acceso2',
        'acceso3',
        'acceso4',
        'acceso5',
        'codigo',
        'imagen',
        'internet',
    ];
}
