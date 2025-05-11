<?php

namespace App\Http\Controllers;

use App\Models\Voter;
use App\Models\Agenda;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\VoterImport;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VoterManagementController extends Controller
{
    public function index()
    {
        $agendas = Agenda::withCount(['voters'])->latest()->get();
        return view('admin.voter-management.index', compact('agendas'));
    }

    public function create(Request $request)
    {
        $agendaId = $request->get('agenda_id');
        $agenda = $agendaId ? Agenda::findOrFail($agendaId) : null;
        return view('admin.voter-management.create', compact('agenda'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'identifier' => 'required|string|unique:voters,identifier',
            'agenda_id' => 'required|exists:agendas,id',
        ]);

        // Generate unique voting code
        do {
            $votingCode = strtoupper(Str::random(6)); // Generate 6 character code
        } while (Voter::where('voting_code', $votingCode)->exists());

        $voter = Voter::create([
            'name' => $request->name,
            'identifier' => $request->identifier,
            'voting_code' => $votingCode,
            'agenda_id' => $request->agenda_id,
        ]);

        return redirect()->route('admin.voters.by_agenda', $request->agenda_id)
            ->with('success', 'Pemilih berhasil ditambahkan dengan kode voting: ' . $votingCode);
    }

    public function export($agendaId)
    {
        $agenda = Agenda::findOrFail($agendaId); // Pastikan agenda ada
        $voters = Voter::where('agenda_id', $agendaId)->get(); // Filter voter berdasarkan agenda
    
        return view('admin.voter-management.export', compact('agenda', 'voters'));
    }

public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls', // Pastikan file adalah Excel
        'agenda_id' => 'required|exists:agendas,id', // Validasi agenda_id
    ]);

    $agenda = Agenda::findOrFail($request->agenda_id);

    // Import data
    Excel::import(new VoterImport($agenda), $request->file('file'));

    return redirect()->route('admin.voters.by_agenda', $request->agenda_id)
        ->with('success', 'Data pemilih berhasil diimpor.');
}
    public function destroy($id)
    {
        $voter = Voter::findOrFail($id);
        $agendaId = $voter->agenda_id; // Ambil agenda_id dari voter
        $voter->delete();

        return redirect()->route('admin.voters.by_agenda', $agendaId)
            ->with('success', 'Voter berhasil dihapus.');
    }

    public function exportExcel($agendaId)
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\VotersExport($agendaId), 'voters-agenda-' . $agendaId . '.xlsx');
    }
}