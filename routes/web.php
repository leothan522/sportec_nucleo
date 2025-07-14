<?php

use App\Http\Controllers\ExportController;
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

Route::get('export/{id}/participante', [ExportController::class, 'exportParticipante'])->name('export.participante');
Route::get('export/{reporte}/reportes/{id?}', [ExportController::class, 'exportReportes'])->name('export.reportes');
