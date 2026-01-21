@extends('layouts.app')

@section('title', 'Dashboard Juri')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <h2 class="text-2xl font-bold mb-4">Dashboard Juri</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-blue-100 p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-blue-800">Alternatif</h3>
                <p class="text-3xl font-bold text-blue-600">{{ $stats['alternatives'] }}</p>
            </div>
            <div class="bg-green-100 p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-green-800">Kriteria</h3>
                <p class="text-3xl font-bold text-green-600">{{ $stats['criteria'] }}</p>
            </div>
            <div class="bg-yellow-100 p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-yellow-800">Penilaian Saya</h3>
                <p class="text-3xl font-bold text-yellow-600">{{ $userRatings }}</p>
            </div>
        </div>

        <div class="mt-6">
            <h3 class="text-xl font-semibold mb-4">Quick Actions</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <a href="{{ route('ratings.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center">
                    Input Penilaian
                </a>
                <a href="{{ route('alternatives.create') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-center">
                    Tambah Alternatif
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

