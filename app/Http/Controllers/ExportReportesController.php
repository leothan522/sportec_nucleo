<?php

namespace App\Http\Controllers;

use App\Models\Deporte;
use App\Models\Entidad;
use App\Models\Participante;
use Codedge\Fpdf\Fpdf\Fpdf;
use JetBrains\PhpStorm\NoReturn;

class ExportReportesController extends Fpdf
{
    // Cabecera de página
    function Header()
    {
        // Logo
        $this->Image(asset('img/logo.png'), 10, 8, 33);
        // Arial bold 15
        $this->SetFont('Arial', 'B', 15);
        // Movernos a la derecha
        $this->Cell(80);
        // Título
        $this->Cell(30, 10, 'Title', 1, 0, 'C');
        // Salto de línea
        $this->Ln(20);
    }

    // Pie de página
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Número de página
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . ' / {nb}', 0, 0, 'C');
    }

    #[NoReturn] public function exportReportes($id_deporte = null): void
    {
        $name = 'Reporte General';
        $entidad = '';
        $query = Participante::query();

        $id_nivel = auth()->user()->id_nivel;
        $id_entidad = auth()->user()->id_entidad;
        $is_root = auth()->user()->is_root;

        if ($id_nivel != 1 && !$is_root) {
            $query->where('id_entidad', $id_entidad);
            $entidad = Entidad::find($id_entidad);
        }

        if (!empty($id_deporte)){
            $query->where('deporteini', $id_deporte);
            $deporte = Deporte::find($id_deporte);
            $name = 'Inscritos por Deporte - '.$deporte->deporte;
        }

        $participantes = $participantes = $query->orderBy('id_entidad')->get();

        $pdf = new ExportReportesController();
        $pdf->SetTitle('viewPDF');
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Times','',12);
        $i = 0;
        foreach ($participantes as $participante){
            $pdf->Cell(0,10,verUtf8('Imprimiendo línea número').++$i,0,1);
        }
        $pdf->Output('I', $name);
        exit;
    }
}
