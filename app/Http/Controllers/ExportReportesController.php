<?php

namespace App\Http\Controllers;

use App\Models\Deporte;
use App\Models\Entidad;
use App\Models\Participante;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\NoReturn;

class ExportReportesController extends Fpdf
{

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
            $pdf->Cell(160, 10, $this->getClub($entidad), 0, 0, 'C');
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
            $pdf->Output('I', $name);

        }
        exit;
    }

    // Cabecera de página
    function Header(): void
    {
        // Logo
        $this->Image(asset('img/cintillo.png'), 10, 0);
        // Arial bold 15
        $this->SetFont('Arial', 'B', 15);
        // Movernos hacia abajo
        $this->SetY(12);
        // Movernos a la derecha
        $this->Cell(30);
        // Name APP
        $this->SetTextColor(255);
        $this->Cell(43, 10, env('APP_NAME', 'Morros Devops'), 0, 0, 'C');
        $this->Cell(12);
        // Título
        $this->SetTextColor(0);
        $this->Cell(0, 10, $_SESSION['headerTitle'], 0, 0, 'C');
        // Salto de línea
        $this->Ln(20);
    }

    // Pie de página
    function Footer(): void
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 7);
        //Nombre club
        $this->Cell(160, 10, verUtf8(Str::upper(/*'Club: '.*/$_SESSION['footerClub'])));
        $this->SetFont('Arial', 'I', 8);
        // Número de página
        $this->Cell(0, 10, verUtf8('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'R');
    }

    protected function getClub($entidad): string
    {
        return verUtf8(Str::upper(/*'CLUB: '.*/$entidad->nombre));
    }

    protected function getTotal($total): string
    {
        return Str::upper('Total: '.$total);
    }

    protected function getDeporte($nameDeporte): string
    {
        return Str::upper('Deporte: '.$nameDeporte);
    }

    protected function getCedula($participante): string
    {
        $cedula = $participante->cedula;
        if (is_numeric($participante->cedula)){
            $cedula = formatoMillares($participante->cedula, 0);
        }
        return Str::limit(Str::padLeft(Str::upper($cedula), 10), 12, preserveWords: true);
    }

    protected function getNombres($participante): string
    {
        return verUtf8(Str::limit(Str::upper($participante->primer_nombre.' '.$participante->segundo_nombre),20));
    }

    protected function getApellidos($participante): string
    {
        return verUtf8(Str::limit(Str::upper($participante->primer_apellido.' '.$participante->segundo_apellido),20));
    }

    protected function getFechaNac($participante): string
    {
        if (!empty($participante->fecha_nacimiento)){
            return getFecha($participante->fecha_nacimiento);
        }
        return '';
    }

    protected function getCargo($participante): string
    {
        return verUtf8(Str::limit(Str::upper($participante->cargo->cargo), 12, preserveWords: true));
    }

}
