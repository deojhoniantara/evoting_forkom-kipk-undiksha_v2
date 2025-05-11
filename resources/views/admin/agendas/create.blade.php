@extends('layouts.admin')

@section('title', 'Tambah Agenda')

@section('content')
<div class="max-w-3xl mx-auto py-8">
    <div class="bg-white rounded-2xl shadow-2xl p-8 mb-8">
        <div class="flex items-center gap-3 mb-6">
            <span class="text-3xl text-primary">🗓️</span>
            <h1 class="text-2xl md:text-3xl font-extrabold text-primary">Tambah Agenda</h1>
        </div>
        <!-- Step Indicator -->
        <div class="flex items-center justify-center mb-10">
            <div class="flex items-center w-full max-w-2xl">
                <div class="step-indicator flex-1 flex flex-col items-center" id="indicator-1">
                    <div class="w-12 h-12 flex items-center justify-center rounded-full border-4 border-primary bg-white font-bold text-primary step-circle text-lg shadow transition-all duration-300">1</div>
                    <span class="mt-2 text-sm font-bold text-primary">Agenda</span>
                </div>
                <div class="flex-1 h-1 bg-primary mx-2"></div>
                <div class="step-indicator flex-1 flex flex-col items-center" id="indicator-2">
                    <div class="w-12 h-12 flex items-center justify-center rounded-full border-4 border-gray-300 bg-white font-bold text-gray-400 step-circle text-lg shadow transition-all duration-300">2</div>
                    <span class="mt-2 text-sm font-bold text-gray-400">Kandidat</span>
                </div>
                <div class="flex-1 h-1 bg-primary mx-2"></div>
                <div class="step-indicator flex-1 flex flex-col items-center" id="indicator-3">
                    <div class="w-12 h-12 flex items-center justify-center rounded-full border-4 border-gray-300 bg-white font-bold text-gray-400 step-circle text-lg shadow transition-all duration-300">3</div>
                    <span class="mt-2 text-sm font-bold text-gray-400">Voter</span>
                </div>
            </div>
        </div>
        <form id="agendaForm" action="{{ route('agendas.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div id="stepper">
                <!-- Step 1: Nama Agenda -->
                <div class="step transition-all duration-500" id="step-1">
                    <div class="bg-gray-50 rounded-xl shadow p-8 mb-4 animate-fade-in">
                        <h2 class="text-lg font-bold mb-4 text-primary flex items-center gap-2">1. Data Agenda</h2>
                        <div class="mb-6">
                            <label for="name" class="block text-base font-bold text-gray-700 mb-2">Nama Agenda</label>
                            <textarea name="name" id="name" rows="3" class="block w-full rounded-xl border-2 border-gray-200 shadow-sm focus:ring-primary focus:border-primary focus:bg-white/50 sm:text-base transition" required>{{ old('name') }}</textarea>
                        </div>
                        <div class="flex justify-end">
                            <button type="button" class="bg-primary hover:bg-primary/90 text-white px-8 py-2 rounded-xl shadow font-bold text-base flex items-center gap-2 transition hover:scale-105" onclick="validateStep1()">
                                Selanjutnya <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Step 2: Kandidat -->
                <div class="step hidden transition-all duration-500" id="step-2">
                    <div class="bg-gray-50 rounded-xl shadow p-8 mb-4 animate-fade-in">
                        <h2 class="text-lg font-bold mb-4 text-primary flex items-center gap-2">2. Data Kandidat</h2>
                        <div id="candidates-list"></div>
                        <button type="button" class="bg-accent hover:bg-primary/80 text-white px-4 py-2 rounded-xl mb-4 font-bold flex items-center gap-2 transition hover:scale-105" onclick="addCandidate()">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Tambah Kandidat
                        </button>
                        <div class="flex justify-between mt-6">
                            <button type="button" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-8 py-2 rounded-xl shadow font-bold flex items-center gap-2 transition hover:scale-105" onclick="nextStep(1)"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg> Kembali</button>
                            <button type="button" class="bg-primary hover:bg-primary/90 text-white px-8 py-2 rounded-xl shadow font-bold flex items-center gap-2 transition hover:scale-105" onclick="validateStep2()">Selanjutnya <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></button>
                        </div>
                    </div>
                </div>
                <!-- Step 3: Voter -->
                <div class="step hidden transition-all duration-500" id="step-3">
                    <div class="bg-gray-50 rounded-xl shadow p-8 mb-4 animate-fade-in">
                        <h2 class="text-lg font-bold mb-4 text-primary flex items-center gap-2">3. Data Voter</h2>
                        <div class="mb-4">
                            <label class="block text-base font-bold text-gray-700 mb-2">Tambah Voter</label>
                            <button type="button" class="bg-accent hover:bg-primary/80 text-white px-4 py-2 rounded-xl mb-2 font-bold flex items-center gap-2 transition hover:scale-105" onclick="addVoterRow()">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                Tambah Voter Manual
                            </button>
                            <div id="voters-list"></div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-base font-bold text-gray-700 mb-2">Import Excel</label>
                            <input type="file" name="voters_excel" accept=".xlsx,.xls" class="block w-full text-sm text-gray-500 rounded-xl border-2 border-gray-200 focus:border-primary focus:ring-primary transition">
                            <p class="text-xs text-gray-500 mt-1">Format: Nama, Identifier</p>
                        </div>
                        <div class="flex justify-between mt-6">
                            <button type="button" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-8 py-2 rounded-xl shadow font-bold flex items-center gap-2 transition hover:scale-105" onclick="nextStep(2)"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg> Kembali</button>
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-8 py-2 rounded-xl shadow font-bold flex items-center gap-2 transition hover:scale-105"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Simpan Agenda</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
.step-indicator .step-circle {
    border-width: 4px;
    transition: all 0.3s;
}
.step-indicator.active .step-circle {
    background: #4576D3;
    color: #fff;
    border-color: #4576D3;
}
.step-indicator.active span {
    color: #4576D3;
}
.animate-fade-in {
    animation: fadeIn 0.4s;
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
@endpush

@push('scripts')
<script>
let candidateCount = 0;
let voterCount = 0;
function nextStep(step) {
    document.querySelectorAll('.step').forEach(s => s.classList.add('hidden'));
    document.getElementById('step-' + step).classList.remove('hidden');
    updateIndicator(step);
}
function updateIndicator(step) {
    for (let i = 1; i <= 3; i++) {
        const indicator = document.getElementById('indicator-' + i);
        if (i < step) {
            indicator.classList.add('active');
            indicator.querySelector('.step-circle').classList.add('bg-primary', 'text-white', 'border-primary');
            indicator.querySelector('span').classList.add('text-primary');
        } else if (i === step) {
            indicator.classList.add('active');
            indicator.querySelector('.step-circle').classList.add('bg-primary', 'text-white', 'border-primary');
            indicator.querySelector('span').classList.add('text-primary');
        } else {
            indicator.classList.remove('active');
            indicator.querySelector('.step-circle').classList.remove('bg-primary', 'text-white', 'border-primary');
            indicator.querySelector('span').classList.remove('text-primary');
        }
    }
}
function validateStep1() {
    const name = document.getElementById('name').value.trim();
    if (!name) {
        alert('Nama agenda wajib diisi!');
        return;
    }
    nextStep(2);
}
function validateStep2() {
    const candidates = document.querySelectorAll('#candidates-list input[name^="candidates"], #candidates-list textarea[name^="candidates"]');
    if (candidates.length === 0) {
        alert('Minimal 1 kandidat harus diisi!');
        return;
    }
    let valid = true;
    candidates.forEach(el => { if (!el.value.trim()) valid = false; });
    if (!valid) {
        alert('Semua field kandidat wajib diisi!');
        return;
    }
    nextStep(3);
}
function addCandidate() {
    candidateCount++;
    const html = `<div class='border-2 border-primary/30 rounded-xl p-4 mb-4 bg-white shadow relative flex flex-col gap-2'>
        <button type='button' class='absolute top-2 right-2 text-red-500 hover:bg-red-100 rounded-full p-1' title='Hapus' onclick='this.parentElement.remove()'><svg class='w-5 h-5' fill='none' stroke='currentColor' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M6 18L18 6M6 6l12 12'/></svg></button>
        <div><label class='font-bold text-gray-700'>Nama Kandidat</label><input type='text' name='candidates[${candidateCount}][name]' class='block w-full rounded-xl border-2 border-gray-200 focus:border-primary focus:ring-primary transition' required></div>
        <div><label class='font-bold text-gray-700'>Visi</label><textarea name='candidates[${candidateCount}][vision]' class='block w-full rounded-xl border-2 border-gray-200 focus:border-primary focus:ring-primary transition' required></textarea></div>
        <div><label class='font-bold text-gray-700'>Misi</label><textarea name='candidates[${candidateCount}][mission]' class='block w-full rounded-xl border-2 border-gray-200 focus:border-primary focus:ring-primary transition' required></textarea></div>
        <div><label class='font-bold text-gray-700'>Foto</label><input type='file' name='candidates[${candidateCount}][photo]' accept='image/*' class='block w-full rounded-xl border-2 border-gray-200 focus:border-primary focus:ring-primary transition'></div>
    </div>`;
    document.getElementById('candidates-list').insertAdjacentHTML('beforeend', html);
}
function addVoterRow() {
    voterCount++;
    const html = `<div class='flex gap-2 mb-2 items-center'>
        <input type='text' name='voters_manual[${voterCount}][name]' placeholder='Nama' class='rounded-xl border-2 border-gray-200 focus:border-primary focus:ring-primary transition' required>
        <input type='text' name='voters_manual[${voterCount}][identifier]' placeholder='Identifier' class='rounded-xl border-2 border-gray-200 focus:border-primary focus:ring-primary transition' required>
        <button type='button' class='text-red-500 hover:bg-red-100 rounded-full p-1' title='Hapus' onclick='this.parentElement.remove()'><svg class='w-5 h-5' fill='none' stroke='currentColor' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M6 18L18 6M6 6l12 12'/></svg></button>
    </div>`;
    document.getElementById('voters-list').insertAdjacentHTML('beforeend', html);
}
// Inisialisasi step awal
updateIndicator(1);
</script>
@endpush
@endsection 