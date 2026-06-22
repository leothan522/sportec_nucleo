<table>
    <thead>
    <tr>
        <th rowspan="2" style="background-color: #F2F2F2; border: 1px solid #404040; text-align: center; vertical-align: center; font-weight: bold">Nº</th>
        <th rowspan="2" style="background-color: #F2F2F2; border: 1px solid #404040; text-align: center; vertical-align: center; font-weight: bold">DEPORTES - MODALIDAD</th>
        @foreach($clubes as $club)
            <th colspan="2"
                style="background-color: #F2F2F2; border: 1px solid #404040; text-align: center; vertical-align: center; font-weight: bold">{{ \Illuminate\Support\Str::upper($club->short_nombre) }}</th>
        @endforeach
        <th colspan="2"
            style="background-color: #F2F2F2; border: 1px solid #404040; text-align: center; vertical-align: center; font-weight: bold">
            TOTALES
        </th>
        <th style="background-color: #F2F2F2; border: 1px solid #404040; text-align: center; vertical-align: center; font-weight: bold">
            ATLETAS
        </th>
    </tr>
    <tr>
        @foreach($clubes as $club)
            <th style="background-color: #F2F2F2; border: 1px solid #404040; text-align: center; vertical-align: center; font-weight: bold">
                Fem.
            </th>
            <th style="background-color: #F2F2F2; border: 1px solid #404040; text-align: center; vertical-align: center; font-weight: bold">
                Masc.
            </th>
        @endforeach
        <th style="background-color: #F2F2F2; border: 1px solid #404040; text-align: center; vertical-align: center; font-weight: bold">
            Fem.
        </th>
        <th style="background-color: #F2F2F2; border: 1px solid #404040; text-align: center; vertical-align: center; font-weight: bold">
            Masc.
        </th>
        <th style="background-color: #F2F2F2; border: 1px solid #404040; text-align: center; vertical-align: center; font-weight: bold">
            TOTAL
        </th>
    </tr>
    </thead>
    <tbody>
    @foreach($deportes as $row)
        <tr>
            <td style="border: 1px solid #404040; vertical-align: center; text-align: center;">{{ ++$i }}</td>
            <td style="border: 1px solid #404040; vertical-align: center;">
                {{ \Illuminate\Support\Str::upper($row->deporte->deporte) }} -
                {{ \Illuminate\Support\Str::upper($row->modalidad) }}</td>
            @foreach($clubes as $club)
                @php

                    /*$fem = '';
                    $masc = '';

                    $datos = \App\Models\ParticipacionClub::where('id_entidad', $club->id)->where('id_modalidad', $row->id)->first();
                    if ($datos){
                        if ($datos->num_atl_fem){
                            $fem = $datos->num_atl_fem;
                        }
                        if ($datos->num_atl_mas){
                            $masc = $datos->num_atl_mas;
                        }
                    }*/

                    /*$conteos = \App\Models\Atleta::query()
                    // Filtramos por el deporte y la modalidad de la FILA actual
                    ->where('id_deporte', $row->id_deporte)
                    ->where('id_modalidad', $row->id) // O $row->id_modalidad según tu base de datos
                    // Filtramos por la entidad del CLUB actual
                    ->whereHas('participante', function ($query) use ($club) {
                        $query->where('id_entidad', $club->id);
                    })
                    ->join('participantes', 'atletas.id_participante', '=', 'participantes.id')
                    ->select(
                        \Illuminate\Support\Facades\DB::raw("SUM(CASE WHEN participantes.sexo = '1' THEN 1 ELSE 0 END) as fem"),
                        \Illuminate\Support\Facades\DB::raw("SUM(CASE WHEN participantes.sexo = '0' THEN 1 ELSE 0 END) as masc")
                    )
                    ->first();*/

                    $conteos = \App\Models\Atleta::query()
                        // Filtramos por el deporte y la modalidad de la FILA actual
                        ->where('id_deporte', $row->id_deporte)
                        ->where('id_modalidad', $row->id)
                        // Hacemos el Join con participantes
                        ->join('participantes', 'atletas.id_participante', '=', 'participantes.id')
                        // Filtramos por la entidad del CLUB, que asista (asiste = 1) y manejamos el SoftDelete si aplica
                        ->where('participantes.id_entidad', $club->id)
                        ->where('participantes.asiste', 1)
                        ->whereNull('participantes.deleted_at') // Importante ya que el modelo Participante usa SoftDeletes
                        ->select(
                            \Illuminate\Support\Facades\DB::raw("SUM(CASE WHEN participantes.sexo = '1' THEN 1 ELSE 0 END) as fem"),
                            \Illuminate\Support\Facades\DB::raw("SUM(CASE WHEN participantes.sexo = '0' THEN 1 ELSE 0 END) as masc")
                        )
                        ->first();

                    $fem  = (int) ($conteos->fem ?? 0);
                    $masc = (int) ($conteos->masc ?? 0);

                @endphp
                <td style="border: 1px solid #404040; vertical-align: center; text-align: center;">{{ $fem > 0 ? $fem : '' }}</td>
                <td style="border: 1px solid #404040; vertical-align: center; text-align: center;">{{ $masc > 0 ? $masc : '' }}</td>
            @endforeach
            @php
                /*$femenino = \App\Models\ParticipacionClub::where('id_modalidad', $row->id)->sum('num_atl_fem');
                $masculino = \App\Models\ParticipacionClub::where('id_modalidad', $row->id)->sum('num_atl_mas');*/
                $femenino = \App\Models\Atleta::where('id_modalidad', $row->id)
                ->whereHas('participante', function ($query) {
                    $query->where('sexo', '1')
                    ->where('asiste', 1); // <-- Filtro de asistencia añadido
                })->count();

                $masculino = \App\Models\Atleta::where('id_modalidad', $row->id)
                    ->whereHas('participante', function ($query) {
                        $query->where('sexo', '0')
                        ->where('asiste', 1); // <-- Filtro de asistencia añadido
                    })->count();
                $totalFemenino = $totalFemenino + $femenino;
                $totalMasculino = $totalMasculino + $masculino;
            @endphp
            <td style="border: 1px solid #404040; vertical-align: center; text-align: center;">{{ $femenino }}</td>
            <td style="border: 1px solid #404040; vertical-align: center; text-align: center;">{{ $masculino }}</td>
            <td style="border: 1px solid #404040; vertical-align: center; text-align: center; font-weight: bold;">{{ $femenino + $masculino }}</td>
        </tr>
    @endforeach
    <tr>
        <td colspan="2"
            style="border: 1px solid #404040; vertical-align: center; text-align: center; font-weight: bold;">TOTALES
        </td>
        @foreach($clubes as $club)
            @php
                /*$femenino = \App\Models\ParticipacionClub::where('id_entidad', $club->id)->sum('num_atl_fem');
                $masculino = \App\Models\ParticipacionClub::where('id_entidad', $club->id)->sum('num_atl_mas');*/
            $femenino = \App\Models\Atleta::whereHas('participante', function ($query) use ($club) {
                $query->where('id_entidad', $club->id)->where('sexo', '1')->where('asiste', 1);
            })->count();

            $masculino = \App\Models\Atleta::whereHas('participante', function ($query) use ($club) {
                $query->where('id_entidad', $club->id)->where('sexo', '0')->where('asiste', 1);
            })->count();
            @endphp
            <td style="border: 1px solid #404040; vertical-align: center; text-align: center; font-weight: bold;">{{ $femenino }}</td>
            <td style="border: 1px solid #404040; vertical-align: center; text-align: center; font-weight: bold;">{{ $masculino }}</td>
        @endforeach
        <td style="border: 1px solid #404040; vertical-align: center; text-align: center; font-weight: bold;">{{ $totalFemenino }}</td>
        <td style="border: 1px solid #404040; vertical-align: center; text-align: center; font-weight: bold;">{{ $totalMasculino }}</td>
        <td style="border: 1px solid #404040; vertical-align: center; text-align: center; font-weight: bold;">{{ $totalFemenino + $totalMasculino }}</td>
    </tr>
    </tbody>
</table>
