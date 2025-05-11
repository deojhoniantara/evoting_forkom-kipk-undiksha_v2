@extends('layouts.admin')

@section('title', 'Voter Management - ' . $agenda->name)

@section('content')
<div class="mb-8">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl md:text-4xl font-extrabold text-primary mb-2">{{ $agenda->name }}</h1>
            <p class="text-gray-600">Kelola data voter untuk agenda ini</p>
        </div>
        <div class="space-x-2">
            <a href="{{ route('admin.voter-management.create', ['agenda_id' => $agenda->id]) }}" class="inline-block bg-primary text-white px-4 py-2 rounded-lg shadow hover:bg-accent transition">Tambah Voter</a>
            <button onclick="openImportModal()" class="inline-block bg-green-600 text-white px-4 py-2 rounded-lg shadow hover:bg-green-700 transition">Import Excel</button>
            <a href="{{ route('admin.voter-management.export', $agenda->id) }}" class="inline-block bg-accent text-white px-4 py-2 rounded-lg shadow hover:bg-primary transition">Export</a>
        </div>
    </div>
</div>

@if(session('success'))
<div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
    <span class="block sm:inline">{{ session('success') }}</span>
</div>
@endif

<div class="bg-white rounded-xl shadow-sm p-6">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIM</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Voting Code</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($voters as $voter)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $voter->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $voter->identifier }}</td>
                    <td class="px-6 py-4 whitespace-nowrap font-mono font-bold text-blue-600">{{ $voter->voting_code }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($voter->vote)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Voted</span>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Not Voted</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <button type="button"
                            onclick="openDeleteModal('{{ route('admin.voter-management.destroy', ['id' => $voter->id, 'agenda_id' => $agenda->id]) }}')"
                            class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition text-xs">
                            Hapus
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">Belum ada voter</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Import Excel -->
<div id="importModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl p-8 max-w-sm w-full shadow-lg">
        <h3 class="text-xl font-bold text-primary mb-4">Import Data Voter</h3>
        <form action="{{ route('admin.voter-management.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="agenda_id" value="{{ $agenda->id }}">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="file">
                    File Excel
                </label>
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
@endsection

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

