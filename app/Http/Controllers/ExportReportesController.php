<?php

namespace App\Http\Controllers;

use App\Models\Deporte;
use App\Models\Entidad;
use App\Models\Participante;
use App\Traits\ReportesFpdf;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\NoReturn;

class ExportReportesController extends Fpdf
{
    use ReportesFpdf;

    #[NoReturn] public function generarPDF($id_deporte = null): void
    {
        $this->exportReportes($id_deporte);
    }

    #[NoReturn] public function generarEntidadPDF($id_entidad, $id_deporte = null): void
    {
        $this->exportReportes($id_deporte, $id_entidad);
    }

    #[NoReturn] protected function exportReportes($id_deporte = null, $id_entidad = null): void
    {
        $_SESSION['headerTitle'] = 'Listado General de Inscritos';
        $name = 'Reporte General';
        $nameDeporte = '';
        $query = Participante::query();

        if (is_null($id_entidad)) {
            $id_entidad = auth()->user()->id_entidad;
        }

        $query->where('id_entidad', $id_entidad);

        if (!empty($id_deporte)) {
            $query->where('deporteini', $id_deporte);
            $deporte = Deporte::find($id_deporte);
            if ($deporte) {
                $_SESSION['headerTitle']= 'Inscritos por Deporte';
                $name = 'Inscritos por Deporte - ' . $deporte->deporte;
                $nameDeporte = $deporte->deporte;
            }
        }

        $participantes = $query->orderBy('id_entidad')->get();

        if ($participantes->isNotEmpty()) {

            $entidad = Entidad::find($id_entidad);
            $this->setClub($entidad->nombre);
            $_SESSION['footerClub'] = $entidad->nombre;
            $count = $participantes->count();
            if ($count < 10){
                $total = cerosIzquierda($count, 2);
            }else{
                $total = formatoMillares($count, 0);
            }

            $pdf = new ExportReportesController();
            $pdf->SetTitle('viewPDF');
            $pdf->AliasNbPages();
            $pdf->AddPage();

            //Cabecera
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->SetTextColor(46, 57, 242);
            $pdf->Cell(160, 10, $this->getClub(), 0, 0, 'C');
            $pdf->Cell(30, 10, $this->getTotal($total), 0, 1, 'C');
            if (!empty($nameDeporte)){
                $pdf->Cell(0, 10, $this->getDeporte($nameDeporte), 0, 1, 'C');
            }
            $pdf->Ln(3);

            //Titulos de Columnas
            $pdf->SetFillColor(250, 152, 135);
            $pdf->SetFont('Times', 'B', 10);
            $pdf->SetTextColor(0);
            $pdf->Cell(10, 7, verUtf8('#'), 1, 0, 'C', 1);
            $pdf->Cell(25, 7, verUtf8('Cédula'), 1, 0, 'C', 1);
            $pdf->Cell(50, 7, verUtf8('Nombres'), 1, 0, 'C', 1);
            $pdf->Cell(50, 7, verUtf8('Apellidos'), 1, 0, 'C', 1);
            $pdf->Cell(25, 7, verUtf8('Fecha Nac.'), 1, 0, 'C', 1);
            $pdf->Cell(30, 7, verUtf8('Cargo'), 1, 1, 'C', 1);

            //filas
            $pdf->SetFont('Times', '', 10);
            $pdf->SetTextColor(0);
            $i = 0;
            foreach ($participantes as $participante) {
                $pdf->Cell(10, 7, ++$i, 1, 0, 'C');
                $pdf->Cell(25, 7, $this->getCedula($participante), 1, 0, 'C');
                $pdf->Cell(50, 7, $this->getNombres($participante), 1);
                $pdf->Cell(50, 7, $this->getApellidos($participante), 1);
                $pdf->Cell(25, 7, $this->getFechaNac($participante), 1, 0, 'C');
                $pdf->Cell(30, 7, $this->getCargo($participante), 1, 1, 'C');
            }
            $pdf->Output('I', $name.'.pdf');

        }
        exit;
    }

}
