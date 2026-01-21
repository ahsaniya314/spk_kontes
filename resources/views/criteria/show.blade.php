@extends('layouts.app')

@section('title', 'Detail Kriteria')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">Detail Kriteria: {{ $criterion->name }}</h2>
            <div>
                <a href="{{ route('criteria.edit', $criterion) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mr-2">
                    Edit
                </a>
                <a href="{{ route('criteria.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Kembali
                </a>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <p class="text-gray-700"><strong>Kategori:</strong> {{ $criterion->category->name }}</p>
            </div>
            <div>
                <p class="text-gray-700"><strong>Bobot:</strong> {{ $criterion->weight }}</p>
            </div>
            <div>
                <p class="text-gray-700"><strong>Tipe:</strong> 
                    <span class="px-2 py-1 text-xs rounded {{ $criterion->type === 'benefit' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $criterion->type === 'benefit' ? 'Benefit' : 'Cost' }}
                    </span>
                </p>
            </div>
            <div>
                <p class="text-gray-700"><strong>Deskripsi:</strong> {{ $criterion->description ?? '-' }}</p>
            </div>
        </div>

        <h3 class="text-xl font-semibold mb-4">Penilaian untuk Kriteria ini ({{ $criterion->ratings->count() }})</h3>

        @if($criterion->ratings->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alternatif</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Juri</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($criterion->ratings as $rating)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $rating->alternative->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $rating->user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $rating->value }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500">Belum ada penilaian untuk kriteria ini.</p>
        @endif
    </div>
</div>
@endsection

