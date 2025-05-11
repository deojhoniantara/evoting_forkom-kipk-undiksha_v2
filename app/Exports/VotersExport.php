<?php

namespace App\Exports;

use App\Models\Voter;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VotersExport implements FromCollection, WithHeadings
{
    protected $agendaId;

    public function __construct($agendaId)
    {
        $this->agendaId = $agendaId;
    }

    public function collection()
    {
        return Voter::where('agenda_id', $this->agendaId)
            ->select('name', 'identifier', 'voting_code')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Name',
            'Identifier',
            'Voting Code',
        ];
    }
} 