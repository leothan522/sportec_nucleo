<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deporte extends Model
{
    //
    protected $table = 'deportes';
    protected $fillable = [
        'tipo_deporte',
        'codigod',
        'deporte',
        'en_uso',
        'acronimo',
        'ruta_logo',
        'listo',
        'federacion',
        'presidente',
        'url_federacion',
        'email',
        'direccion',
        'telefono',
        'fax',
        'observaciones',
        'url_ranking',
        'clasificatorio',
        'plan',
        'rango_minimo',
        'rango_maximo',
        'secundario',
        'sport',
    ];
}
