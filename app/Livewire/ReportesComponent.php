<?php

namespace App\Livewire;

use App\Models\Deporte;
use App\Models\Participante;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class ReportesComponent extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public $titleTable;
    public $descriptionTable = 'Listado General de Inscritos';
    public $reporte;
    public $id_reporte;

    public function mount($reporte, $id = null)
    {
        $this->reporte = $reporte;
        $this->id_reporte = $id;
    }

    public function render()
    {
        $deportes = Deporte::where('en_uso', 1)->get();
        return view('livewire.reportes-component')
            ->with('listarDeportes', $deportes);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Participante::query())
            ->heading($this->titleTable)
            ->description($this->descriptionTable)
            ->columns([
                TextColumn::make('cedula')
                    ->numeric(),
                TextColumn::make('primer_nombre')
                    ->label('Nombres')
                    ->formatStateUsing(function ($state, Participante $participante) {
                        return mb_strtoupper($participante->primer_nombre . ' ' . $participante->segundo_nombre);
                    })
                    ->limit(15),
                TextColumn::make('primer_apellido')
                    ->label('Apellidos')
                    ->formatStateUsing(function ($state, Participante $participante) {
                        return mb_strtoupper($participante->primer_apellido . ' ' . $participante->segundo_apellido);
                    })
                    ->limit(15),
                TextColumn::make('fecha_nacimiento')
                    ->date('d/m/Y')
                    ->alignEnd(),
                TextColumn::make('cargo.cargo')
                    ->label('Cargo')
                    ->formatStateUsing(fn(string $state) => mb_strtoupper($state))
                    ->limit(15),
                TextColumn::make('entidad.short_nombre')
                    ->label('Club')
                    ->formatStateUsing(fn(string $state) => mb_strtoupper($state))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->hidden(auth()->user()->id_nivel != 1 && !auth()->user()->is_root)
            ])
            ->filters([
                // ...
            ])
            ->actions([
                // ...
            ])
            ->bulkActions([
                // ...
            ])
            ->headerActions([
                Action::make('imprimir')
                    ->label('Generar PDF')
                    //->icon('heroicon-s-archive-box-arrow-down')
                    ->url(route('export.reportes', [$this->reporte, $this->id_reporte]))
                    ->openUrlInNewTab(),
            ])
            ->modifyQueryUsing(function (Builder $query) {
                $id_nivel = auth()->user()->id_nivel;
                $id_entidad = auth()->user()->id_entidad;
                $is_root = auth()->user()->is_root;
                if ($id_nivel != 1 && !$is_root) {
                    $query->where('id_entidad', $id_entidad);
                }
                if ($this->reporte == 'deporte') {
                    $query->where('deporteini', $this->id_reporte);
                }
                return $query;
            })
            //->paginated($this->reporte == 'general')
            ->defaultSort('id_entidad');
    }

    public function initTable($title, $id): int
    {
        $query = Participante::query();
        $id_nivel = auth()->user()->id_nivel;
        $id_entidad = auth()->user()->id_entidad;
        $is_root = auth()->user()->is_root;
        if ($id_nivel != 1 && !$is_root) {
            $query->where('id_entidad', $id_entidad);
        }
        $this->id_reporte = $id;
        $this->titleTable = $title;
        $this->descriptionTable = 'Listado de Inscritos';
        $this->resetTable();
        return $query->where('deporteini', $this->id_reporte)->count();
    }

}
