<?php

namespace App\Imports;

use App\Models\Voter;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class VoterImport implements ToModel, WithHeadingRow
{
    protected $agenda;

    public function __construct($agenda)
    {
        $this->agenda = $agenda;
    }

    public function model(array $row)
    {
        // Lewati baris jika kolom 'name' atau 'identifier' kosong/null
        if (empty($row['name']) || empty($row['identifier'])) {
            return null;
        }
        // Generate unique voting code
        do {
            $votingCode = strtoupper(Str::random(6)); // Generate kode unik
        } while (Voter::where('voting_code', $votingCode)->exists());

        // Simpan voter dengan agenda_id
        return Voter::updateOrCreate(
            [
                'identifier' => $row['identifier'], // Unique field
                'agenda_id' => $this->agenda->id,
            ],
            [
                'name' => $row['name'],
                'voting_code' => $votingCode,
                'updated_at' => now(),
            ]
        );
    }
}