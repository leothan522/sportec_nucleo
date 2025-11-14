<?php

namespace App\Livewire;

use App\Models\DeporteOficial;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;
use Livewire\Component;

class IntencionDeporteTableComponent extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public $id_entidad;

    public function mount($id_entidad)
    {
        $this->id_entidad = $id_entidad;
    }

    public function render()
    {
        return view('livewire.intencion-deporte-table-component');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(function () {
                $query = DeporteOficial::query();
                return $query->orderBy('id_deporte');
            })
            ->columns([
                TextColumn::make('deporte_sm')
                    ->label('Deporte')
                    ->default(fn(DeporteOficial $record) => $record->deporte->deporte ?? null)
                    ->description(fn(DeporteOficial $record) => $record->genero)
                    ->hiddenFrom('md'),
                TextColumn::make('deporte.deporte')
                    ->searchable()
                    ->wrap()
                    ->visibleFrom('md'),
                TextColumn::make('categoria')
                    ->description(function (DeporteOficial $record): string {
                        $response = "";

                        if (!$record->edad_libre) {
                            $response = "($record->edad_inicial a $record->edad_final)";
                        }

                        return $response;
                    })
                    ->searchable()
                    ->wrap()
                    ->alignCenter(),
                TextColumn::make('min')
                    ->numeric()
                    ->alignCenter()
                    ->visibleFrom('md'),
                TextColumn::make('max')
                    ->numeric()
                    ->alignCenter()
                    ->visibleFrom('md'),
                TextColumn::make('genero')
                    ->alignCenter()
                    ->visibleFrom('md'),
            ])
            ->filters([
                SelectFilter::make('deporte')
                    ->relationship(
                        'deporte',
                        'deporte',
                        fn(Builder $query) => $query->has('oficiales'),
                    )
            ])
            ->actions([
                Action::make('seleccionar')
                    ->iconButton()
                    ->icon('heroicon-o-stop')
                    ->action(function (DeporteOficial $record): void {
                        if ($this->id_entidad){
                            //programaos
                        }else{
                            Notification::make()
                                ->title('Falta Seleccionar CLUB')
                                ->warning()
                                ->color('warning')
                                ->persistent()
                                ->send();
                        }
                    }),
            ], position: ActionsPosition::BeforeColumns);
    }

    #[On('cambiarValorEntidad')]
    public function setEntidad($id): void
    {
        $this->id_entidad = $id;
        $this->resetTable();
    }

}
