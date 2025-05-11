<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VotingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VoterManagementController;
use App\Http\Controllers\Admin\CandidateController;
use App\Http\Controllers\Admin\VoteController;
use App\Http\Controllers\Admin\AgendaController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Redirect dari root ke /voting
Route::get('/', function () {
    return redirect()->route('voting.form');
});

// Voting Routes
Route::get('/voting', [VotingController::class, 'showForm'])->name('voting.form');
Route::post('/voting/verify', [VotingController::class, 'verifyCode'])->name('verify.code');
Route::get('/voting/{voter}', [VotingController::class, 'showVotePage'])->name('vote.page');
Route::post('/voting/{voter}', [VotingController::class, 'submitVote'])->name('submit.vote');
Route::get('/thank-you', function () {
    return view('voting.thank-you');
})->name('thank.you');

// Admin Routes
Route::middleware(['auth', 'admin'])->group(function () {
    // Dashboard
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/statistics', [AdminController::class, 'statistics'])->name('admin.statistics');
    
    // Voters
    Route::get('/admin/voters', [AdminController::class, 'voters'])->name('admin.voters');
    Route::get('/admin/voters/{agenda}', [AdminController::class, 'votersByAgenda'])->name('admin.voters.by_agenda');
    
    // Votes
    Route::get('/admin/votes', [AdminController::class, 'votes'])->name('admin.votes');
    Route::get('/vote-result', [VoteController::class, 'getResult'])->name('vote.result');
    Route::get('/admin/votes/{agenda}', [AdminController::class, 'votesByAgenda'])->name('admin.votes.by_agenda');

    // Voter Management
    Route::prefix('admin/voter-management')->name('admin.voter-management.')->group(function () {
        Route::get('/', [VoterManagementController::class, 'index'])->name('index');
        Route::get('/create', [VoterManagementController::class, 'create'])->name('create');
        Route::post('/store', [VoterManagementController::class, 'store'])->name('store');
        Route::post('/import', [VoterManagementController::class, 'import'])->name('import');
        Route::get('/export/{agendaId}', [VoterManagementController::class, 'export'])->name('export');
        Route::delete('/{id}', [VoterManagementController::class, 'destroy'])->name('destroy');
        Route::get('/export-excel/{agendaId}', [VoterManagementController::class, 'exportExcel'])->name('export-excel');
    });
    
    Route::resource('candidates', CandidateController::class);
    Route::patch('candidates/{candidate}/toggle-active', [CandidateController::class, 'toggleActive'])
        ->name('admin.candidates.toggle-active');
    Route::get('/admin/candidates', [CandidateController::class, 'index'])->name('admin.candidates.index');
    Route::get('/candidates/create', [CandidateController::class, 'create'])->name('admin.candidates.create');
    Route::post('/candidates', [CandidateController::class, 'store'])->name('admin.candidates.store');
    Route::get('/candidates/{candidate}/edit', [CandidateController::class, 'edit'])->name('admin.candidates.edit');
    Route::put('/candidates/{candidate}', [CandidateController::class, 'update'])->name('admin.candidates.update');
    Route::delete('/candidates/{candidate}', [CandidateController::class, 'destroy'])->name('admin.candidates.destroy');
    Route::get('/admin/candidates/{agenda}', [CandidateController::class, 'byAgenda'])->name('admin.candidates.by_agenda');

    Route::resource('agendas', AgendaController::class);
    Route::post('agendas/{agenda}/start', [AgendaController::class, 'start'])->name('agendas.start');
    Route::post('agendas/{agenda}/finish', [AgendaController::class, 'finish'])->name('agendas.finish');
    Route::get('agendas/{agenda}/result', [AgendaController::class, 'result'])->name('agendas.result');
    Route::get('agendas/{agenda}/voters', [AgendaController::class, 'voters'])->name('agendas.voters');

});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


