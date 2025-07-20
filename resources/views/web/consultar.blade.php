<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Ing. Yonathan Castillo">
    <meta name="generator" content="Bootstrap v5.3.7">

    <title>Consultar Participante - {{ config('app.name', 'Laravel') }}</title>

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('img/favicons/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('img/favicons/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('img/favicons/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/favicons/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('img/favicons/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('img/favicons/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('img/favicons/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('img/favicons/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/favicons/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('img/favicons/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('img/favicons/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicons/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('img/favicons/manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('img/favicons/ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">

    <!--Bootstrap -->
    {{--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">--}}
    @vite(['resources/js/bootstrap5.js', 'resources/js/sweetalert2.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;400&display=swap" rel="stylesheet">

    <style>
        @media (min-width: 768px) {
            #scale {
                transform: scale(0.8); /* Reduce el tamaño al 80% */
            }
        }

        * {
            font-family: "Poppins", sans-serif;
            font-weight: 400;
            font-style: normal;
        }

        .text_title {
            color: rgba(8, 23, 44, 1);
            font-weight: bold;
        }


        .gradient-custom-2 {
            /* fallback for old browsers */
            background: rgb(42, 177, 199);

            /* Chrome 10-25, Safari 5.1-6 */
            background: -webkit-linear-gradient(90deg, rgba(42, 177, 199, 1) 0%, rgba(41, 149, 209, 1) 50%, rgba(41, 94, 228, 1) 100%);

            /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            background: linear-gradient(90deg, rgba(42, 177, 199, 1) 0%, rgba(41, 149, 209, 1) 50%, rgba(41, 94, 228, 1) 100%);
        }

        @media (min-width: 768px) {
            .gradient-form {
                height: 100vh !important;
            }
        }

        @media (min-width: 769px) {
            .gradient-custom-2 {
                border-top-right-radius: .3rem;
                border-bottom-right-radius: .3rem;
            }
        }

        #preloader {
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: #fff no-repeat center center;
            z-index: 9999;
        }

        #preloader::before {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            width: 100px;
            height: 100px;
            background: url('{{ asset('img/preloader_171x171.png') }}') no-repeat center center;
            background-size: contain;
            transform: translate(-50%, -50%);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: translate(-50%, -50%) scale(1);
            }
            50% {
                transform: translate(-50%, -50%) scale(1.2);
            }
            100% {
                transform: translate(-50%, -50%) scale(1);
            }
        }

        .ima_profile_user{
            width: 200px;
            height: 200px;
            border-radius: 100%;
            object-fit: cover;
        }

    </style>
    <script type="application/javascript">
        //Script para ejecurar el preloader
        window.addEventListener('load', function () {
            document.querySelector('#preloader').style.display = 'none';
            document.querySelector('.container').style.display = 'block';
        });
    </script>

    @livewireStyles
</head>
<body style="background-color: #eee;">

<div id="preloader"></div>

<div class="position-relative gradient-form" style="min-height: 100vh;">
    <div class="<!--position-absolute--> <!--top-50--> <!--start-50--> <!--translate-middle--> container pt-5">


        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-xl-10">
                <div class="card rounded-3 text-black">
                    <div class="row g-0">
                        <div class="col-lg-6">
                            <div class="card-body mx-md-4 <!--position-relative-->" id="card_body">

                                <div class="text-center">
                                    {{--<a href="{{ route('web.index') }}" onclick="verCargandoAuth(this)">--}}
                                        <img class="img-fluid" src="{{ asset('img/cintillo.png') }}" alt="Foto del Participante">
                                    {{--</a>--}}
                                    <h6 class="pb-1 text_title">
                                        <strong>Consultar Participante</strong>
                                    </h6>
                                </div>


                                <img src="{{ verImagen($participante->fotografia, true) }}" class="img-thumbnail rounded mx-auto d-block ima_profile_user" alt="...">


                                <ol class="list-group mt-2 <!--list-group-numbered-->">
                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                        <div class="ms-2 me-auto">
                                            <div class="fw-bold">Cédula:</div>
                                            <span class="text-uppercase">{{ is_numeric($participante->cedula) ? formatoMillares($participante->cedula, 0) : $participante->cedula }}</span>
                                        </div>
                                        {{--<span class="badge text-bg-primary rounded-pill">14</span>--}}
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                        <div class="ms-2 me-auto">
                                            <div class="fw-bold">Nombre Completo</div>
                                            <span class="text-uppercase">
                                                {{ $participante->primer_nombre }}
                                                {{ $participante->segundo_nombre }}
                                                {{ $participante->primer_apellido }}
                                                {{ $participante->segundo_apellido }}
                                            </span>
                                        </div>
                                        {{--<span class="badge text-bg-primary rounded-pill">14</span>--}}
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                        <div class="ms-2 me-auto">
                                            <div class="fw-bold">Club:</div>
                                            <span class="text-uppercase">{{ $participante->entidad->nombre }}</span>
                                        </div>
                                        {{--<span class="badge text-bg-primary rounded-pill">14</span>--}}
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                        <div class="ms-2 me-auto">
                                            <div class="fw-bold">Deporte:</div>
                                            <span class="text-uppercase">{{ $participante->deporteinicial->deporte }}</span>
                                        </div>
                                        {{--<span class="badge text-bg-primary rounded-pill">14</span>--}}
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                        <div class="ms-2 me-auto">
                                            <div class="fw-bold">Cargo:</div>
                                            <span class="text-uppercase">{{ $participante->cargo->cargo }}</span>
                                        </div>
                                        {{--<span class="badge text-bg-primary rounded-pill">14</span>--}}
                                    </li>
                                    @if($deportes->isNotEmpty())
                                        <li class="list-group-item justify-content-between align-items-start">
                                            <div class="ms-2 me-auto">
                                                <div class="fw-bold">Deportes y Modalidades:</div>
                                                <ol class="list-group list-group-numbered">
                                                    @foreach($deportes as $atleta)
                                                        <li class="list-group-item text-uppercase">
                                                            <small>{{ $atleta->deporte->deporte }} - {{ $atleta->modalidad->modalidad }}</small>
                                                        </li>
                                                    @endforeach
                                                </ol>
                                            </div>
                                            {{--<span class="badge text-bg-primary rounded-pill">14</span>--}}
                                        </li>
                                    @endif
                                </ol>





                            </div>
                        </div>
                        <div class="col-lg-6 d-none d-lg-flex align-items-center gradient-custom-2" style="min-height: 70vh">
                            <div class="text-white px-3 py-4 p-md-5 mx-md-4 text-center">
                                <h3>Desarrollado por Morros Devops</h3>
                                <a href="https://www.morros-devops.xyz" target="_blank"
                                   class="text-white text-decoration-none">www.morros-devops.xyz</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>

{{--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>--}}
@livewireScripts
<script type="application/javascript">
    (() => {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        const forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                } else {
                    form.classList.add('opacity-50');
                    document.querySelector(".verCargando").classList.remove('d-none');
                }
                form.classList.add('was-validated');
            }, false);
        })
    })()

    function verCargandoAuth(enlace) {
        event.preventDefault();
        const card = document.querySelector("#card_body");
        const spinner = document.querySelector(".verCargando");

        card.classList.add('opacity-50');
        spinner.classList.remove('d-none');

        setTimeout(function () {
            card.classList.remove('opacity-50');
            spinner.classList.add('d-none');
            //alert(enlace.href)
            window.location.href = enlace.href;
        }, 1000)
    }

    console.log('Hi!')
</script>
@include('layouts.sweetAlert2')
</body>
</html>
