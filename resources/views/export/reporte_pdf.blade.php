<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ViewPDF</title>
    <link rel="stylesheet" href="{{ public_path('css/invoice_style.css') }}" type="text/css" media="all"/>
</head>

<body>
<div>
    <div class="py-4">
        {{--<div class="px-14 py-6">
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
        </div>--}}

        {{--<div class="bg-slate-100 px-14 py-6 text-sm">
            <table class="w-full border-collapse border-spacing-0">
                <tbody>
                <tr>
                    <td class="align-top">
                        <div class="text-sm text-neutral-600">
                            <p class="font-bold text-main text-uppercase">Titulo</p>
                            <p class="text-uppercase"><span class="font-bold">Deporte</span>: Domino</p>
                            --}}{{--<p class="text-uppercase"><span class="font-bold">Tipo socio</span>: {{ $participante->id_tipo_socio ? $participante->tipoSocio->tipo_socio : 'No suministrado' }}</p>--}}{{--
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>--}}


        <div class="px-14 py-10 text-sm text-neutral-700">
            <table class="w-full border-collapse border-spacing-0">
                <thead>
                <tr>
                    <td colspan="@if(auth()->user()->id_nivel == 1 || auth()->user()->is_root) 6 @else 5 @endif" class="align-top">
                        <div class="text-sm text-neutral-600">
                            <p class="font-bold pb-3 text-main text-center text-uppercase">
                                Listado @if($reporte == 'general') General @endif de Inscritos @if($reporte == 'deporte') por Deporte @endif
                            </p>
                            @if($entidad)
                                <p class="pb-3 text-uppercase">
                                    <span class="font-bold">Club</span>: {{ $entidad->nombre }}
                                </p>
                            @endif
                            @if($deporte)
                                <p class="pb-3 text-uppercase">
                                    <span class="font-bold">Deporte</span>: {{ $deporte->deporte }}
                                    {{--&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <span class="font-bold">Modalidad</span>: Domino--}}
                                </p>
                            @endif
                            {{--<p class="pb-3 text-uppercase">
                                <span class="font-bold">Deporte</span>: Domino
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <span class="font-bold">Modalidad</span>: Domino
                            </p>--}}
                            {{--<p class="text-uppercase"><span class="font-bold">Tipo socio</span>: {{ $participante->id_tipo_socio ? $participante->tipoSocio->tipo_socio : 'No suministrado' }}</p>--}}
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="border-b-2 border-main pb-3 pl-3 font-bold text-main">Cedula</td>
                    <td class="border-b-2 border-main pb-3 pl-2 font-bold text-main">Nombres</td>
                    <td class="border-b-2 border-main pb-3 pl-2 font-bold text-main">Apellidos</td>
                    <td class="border-b-2 border-main pb-3 pl-2 font-bold text-main">Fecha Nac.</td>
                    <td class="border-b-2 border-main pb-3 pl-2 font-bold text-main">Cargo</td>
                    @if(auth()->user()->id_nivel == 1 || auth()->user()->is_root)
                        <td class="border-b-2 border-main pb-3 pl-2 font-bold text-main">Club</td>
                    @endif
                </tr>
                </thead>
                <tbody>
                @php($i = 0)
                @foreach($participantes as $participante)
                    @php($i++)
                    <tr>
                        <td class="border-b py-3 pl-3 text-uppercase">{{ formatoMillares($participante->cedula, 0) }}</td>
                        <td class="border-b py-3 pl-2 text-uppercase">{{ $participante->primer_nombre }} {{ $participante->segundo_nombre }}</td>
                        <td class="border-b py-3 pl-2 text-uppercase">{{ $participante->primer_apellido }} {{ $participante->segundo_apellido }}</td>
                        <td class="border-b py-3 pl-2 text-uppercase">{{ $participante->fecha_nacimiento ? getFecha($participante->fecha_nacimiento) : '' }}</td>
                        <td class="border-b py-3 pl-2 text-uppercase">{{ $participante->cargo->cargo }}</td>
                        @if(auth()->user()->id_nivel == 1 || auth()->user()->is_root)
                            <td class="border-b py-3 pl-2 text-uppercase">{{ $participante->entidad->short_nombre }}</td>
                        @endif
                    </tr>
                @endforeach
                @if(!$i)
                    <tr>
                        <td colspan="@if(auth()->user()->id_nivel == 1 || auth()->user()->is_root) 6 @else 5 @endif" class="border-b py-3 pl-3 text-uppercase">NO Encontrado</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>


        {{--<div class="px-14 py-6 text-sm">
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
        </div>--}}

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

        <footer
            class="fixed bottom-0 left-0 bg-slate-100 w-full text-neutral-600 text-center text-xs py-3 text-uppercase">
            Listado @if($reporte == 'general') General @endif de Inscritos @if($deporte) | Deporte: {{ $deporte->deporte }} @endif | Total: {{ formatoMillares($participantes->count(), 0) }}
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
