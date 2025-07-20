<?php

namespace App\Http\Controllers;

use App\Models\Participante;
use App\Traits\ReportesFpdf;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\NoReturn;

class ExportParticipanteController extends Fpdf
{
    use ReportesFpdf;

    public function generarPDF($id): mixed
    {
        $participante = Participante::find($id);
        if (!$participante) {
            return redirect('/dashboard/participantes');
        }

        $name = 'Participante CI ' . $participante->cedula;
        $_SESSION['headerTitle'] = "Ficha del Participante";
        $this->setClub($participante->entidad->nombre);
        $_SESSION['footerClub'] = $this->getClub();

        $pdf = new ExportParticipanteController();
        $pdf->SetTitle('viewPDF');
        $pdf->AliasNbPages();
        $pdf->AddPage();

        //Cabecera
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetTextColor(46, 57, 242);
        $pdf->Cell(0, 10, $this->getClub(), 0, 1, 'C');
        $pdf->Ln(3);

        //Imagen de Perfil
        $x = $pdf->GetX();
        $y = $pdf->GetY();

        for ($i = 1; $i <= 5; $i++) {
            $pdf->Cell(50, 10, '', 0, 1);
        }

        $pdf->SetFillColor(46, 119, 195);
        $pdf->Rect($x, $y, 50, 50, 'F');
        $pdf->Image(verImagen($participante->fotografia), $x + 0.6, $y + 0.5, 49, 49);

        $pdf->SetY($y);
        $pdf->SetX(61);

        //Datos Personales
        $x = $pdf->GetX();
        $y = $pdf->GetY();

        $pdf->SetFillColor(250, 152, 135);
        $pdf->SetFont('Times', 'B', 10);
        $pdf->SetTextColor(0);

        //$pdf->Cell(139, 7, '', 1, 1);
        $pdf->Cell(0, 7, verUtf8(Str::upper('Datos Personales')), 1, 1, 'C', 1);

        $pdf->SetX($x);
        $pdf->Cell(15, 7, verUtf8('Cédula:'));
        $pdf->SetFont('Times', '', 10);
        $pdf->Cell(31, 7, $this->getCedula($participante));
        $pdf->SetFont('Times', 'B', 10);
        $pdf->Cell(15, 7, verUtf8('Carnet:'));
        $pdf->SetFont('Times', '', 10);
        $pdf->Cell(32, 7, '14528635412lkj');
        $pdf->SetFont('Times', 'B', 10);
        $pdf->Cell(18, 7, verUtf8('Tipo Socio:'));
        $pdf->SetFont('Times', '', 10);
        $pdf->Cell(28, 7, 'Socio Activo');
        $pdf->SetX($x);
        $pdf->Cell(0, 7, '', 1, 1);

        $pdf->SetX($x);
        $pdf->SetFont('Times', 'B', 10);
        $pdf->Cell(20, 7, verUtf8('P. Nombre:'));
        $pdf->SetFont('Times', '', 10);
        $pdf->Cell(51, 7, 'YONATHAN LEONARDO');
        $pdf->SetFont('Times', 'B', 10);
        $pdf->Cell(20, 7, verUtf8('S. Nombre:'));
        $pdf->SetFont('Times', '', 10);
        $pdf->Cell(48, 7, 'CASTILLO ROMERO');
        $pdf->SetX($x);
        $pdf->Cell(0, 7, '', 1, 1);

        $pdf->SetX($x);
        $pdf->SetFont('Times', 'B', 10);
        $pdf->Cell(20, 7, verUtf8('P. Apellido:'));
        $pdf->SetFont('Times', '', 10);
        $pdf->Cell(51, 7, 'leothan522@gmail.com');
        $pdf->SetFont('Times', 'B', 10);
        $pdf->Cell(20, 7, verUtf8('S. Apellido:'));
        $pdf->SetFont('Times', '', 10);
        $pdf->Cell(48, 7, '0424-3386600');
        $pdf->SetX($x);
        $pdf->Cell(0, 7, '', 1, 1);

        $pdf->SetX($x);
        $pdf->SetFont('Times', 'B', 10);
        $pdf->Cell(20, 7, verUtf8('Sexo:'));
        $pdf->SetFont('Times', '', 10);
        $pdf->Cell(51, 7, 'Masculino');
        $pdf->SetFont('Times', 'B', 10);
        $pdf->Cell(20, 7, verUtf8('Fecha Nac:'));
        $pdf->SetFont('Times', '', 10);
        $pdf->Cell(48, 7, '21/02/1989');
        $pdf->SetX($x);
        $pdf->Cell(0, 7, '', 1, 1);

        $pdf->SetX($x);
        $pdf->SetFont('Times', 'B', 10);
        $pdf->Cell(20, 7, verUtf8('Email:'));
        $pdf->SetFont('Times', '', 10);
        $pdf->Cell(51, 7, 'leothan522@gmail.com');
        $pdf->SetFont('Times', 'B', 10);
        $pdf->Cell(20, 7, verUtf8('Teléfono:'));
        $pdf->SetFont('Times', '', 10);
        $pdf->Cell(48, 7, '0424-3386600');
        $pdf->SetX($x);
        $pdf->Cell(0, 7, '', 1, 1);

        $pdf->SetX($x);
        $pdf->SetFont('Times', 'B', 10);
        $pdf->Cell(20, 7, verUtf8('Deporte:'));
        $pdf->SetFont('Times', '', 10);
        $pdf->Cell(51, 7, 'Masculino');
        $pdf->SetFont('Times', 'B', 10);
        $pdf->Cell(20, 7, verUtf8('Cargo:'));
        $pdf->SetFont('Times', '', 10);
        $pdf->Cell(48, 7, '21/02/1989');
        $pdf->SetX($x);
        $pdf->Cell(0, 7, '', 1, 1);

        $pdf->Ln(10);

        //Datos medicos
        $x = $pdf->GetX();
        $y = $pdf->GetY();
        $pdf->SetFont('Times', 'B', 10);

        $pdf->Cell(139, 7, verUtf8(Str::upper('Datos Médicos')), 1, 0, 'C', 1);
        $pdf->Cell(51, 7, verUtf8(Str::upper('Foto del Carnet')), 1, 1, 'C', 1);

        $pdf->Cell(39, 7, verUtf8('Grupo Sanguineo y RH:'));
        $pdf->SetFont('Times', '', 10);
        $pdf->Cell(100, 7, $this->getCedula($participante));
        $x2 = $pdf->GetX();
        $y2 = $pdf->GetY();
        $pdf->SetX($x);
        $pdf->Cell(139, 7, '', 1, 1);

        $pdf->SetFont('Times', 'B', 10);
        $pdf->Cell(23, 7, verUtf8('Es alérgico:'));
        $pdf->SetFont('Times', '', 10);
        $pdf->Cell(116, 7, 'SI');
        $pdf->SetX($x);
        $pdf->Cell(139, 7, '', 1, 1);

        $pdf->SetFont('Times', 'B', 10);
        $pdf->Cell(23, 7, verUtf8('Alergias:'));
        $pdf->SetFont('Times', '', 10);
        $pdf->Cell(116, 7, 'CASTILLO ROMERO');
        $pdf->SetX($x);
        $pdf->Cell(139, 7, '', 1, 1);

        $pdf->SetFont('Times', 'B', 10);
        $pdf->Cell(23, 7, verUtf8('Ant. Médicos:'));
        $pdf->SetFont('Times', '', 10);
        $pdf->Cell(116, 7, 'SI');
        $pdf->SetX($x);
        $pdf->Cell(139, 7, '', 1, 1);

        $pdf->SetFont('Times', 'B', 10);
        $pdf->Cell(23, 7, verUtf8('Antecedentes:'));
        $pdf->SetFont('Times', '', 10);
        $pdf->Cell(116, 7, 'CASTILLO ROMERO');
        $pdf->SetX($x);
        $pdf->Cell(139, 7, '', 1, 1);

        $pdf->SetFont('Times', 'B', 10);
        $pdf->Cell(51, 7, verUtf8('En caso de emergencia avisar a:'));
        $pdf->SetFont('Times', '', 10);
        $pdf->Cell(88, 7, 'lheothan522@gmail.com');
        $pdf->SetX($x);
        $pdf->Cell(139, 7, '', 1, 1);

        $pdf->SetFont('Times', 'B', 10);
        $pdf->Cell(20, 7, verUtf8('Teléfono:'));
        $pdf->SetFont('Times', '', 10);
        $pdf->Cell(48, 7, '0424-3386600');
        $pdf->SetX($x);
        $pdf->Cell(139, 7, '', 1, 1);

        //Foto del Carnet
        $pdf->Rect($x2, $y2, 51, 49);
        $pdf->Image(verImagen($participante->image_cedula), $x2 + 1, $y2 + 0.5, 49, 48);

        $pdf->Ln(10);

        //Deportes y Modalidades
        $pdf->SetFont('Times', 'B', 10);

        $pdf->Cell(95, 7, verUtf8(Str::upper('Deportes y Modalidades')), 1, 1, 'C', 1);

        $pdf->Cell(95, 7, verUtf8('P. Nombre:'), 0, 0, 'C');
        $pdf->SetX($x);
        $pdf->Cell(95, 7, '', 1, 1);



        $pdf->Output('I', $name . '.pdf');

        return $pdf;
    }

}
