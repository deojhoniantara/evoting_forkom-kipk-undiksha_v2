@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
    <!-- Tambah Agenda -->
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg p-6 flex flex-col items-center justify-center cursor-pointer transition hover:shadow-xl hover:-translate-y-1 group hover:scale-105" onclick="window.location='{{ route('agendas.create') }}'">
        <div class="w-14 h-14 flex items-center justify-center rounded-full border-4 border-white bg-white/20 mb-3 group-hover:bg-white/40 transition animate-bounce">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
            </svg>
        </div>
        <span class="font-semibold text-white">Tambah Agenda</span>
        <span class="text-xs text-white/80 mt-1">Buat agenda baru</span>
    </div>
    <!-- Total Agenda (aktif) -->
    <div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col items-center justify-center cursor-pointer transition hover:shadow-xl hover:-translate-y-1 group hover:scale-105" onclick="window.location='{{ route('agendas.index') }}'">
        <div class="w-14 h-14 flex items-center justify-center rounded-full bg-blue-100 mb-3 group-hover:bg-blue-200 transition animate-pulse">
            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
        </div>
        <span class="font-semibold text-blue-600">Total Agenda</span>
        <span class="text-4xl font-bold mt-1 text-blue-500">{{ $totalAgendas ?? 0 }}</span>
        <span class="text-xs text-gray-400 mt-1">Semua agenda terdaftar</span>
    </div>
    <!-- Running -->
    <div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col items-center justify-center">
        <div class="w-14 h-14 flex items-center justify-center rounded-full bg-yellow-100 mb-3 animate-spin-slow">
            <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="8"/></svg>
        </div>
        <span class="font-semibold text-yellow-600">Running</span>
        <span class="text-4xl font-bold text-yellow-500 mt-1">{{ $ongoingAgendas ?? 0 }}</span>
        <span class="text-xs text-gray-400 mt-1">Agenda berjalan</span>
    </div>
    <!-- Completed -->
    <div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col items-center justify-center">
        <div class="w-14 h-14 flex items-center justify-center rounded-full bg-green-100 mb-3 animate-bounce-slow">
            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        </div>
        <span class="font-semibold text-green-600">Completed</span>
        <span class="text-4xl font-bold text-green-500 mt-1">{{ $finishedAgendas ?? 0 }}</span>
        <span class="text-xs text-gray-400 mt-1">Agenda selesai</span>
    </div>
</div>

<!-- Recent Activity -->
<div class="bg-white rounded-2xl shadow-lg p-8">
    <h2 class="text-xl font-bold text-gray-800 mb-6 sticky top-0 bg-white z-10">Recent Activity</h2>
    <div class="space-y-4">
        @forelse($recentVotes as $vote)
        <div class="flex items-center p-4 bg-gray-50 rounded-xl hover:bg-blue-100 transition-all duration-200 border-l-4 {{ $vote->candidate ? 'border-blue-500' : 'border-gray-300' }} animate-fade-in">
            <div class="flex-shrink-0">
                <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <div class="ml-5">
                <p class="text-base text-gray-600">
                    <span class="font-bold text-gray-700">{{ $vote->voter->identifier }}</span> telah melakukan pemilihan di <span class="font-semibold text-gray-800">{{ $vote->candidate->agenda->name ?? '-' }}</span>
                </p>
                <p class="text-xs text-gray-500 mt-1 flex items-center gap-2">
                    <span class="inline-block w-2 h-2 rounded-full {{ $vote->candidate ? 'bg-blue-500' : 'bg-gray-400' }}"></span>
                    {{ $vote->created_at->diffForHumans() }}
                </p>
            </div>
        </div>
        @empty
        <div class="text-center text-gray-400 py-6">
            Belum ada aktivitas voting
        </div>
        @endforelse
    </div>
</div>

@push('styles')
<style>
@keyframes spin-slow { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
.animate-spin-slow { animation: spin-slow 3s linear infinite; }
@keyframes bounce-slow { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-8px); } }
.animate-bounce-slow { animation: bounce-slow 2s infinite; }
@keyframes fade-in { from { opacity: 0; } to { opacity: 1; } }
.animate-fade-in { animation: fade-in 1s ease; }
</style>
@endpush
@endsection
