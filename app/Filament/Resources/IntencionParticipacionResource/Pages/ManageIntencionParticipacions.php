<?php

namespace App\Filament\Resources\IntencionParticipacionResource\Pages;

use App\Filament\Resources\IntencionParticipacionResource;
use App\Traits\DeportesTrait;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Contracts\Support\Htmlable;

class ManageIntencionParticipacions extends ManageRecords
{
    use DeportesTrait;

    protected static string $resource = IntencionParticipacionResource::class;

    protected function getHeaderActions(): array
    {
        return $this->actionGenerarReporte();
    }

    public function getSubheading(): string|Htmlable|null
    {
        return $this->subHeader();
    }

}
