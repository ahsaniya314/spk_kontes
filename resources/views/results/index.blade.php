@extends('layouts.app')

@section('title', 'Hasil Perhitungan SMART')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <h2 class="text-2xl font-bold mb-4">Hasil Perhitungan SMART</h2>

        @if(isset($message))
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4">
                {{ $message }}

            </div>
        @else
            <div class="mb-6">
                <h3 class="text-xl font-semibold mb-4">Ranking Alternatif</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rank</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alternatif</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai Akhir (Vj)</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">

                            @foreach($ranked as $item)
                                <tr class="{{ $loop->iteration <= 3 ? 'bg-yellow-50' : '' }}">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-2xl font-bold {{ $loop->iteration == 1 ? 'text-yellow-600' : ($loop->iteration == 2 ? 'text-gray-500' : ($loop->iteration == 3 ? 'text-orange-600' : 'text-gray-400')) }}">
                                            {{ $item['rank'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $item['alternative']->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $item['alternative']->code }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap font-semibold">{{ number_format($item['final_value'], 4) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('results.show', $item['alternative']->id) }}" class="text-blue-600 hover:text-blue-900">Detail</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6">
                <h3 class="text-xl font-semibold mb-4">Nilai Normalisasi (U(Xij))</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alternatif</th>
                                @foreach($criteria as $criterion)
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ $criterion->name }}<br>
                                        <span class="text-xs text-gray-400">(W={{ $criterion->weight }})</span>
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($alternatives as $alternative)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap font-semibold">{{ $alternative->name }}</td>
                                    @foreach($criteria as $criterion)
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ isset($normalized[$alternative->id][$criterion->id]) ? number_format($normalized[$alternative->id][$criterion->id], 4) : '-' }}
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tabel Agregasi SMART -->
            <div class="mt-6">
                <h3 class="text-xl font-semibold mb-4">Tabel Perhitungan Agregasi SMART</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alternatif</th>
                                @foreach($criteria as $criterion)
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ $criterion->name }}<br>
                                        <span class="text-xs text-gray-400">(W={{ number_format($criterion->weight,2) }})</span>
                                    </th>
                                @endforeach
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Akhir</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($alternatives as $alternative)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap font-semibold">{{ $alternative->name }}</td>
                                    @php $total = 0; @endphp
                                    @foreach($criteria as $criterion)
                                        @php $nilai = $criterion->weight * ($normalized[$alternative->id][$criterion->id] ?? 0); $total += $nilai; @endphp
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="block text-xs text-gray-500">W: {{ number_format($criterion->weight, 2) }}</span>
                                            <span class="block text-xs text-gray-500">U(X): {{ number_format($normalized[$alternative->id][$criterion->id] ?? 0, 2) }}</span>
                                            <span class="block text-xs font-semibold text-gray-700">W*U(X): {{ number_format($nilai, 2) }}</span>
                                        </td>
                                    @endforeach
                                    <td class="px-6 py-4 whitespace-nowrap font-bold text-blue-700">{{ number_format($total, 4) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

