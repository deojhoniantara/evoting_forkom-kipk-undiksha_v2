@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-cyan-50">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl p-8 text-center transform transition-all duration-500 hover:scale-105">
        <div class="mb-8">
            <svg class="mx-auto h-24 w-24 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        <h2 class="text-3xl font-bold text-gray-900 mb-4">Terima Kasih!</h2>
        <p class="text-gray-600 text-lg mb-8 leading-relaxed">
            Suara Anda telah berhasil direkam. 
            <br>
            Terima kasih telah berpartisipasi dalam pemilihan ini.
        </p>
        <div class="text-sm text-gray-500 bg-gray-50 p-4 rounded-lg">
            <p class="mb-2">Untuk keamanan, halaman voting tidak dapat diakses kembali menggunakan kode yang sama.</p>
            <a href="{{ route('voting.form') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                Kembali ke Halaman Utama
            </a>
        </div>
    </div>
</div>
@endsection
