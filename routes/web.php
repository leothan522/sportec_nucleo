<?php

use App\Http\Controllers\Dashboard\ExportIntencionController;
use App\Http\Controllers\Dashboard\ExportParticipanteController;
use App\Http\Controllers\Dashboard\ExportReportesController;
use App\Http\Controllers\Web\WebController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('inicio');
})->name('web.index');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/home', function () {
        return view('home');
    })->name('home');
});

Route::get('export/{id}/participante', [ExportParticipanteController::class, 'generarPDF'])->name('export.participante');
Route::get('export/reportes/{filtro}/{id_deporte?}', [ExportReportesController::class, 'generarPDF'])->name('export.reportes');
Route::get('export/reportes/{filtro}/{id_entidad}/inscritos/{id_deporte?}', [ExportReportesController::class, 'generarEntidadPDF'])->name('export.reportes.entidad');
Route::get('export/all/reportes/inscritos/{filtro}/{id_deporte?}', [ExportReportesController::class, 'generarAllPDF'])->name('export.reportes.all');

Route::get('consultar/{cedula}/participante', [WebController::class, 'consultarParticipante'])->name('consultar.participante');

Route::get('export/intencion/participacion/{id_endidad?}', [ExportIntencionController::class, 'exportIntencionParticipacion'])->name('intencion.participacion');
Route::get('export/intencion/reporte/', [ExportIntencionController::class, 'exportIntencionReporteGeneral'])->name('intencion.reporte');
