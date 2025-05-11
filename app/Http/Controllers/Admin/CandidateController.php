<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CandidateController extends Controller
{
    public function index()
    {
        $agendas = \App\Models\Agenda::withCount(['candidates'])->latest()->get();
        return view('admin.candidates.index', compact('agendas'));
    }

    public function create()
    {
        return view('admin.candidates.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'vision' => 'required|string',
            'mission' => 'required|string',
        ]);
    
        $data = $request->except('photo');
        
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = 'candidate-' . time() . '.' . $photo->getClientOriginalExtension();
            $photo->storeAs('public/images', $filename); // Simpan di direktori 'public/images'
            $data['photo'] = $filename; // Simpan nama file di database
        }
    
        Candidate::create($data);
    
        return redirect()->route('admin.candidates.index')
            ->with('success', 'Kandidat berhasil ditambahkan.');
    }

    public function edit(Candidate $candidate)
    {
        return view('admin.candidates.edit', compact('candidate'));
    }

    public function update(Request $request, Candidate $candidate)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'vision' => 'required|string',
            'mission' => 'required|string',
        ]);
    
        $data = $request->except('photo');
    
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($candidate->photo) {
                Storage::delete('public/images/' . $candidate->photo);
            }
    
            $photo = $request->file('photo');
            $filename = 'candidate-' . time() . '.' . $photo->getClientOriginalExtension();
            $photo->storeAs('public/images', $filename);
            $data['photo'] = $filename;
        }
    
        $candidate->update($data);
    
        return redirect()->route('admin.candidates.index')
            ->with('success', 'Data kandidat berhasil diperbarui.');
    }

    public function destroy(Candidate $candidate)
    {
        // Delete photo if exists
        if ($candidate->photo) {
            Storage::delete('public/images/' . $candidate->photo);
        }

        $candidate->delete();

        return redirect()->route('admin.candidates.index')
            ->with('success', 'Kandidat berhasil dihapus.');
    }

    public function toggleActive(Candidate $candidate)
    {
        $candidate->update([
            'is_active' => !$candidate->is_active
        ]);

        return redirect()->route('admin.candidates.index')
            ->with('success', 'Status kandidat berhasil diperbarui.');
    }

    public function byAgenda($agendaId)
    {
        $agenda = \App\Models\Agenda::findOrFail($agendaId);
        $candidates = $agenda->candidates()->latest()->get();
        return view('admin.candidates.by_agenda', compact('agenda', 'candidates'));
    }
} 