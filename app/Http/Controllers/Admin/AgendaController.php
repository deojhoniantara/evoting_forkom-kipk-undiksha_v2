<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Agenda;
use App\Models\Candidate;
use App\Models\Voter;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AgendaController extends Controller
{
    public function index()
    {
        $agendas = Agenda::withCount(['candidates', 'voters'])->latest()->get();
        return view('admin.agendas.index', compact('agendas'));
    }

    public function create()
    {
        $voters = Voter::all();
        return view('admin.agendas.create', compact('voters'));
    }

    public function store(Request $request)
    {
        // Validasi nama agenda
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Simpan agenda
        $agenda = Agenda::create([
            'name' => $request->name,
            'status' => 'draft',
            'detail' => $request->detail,
        ]);

        // Simpan kandidat
        if ($request->has('candidates')) {
            foreach ($request->candidates as $candidateData) {
                $data = [
                    'agenda_id' => $agenda->id,
                    'name' => $candidateData['name'],
                    'vision' => $candidateData['vision'],
                    'mission' => $candidateData['mission'],
                ];
                // Proses upload foto jika ada
                if (isset($candidateData['photo']) && $candidateData['photo']) {
                    $photo = $candidateData['photo'];
                    $filename = 'candidate-' . time() . '-' . uniqid() . '.' . $photo->getClientOriginalExtension();
                    $photo->storeAs('public/images', $filename);
                    $data['photo'] = $filename;
                }
                Candidate::create($data);
            }
        }

        // Simpan voter manual
        if ($request->has('voters_manual')) {
            $voterIds = [];
            foreach ($request->voters_manual as $row) {
                if (isset($row[0]) && isset($row[1])) {
                    $voter = Voter::firstOrCreate(
                        [
                            'identifier' => $row[0],
                        ],
                        [
                            'name' => $row[1],
                            'voting_code' => strtoupper(\Str::random(6)),
                            'agenda_id' => $agenda->id, // Langsung isi agenda_id dari agenda yang baru dibuat
                        ]
                    );
                    $voterIds[] = $voter->id;
                }
            }
            
        }

        // Import voter dari excel jika ada
        if ($request->hasFile('voters_excel')) {
            $file = $request->file('voters_excel');
            $imported = \Maatwebsite\Excel\Facades\Excel::toCollection(null, $file)[0];
            $voterIds = [];
            foreach ($imported as $row) {
                if (isset($row[0]) && isset($row[1])) {
                    $voter = Voter::firstOrCreate(
                        [
                            'identifier' => $row[0],
                        ],
                        [
                            'name' => $row[1],
                            'voting_code' => strtoupper(\Str::random(6)),
                            'agenda_id' => $agenda->id, // Langsung isi agenda_id dari agenda yang baru dibuat
                        ]
                    );
                    $voterIds[] = $voter->id;
                }
            }
        }

        return redirect()->route('agendas.index')->with('success', 'Agenda dan voter berhasil ditambahkan.');
    }

    public function exportVoters($agendaId)
    {
        $voters = Voter::where('agenda_id', $agendaId)->get();

        // Gunakan library Excel untuk mengekspor data
        return Excel::download(new VotersExport($voters), 'voters-agenda-' . $agendaId . '.xlsx');
    }

    public function show(Agenda $agenda, \Illuminate\Http\Request $request)
    {
        $tab = $request->get('tab', 'candidate');
        $agenda->load(['candidates', 'voters']);
        $votes = null;
        if ($tab === 'votes') {
            $votes = \App\Models\Vote::whereIn('voter_id', $agenda->voters->pluck('id'))->with(['voter', 'candidate'])->latest()->get();
        }
        return view('admin.agendas.show', compact('agenda', 'tab', 'votes'));
    }

    public function edit(Agenda $agenda)
    {
        $voters = Voter::all();
        $agenda->load('voters');
        return view('admin.agendas.edit', compact('agenda', 'voters'));
    }

    public function update(Request $request, Agenda $agenda)
    {   

        $request->validate([
            'name' => 'required|string| max:255', // Validasi agenda_id
            'voters_excel' => 'nullable|file|mimes:xlsx,xls',
        ]);
        $agenda->update([
            'name' => $request->name,
            'detail' => $request->detail,
        ]);

        // Update kandidat: hapus semua kandidat lama, lalu tambah ulang dari input
        $agenda->candidates()->delete();
        if ($request->has('candidates')) {
            foreach ($request->candidates as $candidateData) {
                $data = [
                    'agenda_id' => $agenda->id,
                    'name' => $candidateData['name'],
                    'vision' => $candidateData['vision'],
                    'mission' => $candidateData['mission'],
                ];
                if (isset($candidateData['photo']) && $candidateData['photo']) {
                    $photo = $candidateData['photo'];
                    $filename = 'candidate-' . time() . '-' . uniqid() . '.' . $photo->getClientOriginalExtension();
                    $photo->storeAs('public/images', $filename);
                    $data['photo'] = $filename;
                }
                Candidate::create($data);
            }
        }

        // Update voter: hapus semua relasi voter lama, lalu tambah ulang dari input manual/import
        $agenda->voters()->delete();
        $voterIds = [];
        if ($request->has('voters_manual')) {
            foreach ($request->voters_manual as $voterData) {
                $voter = Voter::firstOrCreate([
                    'identifier' => $voterData['identifier'],
                ], [
                    'name' => $voterData['name'],
                    'voting_code' => strtoupper(\Str::random(6)),
                    'agenda_id' => $agenda->id,
                ]);
                $voterIds[] = $voter->id;
            }
        }
        if ($request->hasFile('voters_excel')) {
            $file = $request->file('voters_excel');
            $imported = \Maatwebsite\Excel\Facades\Excel::toCollection(null, $file)[0];
            foreach ($imported as $row) {
                if (isset($row[0]) && isset($row[1])) {
                    $voter = Voter::firstOrCreate(
                        [
                            'identifier' => $row[0],
                        ],
                        [
                            'name' => $row[1],
                            'voting_code' => strtoupper(\Str::random(6)),
                            'agenda_id' => $agenda->id, // Pastikan $agenda->id ada nilainya
                        ]
                    );
                    $voterIds[] = $voter->id;
                }
            }
        }
        // $agenda->voters()->syncWithoutDetaching($voterIds);

        return redirect()->route('agendas.index')->with('success', 'Agenda berhasil diperbarui.');
    }

    public function destroy(Agenda $agenda)
    {
        $agenda->delete();
        return redirect()->route('agendas.index')->with('success', 'Agenda berhasil dihapus.');
    }

    public function start(Agenda $agenda)
    {
        $agenda->start();
        return redirect()->route('agendas.show', $agenda)->with('success', 'Agenda dimulai!');
    }

    public function finish(Agenda $agenda)
    {
        $agenda->finish();
        return redirect()->route('agendas.show', $agenda)->with('success', 'Agenda diselesaikan!');
    }

    public function result(Agenda $agenda)
    {
        $agenda->load(['candidates.votes', 'voters', 'votes']);
        return view('admin.agendas.result', compact('agenda'));
    }
}