<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidate;

class VoteController extends Controller
{
    public function getResult()
    {
        $candidates = Candidate::withCount('votes')->get();
        $totalVotes = $candidates->sum('votes_count');

        return response()->json([
            'candidates' => $candidates,
            'totalVotes' => $totalVotes,
        ]);
    }

}
