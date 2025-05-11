@extends('layouts.admin')

@section('title', 'Detail Agenda')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-6xl mx-auto">
        <h1 class="text-3xl font-extrabold text-primary text-center mb-6">{{ $agenda->name }}</h1>
        <!-- Tab Navigation -->
        <div class="flex justify-center gap-2 mb-6">
            @foreach([
                'candidate' => ['icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A9 9 0 1112 21a9 9 0 01-6.879-3.196z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>', 'label' => 'Candidate'],
                'voter' => ['icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="7" width="18" height="13" rx="2"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 3v4M8 3v4"/></svg>', 'label' => 'Voter'],
                'votes' => ['icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>', 'label' => 'Votes'],
                'statistics' => ['icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3v18h18"/><rect x="7" y="13" width="3" height="5" rx="1"/><rect x="14" y="9" width="3" height="9" rx="1"/></svg>', 'label' => 'Statistics'],
            ] as $key => $tabInfo)
                <a href="{{ route('agendas.show', [$agenda, 'tab' => $key]) }}"
                   class="flex items-center gap-2 px-6 py-2 rounded-lg font-bold text-base transition-all duration-200
                   {{ $tab === $key ? 'bg-primary text-white shadow-lg scale-105' : 'bg-primary/10 text-primary hover:bg-primary/20' }}">
                    {!! $tabInfo['icon'] !!} {{ $tabInfo['label'] }}
                </a>
            @endforeach
        </div>
        <!-- Card Detail Agenda -->
        <div class="bg-white rounded-2xl shadow-xl p-6 mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                    <div class="text-lg font-bold text-primary mb-1">{{ $agenda->name }}</div>
                    <div class="text-sm text-gray-500 mb-1">Dibuat: {{ $agenda->created_at->format('d M Y H:i') }}</div>
                    <div class="text-sm">
                    Status:
                    @if($agenda->status == 'draft')
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-gray-200 text-gray-700 text-xs font-semibold"><svg class='w-4 h-4' fill='none' stroke='currentColor' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 6v6l4 2'/></svg> Belum Mulai</span>
                    @elseif($agenda->status == 'ongoing')
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-green-100 text-green-800 text-xs font-semibold"><svg class='w-4 h-4' fill='none' stroke='currentColor' viewBox='0 0 24 24'><circle cx='12' cy='12' r='6'/></svg> Berjalan</span>
                    @else
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-blue-200 text-blue-700 text-xs font-semibold"><svg class='w-4 h-4' fill='none' stroke='currentColor' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M5 13l4 4L19 7'/></svg> Selesai</span>
                    @endif
                </div>
            </div>
                <div class="flex flex-wrap gap-2 mt-2 md:mt-0">
                @if($agenda->status == 'draft')
                <form action="{{ route('agendas.start', $agenda) }}" method="POST" class="inline" onsubmit="return confirm('Mulai agenda ini?')">
                    @csrf
                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg font-semibold shadow flex items-center gap-2 transition hover:scale-105">▶️ Mulai Agenda</button>
                </form>
                @elseif($agenda->status == 'ongoing')
                <form action="{{ route('agendas.finish', $agenda) }}" method="POST" class="inline" onsubmit="return confirm('Selesaikan agenda ini?')">
                    @csrf
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold shadow flex items-center gap-2 transition hover:scale-105">⏹️ Selesaikan Agenda</button>
                </form>
                @endif
                    <a href="{{ route('agendas.result', $agenda) }}" class="bg-primary hover:bg-primary/90 text-white px-4 py-2 rounded-lg font-semibold shadow flex items-center gap-2 transition hover:scale-105">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3v18h18"/><rect x="7" y="13" width="3" height="5" rx="1"/><rect x="14" y="9" width="3" height="9" rx="1"/></svg>
                        Statistik
                    </a>
                </div>
            </div>
            @if($agenda->detail)
            <div class="mt-4 text-gray-700">{{ $agenda->detail }}</div>
            @endif
        </div>
        <!-- Tab Content -->
        <div class="bg-white rounded-2xl shadow-xl p-6">
            @if($tab === 'candidate')
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold text-primary flex items-center gap-2"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A9 9 0 1112 21a9 9 0 01-6.879-3.196z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg> Kandidat</h2>
                    <a href="{{ route('admin.candidates.create', ['agenda_id' => $agenda->id]) }}" class="bg-primary text-white px-4 py-2 rounded-lg flex items-center gap-2 shadow hover:scale-105 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Tambah Kandidat
                    </a>
    </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50 sticky top-0 z-10">
                            <tr>
                                <th class="px-6 py-3 font-bold text-primary">Foto</th>
                                <th class="px-6 py-3 font-bold text-primary">Nama</th>
                                <th class="px-6 py-3 font-bold text-primary">Visi</th>
                                <th class="px-6 py-3 font-bold text-primary">Status</th>
                                <th class="px-6 py-3 font-bold text-primary">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                @forelse($agenda->candidates as $candidate)
                            <tr class="hover:bg-primary/5 transition">
                                <td class="px-6 py-4"><img src="{{ $candidate->photo ? asset('storage/images/' . $candidate->photo) : asset('storage/images/default-avatar.png') }}" alt="{{ $candidate->name }}" class="w-12 h-12 rounded-full object-cover"></td>
                                <td class="px-6 py-4 font-semibold">{{ $candidate->name }}</td>
                                <td class="px-6 py-4">{{ $candidate->vision }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold {{ $candidate->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        @if($candidate->is_active)
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Aktif
                                        @else
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="6"/></svg> Nonaktif
                                        @endif
                                    </span>
                                </td>
                                <td class="px-6 py-4 flex gap-2">
                                    <a href="{{ route('admin.candidates.edit', $candidate) }}" class="text-primary hover:underline flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 13h6m2 2a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v6z"/></svg> Edit</a>
                                    <form action="{{ route('admin.candidates.destroy', $candidate) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kandidat ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg> Hapus</button>
                                    </form>
                                </td>
                            </tr>
                @empty
                            <tr><td colspan="5" class="text-center text-gray-400 py-6">Belum ada data kandidat</td></tr>
                @endforelse
                        </tbody>
                    </table>
                </div>
            @elseif($tab === 'voter')
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold text-primary flex items-center gap-2"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="7" width="18" height="13" rx="2"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 3v4M8 3v4"/></svg> Voter</h2>
                    <div class="space-x-2">
                        <a class="bg-primary text-white px-4 py-2 rounded-lg flex items-center gap-2 shadow hover:scale-105 transition font-semibold"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg> Tambah Voter</a>
                        <button class="bg-green-600 text-white px-4 py-2 rounded-lg flex items-center gap-2 shadow hover:scale-105 transition font-semibold"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 17l4 4 4-4m-4-4V3"/></svg> Import Excel</button>
                        <a class="bg-accent text-white px-4 py-2 rounded-lg flex items-center gap-2 shadow hover:scale-105 transition font-semibold"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 17v-4m0 0V7m0 6l-4-4m4 4l4-4"/></svg> Export</a>
                    </div>
        </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50 sticky top-0 z-10">
                            <tr>
                                <th class="px-6 py-3 font-bold text-primary">#</th>
                                <th class="px-6 py-3 font-bold text-primary">Name</th>
                                <th class="px-6 py-3 font-bold text-primary">NIM</th>
                                <th class="px-6 py-3 font-bold text-primary">Voting Code</th>
                                <th class="px-6 py-3 font-bold text-primary">Status</th>
                                <th class="px-6 py-3 font-bold text-primary">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                @forelse($agenda->voters as $voter)
                            <tr class="hover:bg-primary/5 transition">
                                <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 whitespace-nowrap font-semibold">{{ $voter->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $voter->identifier }}</td>
                                <td class="px-6 py-4 whitespace-nowrap font-mono font-bold text-blue-600">{{ $voter->voting_code }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($voter->vote)
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">🟢 Voted</span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">🔴 Not Voted</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <button type="button" onclick="openDeleteModal('{{ route('admin.voter-management.destroy', ['id' => $voter->id, 'agenda_id' => $agenda->id]) }}')" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition text-xs flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg> Hapus</button>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="text-center text-gray-400 py-6">Belum ada voter</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- Modal Import Excel -->
                <div id="importModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
                    <div class="bg-white rounded-xl p-8 max-w-sm w-full shadow-lg">
                        <h3 class="text-xl font-bold text-primary mb-4">Import Data Voter</h3>
                        <form action="{{ route('admin.voter-management.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="agenda_id" value="{{ $agenda->id }}">
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="file">File Excel</label>
                                <input type="file" name="file" id="file" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                            </div>
                            <div class="flex justify-end space-x-2">
                                <button type="button" onclick="closeImportModal()" class="px-4 py-2 rounded bg-gray-200 text-gray-700 hover:bg-gray-300">Batal</button>
                                <button type="submit" class="px-4 py-2 rounded bg-primary text-white hover:bg-accent">Import</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Modal Konfirmasi Hapus -->
                <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
                    <div class="bg-white rounded-xl p-8 max-w-sm w-full shadow-lg text-center">
                        <h3 class="text-xl font-bold text-red-600 mb-4">Konfirmasi Hapus</h3>
                        <p class="mb-6 text-gray-700">Apakah Anda yakin ingin menghapus voter ini?</p>
                        <form id="deleteForm" method="POST">
                            @csrf
                            @method('DELETE')
                            <div class="flex justify-center space-x-4">
                                <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 rounded bg-gray-200 text-gray-700 hover:bg-gray-300">Batal</button>
                                <button type="submit" class="px-4 py-2 rounded bg-red-500 text-white hover:bg-red-600">Hapus</button>
                            </div>
                        </form>
                    </div>
                </div>
                @push('scripts')
                <script>
                function openImportModal() {
                    document.getElementById('importModal').classList.remove('hidden');
                }
                function closeImportModal() {
                    document.getElementById('importModal').classList.add('hidden');
                }
                function openDeleteModal(actionUrl) {
                    document.getElementById('deleteForm').action = actionUrl;
                    document.getElementById('deleteModal').classList.remove('hidden');
                }
                function closeDeleteModal() {
                    document.getElementById('deleteModal').classList.add('hidden');
                }
                </script>
                @endpush
            @elseif($tab === 'votes')
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold text-primary flex items-center gap-2"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Data Voting</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50 sticky top-0 z-10">
                            <tr>
                                <th class="px-6 py-3 font-bold text-primary">#</th>
                                <th class="px-6 py-3 font-bold text-primary">Nama Voter</th>
                                <th class="px-6 py-3 font-bold text-primary">Identifier</th>
                                <th class="px-6 py-3 font-bold text-primary">Waktu Voting</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($votes as $vote)
                            <tr class="hover:bg-primary/5 transition">
                                <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 whitespace-nowrap font-semibold">{{ $vote->voter->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $vote->voter->identifier }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $vote->created_at->format('d M Y H:i') }}</td>
                            </tr>
                @empty
                            <tr><td colspan="5" class="text-center text-gray-400 py-6">Belum ada voting</td></tr>
                @endforelse
                        </tbody>
                    </table>
                </div>
            @elseif($tab === 'statistics')
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold text-primary flex items-center gap-2"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3v18h18"/><rect x="7" y="13" width="3" height="5" rx="1"/><rect x="14" y="9" width="3" height="9" rx="1"/></svg> Statistik Voting</h2>
                </div>

                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-primary">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Total Voter</p>
                                <h3 class="text-2xl font-bold text-primary">{{ $agenda->voters?->count() ?? 0 }}</h3>
                            </div>
                            <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center">
                                <span class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center"><svg class="w-7 h-7 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A9 9 0 1112 21a9 9 0 01-6.879-3.196z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg></span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-green-500">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Sudah Voting</p>
                                <h3 class="text-2xl font-bold text-green-600">{{ $agenda->votes?->count() ?? 0 }}</h3>
                            </div>
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                <span class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center"><svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg></span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-blue-500">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Persentase Partisipasi</p>
                                <h3 class="text-2xl font-bold text-blue-600">
                                    {{ ($agenda->voters?->count() ?? 0) > 0 ? round((($agenda->votes?->count() ?? 0) / ($agenda->voters?->count() ?? 1)) * 100) : 0 }}%
                                </h3>
                            </div>
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                <span class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center"><svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3v18h18"/><rect x="7" y="13" width="3" height="5" rx="1"/><rect x="14" y="9" width="3" height="9" rx="1"/></svg></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chart Section -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Bar Chart -->
                    <div class="bg-white rounded-2xl shadow-lg p-6">
                        <h3 class="text-lg font-bold text-primary mb-4">Hasil Voting per Kandidat</h3>
                        <canvas id="voteChart" height="300"></canvas>
                    </div>

                    <!-- Pie Chart -->
                    <div class="bg-white rounded-2xl shadow-lg p-6">
                        <h3 class="text-lg font-bold text-primary mb-4">Distribusi Suara</h3>
                        <canvas id="pieChart" height="300"></canvas>
                    </div>
                </div>

                <!-- Results Table -->
                <div class="bg-white rounded-2xl shadow-lg p-6 mt-8">
                    <h3 class="text-lg font-bold text-primary mb-4">Detail Hasil Voting</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kandidat</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Suara</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Persentase</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @php
                                    $totalVotes = $agenda->votes?->count() ?? 0;
                                    $maxVotes = $agenda->candidates->max(function($candidate) {
                                        return $candidate->votes->count();
                                    });
                                @endphp
                                @foreach($agenda->candidates as $candidate)
                                @php
                                    $votes = $candidate->votes->count();
                                    $percentage = $totalVotes > 0 ? round(($votes / $totalVotes) * 100) : 0;
                                    $isWinner = $votes > 0 && $votes === $maxVotes;
                                @endphp
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <img src="{{ $candidate->photo ? asset('storage/images/' . $candidate->photo) : asset('storage/images/default-avatar.png') }}" 
                                                 alt="{{ $candidate->name }}" 
                                                 class="w-10 h-10 rounded-full mr-3">
                                            <span class="font-medium">{{ $candidate->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <span class="font-bold text-primary">{{ $votes }}</span>
                                            <div class="ml-2 w-32 bg-gray-200 rounded-full h-2.5">
                                                <div class="bg-primary h-2.5 rounded-full" style="width: {{ $percentage }}%"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="font-semibold">{{ $percentage }}%</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($isWinner)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Pemenang</span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                                {{ $votes > 0 ? 'Runner Up' : 'Belum Ada Suara' }}
                                            </span>
                                        @endif
                                    </td>
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

                // Pie Chart
                const pieCtx = document.getElementById('pieChart').getContext('2d');
                const pieChart = new Chart(pieCtx, {
                    type: 'doughnut',
                    data: {
                        labels: [
                            @foreach($agenda->candidates as $candidate)
                                '{{ $candidate->name }}',
                            @endforeach
                        ],
                        datasets: [{
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
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'right',
                                labels: {
                                    padding: 20,
                                    font: {
                                        size: 12
                                    }
                                }
                            }
                        },
                        animation: {
                            duration: 2000,
                            easing: 'easeInOutQuart'
                        },
                        cutout: '60%'
                    }
                });
                </script>
            @endif
        </div>
    </div>
</div>
@endsection 