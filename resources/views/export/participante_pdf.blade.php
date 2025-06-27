<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ViewPDF</title>
    <link rel="stylesheet" href="{{ public_path('css/invoice_style.css') }}" type="text/css" media="all" />
</head>

<body>
<div>
    <div class="py-4">
        <div class="px-14 py-6">
            <table class="w-full border-collapse border-spacing-0">
                <tbody>
                <tr>
                    <td class="w-full align-top">
                        <div>
                            <img src="{{ verImagen($participante->fotografia) }}" class="img_perfil"  alt="Logo"/>
                        </div>
                    </td>

                    <td class="align-top">
                        <div class="text-sm">
                            <table class="border-collapse border-spacing-0">
                                <tbody>
                                <tr>
                                    <td class="border-r pr-4">
                                        <div>
                                            <p class="whitespace-nowrap text-slate-400 text-right">Fecha de Nacimiento</p>
                                            <p class="whitespace-nowrap font-bold text-main text-right text-uppercase">{{ $participante->fecha_nacmiento ? getFecha($participante->fecha_nacimiento) : 'No suministrado' }}</p>
                                        </div>
                                    </td>
                                    <td class="pl-4">
                                        <div>
                                            <p class="whitespace-nowrap text-slate-400 text-right">Cedula</p>
                                            <p class="whitespace-nowrap font-bold text-main text-right">{{ is_numeric($participante->cedula) ? formatoMillares($participante->cedula, 0) : $participante->cedula }}</p>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="bg-slate-100 px-14 py-6 text-sm">
            <table class="w-full border-collapse border-spacing-0">
                <tbody>
                <tr>
                    <td class="w-1/2 align-top">
                        <div class="text-sm text-neutral-600">
                            <p class="font-bold text-main text-uppercase">{{ $participante->entidad->nombre }}</p>
                            <br>
                            <p class="text-uppercase"><span class="font-bold">Carnet</span>: {{ $participante->carnet_socio ?? 'No suministrado' }}</p>
                            <p class="text-uppercase"><span class="font-bold">Tipo socio</span>: {{ $participante->id_tipo_socio ? $participante->tipoSocio->tipo_socio : 'No suministrado' }}</p>
                        </div>
                    </td>
                    <td class="w-1/2 align-top text-right">
                        <div class="text-sm text-neutral-600">
                            <p class="font-bold">Nombre Completo</p>
                            <p class="text-uppercase">
                                {{ $participante->primer_nombre." ".$participante->segundo_nombre." ".$participante->primer_apellido." ".$participante->segundo_apellido }}
                            </p>
                            <p><span class="font-bold">Sexo</span>: <span class="text-uppercase">{{ $participante->sexo ? 'Femenino' : 'Masculino' }}</span></p>
                            <p><span class="font-bold">Deporte</span>: <span class="text-uppercase">{{ $participante->deporteinicial->deporte }}</span></p>
                            <p><span class="font-bold">Cargo</span>: <span class="text-uppercase">{{ $participante->cargo->cargo }}</span></p>
                            @if($participante->email) <p><span class="font-bold">Email</span>: <span class="text-uppercase"> {{ $participante->email }} </span></p> @endif
                            @if($participante->telefono) <p><span class="font-bold">Teléfono</span>: <span class="text-uppercase">{{ $participante->telefono }}</span></p> @endif
                            @if($participante->rh || $participante->alergias || $participante->antecedentes)
                                <br>
                                <p class="font-bold">Datos Médicos</p>
                                @if($participante->rh) <p><span class="font-bold">Grupo Sanguineo y RH</span>: <span class="text-uppercase">{{ $participante->rh }}</span></p> @endif
                                @if($participante->alergias) <p><span class="font-bold">Alergias</span>: <span class="text-uppercase">{{ $participante->alergias }}</span></p> @endif
                                @if($participante->antecedentes) <p><span class="font-bold">Antecedentes</span>: <span class="text-uppercase">{{ $participante->antecedentes }}</span></p> @endif
                                <p><span class="font-bold">Avisar a</span>: <span class="text-uppercase">{{ $participante->avisar_a }} - {{ $participante->telefono_medico }}</span></p>
                            @endif
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        @if($participante->id_cargo == 4)
            <div class="px-14 py-10 text-sm text-neutral-700">
                <table class="w-full border-collapse border-spacing-0">
                    <thead>
                    <tr>
                        <td colspan="2" class="border-b-2 border-main pb-3 pl-3 font-bold text-main text-center text-uppercase">Deportes y Modalidades</td>
                    </tr>
                    </thead>
                    <tbody>
                    @php($i = 0)
                    @foreach($modalidades as $modalidad)
                        @if(!$modalidad->ver) @continue @endif
                        @php($i++)
                        <tr>
                            <td class="border-b py-3 pl-3 text-uppercase">{{ $modalidad->deporte->deporte }}</td>
                            <td class="border-b py-3 pl-2 text-uppercase">{{ $modalidad->modalidad }}</td>
                        </tr>
                    @endforeach
                    @if(!$i)
                        <tr>
                            <td colspan="2" class="border-b py-3 pl-3 text-uppercase">NO suministrado</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        @endif

        <div class="px-14 py-6 text-sm">
            <table class="w-full border-collapse border-spacing-0">
                <tbody>
                <tr>
                    <td class="align-top text-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td class="w-1/2 align-top">
                        <p><span class="">Foto del Carnet:</span></p>
                        <div class="">
                            <img src="{{ verImagen($participante->image_cedula) }}" class="img_cedula" alt="Cedula"/>
                        </div>
                    </td>
                    <td class="align-top text-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                </tr>
                </tbody>
            </table>
        </div>

        {{--<div class="px-14 py-6 text-sm">
            <table class="w-full border-collapse border-spacing-0">
                <tbody>
                <tr>
                    <td class="w-1/2 align-top">
                        <div class="text-sm text-neutral-600">
                            <p class="font-bold text-uppercase text-main">ESTREGADO POR</p>
                            <p class="border-b-2 border-main pb-3">Nombre:</p>
                            <p class="border-b-2 border-main pb-3">C.I:</p>
                            <p class="border-b-2 border-main pb-3">Firma:</p>
                        </div>
                    </td>
                    <td class="align-top text-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td class="w-1/2 align-top">
                        <div class="text-sm text-neutral-600">
                            <p class="font-bold text-uppercase text-main">RECIBIDO POR</p>
                            <p class="border-b-2 border-main pb-3">Nombre:</p>
                            <p class="border-b-2 border-main pb-3">C.I:</p>
                            <p class="border-b-2 border-main pb-3">Firma:</p>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>--}}

        <footer class="fixed bottom-0 left-0 bg-slate-100 w-full text-neutral-600 text-center text-xs py-3 text-uppercase">
            {{ $participante->entidad->nombre }}
           {{-- @if($empresa->email)
                <span class="text-slate-300 px-2">|</span>
                 $empresa->email
            @endif
            @if($empresa->telefono)
                <span class="text-slate-300 px-2">|</span>
                 $empresa->telefono
            @endif--}}
        </footer>
    </div>
</div>
</body>

</html>
