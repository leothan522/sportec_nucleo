<?php

namespace App\Http\Controllers\Dashboard;


use App\Traits\ReportesFpdf;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Http\Request;

class ExportModalidadController extends Fpdf
{
    use ReportesFpdf;

    public function exportDeporte($id_entidad, $filtro, $id_deporte)
    {
        echo "id_entidad: $id_entidad, filtro: $filtro, id_deporte: $id_deporte";
    }

    public function exportModalidad($id_entidad, $filtro, $id_modalidad)
    {
        echo "id_entidad: $id_entidad, filtro: $filtro, id_modalidad: $id_modalidad";
    }

}
