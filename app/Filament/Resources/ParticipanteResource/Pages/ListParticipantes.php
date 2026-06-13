<?php

namespace App\Filament\Resources\ParticipanteResource\Pages;

use App\Filament\Resources\ParticipanteResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

class ListParticipantes extends ListRecords
{
    protected static string $resource = ParticipanteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('generar_excel')
                ->label('Generar Reporte')
                ->icon('heroicon-o-document-arrow-down')
                ->color('success')
                ->url(route('excel-exports.participantes'))
                ->openUrlInNewTab()
                ->visible(fn(): bool => auth()->user()->id_nivel == 1 || auth()->user()->id_nivel == 6 || auth()->user()->is_root),
            Actions\CreateAction::make(),
        ];
    }

    public function getSubheading(): string|Htmlable|null
    {
        $response = null;
        $id_nivel = auth()->user()->id_nivel ?? null;
        $is_root = auth()->user()->is_root ?? null;
        if ($id_nivel == 1 || $is_root){
            if (verPage('PARTICIPANTES_VER', 'PARTICIPANTES_HASTA')){
                $response = "Registro Activo";
            }else{
                $response = "Registro Inactivo";
            }
        }

        return $response;
    }
}
