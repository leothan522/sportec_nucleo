<?php
//Funciones Personalizadas para el Proyecto

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
            $date = \Carbon\Carbon::now(env('APP_TIMEZONE', "America/Caracas"))->toDateString();
        }else{
            $date = \Carbon\Carbon::now(env('APP_TIMEZONE', "America/Caracas"))->format($format);
        }
    }else{
        if (is_null($format)){
            $date = \Carbon\Carbon::parse($fecha)->format("d/m/Y");
        }else{
            $date = \Carbon\Carbon::parse($fecha)->format($format);
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

function sweetAlert2(array $parametros = []): void
{
    session()->flash('sweetAlert2', $parametros);
}

function cerosIzquierda($cantidad, $cantCeros = 2): int|string
{
    if ($cantidad == 0) {
        return 0;
    }
    return str_pad($cantidad, $cantCeros, "0", STR_PAD_LEFT);
}

function verUtf8($string, $safeNull = false): string
{
    //$utf8_string = "Some UTF-8 encoded BATE QUEBRADO ÑñíÍÁÜ niño ó Ó string: é, ö, ü";
    $response = null;
    $text = 'NULL';
    if ($safeNull){
        $text = '';
    }
    if (!is_null($string)){
        $response = mb_convert_encoding($string, 'ISO-8859-1', 'UTF-8');
    }
    if (!is_null($response)){
        $text = "$response";
    }
    return $text;
}
