<?php

namespace App\Exports;

use App\Models\Cargo;
use App\Models\Entidad;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class EstadisticaInscritosExport implements WithMultipleSheets
{
    protected $entidadId;

    public function __construct($entidadId)
    {
        $this->entidadId = $entidadId;
    }

    public function sheets(): array
    {
        $sheets = [];
        $cargoModel = Cargo::class;
        $entidadModel = Entidad::class;

        // CASO A: El usuario seleccionó generar el libro completo de pestañas ("general")
        if ($this->entidadId === 'general') {

            // 1. Añadimos la primera pestaña: Consolidado General
            $dataGeneral = $cargoModel::select('id', 'cargo')
                ->whereHas('participantes')
                ->withCount([
                    'participantes as fem_count' => fn($q) => $q->where('sexo', '0'),
                    'participantes as mas_count' => fn($q) => $q->where('sexo', '1')
                ])->get();

            $sheets[] = new EstadisticaHojaExport('Consolidado General', $dataGeneral, []);

            // 2. Añadimos dinámicamente una pestaña por cada Club que tenga inscritos
            $clubes = $entidadModel::whereHas('participantes')->get();
            foreach ($clubes as $club) {
                $reporteClub = $cargoModel::select('id', 'cargo')
                    ->whereHas('participantes', fn($q) => $q->where('id_entidad', $club->id))
                    ->withCount([
                        'participantes as fem_count' => fn($q) => $q->where('sexo', '0')->where('id_entidad', $club->id),
                        'participantes as mas_count' => fn($q) => $q->where('sexo', '1')->where('id_entidad', $club->id)
                    ])->get();

                $sheets[] = new EstadisticaHojaExport($club->short_nombre, null, [$club->short_nombre => $reporteClub]);
            }

        } else {
            // CASO B: El usuario seleccionó un solo Club específico
            $club = $entidadModel::findOrFail($this->entidadId);
            $reporteClub = $cargoModel::select('id', 'cargo')
                ->whereHas('participantes', fn($q) => $q->where('id_entidad', $club->id))
                ->withCount([
                    'participantes as fem_count' => fn($q) => $q->where('sexo', '0')->where('id_entidad', $club->id),
                    'participantes as mas_count' => fn($q) => $q->where('sexo', '1')->where('id_entidad', $club->id)
                ])->get();

            $sheets[] = new EstadisticaHojaExport($club->short_nombre, null, [$club->short_nombre => $reporteClub]);
        }

        return $sheets;
    }
}
