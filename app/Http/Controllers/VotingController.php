<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Voter;
use App\Models\Candidate;
use App\Models\Vote;
use App\Models\Agenda;

class VotingController extends Controller
{
    public function showForm()
    {
        $agenda = Agenda::where('status', 'ongoing')->with('candidates')->first();
        return view('voting.form', compact('agenda'));
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'voting_code' => 'required|string',
        ]);

        $voter = Voter::where('voting_code', strtoupper($request->voting_code))
                     ->where('is_used', false)
                     ->first();

        if (!$voter) {
            return back()->with('error', 'Kode voting tidak valid atau sudah digunakan.');
        }

        return redirect()->route('vote.page', $voter->id);
    }

    public function showVotePage($voter_id)
    {
        $voter = Voter::findOrFail($voter_id);
        
        // Cek jika pemilih sudah memilih
        if ($voter->is_used) {
            return redirect()->route('voting.form')
                           ->with('error', 'Kode voting ini sudah digunakan.');
        }
    
        // Ambil agenda terkait yang sedang berlangsung
        $agenda = Agenda::where('status', 'ongoing')
                        ->whereHas('candidates', function ($query) {
                            $query->whereNotNull('id');
                        })->first();
    
        if (!$agenda) {
            return redirect()->route('voting.form')
                           ->with('error', 'Agenda tidak ditemukan atau sudah selesai.');
        }
    
        $candidates = Candidate::where('agenda_id', $agenda->id)->get();
        return view('voting.vote', compact('voter', 'candidates', 'agenda'));
    }

    public function submitVote(Request $request, $voter_id)
    {
        $voter = Voter::findOrFail($voter_id);

        // Cek lagi jika pemilih sudah memilih
        if ($voter->is_used) {
            return response()->json([
                'success' => false,
                'message' => 'Kode voting ini sudah digunakan.'
            ]);
        }

        $request->validate([
            'candidate_id' => 'required|exists:candidates,id',
        ]);

        // Buat vote dan update status pemilih
        Vote::create([
            'voter_id' => $voter->id,
            'candidate_id' => $request->candidate_id,
        ]);

        $voter->update(['is_used' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Terima kasih, suara Anda telah berhasil direkam.'
        ]);
    }
}

