<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

class EstadisticaHojaExport implements FromView, ShouldAutoSize, WithTitle
{

    protected $tituloHoja;
    protected $dataGeneral;
    protected $reportePorClub;

    public function __construct($tituloHoja, $dataGeneral = null, $reportePorClub = [])
    {
        $this->tituloHoja     = $tituloHoja;
        $this->dataGeneral    = $dataGeneral;
        $this->reportePorClub = $reportePorClub;
    }

    public function title(): string
    {
        // Limitamos a 31 caracteres porque es el máximo permitido por Excel para nombres de pestañas
        return substr($this->tituloHoja, 0, 31);
    }

    public function view(): View
    {
        return view('export.estadistica_inscritos', [
            'dataGeneral'    => $this->dataGeneral,
            'reportePorClub' => $this->reportePorClub
        ]);
    }
}
