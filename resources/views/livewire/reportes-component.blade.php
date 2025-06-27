<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    @if($reporte == "general")
        {{ $this->table }}
    @endif

    @if($reporte == 'deporte')
        @foreach($listarDeportes as $deporte)
            @if($this->initTable('Deporte: '.$deporte->deporte, $deporte->id))
                {{ $this->table }}
                <br>
                <br>
            @endif
        @endforeach
    @endif

</div>
