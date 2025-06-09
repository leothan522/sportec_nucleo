<?php

namespace App\Http\Controllers;

use App\Models\Atleta;
use App\Models\ModalidadDeportiva;
use App\Models\Participante;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function exportParticipante($id)
    {
        $participante = Participante::find($id);
        if (!$participante){
            return redirect('/dashboard/participantes');
        }

        //return view('export.participante_pdf');

        $sexo = $participante->sexo;
        $fecha_nacimiento = $participante->fecha_nacimiento;
        $id_cargo = $participante->id_cargo;
        $modalidades = ModalidadDeportiva::query();
        if ($sexo) {
            $modalidades->where('femenino', 1);
        } else {
            $modalidades->where('masculino', 1);
        }

        if ($fecha_nacimiento) {
            $modalidades->where('rango_minimo', '>=', $fecha_nacimiento)
                ->where('rango_maximo', '<=', $fecha_nacimiento);
        }

        if ($id_cargo != 4){
            $modalidades->where('id', -1);
        }

        $modalidades->whereRelation('deporte', 'en_uso', 1)
            ->where('puntuable', 1)
            ->where('en_practica', 1);

        $modalidades = $modalidades->get();

        $modalidades->each(function ($modalidad){
            $id_participante = $modalidad->id;
            $id_deporte = $modalidad->id_deporte;
            $id_modalidad = $modalidad->id;
            $atleta = Atleta::where('id_participante', $id_participante)
                ->where('id_deporte', $id_deporte)
                ->where('id_modalidad', $id_modalidad)
                ->first();
            if ($atleta) {
                return 'heroicon-m-check-circle';
            } else {
                return 'heroicon-o-stop';
            }
        });

        return Pdf::loadView('export.participante_pdf', [
            'participante' => $participante,
            'modalidades' => $modalidades,
        ])
            ->stream('Participante.pdf');
    }
}
