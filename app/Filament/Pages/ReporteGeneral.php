<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class ReporteGeneral extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.reporte-general';
    protected static ?string $navigationGroup = "Reportes";
}
