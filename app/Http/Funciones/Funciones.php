<?php
//Funciones Personalizadas para el Proyecto

use Carbon\Carbon;

function verImagen($path): string
{
    $response  = public_path('img/placeholder.jpg');
    if (!empty($path)){
        $existe = file_exists(public_path('storage/'.$path));
        if ($existe){
            $response = storage_path('app/public/'.$path);
        }
    }
    return $response;
}

function getFecha($fecha, $format = null): string
{
    if (is_null($fecha)){
        if (is_null($format)){
            $date = Carbon::now(env('APP_TIMEZONE', "America/Caracas"))->toDateString();
        }else{
            $date = Carbon::now(env('APP_TIMEZONE', "America/Caracas"))->format($format);
        }
    }else{
        if (is_null($format)){
            $date = Carbon::parse($fecha)->format("d/m/Y");
        }else{
            $date = Carbon::parse($fecha)->format($format);
        }
    }
    return $date;
}

function formatoMillares($cantidad, $decimal = 2): string
{
    if (!is_numeric($cantidad)){
        $cantidad = 0;
    }
    return number_format($cantidad, $decimal, ',', '.');
}

function cerosIzquierda($cantidad, $cantCeros = 2): int|string
{
    if ($cantidad == 0) {
        return 0;
    }
    return str_pad($cantidad, $cantCeros, "0", STR_PAD_LEFT);
}

function generarStringAleatorio($largo = 10, $soloNumeros = false , $espacio = false): string
{
    $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    if ($soloNumeros){
        $caracteres = '0123456789';
    }
    $caracteres = $espacio ? $caracteres . ' ' : $caracteres;
    $string = '';
    for ($i = 0; $i < $largo; $i++) {
        $string .= $caracteres[rand(0, strlen($caracteres) - 1)];
    }
    return $string;
}
