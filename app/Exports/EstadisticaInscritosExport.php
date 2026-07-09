<?php

namespace App\Exports;

use App\Models\Participante;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

class EstadisticaInscritosExport implements FromView, ShouldAutoSize, WithTitle
{
    protected $dataGeneral;
    protected $reportePorClub;

    // Colocamos = null por defecto para evitar el error de variable indefinida
    public function __construct($dataGeneral = null, $reportePorClub = [])
    {
        $this->dataGeneral = $dataGeneral;
        $this->reportePorClub = $reportePorClub;
    }

    public function view(): View
    {
        return view('export.estadistica_inscritos', [
            'dataGeneral'    => $this->dataGeneral,
            'reportePorClub' => $this->reportePorClub
        ]);
    }

    public function title(): string
    {
        return "Estadisticas Inscritos";
    }
}
