<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModalidadDeportiva extends Model
{
    //
    protected $table = 'modalidad_deportiva';
    protected $fillable = [
        'id_deporte',
        'codigod',
        'codigo_modalidad',
        'modalidad',
        'masculino',
        'femenino',
        'puntuable',
        'en_practica',
        'rango_minimo',
        'rango_maximo',
        'observaciones',
        'es_equipo',
        'modality',
        'IdModalAccess',
        'IdCategAccess',
        'Orden',
    ];
}
