<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WebController extends Controller
{
    public function consultarParticipante($cedula)
    {
        return 'Cedula: '.$cedula;
    }
}
