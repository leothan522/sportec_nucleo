<?php

use App\Http\Controllers\ExportController;
use App\Http\Controllers\ExportParticipanteController;
use App\Http\Controllers\ExportReportesController;
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
Route::get('export/reportes/{id_deporte?}', [ExportReportesController::class, 'generarPDF'])->name('export.reportes');
Route::get('export/reportes/{id_entidad}/inscritos/{id_deporte?}', [ExportReportesController::class, 'generarEntidadPDF'])->name('export.reportes.entidad');
