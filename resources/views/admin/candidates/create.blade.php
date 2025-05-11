@extends('layouts.admin')

@section('title', 'Tambah Kandidat')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-3xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Tambah Kandidat</h1>
            <a href="{{ route('admin.candidates.index') }}" 
               class="text-gray-600 hover:text-gray-800 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <form action="{{ route('admin.candidates.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                
                <div class="space-y-6">
                    <!-- Photo Upload -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Foto Kandidat
                        </label>
                        <div class="flex items-center space-x-4">
                            <div class="w-24 h-24 rounded-full overflow-hidden bg-gray-100">
                                <img id="photo-preview" src="{{ asset('storage/images/default-avatar.png') }}" 
                                     alt="Preview" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1">
                                <input type="file" 
                                       name="photo" 
                                       id="photo"
                                       accept="image/*"
                                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                                @error('photo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Kandidat
                        </label>
                        <input type="text" 
                               name="name" 
                               id="name" 
                               value="{{ old('name') }}"
                               class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-primary focus:border-primary sm:text-sm"
                               required>
                        @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Vision -->
                    <div>
                        <label for="vision" class="block text-sm font-medium text-gray-700 mb-2">
                            Visi
                        </label>
                        <textarea name="vision" 
                                  id="vision" 
                                  rows="3"
                                  class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-primary focus:border-primary sm:text-sm"
                                  required>{{ old('vision') }}</textarea>
                        @error('vision')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Mission -->
                    <div>
                        <label for="mission" class="block text-sm font-medium text-gray-700 mb-2">
                            Misi
                        </label>
                        <textarea name="mission" 
                                  id="mission" 
                                  rows="5"
                                  class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-primary focus:border-primary sm:text-sm"
                                  required
                                  placeholder="Pisahkan setiap misi dengan baris baru">{{ old('mission') }}</textarea>
                        <p class="mt-1 text-sm text-gray-500">Pisahkan setiap misi dengan baris baru (Enter)</p>
                        @error('mission')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" 
                                class="bg-primary hover:bg-primary/90 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                            Simpan Kandidat
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Preview uploaded photo
    document.getElementById('photo').addEventListener('change', function(e) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('photo-preview').src = e.target.result;
        }
        reader.readAsDataURL(this.files[0]);
    });
</script>
@endsection 