@extends('layouts.app')

@section('title', 'Detail Alternatif')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">Detail Alternatif: {{ $alternative->name }}</h2>
            <div>
                @can('input-rating')
                <a href="{{ route('alternatives.edit', $alternative) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mr-2">
                    Edit
                </a>
                @endcan
                <a href="{{ route('alternatives.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Kembali
                </a>
            </div>
        </div>

        <div class="mb-6">
            <p class="text-gray-700 mb-2"><strong>Kode:</strong> {{ $alternative->code }}</p>
            <p class="text-gray-700"><strong>Deskripsi:</strong> {{ $alternative->description ?? '-' }}</p>
        </div>

        <h3 class="text-xl font-semibold mb-4">Penilaian untuk Alternatif ini ({{ $alternative->ratings->count() }})</h3>

        @if($alternative->ratings->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kriteria</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Juri</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($alternative->ratings as $rating)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $rating->criterion->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $rating->user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $rating->value }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500">Belum ada penilaian untuk alternatif ini.</p>
        @endif
    </div>
</div>
@endsection

