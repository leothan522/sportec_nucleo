<table>
    <!-- ========================================== -->
    <!-- CASO 1: SI SE SELECCIONÓ GENERAL          -->
    <!-- ========================================== -->
    @if($dataGeneral)
        <tr>
            <th colspan="4" style="font-weight: bold; text-align: center; font-size: 14px; background-color: #D3D3D3;">
                ESTADISTICA DE INSCRITOS
            </th>
        </tr>
        <tr>
            <th colspan="4" style="font-weight: bold; text-align: center; font-size: 12px; background-color: #D3D3D3;">
                CONSOLIDADO GENERAL
            </th>
        </tr>
        <tr><td colspan="4"></td></tr>

        <thead>
        <tr>
            <th style="border: 1px solid #000000; font-weight: bold; text-align: center; background-color: #EFEFEF;">CARGO</th>
            <th style="border: 1px solid #000000; font-weight: bold; text-align: center; background-color: #EFEFEF;">FEM</th>
            <th style="border: 1px solid #000000; font-weight: bold; text-align: center; background-color: #EFEFEF;">MAS</th>
            <th style="border: 1px solid #000000; font-weight: bold; text-align: center; background-color: #EFEFEF;">TOTAL</th>
        </tr>
        </thead>

        <tbody>
        @php $gFem = 0; $gMas = 0; @endphp
        @foreach($dataGeneral as $fila)
            @php
                $totalFila = $fila->fem_count + $fila->mas_count;
                $gFem += $fila->fem_count; $gMas += $fila->mas_count;
            @endphp
            <tr>
                <td style="border: 1px solid #000000; text-align: left;">{{ Str::upper($fila->cargo) }}</td>
                <td style="border: 1px solid #000000; text-align: right;">{{ $fila->fem_count }}</td>
                <td style="border: 1px solid #000000; text-align: right;">{{ $fila->mas_count }}</td>
                <td style="border: 1px solid #000000; text-align: right;">{{ $totalFila }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td style="border: 1px solid #000000; font-weight: bold; text-align: left;">TOTAL</td>
            <td style="border: 1px solid #000000; font-weight: bold; text-align: right;">{{ $gFem }}</td>
            <td style="border: 1px solid #000000; font-weight: bold; text-align: right;">{{ $gMas }}</td>
            <td style="border: 1px solid #000000; font-weight: bold; text-align: right;">{{ $gFem + $gMas }}</td>
        </tr>
        </tfoot>
    @endif

    <!-- ========================================== -->
    <!-- CASO 2: SI SE SELECCIONÓ UN CLUB ESPECÍFICO-->
    <!-- ========================================== -->
    @if(!empty($reportePorClub))
        @foreach($reportePorClub as $nombreClub => $cargosClub)
            <tr>
                <th colspan="4" style="font-weight: bold; text-align: center; font-size: 14px; background-color: #B0C4DE;">
                    ESTADISTICA DE INSCRITOS
                </th>
            </tr>
            <tr>
                <th colspan="4" style="font-weight: bold; text-align: center; font-size: 12px; background-color: #B0C4DE;">
                    CLUB: {{ Str::upper($nombreClub) }}
                </th>
            </tr>
            <tr><td colspan="4"></td></tr>

            <thead>
            <tr>
                <th style="border: 1px solid #000000; font-weight: bold; text-align: center; background-color: #EFEFEF;">CARGO</th>
                <th style="border: 1px solid #000000; font-weight: bold; text-align: center; background-color: #EFEFEF;">FEM</th>
                <th style="border: 1px solid #000000; font-weight: bold; text-align: center; background-color: #EFEFEF;">MAS</th>
                <th style="border: 1px solid #000000; font-weight: bold; text-align: center; background-color: #EFEFEF;">TOTAL</th>
            </tr>
            </thead>

            <tbody>
            @php $cFem = 0; $cMas = 0; @endphp
            @foreach($cargosClub as $fila)
                @php
                    $totalFilaClub = $fila->fem_count + $fila->mas_count;
                    $cFem += $fila->fem_count; $cMas += $fila->mas_count;
                @endphp
                <tr>
                    <td style="border: 1px solid #000000; text-align: left;">{{ Str::upper($fila->cargo) }}</td>
                    <td style="border: 1px solid #000000; text-align: right;">{{ $fila->fem_count }}</td>
                    <td style="border: 1px solid #000000; text-align: right;">{{ $fila->mas_count }}</td>
                    <td style="border: 1px solid #000000; text-align: right;">{{ $totalFilaClub }}</td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <td style="border: 1px solid #000000; font-weight: bold; text-align: left;">TOTAL CLUB</td>
                <td style="border: 1px solid #000000; font-weight: bold; text-align: right;">{{ $cFem }}</td>
                <td style="border: 1px solid #000000; font-weight: bold; text-align: right;">{{ $cMas }}</td>
                <td style="border: 1px solid #000000; font-weight: bold; text-align: right;">{{ $cFem + $cMas }}</td>
            </tr>
            </tfoot>
        @endforeach
    @endif
</table>
