<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ParticipanteResource\Pages;
use App\Filament\Resources\ParticipanteResource\RelationManagers;
use App\Models\Deporte;
use App\Models\Participante;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ParticipanteResource extends Resource
{
    protected static ?string $model = Participante::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('cedula')
                    ->numeric()
                    ->searchable(),
                Tables\Columns\TextColumn::make('primer_nombre')
                    ->label('Nombres')
                    ->formatStateUsing(function ($state, Participante $participante){
                        return $participante->primer_nombre.' '.$participante->segundo_nombre;
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('primer_apellido')
                    ->label('Apellidos')
                    ->formatStateUsing(function ($state, Participante $participante){
                        return $participante->primer_apellido.' '.$participante->segundo_apellido;
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('deporteinicial.deporte')
                    ->label('Deporte')
                    ->limit(15),
                Tables\Columns\TextColumn::make('cargo.cargo')
                    ->label('Cargo')
                    ->formatStateUsing(fn(string $state) => mb_strtoupper($state)),
                Tables\Columns\TextColumn::make('entidad.short_nombre'),
            ])
            ->filters([
                //
                Tables\Filters\SelectFilter::make('Deporte')
                    ->relationship('deporteinicial', 'deporte'),
                Tables\Filters\SelectFilter::make('Cargo')
                    ->relationship('cargo', 'cargo'),
                Tables\Filters\SelectFilter::make('Entidad')
                    ->relationship('entidad', 'short_nombre'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make()
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListParticipantes::route('/'),
            'create' => Pages\CreateParticipante::route('/create'),
            'edit' => Pages\EditParticipante::route('/{record}/edit'),
        ];
    }
}
