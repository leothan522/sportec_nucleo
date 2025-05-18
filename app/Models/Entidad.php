<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Entidad extends Model
{
    //
    protected $table = 'estados';
    protected $fillable = [
        'codigoe',
        'nombre',
        'short_nombre',
        'capital',
        'ruta_bandera',
        'ruta_escudo',
        ];
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'id_entidad', 'id');
    }

}
