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
                ->label('Estadisticas Inscritos')
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
                    $dataGeneral = null;
                    $reportePorClub = [];

                    if ($entidadId === 'general') {
                        // Caso 1: Consolidado General
                        $dataGeneral = Cargo::select('id', 'cargo')
                            ->whereHas('participantes')
                            ->withCount([
                                'participantes as fem_count' => fn($q) => $q->where('sexo', '0'),
                                'participantes as mas_count' => fn($q) => $q->where('sexo', '1')
                            ])->get();

                        $nombreArchivo = 'estadistica_general_' . now()->format('Y-m-d') . '.xlsx';
                    } else {
                        // Caso 2: Un Club específico seleccionado
                        $club = Entidad::findOrFail($entidadId);

                        $reportePorClub[$club->short_nombre] = Cargo::select('id', 'cargo')
                            ->whereHas('participantes', fn($q) => $q->where('id_entidad', $club->id))
                            ->withCount([
                                'participantes as fem_count' => fn($q) => $q->where('sexo', '0')->where('id_entidad', $club->id),
                                'participantes as mas_count' => fn($q) => $q->where('sexo', '1')->where('id_entidad', $club->id)
                            ])->get();

                        $nombreArchivo = 'estadistica_' . Str::slug($club->short_nombre) . '_' . now()->format('Y-m-d') . '.xlsx';
                    }

                    return Excel::download(
                        new EstadisticaInscritosExport($dataGeneral, $reportePorClub),
                        $nombreArchivo
                    );
                }),
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
