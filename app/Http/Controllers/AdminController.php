<?php

namespace App\Http\Controllers;

use App\Models\Vote;
use App\Models\Voter;
use App\Models\Candidate;
use App\Models\Agenda;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalVoters = Voter::count();
        $totalVotes = Vote::count();
        $recentVotes = Vote::with(['voter', 'candidate'])->latest()->take(5)->get();
        $totalAgendas = Agenda::count();
        $ongoingAgendas = Agenda::where('status', 'ongoing')->count();
        $finishedAgendas = Agenda::where('status', 'finished')->count();
        return view('admin.dashboard', compact('totalVoters', 'totalVotes', 'recentVotes', 'totalAgendas', 'ongoingAgendas', 'finishedAgendas'));
    }

    public function statistics()
    {
        $agendas = \App\Models\Agenda::withCount(['candidates', 'voters'])->latest()->get();
        return view('admin.statistics', compact('agendas'));
    }

    public function voters()
    {
        $agendas = \App\Models\Agenda::withCount(['voters'])->latest()->get();
        return view('admin.voters', compact('agendas'));
    }

    public function votes()
    {
        $agendas = Agenda::withCount(['candidates', 'voters'])->latest()->get();
        return view('admin.votes', compact('agendas'));
    }

    public function votesByAgenda($agendaId)
    {
        $agenda = \App\Models\Agenda::with(['voters', 'candidates'])->findOrFail($agendaId);
        $votes = \App\Models\Vote::whereIn('voter_id', $agenda->voters->pluck('id'))
            ->with(['voter', 'candidate'])
            ->latest()
            ->get();
        return view('admin.votes_by_agenda', compact('agenda', 'votes'));
    }

    public function votersByAgenda($agendaId)
    {
        $agenda = \App\Models\Agenda::findOrFail($agendaId);
        $voters = $agenda->voters()->latest()->get();
        return view('admin.voter-management.by_agenda', compact('agenda', 'voters'));
    }
}

