@extends('layouts.admin')

@section('title', 'Agenda')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Statistik Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-blue-500 flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="4" y="4" width="16" height="16" rx="2"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 2v4m8-4v4"/></svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">Total Agenda</p>
                <h3 class="text-2xl font-bold text-blue-600">{{ $agendas->count() }}</h3>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-yellow-500 flex items-center gap-4">
            <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                <svg class="w-7 h-7 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="6"/></svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">Berjalan</p>
                <h3 class="text-2xl font-bold text-yellow-600">{{ $agendas->where('status','ongoing')->count() }}</h3>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-green-500 flex items-center gap-4">
            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">Selesai</p>
                <h3 class="text-2xl font-bold text-green-600">{{ $agendas->where('status','finished')->count() }}</h3>
            </div>
        </div>
    </div>
    <div class="flex flex-col sm:flex-row justify-between items-center mb-8 gap-4">
        <h1 class="text-3xl font-extrabold text-blue-600">Agenda</h1>
        <a href="{{ route('agendas.create') }}" class="bg-blue-500 text-white px-6 py-2 rounded-xl font-semibold shadow hover:bg-blue-600 transition flex items-center gap-2 hover:scale-105">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Agenda
        </a>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-8">
        @forelse($agendas as $agenda)
        <div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col relative group transition hover:shadow-xl hover:-translate-y-1 hover:scale-105 h-full overflow-hidden">
            <span class="absolute top-4 right-5 text-xs font-bold px-3 py-1 rounded-lg shadow flex items-center gap-1
                @if($agenda->status == 'draft') bg-gray-100 text-gray-600 @elseif($agenda->status == 'ongoing') bg-yellow-50 text-yellow-600 @else bg-green-50 text-green-600 @endif">
                @if($agenda->status == 'draft')
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2"/></svg> Belum Mulai
                @elseif($agenda->status == 'ongoing')
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="6"/></svg> Berjalan
                @else
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Selesai
                @endif
            </span>
            <div class="flex items-center justify-center mb-4">
                <div class="w-16 h-16 rounded-lg bg-blue-50 flex items-center justify-center">
                    <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/></svg>
                </div>
            </div>
            <div class="text-blue-500 font-bold text-lg leading-tight mb-1 break-words">{{ $agenda->name }}</div>
            <div class="text-gray-500 text-xs mb-4">{{ $agenda->created_at->format('d M Y') }}</div>
            <div class="flex gap-2 mt-auto flex-wrap">
                <a href="{{ route('agendas.show', $agenda) }}" class="bg-primary text-white font-bold rounded-lg py-1 px-2 text-xs text-center transition hover:bg-blue-700 flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m6 0a6 6 0 11-12 0 6 6 0 0112 0z"/></svg> Lihat</a>
                <a href="{{ route('agendas.edit', $agenda) }}" class="bg-yellow-400 text-white font-bold rounded-lg py-1 px-2 text-xs text-center transition hover:bg-yellow-500 flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 13h6m2 2a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v6z"/></svg> Edit</a>
                <form action="{{ route('agendas.destroy', $agenda) }}" method="POST" onsubmit="return confirm('Hapus agenda ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 text-white font-bold rounded-lg py-1 px-2 text-xs text-center transition hover:bg-red-600 flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg> Hapus</button>
                </form>
            </div>
        </div>
        @empty
        <div class="col-span-4 text-center text-gray-400 py-10">Belum ada agenda</div>
        @endforelse
    </div>
</div>
@endsection 