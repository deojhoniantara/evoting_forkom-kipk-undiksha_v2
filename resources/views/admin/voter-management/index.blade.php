@extends('layouts.admin')

@section('title', 'Voter Management')

@section('content')
<div class="mb-8 text-center">
    <div class="flex flex-col items-center justify-center mb-2">
        <span class="text-4xl text-primary mb-2"><svg class='w-8 h-8' fill='none' stroke='currentColor' viewBox='0 0 24 24'><rect x='3' y='7' width='18' height='13' rx='2'/><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M16 3v4M8 3v4'/></svg></span>
        <h1 class="text-3xl md:text-4xl font-extrabold text-primary">Voter Management</h1>
    </div>
    <p class="text-gray-600">Pilih agenda untuk mengelola data voter</p>
</div>

<div class="space-y-6 max-w-2xl mx-auto">
    @foreach($agendas as $agenda)
    <div class="flex flex-col md:flex-row md:items-center md:justify-between bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border-l-4 @if($agenda->status=='draft') border-gray-300 @elseif($agenda->status=='ongoing') border-yellow-400 @else border-green-500 @endif">
        <div class="mb-4 md:mb-0">
            <div class="text-lg font-bold text-primary mb-1">{{ $agenda->name }}</div>
            <div class="text-sm text-gray-500 flex items-center gap-2">
                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-primary/10 text-primary text-xs font-semibold"><svg class='w-4 h-4' fill='none' stroke='currentColor' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M16 12H8m8 0a4 4 0 11-8 0 4 4 0 018 0zm0 0v4m0-4V8'/></svg> {{ $agenda->voters_count }} Voter</span>
                <span class="mx-2">•</span>
                Status:
                @if($agenda->status == 'draft')
                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-gray-200 text-gray-700 text-xs font-semibold"><svg class='w-4 h-4' fill='none' stroke='currentColor' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 6v6l4 2'/></svg> Belum Mulai</span>
                @elseif($agenda->status == 'ongoing')
                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold"><svg class='w-4 h-4' fill='none' stroke='currentColor' viewBox='0 0 24 24'><circle cx='12' cy='12' r='6'/></svg> Berjalan</span>
                @else
                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold"><svg class='w-4 h-4' fill='none' stroke='currentColor' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M5 13l4 4L19 7'/></svg> Selesai</span>
                @endif
            </div>
        </div>
        <a href="{{ route('admin.voters.by_agenda', $agenda->id) }}" class="bg-primary hover:bg-primary/90 text-white px-6 py-2 rounded-xl font-bold shadow flex items-center gap-2 transition hover:scale-105">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m6 0a6 6 0 11-12 0 6 6 0 0112 0z"/></svg>
            Kelola Voter
        </a>
    </div>
    @endforeach
    @if($agendas->isEmpty())
    <div class="text-center text-gray-400 py-8 flex flex-col items-center gap-2">
        <span class="text-5xl"><svg class='w-10 h-10' fill='none' stroke='currentColor' viewBox='0 0 24 24'><rect x='3' y='7' width='18' height='13' rx='2'/><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M16 3v4M8 3v4'/></svg></span>
        <span>Belum ada agenda</span>
    </div>
    @endif
</div>
@endsection