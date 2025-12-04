<?php

namespace App\Exports;

use App\Models\DeporteOficial;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class IntencionParticipacionExport implements FromView
{
    /**
     * @return View
     */
    public function view(): View
    {
        return \view('export.intencion-participacion');
    }
}
