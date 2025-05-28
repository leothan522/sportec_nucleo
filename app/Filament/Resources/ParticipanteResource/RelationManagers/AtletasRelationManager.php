<?php

namespace App\Filament\Resources\ParticipanteResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AtletasRelationManager extends RelationManager
{
    protected static string $relationship = 'atletas';
    protected static ?string $title = 'Deportes y Modalidades';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('cedula')
                    ->default(function (RelationManager $livewire): string{
                        return $livewire->getOwnerRecord()->cedula;
                    }),
                Forms\Components\Select::make('id_deporte')
                ->label('Deporte')
                ->relationship('deporte', 'deporte')
                    ->default(function (RelationManager $livewire): string{
                        return $livewire->getOwnerRecord()->deporteini;
                    })
                    ->searchable()
                    ->preload()
                    ->required()
                    ->live()
                    ->afterStateUpdated(fn(Set $set) => $set('id_modalidad', '')),
                Forms\Components\Select::make('id_modalidad')
                    ->label('Modalidad')
                    ->relationship(
                        'modalidad',
                        'modalidad',
                        fn(Builder $query, Get $get) => $query->where('id_deporte', $get('id_deporte'))
                    )
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('marca')
                ->label('Marca Personal'),
                Forms\Components\TextInput::make('obs')
                ->label('Observaciones'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('cedula')
            ->columns([
                Tables\Columns\TextColumn::make('deporte.deporte')
                ->searchable(),
                Tables\Columns\TextColumn::make('modalidad.modalidad')
                ->searchable(),
                Tables\Columns\TextColumn::make('marca')
                ->label('Marca Personal')
                ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('obs')
                ->label('Observaciones')
                ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                ->label('Agregar')
                ->modalHeading('Agregar Deporte y Modalidad'),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
