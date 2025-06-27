<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class ReporteModalidad extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.reporte-modalidad';
    protected static ?string $title = 'Inscritos por Deporte y Modalidad';
    protected static ?string $navigationGroup = "Reportes";
    protected static ?int $navigationSort = 96;
}
