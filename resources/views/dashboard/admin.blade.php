@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <h2 class="text-2xl font-bold mb-4">Dashboard Admin</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-blue-100 p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-blue-800">Kategori</h3>
                <p class="text-3xl font-bold text-blue-600">{{ $stats['categories'] }}</p>
            </div>
            <div class="bg-green-100 p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-green-800">Kriteria</h3>
                <p class="text-3xl font-bold text-green-600">{{ $stats['criteria'] }}</p>
            </div>
            <div class="bg-yellow-100 p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-yellow-800">Alternatif</h3>
                <p class="text-3xl font-bold text-yellow-600">{{ $stats['alternatives'] }}</p>
            </div>
            <div class="bg-purple-100 p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-purple-800">Penilaian</h3>
                <p class="text-3xl font-bold text-purple-600">{{ $stats['ratings'] }}</p>
            </div>
        </div>

        <div class="mt-6">
            <h3 class="text-xl font-semibold mb-4">Quick Actions</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('categories.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center">
                    Tambah Kategori
                </a>
                <a href="{{ route('criteria.create') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-center">
                    Tambah Kriteria
                </a>
                <a href="{{ route('results.index') }}" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded text-center">
                    Lihat Hasil
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

