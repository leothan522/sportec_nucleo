<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class ReporteDeportes extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.reporte-deportes';
    protected static ?string $title = 'Inscritos por Deporte';
    protected static ?string $navigationGroup = "Reportes";
    protected static ?int $navigationSort = 95;
}
