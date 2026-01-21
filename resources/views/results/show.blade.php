@extends('layouts.app')

@section('title', 'Detail Hasil - ' . $alternative->name)

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">Detail Hasil: {{ $alternative->name }}</h2>
            <a href="{{ route('results.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Kembali
            </a>
        </div>

        <div class="mb-6 bg-blue-50 p-4 rounded">
            <p class="text-lg"><strong>Ranking:</strong> <span class="text-2xl font-bold text-blue-600">#{{ $rank ?? 'N/A' }}</span></p>
            <p class="text-lg"><strong>Nilai Akhir (Vj):</strong> <span class="text-xl font-bold text-blue-600">{{ number_format($finalValue, 4) }}</span></p>
        </div>

        <h3 class="text-xl font-semibold mb-4">Nilai Normalisasi per Kriteria</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kriteria</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bobot (Wi)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai Normalisasi U(Xij)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Wi × U(Xij)</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($criteria as $criterion)
                        @php
                            $uij = $normalized[$criterion->id] ?? 0;
                            $wiUij = $criterion->weight * $uij;
                        @endphp
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $criterion->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $criterion->weight }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ number_format($uij, 4) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap font-semibold">{{ number_format($wiUij, 4) }}</td>
                        </tr>
                    @endforeach
                    <tr class="bg-gray-100 font-bold">
                        <td class="px-6 py-4 whitespace-nowrap" colspan="3">Total (Vj)</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ number_format($finalValue, 4) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

