@extends('layouts.admin')

@section('title', 'Hasil Voting - ' . $agenda->name)

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 gap-4">
        <div class="flex items-center gap-3">
            <span class="text-3xl text-primary">📊</span>
            <h1 class="text-2xl md:text-3xl font-extrabold text-primary">Hasil Voting: {{ $agenda->name }}</h1>
        </div>
        <a href="{{ route('agendas.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-2 rounded-xl font-semibold shadow flex items-center gap-2 transition hover:scale-105">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Daftar Agenda
        </a>
    </div>
    <!-- Statistik Cards (Total Voter, Sudah Voting, Persentase Voting) -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8 max-w-6xl mx-auto">
        <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-blue-500 flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A9 9 0 1112 21a9 9 0 01-6.879-3.196z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">Total Voter</p>
                <h3 class="text-2xl font-bold text-blue-600">{{ $agenda->voters?->count() ?? 0 }}</h3>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-green-500 flex items-center gap-4">
            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">Sudah Voting</p>
                <h3 class="text-2xl font-bold text-green-600">{{ $agenda->votes?->count() ?? 0 }}</h3>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-blue-500 flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3v18h18"/><rect x="7" y="13" width="3" height="5" rx="1"/><rect x="14" y="9" width="3" height="9" rx="1"/></svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">Persentase Voting</p>
                <h3 class="text-2xl font-bold text-blue-600">
                    {{ ($agenda->voters?->count() ?? 0) > 0 ? round((($agenda->votes?->count() ?? 0) / ($agenda->voters?->count() ?? 1)) * 100) : 0 }}%
                </h3>
            </div>
        </div>
    </div>
    <!-- Bar Chart -->
    <div class="bg-white rounded-2xl shadow-lg p-6 max-w-6xl mx-auto mb-8">
        <h3 class="text-lg font-bold text-primary mb-4">Hasil Voting per Kandidat</h3>
        <canvas id="voteChart" height="300"></canvas>
    </div>
    <!-- Tabel Nama Kandidat & Jumlah Suara -->
    <div class="bg-white rounded-2xl shadow-lg p-6 max-w-6xl mx-auto">
        <h3 class="text-lg font-bold text-primary mb-4">Rekapitulasi Suara</h3>
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr class="bg-gray-50">
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Kandidat</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Suara</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($agenda->candidates as $candidate)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $candidate->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap font-bold">{{ $candidate->votes->count() }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Bar Chart
const barCtx = document.getElementById('voteChart').getContext('2d');
const barChart = new Chart(barCtx, {
    type: 'bar',
    data: {
        labels: [
            @foreach($agenda->candidates as $candidate)
                '{{ $candidate->name }}',
            @endforeach
        ],
        datasets: [{
            label: 'Jumlah Suara',
            data: [
                @foreach($agenda->candidates as $candidate)
                    {{ $candidate->votes->count() }},
                @endforeach
            ],
            backgroundColor: [
                'rgba(69, 118, 211, 0.7)',
                'rgba(75, 192, 192, 0.7)',
                'rgba(255, 159, 64, 0.7)',
                'rgba(153, 102, 255, 0.7)',
                'rgba(255, 99, 132, 0.7)'
            ],
            borderColor: [
                'rgba(69, 118, 211, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 99, 132, 1)'
            ],
            borderWidth: 2,
            borderRadius: 5
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
            title: { display: false }
        },
        scales: {
            y: { 
                beginAtZero: true,
                precision: 0,
                grid: {
                    color: 'rgba(0, 0, 0, 0.1)'
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        },
        animation: {
            duration: 2000,
            easing: 'easeInOutQuart'
        }
    }
});
</script>
@endsection 