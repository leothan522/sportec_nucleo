<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait ReportesFpdf
{
    public string $nombreClub;

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
        $this->SetTextColor(0);
        //Nombre club
        $this->Cell(160, 10, verUtf8(Str::upper(/*'Club: '.*/$_SESSION['footerClub'])));
        $this->SetFont('Arial', 'I', 8);
        // Número de página
        $this->Cell(0, 10, verUtf8('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'R');
    }

    protected function setClub($nombre): void
    {
        $this->nombreClub = $nombre;
    }

    protected function getClub(): string
    {
        return verUtf8(Str::upper(/*'CLUB: '.*/$this->nombreClub));
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
