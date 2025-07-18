<div>
    {{-- The Master doesn't talk, he acts. --}}
    @foreach($listarDeportes as $deporte)
        <livewire:reporte-general-infolist-component
            title="{{ $deporte->deporte }}"
            id_deporte="{{ $deporte->id }}"
        />
        <br>
    @endforeach
</div>
