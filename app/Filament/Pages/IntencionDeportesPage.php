<?php

namespace App\Filament\Pages;

use App\Traits\DeportesTrait;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class IntencionDeportesPage extends Page
{
    use DeportesTrait;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.intencion-deportes-page';
    protected static ?string $title = 'OLD->Intención de Participación';

    public static function canAccess(): bool
    {
        return false;
        /*$id_nivel = auth()->user()->id_nivel ?? null;
        $is_root = auth()->user()->is_root ?? null;
        return verPage('INTENCION_DEPORTE_VER', 'INTENCION_DEPORTE_HASTA') ||
            (!verPage('INTENCION_VER', 'INTENCION_HASTA') && ($id_nivel == 1 || $is_root));*/
    }

    public function getSubheading(): string|Htmlable|null
    {
        return $this->subHeader();
    }

    protected function getHeaderActions(): array
    {
        return $this->actionGenerarReporte();
    }

}
