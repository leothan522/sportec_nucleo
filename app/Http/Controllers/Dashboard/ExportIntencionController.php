<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Deporte;
use App\Models\Entidad;
use App\Models\ParticipacionClub;
use App\Models\Participante;
use App\Traits\ReportesFpdf;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ExportIntencionController extends Fpdf
{
    use ReportesFpdf;

    public function exportIntencionParticipacion($id_entidad = null): mixed
    {
        $_SESSION['headerTitle'] = verUtf8('Intención de Participación');
        $name = 'Reporte General';
        $nameDeporte = '';
        $query = ParticipacionClub::query();

        if (is_null($id_entidad)) {
            $id_entidad = auth()->user()->id_entidad;
        }

        $query->where('id_entidad', $id_entidad)
            ->where('intencion', 1);

        $participantes = $query->orderBy('id_deporte')->get();

        if ($participantes->isNotEmpty()) {

            $entidad = Entidad::find($id_entidad);
            $this->setClub($entidad->nombre);
            $_SESSION['footerClub'] = $entidad->nombre;
            $count = $participantes->count();
            if ($count < 10) {
                $total = cerosIzquierda($count, 2);
            } else {
                $total = formatoMillares($count, 0);
            }

            $pdf = new ExportIntencionController();
            $pdf->SetTitle('viewPDF');
            $pdf->AliasNbPages();
            $pdf->AddPage();

            //Cabecera
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->SetTextColor(46, 57, 242);
            $pdf->Cell(160, 10, $this->getClub(), 0, 0, 'C');
            $pdf->Cell(30, 10, $this->getTotal($total), 0, 1, 'C');
            $pdf->Ln(3);

            //Titulos de Columnas
            $pdf->SetFillColor(250, 152, 135);
            $pdf->SetFont('Times', 'B', 10);
            $pdf->SetTextColor(0);
            $pdf->Cell(10, 7, verUtf8('#'), 1, 0, 'C', 1);
            $pdf->Cell(60, 7, verUtf8('Deporte'), 1, 0, 'C', 1);
            $pdf->Cell(0, 7, verUtf8('Modalidad'), 1, 1, 'C', 1);

            //filas
            $pdf->SetFont('Times', '', 9);
            $pdf->SetTextColor(0);
            $i = 0;
            foreach ($participantes as $participante) {
                $pdf->Cell(10, 7, ++$i, 1, 0, 'C');
                $pdf->Cell(60, 7, Str::upper($participante->deporte->deporte), 1, 0, 'C');
                $pdf->Cell(0, 7, Str::upper($participante->modalidad->modalidad), 1, 1, 'C');
            }
            $pdf->Output('I', $name . '.pdf');
            return $pdf;
        } else {
            /*sweetAlert2([
                'icon' => 'info',
                'text' => 'Reporte Vacio',
                'timer' => null,
                'showCloseButton' => true
            ]);
            return redirect()->route('web.index');*/
            echo "<script type='text/javascript'>
                    alert('Reporte Vacio.');
                    window.close();</script>";
            return false;
        }
    }

    protected function exportAllReportes($filtro, $id_deporte = null): mixed
    {
        $_SESSION['headerTitle'] = 'Listado General de Inscritos';
        $name = 'Reporte General';
        $nameDeporte = '';
        $query = Participante::query();

        if ($filtro != 'all') {
            $query->where('asiste', $filtro);
        }

        if (!empty($id_deporte)) {
            $query->where('deporteini', $id_deporte);
            $deporte = Deporte::find($id_deporte);
            if ($deporte) {
                $_SESSION['headerTitle'] = 'Inscritos por Deporte';
                $name = 'Inscritos por Deporte - ' . $deporte->deporte;
                $nameDeporte = $deporte->deporte;
            }
        }

        $participantes = $query->orderBy('id_entidad')->get();

        if ($participantes->isNotEmpty()) {

            $this->setClub('REPORTE COMPLETO DE CLUBES');
            $_SESSION['footerClub'] = 'REPORTE COMPLETO DE CLUBES';
            $count = $participantes->count();
            if ($count < 10) {
                $total = cerosIzquierda($count, 2);
            } else {
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
            if (!empty($nameDeporte)) {
                $w = $filtro != 'all' ? 130 : 190;
                $pdf->Cell($w, 10, $this->getDeporte($nameDeporte), 0, 0, 'C');
            }
            if ($filtro != 'all') {
                $w = !empty($nameDeporte) ? 50 : 190;
                $texto = $filtro ? 'ASISTE' : 'NO ASISTE';
                $pdf->Cell($w, 10, 'FILTRO: ' . $texto, 0, 0, 'C');
            }
            if (!empty($nameDeporte) || $filtro != 'all') {
                $pdf->Cell(0, 10, '', 0, 1);
            }
            $pdf->Ln(3);

            //Titulos de Columnas
            $pdf->SetFillColor(250, 152, 135);
            $pdf->SetFont('Times', 'B', 10);
            $pdf->SetTextColor(0);
            $pdf->Cell(10, 7, verUtf8('#'), 1, 0, 'C', 1);
            $pdf->Cell(19, 7, verUtf8('Cédula'), 1, 0, 'C', 1);
            $pdf->Cell(25, 7, verUtf8('Nombres'), 1, 0, 'C', 1);
            $pdf->Cell(25, 7, verUtf8('Apellidos'), 1, 0, 'C', 1);
            $pdf->Cell(19, 7, verUtf8('Fecha Nac.'), 1, 0, 'C', 1);
            $pdf->Cell(25, 7, verUtf8('Cargo'), 1, 0, 'C', 1);
            $pdf->Cell(12, 7, verUtf8('Asiste'), 1, 0, 'C', 1);
            $pdf->Cell(25, 7, verUtf8('Tipo Socio'), 1, 0, 'C', 1);
            $pdf->Cell(30, 7, verUtf8('Club'), 1, 1, 'C', 1);

            //filas
            $pdf->SetFont('Times', '', 9);
            $pdf->SetTextColor(0);
            $i = 0;
            foreach ($participantes as $participante) {
                $pdf->Cell(10, 7, ++$i, 1, 0, 'C');
                $pdf->Cell(19, 7, $this->getCedula($participante), 1, 0, 'C');
                $pdf->Cell(25, 7, $this->getPrimerNombre($participante, 10), 1);
                $pdf->Cell(25, 7, $this->getPrimerApellido($participante, 10), 1);
                $pdf->Cell(19, 7, $this->getFechaNac($participante), 1, 0, 'C');
                $pdf->Cell(25, 7, $this->getCargo($participante), 1, 0, 'C');
                $pdf->Cell(12, 7, $this->getAsiste($participante), 1, 0, 'C');
                $pdf->Cell(25, 7, $this->getTipoSocio($participante), 1, 0, 'C');
                $pdf->Cell(30, 7, $this->getNombreClub($participante, 14), 1, 1, 'C');
            }
            $pdf->Output('I', $name . '.pdf');
            return $pdf;
        } else {
            /*sweetAlert2([
                'icon' => 'info',
                'text' => 'Reporte Vacio',
                'timer' => null,
                'showCloseButton' => true
            ]);
            return redirect()->route('web.index');*/
            echo "<script type='text/javascript'>
                    alert('Reporte Vacio.');
                    window.close();</script>";
            return false;
        }
    }
}
