<?php

namespace App\Http\Controllers\Dashboard;

use App\Exports\ResumenExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Exception;

class ExportsExcelController extends Controller
{
    /**
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function intencionParticipacion()
    {
        return Excel::download(new ResumenExport(), 'RESUMEN_INTENCION_PARTICIPACION.xlsx');
    }
}
