<table>
    <thead>
    <tr>
        <th rowspan="2" style="background-color: #F2F2F2; border: 1px solid #404040; text-align: center; vertical-align: center; font-weight: bold">Nº</th>
        <th rowspan="2" style="background-color: #F2F2F2; border: 1px solid #404040; text-align: center; vertical-align: center; font-weight: bold">DEPORTES - MODALIDAD</th>
        <th colspan="3" style="background-color: #F2F2F2; border: 1px solid #404040; text-align: center; vertical-align: center; font-weight: bold">CLUBES</th>
    </tr>
    <tr>
        <th style="background-color: #F2F2F2; border: 1px solid #404040; text-align: center; vertical-align: center; font-weight: bold">Fem.</th>
        <th style="background-color: #F2F2F2; border: 1px solid #404040; text-align: center; vertical-align: center; font-weight: bold">Masc.</th>
        <th style="background-color: #F2F2F2; border: 1px solid #404040; text-align: center; vertical-align: center; font-weight: bold">TOTAL</th>
    </tr>
    </thead>
    <tbody>
    @foreach($deportes as $row)
        <tr>
            <td style="border: 1px solid #404040; vertical-align: center; text-align: center;">{{ ++$i }}</td>
            <td style="border: 1px solid #404040; vertical-align: center;">
                {{ \Illuminate\Support\Str::upper($row->deporte->deporte) }} -
                {{ \Illuminate\Support\Str::upper($row->categoria) }}</td>
            @php
                $femenino = \App\Models\ParticipacionDisciplina::where('id_deporte_oficial', $row->id)->whereNotNull('femenino')->where('femenino', '!=', 0)->count();
                $masculino = \App\Models\ParticipacionDisciplina::where('id_deporte_oficial', $row->id)->whereNotNull('masculino')->where('masculino', '!=', 0)->count();
                $totalFemenino = $totalFemenino + $femenino;
                $totalMasculino = $totalMasculino + $masculino;
            @endphp
            <td style="border: 1px solid #404040; vertical-align: center; text-align: center; font-weight: bold;">{{ $femenino }}</td>
            <td style="border: 1px solid #404040; vertical-align: center; text-align: center; font-weight: bold;">{{ $masculino }}</td>
            <td style="border: 1px solid #404040; vertical-align: center; text-align: center; font-weight: bold;">{{ $femenino + $masculino }}</td>
        </tr>
    @endforeach
    <tr>
        <td colspan="2" style="border: 1px solid #404040; vertical-align: center; text-align: center; font-weight: bold;">TOTALES</td>
        <td style="border: 1px solid #404040; vertical-align: center; text-align: center; font-weight: bold;">{{ $totalFemenino }}</td>
        <td style="border: 1px solid #404040; vertical-align: center; text-align: center; font-weight: bold;">{{ $totalMasculino }}</td>
        <td style="border: 1px solid #404040; vertical-align: center; text-align: center; font-weight: bold;">{{ $totalFemenino + $totalMasculino }}</td>
    </tr>
    </tbody>
</table>
