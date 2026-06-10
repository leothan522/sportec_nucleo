<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ParticipanteResource\Pages;
use App\Filament\Resources\ParticipanteResource\RelationManagers;
use App\Filament\Resources\ParticipanteResource\Widgets\ModalidadDeportivaWidget;
use App\Models\Nivel;
use App\Models\Participante;
use App\Models\Permiso;
use App\Models\Socio;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Component;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Collection;
use function Pest\Laravel\options;

class ParticipanteResource extends Resource
{
    protected static ?string $model = Participante::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Datos Personales')
                    ->schema([
                        Forms\Components\Select::make('id_entidad')
                            ->label('Club')
                            ->relationship('entidad', 'nombre')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->columnSpanFull()
                            // 1. Definimos el valor por defecto usando la sesión o el club del usuario común
                            ->default(function () {
                                $user = auth()->user();

                                // Si no es admin/root, su club por defecto es el suyo propio
                                if ($user->id_nivel != 1 && !$user->is_root) {
                                    return $user->id_entidad;
                                }

                                // Si es admin, intentamos recuperar el último club guardado en la sesión
                                return session('last_selected_id_entidad');
                            })
                            // 2. Si no es admin, se oculta el campo (ya que el default le asignará su id_entidad automáticamente)
                            ->hidden(fn () => auth()->user()->id_nivel != 1 && !auth()->user()->is_root)
                            // 3. Activamos la reactividad para capturar el cambio inmediatamente
                            ->live()
                            // 4. Cada vez que el administrador cambie el club, lo guardamos en la sesión
                            ->afterStateUpdated(function ($state) {
                                if (auth()->user()->id_nivel == 1 || auth()->user()->is_root) {
                                    session(['last_selected_id_entidad' => $state]);
                                }
                            }),
                        Forms\Components\Fieldset::make()
                            ->schema([
                                /*Forms\Components\Select::make('cedula')
                                    ->label('Cédula')
                                    ->unique(ignoreRecord: true)
                                    ->required()
                                    ->live()
                                    ->searchable()
                                    ->getSearchResultsUsing(function (string $search, Get $get): array {
                                        if (! $get('id_entidad')) {
                                            return [];
                                        }

                                        // 1. Buscamos los socios reales en la base de datos
                                        $resultados = Socio::query()
                                            ->where('id_entidad', $get('id_entidad'))
                                            ->where(function ($query) use ($search) {
                                                $query->where('cedula', 'like', "%{$search}%")
                                                    ->orWhere('primer_nombre', 'like', "%{$search}%")
                                                    ->orWhere('primer_apellido', 'like', "%{$search}%");
                                            })
                                            ->limit(10)
                                            ->get()
                                            ->mapWithKeys(function ($socio) {
                                                return [$socio->cedula => "{$socio->cedula} - {$socio->primer_nombre} {$socio->primer_apellido}"];
                                            })
                                            ->toArray();

                                        // 2. Aplicamos la limpieza estrictamente para construir la opción virtual
                                        $cleanSearch = preg_replace('/[^0-9-]/', '', $search);
                                        $cleanSearch = trim($cleanSearch, '-');

                                        if (filled($cleanSearch) && ! isset($resultados[$cleanSearch])) {
                                            return [$cleanSearch => "Utilizar: {$cleanSearch}"] + $resultados;
                                        }

                                        return $resultados;
                                    })
                                    ->getOptionLabelUsing(function ($value): ?string {
                                        if (blank($value)) {
                                            return null;
                                        }
                                        $cleanValue = preg_replace('/[^0-9-]/', '', $value);
                                        return trim($cleanValue, '-');
                                    })
                                    ->rules([
                                        fn(Get $get, $component): Closure => function (string $attribute, $value, Closure $fail) use ($get, $component) {
                                            $id_entidad = $get('id_entidad');
                                            $cedula = $value;

                                            if (config('app.chequear_socios') && auth()->user()->validar_socios && !auth()->user()->is_root) {
                                                $existe = Socio::where('id_entidad', $id_entidad)->where('cedula', $cedula)->first();
                                                if (!$existe) {
                                                    $fail("La cédula no está en el listado de Socios.");
                                                }
                                            }
                                        },
                                    ])
                                    ->afterStateUpdated(function (Get $get, Set $set, ?string $state, $livewire, $component) {
                                        $id_entidad = $get('id_entidad');
                                        $cedula = $state;
                                        $key = $component->getRecord()?->getKey();

                                        if (blank($cedula)) {
                                            return;
                                        }

                                        // 🛡️ 1. CONTROL DE REGLA "UNIQUE": Si la cédula ya está registrada en el formulario actual
                                        // (excluyendo el registro actual si es edición), limpiamos todo y abortamos el rellenado.
                                        $modelClass = $component->getModel();
                                        $duplicadoQuery = $modelClass::where('cedula', $cedula);
                                        if ($key) {
                                            $duplicadoQuery->where($component->getRecord()->getKeyName(), '!=', $key);
                                        }
                                        if ($duplicadoQuery->exists()) {
                                            // Limpiamos los campos para que no retenga datos viejos
                                            $set('carnet_socio', '');
                                            $set('id_tipo_socio', '');
                                            $set('primer_nombre', '');
                                            $set('segundo_nombre', '');
                                            $set('primer_apellido', '');
                                            $set('segundo_apellido', '');
                                            $set('sexo', '');
                                            $set('fecha_nacimiento', '');

                                            // Forzamos la validación para que pinte el error de 'unique' de inmediato en la UI
                                            $livewire->validateOnly($component->getStatePath());
                                            return;
                                        }

                                        // 🔍 2. Consultamos en la tabla de socios si superó el filtro de unicidad
                                        $existe = Socio::where('id_entidad', $id_entidad)->where('cedula', $cedula)->first();

                                        // 🛡️ 3. CONTROL DE REGLA PERSONALIZADA (config('app.chequear_socios'))
                                        // Si el sistema exige que el socio exista obligatoriamente y NO se encontró, no rellenamos nada.
                                        $exigeSocio = config('app.chequear_socios') && auth()->user()->validar_socios && !auth()->user()->is_root;

                                        if (!$existe && $exigeSocio) {
                                            // Forzamos el comportamiento de error limpiando los campos
                                            if (!$key) {
                                                $set('carnet_socio', '');
                                                $set('id_tipo_socio', '');
                                                $set('primer_nombre', '');
                                                $set('segundo_nombre', '');
                                                $set('primer_apellido', '');
                                                $set('segundo_apellido', '');
                                                $set('sexo', '');
                                                $set('fecha_nacimiento', '');
                                            }

                                            Notification::make()
                                                ->title('La cédula ' . $cedula)
                                                ->body('no está en el listado de Socios')
                                                ->icon('heroicon-c-exclamation-circle')
                                                ->iconColor('warning')
                                                ->color('warning')
                                                ->persistent()
                                                ->send();

                                            $livewire->validateOnly($component->getStatePath());
                                            return;
                                        }

                                        // 🚀 4. Si pasó los filtros de arriba con éxito, procedemos a rellenar o vaciar según corresponda
                                        if ($existe) {
                                            $set('carnet_socio', $existe->carnet);
                                            $set('id_tipo_socio', $existe->tiposocio);
                                            $set('primer_nombre', $existe->primer_nombre);
                                            $set('segundo_nombre', $existe->segundo_nombre);
                                            $set('primer_apellido', $existe->primer_apellido);
                                            $set('segundo_apellido', $existe->segundo_apellido);
                                            $set('sexo', $existe->sexo);
                                            $set('fecha_nacimiento', $existe->fecha_nacimiento);
                                        } else {
                                            // Si no existe, pero el sistema SÍ permite guardar cédulas libres (opción virtual)
                                            if (!$key) {
                                                $set('carnet_socio', '');
                                                $set('id_tipo_socio', '');
                                                $set('primer_nombre', '');
                                                $set('segundo_nombre', '');
                                                $set('primer_apellido', '');
                                                $set('segundo_apellido', '');
                                                $set('sexo', '');
                                                $set('fecha_nacimiento', '');
                                            }
                                            Notification::make()
                                                ->title('La cédula ' . $cedula)
                                                ->body('no está en el listado de Socios')
                                                ->icon('heroicon-c-exclamation-circle')
                                                ->iconColor('warning')
                                                ->color('warning')
                                                ->persistent()
                                                ->send();
                                        }

                                        $livewire->validateOnly($component->getStatePath());
                                    })*/
                                Forms\Components\Select::make('cedula')
                                    ->label('Cédula')
                                    ->unique(ignoreRecord: true)
                                    ->required()
                                    ->live()
                                    ->searchable()
                                    // 1. Quitamos el key dinámico de sesión para evitar conflictos de renderizado
                                    ->getSearchResultsUsing(function (string $search, Get $get): array {
                                        if (! $get('id_entidad')) {
                                            return [];
                                        }

                                        $resultados = Socio::query()
                                            ->where('id_entidad', $get('id_entidad'))
                                            ->where(function ($query) use ($search) {
                                                $query->where('cedula', 'like', "%{$search}%")
                                                    ->orWhere('primer_nombre', 'like', "%{$search}%")
                                                    ->orWhere('primer_apellido', 'like', "%{$search}%");
                                            })
                                            ->limit(10)
                                            ->get()
                                            ->mapWithKeys(function ($socio) {
                                                return [$socio->cedula => "{$socio->cedula} - {$socio->primer_nombre} {$socio->primer_apellido}"];
                                            })
                                            ->toArray();

                                        $cleanSearch = preg_replace('/[^0-9-]/', '', $search);
                                        $cleanSearch = trim($cleanSearch, '-');

                                        if (filled($cleanSearch) && ! isset($resultados[$cleanSearch])) {
                                            return [$cleanSearch => "Utilizar: {$cleanSearch}"] + $resultados;
                                        }

                                        return $resultados;
                                    })
                                    ->getOptionLabelUsing(function ($value): ?string {
                                        if (blank($value)) {
                                            return null;
                                        }
                                        $cleanValue = preg_replace('/[^0-9-]/', '', $value);
                                        return trim($cleanValue, '-');
                                    })
                                    ->rules([
                                        fn(Get $get, $component): Closure => function (string $attribute, $value, Closure $fail) use ($get, $component) {
                                            $id_entidad = $get('id_entidad');
                                            $cedula = $value;

                                            if (config('app.chequear_socios') && auth()->user()->validar_socios && !auth()->user()->is_root) {
                                                $existe = Socio::where('id_entidad', $id_entidad)->where('cedula', $cedula)->first();
                                                if (!$existe) {
                                                    $fail("La cédula no está en el listado de Socios.");
                                                }
                                            }
                                        },
                                    ])
                                    ->afterStateUpdated(function (Get $get, Set $set, ?string $state, $livewire, $component) {
                                        $id_entidad = $get('id_entidad');
                                        $cedula = $state;
                                        $key = $component->getRecord()?->getKey();

                                        if (blank($cedula)) {
                                            return;
                                        }

                                        // 🛡️ 1. CONTROL DE REGLA "UNIQUE"
                                        $modelClass = $component->getModel();
                                        $duplicadoQuery = $modelClass::where('cedula', $cedula);
                                        if ($key) {
                                            $duplicadoQuery->where($component->getRecord()->getKeyName(), '!=', $key);
                                        }
                                        if ($duplicadoQuery->exists()) {
                                            $set('carnet_socio', '');
                                            $set('id_tipo_socio', '');
                                            $set('primer_nombre', '');
                                            $set('segundo_nombre', '');
                                            $set('primer_apellido', '');
                                            $set('segundo_apellido', '');
                                            $set('sexo', '');
                                            $set('fecha_nacimiento', '');

                                            // Forzamos el estado a null en el componente
                                            $component->state(null);

                                            // ✨ NUEVO: Notificación para avisar al usuario del duplicado
                                            Notification::make()
                                                ->title('Cédula duplicada')
                                                ->body("La cédula {$cedula} ya se encuentra registrada en el sistema.")
                                                ->icon('heroicon-c-exclamation-circle')
                                                ->iconColor('danger') // Color rojo para diferenciarlo de la advertencia de socios
                                                ->color('danger')
                                                ->persistent()
                                                ->send();

                                            // ✨ EJECUCIÓN JAVASCRIPT DIRECTA: Resetea el input visual y destruye la opción virtual
                                            $statePath = $component->getStatePath();
                                            $livewire->js("
                                                let el = document.querySelector('[data-id=\"{$statePath}\"] select') || document.getElementById('{$statePath}');
                                                if (el && el.choices) {
                                                    el.choices.removeActiveItems();
                                                    el.choices.setChoiceByValue('');
                                                }
                                                @this.set('{$statePath}', null);
                                            ");

                                            $livewire->validateOnly($statePath);
                                            return;
                                        }

                                        // 🔍 2. Consultamos en la tabla de socios
                                        $existe = Socio::where('id_entidad', $id_entidad)->where('cedula', $cedula)->first();

                                        // 🛡️ 3. CONTROL DE REGLA PERSONALIZADA (config('app.chequear_socios'))
                                        $exigeSocio = config('app.chequear_socios') && auth()->user()->validar_socios && !auth()->user()->is_root;

                                        if (!$existe && $exigeSocio) {
                                            if (!$key) {
                                                $set('carnet_socio', '');
                                                $set('id_tipo_socio', '');
                                                $set('primer_nombre', '');
                                                $set('segundo_nombre', '');
                                                $set('primer_apellido', '');
                                                $set('segundo_apellido', '');
                                                $set('sexo', '');
                                                $set('fecha_nacimiento', '');
                                            }

                                            Notification::make()
                                                ->title('La cédula ' . $cedula)
                                                ->body('no está en el listado de Socios')
                                                ->icon('heroicon-c-exclamation-circle')
                                                ->iconColor('warning')
                                                ->color('warning')
                                                ->persistent()
                                                ->send();

                                            // Forzamos el estado a null en el componente
                                            $component->state(null);

                                            // ✨ EJECUCIÓN JAVASCRIPT DIRECTA: Resetea el input visual y destruye la opción virtual
                                            $statePath = $component->getStatePath();
                                            $livewire->js("
                                                let el = document.querySelector('[data-id=\"{$statePath}\"] select') || document.getElementById('{$statePath}');
                                                if (el && el.choices) {
                                                    el.choices.removeActiveItems();
                                                    el.choices.setChoiceByValue('');
                                                }
                                                @this.set('{$statePath}', null);
                                            ");

                                            $livewire->validateOnly($statePath);
                                            return;
                                        }

                                        // 🚀 4. Si pasó con éxito
                                        if ($existe) {
                                            $set('carnet_socio', $existe->carnet);
                                            $set('id_tipo_socio', $existe->tiposocio);
                                            $set('primer_nombre', $existe->primer_nombre);
                                            $set('segundo_nombre', $existe->segundo_nombre);
                                            $set('primer_apellido', $existe->primer_apellido);
                                            $set('segundo_apellido', $existe->segundo_apellido);
                                            $set('sexo', $existe->sexo);
                                            $set('fecha_nacimiento', $existe->fecha_nacimiento);
                                        } else {
                                            if (!$key) {
                                                $set('carnet_socio', '');
                                                $set('id_tipo_socio', '');
                                                $set('primer_nombre', '');
                                                $set('segundo_nombre', '');
                                                $set('primer_apellido', '');
                                                $set('segundo_apellido', '');
                                                $set('sexo', '');
                                                $set('fecha_nacimiento', '');
                                            }
                                            Notification::make()
                                                ->title('La cédula ' . $cedula)
                                                ->body('no está en el listado de Socios')
                                                ->icon('heroicon-c-exclamation-circle')
                                                ->iconColor('warning')
                                                ->color('warning')
                                                ->persistent()
                                                ->send();
                                        }

                                        $livewire->validateOnly($component->getStatePath());
                                    }),
                                Forms\Components\TextInput::make('carnet_socio')
                                    ->label('Carnet')
                                    ->integer()
                                    ->required()
                                    ->maxLength(8)
                                    ->minValue(1),
                                Forms\Components\Select::make('id_tipo_socio')
                                    ->relationship('tipoSocio', 'tipo_socio')
                                    ->required()
                                    ->disabled(fn () => auth()->user()->id_nivel != 1 && !auth()->user()->is_root)
                                    ->dehydrated(),
                            ])
                            ->columns(3),
                        Forms\Components\Fieldset::make()
                            ->schema([
                                Forms\Components\TextInput::make('primer_nombre')
                                    ->required()
                                    ->maxLength(50),
                                Forms\Components\TextInput::make('segundo_nombre')
                                    ->maxLength(50),
                                Forms\Components\TextInput::make('primer_apellido')
                                    ->required()
                                    ->maxLength(50),
                                Forms\Components\TextInput::make('segundo_apellido')
                                    ->maxLength(50),
                            ]),
                        Forms\Components\Fieldset::make()
                            ->schema([
                                Forms\Components\Select::make('sexo')
                                    ->options([
                                        0 => mb_strtoupper('Masculino'),
                                        1 => mb_strtoupper('Femenino'),
                                    ])
                                    ->required(),
                                Forms\Components\TextInput::make('email')
                                    ->email()
                                    ->maxLength(100),
                                Forms\Components\TextInput::make('telefono')
                                    ->label('Teléfono')
                                    ->tel()
                                    ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/'),
                            ])
                            ->columns(3),
                        Forms\Components\Fieldset::make()
                            ->schema([
                                Forms\Components\DatePicker::make('fecha_nacimiento')
                                    ->label('Fecha de Nacimiento')
                                    ->required(),
                                Forms\Components\Select::make('deporteini')
                                    ->label('Deporte')
                                    ->relationship(
                                        'deporteinicial',
                                        'deporte',
                                        fn(Builder $query) => $query->where('en_uso', 1),
                                    )
                                    ->default(98)
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                                Forms\Components\Select::make('id_cargo')
                                    ->relationship(
                                        'cargo',
                                        'cargo',
                                        function (Builder $query) {
                                            $nivel = Nivel::find(auth()->user()->id_nivel);
                                            if ($nivel && !auth()->user()->is_root) {
                                                $id_permiso = $nivel->id_permiso;
                                                $permiso = Permiso::find($id_permiso);
                                                if ($permiso) {
                                                    $cargos = explode(',', $permiso->cargos);
                                                    foreach ($cargos as $cargo) {
                                                        $query->orWhere('id', $cargo);
                                                    }
                                                }
                                            }
                                            return $query;
                                        }
                                    )
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                            ])
                            ->columns(3),
                        Forms\Components\Fieldset::make()
                            ->schema([
                                Forms\Components\FileUpload::make('fotografia')
                                    ->label('Foto tipo carnet del Participante')
                                    ->image()
                                    ->imageEditor()
                                    ->maxSize(3072)
                                    ->directory('participantes-photos')
                                    ->required(),
                                Forms\Components\FileUpload::make('image_cedula')
                                    ->label('Foto del Carnet')
                                    ->image()
                                    ->imageEditor()
                                    ->maxSize(3072)
                                    ->directory('participantes-photos'),
                            ]),
                    ])
                    ->columns(3)
                    ->collapsible()
                    ->compact(),
                Forms\Components\Section::make('Datos Médicos')
                    ->schema([
                        Forms\Components\TextInput::make('rh')
                            ->label('Grupo Sanguineo y RH')
                            ->maxLength(50),
                        Forms\Components\Fieldset::make('Alergias')
                            ->schema([
                                Forms\Components\Toggle::make('alergico')
                                    ->label('Es alérgico')
                                    ->inline(false)
                                    ->live()
                                    ->afterStateUpdated(function (Get $get, Set $set) {
                                        $isAlergico = $get('alergico');
                                        if (!$isAlergico) {
                                            $set('alergias', '');
                                        }
                                    }),
                                Forms\Components\TextInput::make('alergias')
                                    ->requiredIf('alergico', true)
                                    ->readOnly(fn(Get $get) => !$get('alergico')),
                            ]),
                        Forms\Components\Fieldset::make('Antecedentes Médicos')
                            ->schema([
                                Forms\Components\Toggle::make('ant_medicos')
                                    ->label('Con Antecedentes')
                                    ->inline(false)
                                    ->live()
                                    ->afterStateUpdated(function (Get $get, Set $set) {
                                        $ConAntecedentes = $get('ant_medicos');
                                        if (!$ConAntecedentes) {
                                            $set('antecedentes', '');
                                        }
                                    }),
                                Forms\Components\TextInput::make('antecedentes')
                                    ->requiredIf('ant_medicos', true)
                                    ->readOnly(fn(Get $get) => !$get('ant_medicos')),
                            ]),
                        Forms\Components\Fieldset::make('Avisar a')
                            ->schema([
                                Forms\Components\TextInput::make('avisar_a')
                                    ->label('Nombre')
                                    ->maxLength(100),
                                Forms\Components\TextInput::make('telefono_medico')
                                    ->label('Teléfono')
                                    ->tel()
                                    ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/'),
                            ]),
                    ])
                    ->columns(3)
                    ->collapsible()
                    ->compact(),
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
                    ->searchable()
                    ->wrap()
                    ->visibleFrom('sm'),
                Tables\Columns\TextColumn::make('primer_apellido')
                    ->label('Apellidos')
                    ->formatStateUsing(function ($state, Participante $participante) {
                        return mb_strtoupper($participante->primer_apellido . ' ' . $participante->segundo_apellido);
                    })
                    ->searchable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('sexo')
                    ->label('Sexo')
                    ->formatStateUsing(function ($state, Participante $participante) {
                        if (!$participante->sexo) {
                            return mb_strtoupper('Masculino');
                        } else {
                            return mb_strtoupper('Femenino');
                        }
                    })
                    ->visibleFrom('sm')
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('deporteinicial.deporte')
                    ->label('Deporte')
                    ->wrap()
                    ->formatStateUsing(fn(string $state) => mb_strtoupper($state))
                    ->visibleFrom('sm')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('cargo.cargo')
                    ->label('Cargo')
                    ->formatStateUsing(fn(string $state) => mb_strtoupper($state))
                    ->wrap()
                    ->visibleFrom('sm'),
                Tables\Columns\CheckboxColumn::make('asiste')
                    ->disabled(fn(): bool => auth()->user()->id_nivel == 6)
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('entidad.short_nombre')
                    ->label('Club')
                    ->formatStateUsing(fn(string $state) => mb_strtoupper($state))
                    ->wrap()
                    ->hidden(function () {
                        $id_nivel = auth()->user()->id_nivel == 1 || auth()->user()->id_nivel == 6;
                        $is_root = auth()->user()->is_root;
                        if (!$id_nivel && !$is_root) {
                            return true;
                        }
                        return false;
                    })
                    ->visibleFrom('sm')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
                Tables\Filters\SelectFilter::make('Deporte')
                    ->relationship('deporteinicial', 'deporte', fn(Builder $query) => $query->where('en_uso', 1)),
                Tables\Filters\SelectFilter::make('Cargo')
                    ->relationship('cargo', 'cargo', function (Builder $query) {
                        // 1. Obtener el usuario autenticado con sus relaciones cargadas
                        $user = auth()->user()?->load('nivel.permiso');

                        // 2. Si no hay usuario o no tiene permisos asignados, vaciamos el select por seguridad
                        if (!$user || !$user->nivel || !$user->nivel->permiso || empty($user->nivel->permiso->cargos)) {
                            return $query->whereRaw('1 = 0'); // Consulta que devuelve vacío
                        }

                        // 3. Limpiamos el string ("1, 2, , 3") y lo convertimos en un array limpio: [1, 2, 3]
                        $cargoIds = array_filter(
                            array_map('trim', explode(',', $user->nivel->permiso->cargos))
                        );

                        // Si después de limpiar el array quedó vacío, no mostramos nada
                        if (empty($cargoIds)) {
                            return $query->whereRaw('1 = 0');
                        }

                        // 4. Filtramos el listado del SELECT para que solo muestre esos IDs
                        return $query->whereIn('id', $cargoIds);
                    }),
                Tables\Filters\SelectFilter::make('Entidad')
                    ->label('Club')
                    ->relationship('entidad', 'short_nombre')
                    ->hidden(function () {
                        $id_nivel = auth()->user()->id_nivel == 1 || auth()->user()->id_nivel == 6;
                        $is_root = auth()->user()->is_root;
                        if (!$id_nivel && !$is_root) {
                            return true;
                        }
                        return false;
                    }),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    //Tables\Actions\ViewAction::make(),
                    Tables\Actions\Action::make('imprimir')
                        ->label('Imprimir')
                        ->icon('heroicon-o-identification')
                        ->url(fn(Participante $record) => route('export.participante', $record->getKey()))
                        ->openUrlInNewTab(),
                    Tables\Actions\EditAction::make()
                        ->disabled(fn():bool => auth()->user()->id_nivel == 6),
                    Tables\Actions\DeleteAction::make()
                        ->before(function ($record) {
                            $i = 0;
                            do {
                                $repeat = Str::repeat('*', ++$i);
                                $cedula = $repeat . $record->cedula;
                                $existe = Participante::withTrashed()->where('cedula', $cedula)->first();
                            } while ($existe);
                            $record->update(['cedula' => $cedula]);
                        })
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->before(function (Collection $records) {
                            foreach ($records as $record) {
                                $i = 0;
                                do {
                                    $repeat = Str::repeat('*', ++$i);
                                    $cedula = $repeat . $record->cedula;
                                    $existe = Participante::withTrashed()->where('cedula', $cedula)->first();
                                } while ($existe);
                                $record->update(['cedula' => $cedula]);
                            }
                        })
                    ->disabled(fn(): bool => auth()->user()->id_nivel == 6)
                    ->hidden(fn(): bool => auth()->user()->id_nivel == 6)
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
                        Column::make('entidad.short_nombre')->heading('Club'),
                    ])
                ])
            ])
            ->defaultSort('created_at', 'DESC')
            ->modifyQueryUsing(function (Builder $query) {
                $id_nivel = auth()->user()->id_nivel == 1 || auth()->user()->id_nivel == 6;
                $id_entidad = auth()->user()->id_entidad;
                $is_root = auth()->user()->is_root;
                if (!$id_nivel && !$is_root) {
                    return $query->where('id_entidad', $id_entidad);
                }
                return $query;
            });
    }

    public static function getRelations(): array
    {
        return [
            //RelationManagers\AtletasRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListParticipantes::route('/'),
            'create' => Pages\CreateParticipante::route('/create'),
            'edit' => Pages\EditParticipante::route('/{record}/edit'),
            //'view' => Pages\ViewParticipante::route('/{record}'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            ModalidadDeportivaWidget::class,
        ];
    }

   /* public static function canAccess(): bool
    {
        $id_nivel = auth()->user()->id_nivel ?? null;
        $is_root = auth()->user()->is_root ?? null;
        return verPage('PARTICIPANTES_VER', 'PARTICIPANTES_HASTA') || $id_nivel == 1 || $is_root;
    }*/





}
