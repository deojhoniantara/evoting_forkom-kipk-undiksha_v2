@extends('layouts.admin')

@section('title', 'Edit Agenda')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Edit Agenda</h1>
    <form id="agendaForm" action="{{ route('agendas.update', $agenda) }}" method="POST" enctype="multipart/form-data" class="max-w-3xl mx-auto">
        @csrf
        @method('PUT')
        <div class="bg-white rounded-xl shadow-lg p-8 mb-6">
            <h2 class="text-lg font-semibold mb-4 text-primary">Data Agenda</h2>
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Agenda</label>
                <textarea name="name" id="name" rows="3" class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-primary focus:border-primary sm:text-sm" required>{{ old('name', $agenda->name) }}</textarea>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-8 mb-6">
            <h2 class="text-lg font-semibold mb-4 text-primary">Data Kandidat</h2>
            <div id="candidates-list">
                @foreach($agenda->candidates as $i => $candidate)
                <div class='border rounded p-4 mb-4 bg-gray-50 relative'>
                    <button type='button' class='absolute top-2 right-2 text-red-500' onclick='this.parentElement.remove()'>Hapus</button>
                    <div class='mb-2'><label>Nama Kandidat</label><input type='text' name='candidates[{{ $i }}][name]' value='{{ $candidate->name }}' class='block w-full rounded border-gray-300' required></div>
                    <div class='mb-2'><label>Visi</label><textarea name='candidates[{{ $i }}][vision]' class='block w-full rounded border-gray-300' required>{{ $candidate->vision }}</textarea></div>
                    <div class='mb-2'><label>Misi</label><textarea name='candidates[{{ $i }}][mission]' class='block w-full rounded border-gray-300' required>{{ $candidate->mission }}</textarea></div>
                    <div class='mb-2'><label>Foto</label><input type='file' name='candidates[{{ $i }}][photo]' accept='image/*' class='block w-full'></div>
                </div>
                @endforeach
            </div>
            <button type="button" class="bg-accent hover:bg-primary/80 text-white px-3 py-1 rounded mb-4" onclick="addCandidate()">+ Tambah Kandidat</button>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-8 mb-6">
            <h2 class="text-lg font-semibold mb-4 text-primary">Data Voter</h2>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Tambah Voter</label>
                <button type="button" class="bg-accent hover:bg-primary/80 text-white px-3 py-1 rounded mb-2" onclick="addVoterRow()">+ Tambah Voter Manual</button>
                <div id="voters-list">
                    @foreach($agenda->voters as $j => $voter)
                    <div class='flex gap-2 mb-2'>
                        <input type='text' name='voters_manual[{{ $j }}][name]' value='{{ $voter->name }}' placeholder='Nama' class='rounded border-gray-300' required>
                        <input type='text' name='voters_manual[{{ $j }}][identifier]' value='{{ $voter->identifier }}' placeholder='Identifier' class='rounded border-gray-300' required>
                        <button type='button' class='text-red-500' onclick='this.parentElement.remove()'>Hapus</button>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Import Excel</label>
                <input type="file" name="voters_excel" accept=".xlsx,.xls" class="block w-full text-sm text-gray-500">
                <p class="text-xs text-gray-500 mt-1">Format: Nama, Identifier</p>
            </div>
        </div>
        <div class="flex justify-end">

        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded shadow">Simpan Perubahan </button>
    
        </div>
    </form>
</div>
<script>
let candidateCount = {{ count($agenda->candidates) }};
let voterCount = {{ count($agenda->voters) }};
function addCandidate() {
    candidateCount++;
    const html = `<div class='border rounded p-4 mb-4 bg-gray-50 relative'>
        <button type='button' class='absolute top-2 right-2 text-red-500' onclick='this.parentElement.remove()'>Hapus</button>
        <div class='mb-2'><label>Nama Kandidat</label><input type='text' name='candidates[${candidateCount}][name]' class='block w-full rounded border-gray-300' required></div>
        <div class='mb-2'><label>Visi</label><textarea name='candidates[${candidateCount}][vision]' class='block w-full rounded border-gray-300' required></textarea></div>
        <div class='mb-2'><label>Misi</label><textarea name='candidates[${candidateCount}][mission]' class='block w-full rounded border-gray-300' required></textarea></div>
        <div class='mb-2'><label>Foto</label><input type='file' name='candidates[${candidateCount}][photo]' accept='image/*' class='block w-full'></div>
    </div>`;
    document.getElementById('candidates-list').insertAdjacentHTML('beforeend', html);
}
function addVoterRow() {
    voterCount++;
    const html = `<div class='flex gap-2 mb-2'>
        <input type='text' name='voters_manual[${voterCount}][name]' placeholder='Nama' class='rounded border-gray-300' required>
        <input type='text' name='voters_manual[${voterCount}][identifier]' placeholder='Identifier' class='rounded border-gray-300' required>
        <button type='button' class='text-red-500' onclick='this.parentElement.remove()'>Hapus</button>
    </div>`;
    document.getElementById('voters-list').insertAdjacentHTML('beforeend', html);
}
</script>
@endsection 