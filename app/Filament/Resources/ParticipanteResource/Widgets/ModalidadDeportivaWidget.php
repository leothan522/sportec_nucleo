<?php

namespace App\Filament\Resources\ParticipanteResource\Widgets;

use App\Models\Atleta;
use App\Models\ModalidadDeportiva;
use Filament\Actions\Action;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Model;

class ModalidadDeportivaWidget extends BaseWidget
{
    public ?Model $record = null;
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(function () {
                $sexo = $this->record->sexo;
                $fecha_nacimiento = $this->record->fecha_nacimiento;
                $query = ModalidadDeportiva::query();
                if ($sexo) {
                    $query->where('femenino', 1);
                } else {
                    $query->where('masculino', 1);
                }

                if ($fecha_nacimiento) {
                    $query->where('rango_minimo', '>=', $fecha_nacimiento)
                        ->where('rango_maximo', '<=', $fecha_nacimiento);
                }

                return $query->whereRelation('deporte', 'en_uso', 1)
                    ->where('puntuable', 1)
                    ->where('en_practica', 1);
            })
            ->heading('Deportes y Modalidades')
            ->columns([
                Tables\Columns\TextColumn::make('deporte.deporte'),
                Tables\Columns\TextColumn::make('modalidad'),
            ])
            ->actions([
                Tables\Actions\Action::make('seleccionar')
                    ->icon('heroicon-m-check-circle')
                    ->icon(function (ModalidadDeportiva $modalidadDeportiva) {
                        $id_participante = $this->record->id;
                        $id_deporte = $modalidadDeportiva->id_deporte;
                        $id_modalidad = $modalidadDeportiva->id;
                        $atleta = Atleta::where('id_participante', $id_participante)
                            ->where('id_deporte', $id_deporte)
                            ->where('id_modalidad', $id_modalidad)
                            ->first();
                        if ($atleta) {
                            return 'heroicon-m-check-circle';
                        } else {
                            return 'heroicon-o-stop';
                        }
                    })
                    ->iconButton()
                    ->action(function (ModalidadDeportiva $modalidadDeportiva) {
                        $id_participante = $this->record->id;
                        $cedula = $this->record->cedula;
                        $id_deporte = $modalidadDeportiva->id_deporte;
                        $id_modalidad = $modalidadDeportiva->id;
                        $atleta = Atleta::where('id_participante', $id_participante)
                            ->where('id_deporte', $id_deporte)
                            ->where('id_modalidad', $id_modalidad)
                            ->first();
                        if ($atleta) {
                            $atleta->delete();
                        } else {
                            $atleta = new Atleta();
                            $atleta->id_participante = $id_participante;
                            $atleta->cedula = $cedula;
                            $atleta->id_deporte = $id_deporte;
                            $atleta->id_modalidad = $id_modalidad;
                            $atleta->save();
                        }
                    })
            ], position: Tables\Enums\ActionsPosition::BeforeColumns);
    }
}
