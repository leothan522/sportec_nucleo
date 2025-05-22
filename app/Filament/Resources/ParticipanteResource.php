<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ParticipanteResource\Pages;
use App\Filament\Resources\ParticipanteResource\RelationManagers;
use App\Models\Participante;
use App\Models\Socio;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Component;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use function Pest\Laravel\options;

class ParticipanteResource extends Resource
{
    protected static ?string $model = Participante::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\Components\Section::make('Datos Personales')
                    ->schema([
                        Forms\Components\Select::make('id_entidad')
                            ->relationship('entidad', 'nombre')
                            ->required()
                            ->searchable()
                            ->preload()->columnSpanFull(),
                        Forms\Components\TextInput::make('cedula')
                            ->unique(ignoreRecord: true)
                            ->live(onBlur: true)
                            ->required()
                            ->suffixIcon('heroicon-m-magnifying-glass')
                            ->suffixIconColor('warning')
                            ->rules([
                                fn(Get $get, Component $component): Closure => function (string $attribute, $value, Closure $fail) use ($get, $component) {
                                    $id_entidad = $get('id_entidad');
                                    $cedula = $value;
                                    $key = $component->getRecord()?->getKey();
                                    if (env('chequear_listado_socios', false)) {
                                        $exite = Socio::where('id_entidad', $id_entidad)->where('cedula', $cedula)->first();
                                        if (!$exite && !$key) {
                                            //$fail("The {$attribute} is invalid.");
                                            $fail("La cedula no esta en el listado de Socios.");
                                        }
                                    }
                                },
                            ])
                            ->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state, Forms\Contracts\HasForms $livewire, Forms\Components\TextInput $input) {
                                $id_entidad = $get('id_entidad');
                                $cedula = $state;
                                $exite = Socio::where('id_entidad', $id_entidad)->where('cedula', $cedula)->first();
                                if ($exite) {
                                    $set('carnet_socio', $exite->carnet);
                                    $set('id_tipo_socio', $exite->tiposocio);
                                    $set('primer_nombre', $exite->primer_nombre);
                                    $set('segundo_nombre', $exite->segundo_nombre);
                                    $set('primer_apellido', $exite->primer_apellido);
                                    $set('segundo_apellido', $exite->segundo_apellido);
                                    $set('sexo', $exite->sexo);
                                    $set('fecha_nacimiento', $exite->fecha_nacimiento);
                                } else {
                                    $set('carnet_socio', '');
                                    $set('id_tipo_socio', '');
                                    $set('primer_nombre', '');
                                    $set('segundo_nombre', '');
                                    $set('primer_apellido', '');
                                    $set('segundo_apellido', '');
                                    $set('sexo', '');
                                    $set('fecha_nacimiento', '');
                                }
                                $livewire->validateOnly($input->getStatePath());
                            }),
                        Forms\Components\TextInput::make('carnet_socio')
                            ->label('Carnet')
                            ->integer()
                            ->required(),
                        Forms\Components\Select::make('id_tipo_socio')
                            ->relationship('tipoSocio', 'tipo_socio')
                            ->required(),
                        Forms\Components\TextInput::make('primer_nombre')
                            ->required(),
                        Forms\Components\TextInput::make('segundo_nombre'),
                        Forms\Components\TextInput::make('primer_apellido')
                            ->required(),
                        Forms\Components\TextInput::make('segundo_apellido'),
                        Forms\Components\TextInput::make('email')
                            ->email(),
                        Forms\Components\TextInput::make('telefono')
                            ->tel()
                            ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/'),
                        Forms\Components\Select::make('sexo')
                            ->options([
                                0 => mb_strtoupper('Masculino'),
                                1 => mb_strtoupper('Femenino'),
                            ])
                            ->required(),
                        Forms\Components\DatePicker::make('fecha_nacimiento')
                            ->label('Fecha de Nacimiento')
                            ->required(),
                        Forms\Components\Select::make('deporteini')
                            ->label('Deporte')
                            ->relationship('deporteinicial', 'deporte')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\Select::make('id_cargo')
                            ->relationship('cargo', 'cargo')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\FileUpload::make('fotografia')
                            ->label('Foto del Carnet')
                            ->image()
                            ->imageEditor()
                            ->maxSize(3072),
                        Forms\Components\FileUpload::make('image_cedula')
                            ->label('Foto de la Cedula')
                            ->image()
                            ->imageEditor()
                            ->maxSize(3072),

                    ])
                    ->columns(3)
                    ->collapsible(),
                /*Forms\Components\Section::make('Datos Medicos')
                    ->schema([
                        //TextInput::make('primer_nombre')
                    ])
                    ->columns(2)
                    ->collapsible(),*/
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
                    ->formatStateUsing(function ($state, Participante $participante) {
                        return mb_strtoupper($participante->primer_nombre . ' ' . $participante->segundo_nombre);
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('primer_apellido')
                    ->label('Apellidos')
                    ->formatStateUsing(function ($state, Participante $participante) {
                        return mb_strtoupper($participante->primer_apellido . ' ' . $participante->segundo_apellido);
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('sexo')
                    ->label('Sexo')
                    ->formatStateUsing(function ($state, Participante $participante) {
                        if (!$participante->sexo) {
                            return mb_strtoupper('Masculino');
                        } else {
                            return mb_strtoupper('Femenino');
                        }
                    }),
                Tables\Columns\TextColumn::make('deporteinicial.deporte')
                    ->label('Deporte')
                    ->limit(15)
                    ->formatStateUsing(fn(string $state) => mb_strtoupper($state)),
                Tables\Columns\TextColumn::make('cargo.cargo')
                    ->label('Cargo')
                    ->formatStateUsing(fn(string $state) => mb_strtoupper($state))
                    ->limit(15),
                Tables\Columns\TextColumn::make('entidad.short_nombre')
                    ->formatStateUsing(fn(string $state) => mb_strtoupper($state))
                    ->toggleable(isToggledHiddenByDefault: true),
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
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->before(fn($record) => $record->update(['cedula' => '*' . $record->cedula]))
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                ]),
                ExportBulkAction::make()->exports([
                    ExcelExport::make()->withColumns([
                        Column::make('cedula'),
                        Column::make('primer_nombre'),
                        Column::make('segundo_nombre'),
                        Column::make('primer_apellido'),
                        Column::make('segundo_apellido'),
                        Column::make('sexo')
                            ->formatStateUsing(function ($state, Participante $participante) {
                                if (!$participante->sexo) {
                                    return mb_strtoupper('Masculino');
                                } else {
                                    return mb_strtoupper('Femenino');
                                }
                            }),
                        Column::make('deporteinicial.deporte')->heading('Deporte'),
                        Column::make('cargo.cargo')->heading('Cargo'),
                        Column::make('entidad.short_nombre')->heading('Entidad'),
                    ])
                ])
            ])
            ->defaultSort('created_at', 'DESC');
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
            'view' => Pages\ViewParticipante::route('/{record}'),
        ];
    }

}
