<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Participante extends Model
{
    //
    use SoftDeletes;
    protected $table = 'participantes';
    protected $fillable = [
        'cedula',
        'id_entidad',
        'id_entidad_responsable',
        'id_cargo',
        'status_acreditacion',
        'primer_apellido',
        'segundo_apellido',
        'primer_nombre',
        'segundo_nombre',
        'sexo',
        'fecha_nacimiento',
        'fecha_activacion',
        'direccion',
        'cod_postal',
        'telefono',
        'celular',
        'usa_transporte',
        'cod_transporte',
        'PIN',
        'fotografia',
        'asiste',
        'email',
        'facultad',
        'ano_ingreso',
        'carrera',
        'semestre',
        'deporteini',
        'fechaemipas',
        'fechavenpas',
        'lugaremipas',
        'uniforme',
        'calzado',
        'peso',
        'talla',
        'edad',
        'image_cedula',
        'carnet_socio',
        'id_tipo_socio',
    ];
}
