<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class IntencionNumericaPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.intencion-numerica-page';
    protected static ?string $title = "Intención Numérica";
    protected static ?int $navigationSort = 2;
}
