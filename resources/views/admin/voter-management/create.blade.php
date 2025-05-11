@extends('layouts.admin')

@section('title', 'Tambah Voter')

@section('content')
<div class="mb-8">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl md:text-4xl font-extrabold text-primary mb-2">Tambah Voter</h1>
            <p class="text-gray-600">
                @if($agenda)
                    Tambah voter untuk agenda: {{ $agenda->name }}
                @else
                    Tambah voter baru
                @endif
            </p>
        </div>
        <a href="{{ $agenda ? route('admin.voters.by_agenda', $agenda->id) : route('admin.voter-management.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg shadow hover:bg-gray-600 transition">Kembali</a>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm p-6">
    <form action="{{ route('admin.voter-management.store') }}" method="POST">
        @csrf
        @if($agenda)
            <input type="hidden" name="agenda_id" value="{{ $agenda->id }}">
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="identifier" class="block text-sm font-medium text-gray-700 mb-2">NIM</label>
                <input type="text" name="identifier" id="identifier" value="{{ old('identifier') }}" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary @error('identifier') border-red-500 @enderror">
                @error('identifier')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg shadow hover:bg-accent transition">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection 