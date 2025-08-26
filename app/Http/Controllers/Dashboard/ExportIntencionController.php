<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Deporte;
use App\Models\Entidad;
use App\Models\ModalidadDeportiva;
use App\Models\ParticipacionClub;
use App\Models\Participante;
use App\Traits\ReportesFpdf;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ExportIntencionController extends Fpdf
{
    use ReportesFpdf;

    public function exportIntencionParticipacion($id_entidad = null): mixed
    {
        $_SESSION['headerTitle'] = verUtf8('Intención de Participación');
        $name = 'Intencion_participacion_club';
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
                $pdf->Cell(60, 7, $this->getTextoGenerico($participante->deporte->deporte, 27), 1, 0, 'C');
                $pdf->Cell(0, 7, $this->getTextoGenerico($participante->modalidad->modalidad), 1, 1, 'C');
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

    public function exportIntencionReporteGeneral(): mixed
    {
        $_SESSION['headerTitle'] = verUtf8('Intención de Participación');
        $name = 'Intencion_participacion_reporte_general';
        $nameDeporte = '';
        $query = ModalidadDeportiva::query();

        $query->whereRelation('participacion', 'intencion', 1)
            ->withCount([
                'participacion' => fn(Builder $query) => $query->where('intencion', 1)
            ]);

        $participantes = $query->orderBy('participacion_count', 'DESC')->get();

        if ($participantes->isNotEmpty()) {

            //$entidad = Entidad::find($id_entidad);
            $this->setClub('Reporte General');
            $_SESSION['footerClub'] = 'Reporte General';
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
            $pdf->Cell(0, 10, $this->getClub(), 0, 1, 'C');
            //$pdf->Cell(30, 10, $this->getTotal($total), 0, 1, 'C');
            $pdf->Ln(3);

            //Titulos de Columnas
            $pdf->SetFillColor(250, 152, 135);
            $pdf->SetFont('Times', 'B', 10);
            $pdf->SetTextColor(0);
            $pdf->Cell(10, 7, verUtf8('#'), 1, 0, 'C', 1);
            $pdf->Cell(60, 7, verUtf8('Deporte'), 1, 0, 'C', 1);
            $pdf->Cell(100, 7, verUtf8('Modalidad'), 1, 0, 'C', 1);
            $pdf->Cell(20, 7, verUtf8('Clubes'), 1, 1, 'C', 1);

            //filas
            $pdf->SetFont('Times', '', 9);
            $pdf->SetTextColor(0);
            $i = 0;
            foreach ($participantes as $participante) {
                $pdf->Cell(10, 7, ++$i, 1, 0, 'C');
                $pdf->Cell(60, 7, $this->getTextoGenerico($participante->deporte->deporte, 27), 1, 0, 'C');
                $pdf->Cell(100, 7, $this->getTextoGenerico($participante->modalidad), 1, 0, 'C');
                $pdf->Cell(20, 7, $this->getTextoGenerico($participante->participacion_count), 1, 1, 'C');
            }
            $pdf->Ln(5);

            //Cabecera
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->SetTextColor(46, 57, 242);
            $pdf->Cell(0, 10, 'REPORTE POR DEPORTE Y MODALIDAD', 0, 1, 'C');
            //$pdf->Cell(30, 10, $this->getTotal($total), 0, 1, 'C');
            $pdf->Ln(3);

            foreach ($participantes as $participante) {
                $query = ParticipacionClub::query();
                $clubes = $query->where('id_modalidad', $participante->id)
                    ->where('intencion', 1)
                    ->get();

                //Titulos de Columnas
                $pdf->SetFillColor(250, 152, 135);
                $pdf->SetFont('Times', 'B', 10);
                $pdf->SetTextColor(0);
                $pdf->Cell(10, 7, verUtf8('#'), 1, 0, 'C', 1);
                $pdf->Cell(0, 7, verUtf8('Clubes con Intención Deporte: '.Str::upper($participante->deporte->deporte).' Modalidad: '.Str::upper($participante->modalidad)), 1, 1, 'C', 1);

                //filas
                $pdf->SetFont('Times', '', 9);
                $pdf->SetTextColor(0);
                $i = 0;
                foreach ($clubes as $club){
                    $pdf->Cell(10, 7, ++$i, 1, 0, 'C');
                    $pdf->Cell(0, 7, $this->getTextoGenerico($club->entidad->nombre), 1, 1, 'C');
                }
                $pdf->Ln(5);
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
