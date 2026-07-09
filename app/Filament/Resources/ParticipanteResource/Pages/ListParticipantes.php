<?php

namespace App\Filament\Resources\ParticipanteResource\Pages;

use App\Exports\EstadisticaInscritosExport;
use App\Filament\Resources\ParticipanteResource;
use App\Models\Cargo;
use App\Models\Entidad;
use Filament\Actions;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Contracts\Support\Htmlable;
use Maatwebsite\Excel\Facades\Excel;
use Str;

class ListParticipantes extends ListRecords
{
    protected static string $resource = ParticipanteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('exportarEstadistica')
                ->label('Estadistica Inscritos')
                ->icon('heroicon-o-document-arrow-down')
                ->color('success')
                ->form([
                    Select::make('entidad_id')
                        ->label('Seleccione el Club')
                        ->options(function () {
                            // Combinamos la opción 'general' con la lista de entidades que tienen inscritos
                            return [
                                    'general' => 'CONSOLIDADO GENERAL'
                                ] + Entidad::whereHas('participantes')
                                    ->pluck('short_nombre', 'id') // Ajusta 'nombre_entidad' si se llama distinto
                                    ->toArray();
                        })
                        ->default('general')
                        ->required(),
                ])
                ->modalWidth(MaxWidth::Small)
                ->action(function (array $data) {
                    $entidadId = $data['entidad_id'];

                    $nombreArchivo = $entidadId === 'general'
                        ? 'reporte_estadistico_general_' . now()->format('Y-m-d') . '.xlsx'
                        : 'reporte_estadistico_club_' . now()->format('Y-m-d') . '.xlsx';

                    return Excel::download(
                        new EstadisticaInscritosExport($entidadId),
                        $nombreArchivo
                    );
                })
                ->visible(fn(): bool => auth()->user()->id_nivel == 1 || auth()->user()->id_nivel == 6 || auth()->user()->is_root),
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
