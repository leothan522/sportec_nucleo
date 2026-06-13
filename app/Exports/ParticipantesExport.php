<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ParticipantesExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new ResumenParticipantes(),
            new QuorumParticipantes()
        ];
    }
}
