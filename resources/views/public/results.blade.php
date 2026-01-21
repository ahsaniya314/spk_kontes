@extends('layouts.public')

@section('title', 'Hasil Kontes Unggas - Peringkat Final')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Header Section - Minimalis -->
    <div class="text-center mb-16">
        <h1 class="text-3xl font-semibold text-gray-900 mb-2 tracking-tight">Hasil Kontes Unggas</h1>
        <p class="text-sm text-gray-500">Peringkat Final Berdasarkan Metode SMART</p>
    </div>

    @if(isset($message))
        <div class="card text-center">
            <p class="text-gray-600">{{ $message }}</p>
        </div>
    @else
        <!-- Top 3 Winners Podium - Minimalis -->
        @if($ranked->count() >= 3)
            <div class="mb-16">
                <div class="podium">
                    <!-- 2nd Place -->
                    <div class="podium-item">
                        <div class="podium-base podium-2 flex flex-col justify-end">
                            <div class="text-3xl mb-2">🥈</div>
                            <div class="text-lg font-semibold">{{ $ranked[1]['alternative']->name }}</div>
                            <div class="text-xs mt-2 opacity-90">{{ number_format($ranked[1]['final_value'], 4) }}</div>
                        </div>
                        <div class="bg-gray-100 text-gray-700 text-center py-2 text-xs font-medium rounded-b">#2</div>
                    </div>

                    <!-- 1st Place -->
                    <div class="podium-item">
                        <div class="podium-base podium-1 flex flex-col justify-end">
                            <div class="text-4xl mb-2">👑</div>
                            <div class="text-xl font-bold">{{ $ranked[0]['alternative']->name }}</div>
                            <div class="text-sm mt-2 font-semibold">{{ number_format($ranked[0]['final_value'], 4) }}</div>
                        </div>
                        <div class="bg-amber-500 text-white text-center py-2 text-sm font-semibold rounded-b">Juara 1</div>
                    </div>

                    <!-- 3rd Place -->
                    <div class="podium-item">
                        <div class="podium-base podium-3 flex flex-col justify-end">
                            <div class="text-3xl mb-2">🥉</div>
                            <div class="text-lg font-semibold">{{ $ranked[2]['alternative']->name }}</div>
                            <div class="text-xs mt-2 opacity-90">{{ number_format($ranked[2]['final_value'], 4) }}</div>
                        </div>
                        <div class="bg-gray-100 text-gray-700 text-center py-2 text-xs font-medium rounded-b">#3</div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Top Winner Spotlight - Minimalis -->
        @if($ranked->count() > 0)
            <div class="card mb-12 border-l-4 border-amber-500">
                <div class="flex items-start gap-6">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-3">
                            <span class="text-3xl">👑</span>
                            <div>
                                <h2 class="text-2xl font-semibold text-gray-900">{{ $ranked[0]['alternative']->name }}</h2>
                                <p class="text-sm text-gray-500">{{ $ranked[0]['alternative']->code }}</p>
                            </div>
                        </div>
                        @if($ranked[0]['alternative']->description)
                            <p class="text-gray-600 text-sm mb-4">{{ $ranked[0]['alternative']->description }}</p>
                        @endif
                        <div class="inline-flex items-center gap-2 bg-amber-50 px-4 py-2 rounded-lg">
                            <span class="text-xs text-gray-600">Skor Total</span>
                            <span class="text-2xl font-bold text-amber-600">{{ number_format($ranked[0]['final_value'], 4) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Ranking Board - Minimalis -->
        <div class="card mb-12">
            <h2 class="text-xl font-semibold mb-6 text-gray-900">Peringkat</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead>
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rank</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alternatif</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Skor</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($ranked as $item)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        @if($loop->iteration == 1)
                                            <span class="text-xl">👑</span>
                                        @elseif($loop->iteration == 2)
                                            <span class="text-lg">🥈</span>
                                        @elseif($loop->iteration == 3)
                                            <span class="text-lg">🥉</span>
                                        @endif
                                        <span class="text-lg font-semibold {{ $loop->iteration == 1 ? 'text-amber-600' : ($loop->iteration == 2 ? 'text-gray-500' : ($loop->iteration == 3 ? 'text-orange-600' : 'text-gray-400')) }}">
                                            #{{ $item['rank'] }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-4 py-4">
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $item['alternative']->name }}</div>
                                        <div class="text-xs text-gray-500 font-mono">{{ $item['alternative']->code }}</div>
                                    </div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-right">
                                    <span class="text-lg font-semibold text-gray-900">{{ number_format($item['final_value'], 4) }}</span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <button onclick="showChart({{ $loop->index }})" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                                        Grafik
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Chart Visualization Section - Minimalis -->
        @if(isset($ranked) && $ranked->count() > 0)
            <div class="card mb-12">
                <h2 class="text-xl font-semibold mb-6 text-gray-900">Visualisasi Kontribusi Skor</h2>

                <!-- Chart Selection -->
                <div class="mb-6">
                    <select id="alternativeSelect" onchange="updateChart()" class="w-full border border-gray-200 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @foreach($ranked as $index => $item)
                            <option value="{{ $index }}" {{ $loop->first ? 'selected' : '' }}>
                                #{{ $item['rank'] }} - {{ $item['alternative']->name }} ({{ $item['alternative']->code }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Chart Container -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Bar Chart -->
                    <div>
                        <h3 class="text-sm font-medium text-gray-700 mb-4">Kontribusi per Kriteria</h3>
                        <canvas id="barChart" height="250"></canvas>
                    </div>

                    <!-- Radar Chart -->
                    <div>
                        <h3 class="text-sm font-medium text-gray-700 mb-4">Perbandingan Performa</h3>
                        <canvas id="radarChart" height="250"></canvas>
                    </div>
                </div>
            </div>
        @endif

        <!-- Detailed Scoring Table - Minimalis -->
        @if(isset($ranked) && $ranked->count() > 0 && isset($criteria) && $criteria->count() > 0)
            <div class="card mb-12">
                <h2 class="text-xl font-semibold mb-6 text-gray-900">Detail Penilaian</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100 text-sm">
                        <thead>
                            <tr>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Alternatif</th>
                                @foreach($criteria as $criterion)
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">
                                        <div>{{ $criterion->name }}</div>
                                        <div class="text-xs text-gray-400 font-normal">W: {{ $criterion->weight }}</div>
                                    </th>
                                @endforeach
                                <th class="px-3 py-2 text-right text-xs font-medium text-gray-500 uppercase">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($ranked as $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-3 py-3">
                                        <div class="font-medium text-gray-900">#{{ $item['rank'] }}</div>
                                        <div class="text-xs text-gray-500">{{ $item['alternative']->name }}</div>
                                    </td>
                                    @foreach($criteria as $criterion)
                                        @php
                                            $uij = $normalized[$item['alternative']->id][$criterion->id] ?? 0;
                                            $contribution = $criterion->weight * $uij;
                                        @endphp
                                        <td class="px-3 py-3">
                                            <div class="text-xs text-gray-400 mb-1">U: {{ number_format($uij, 2) }}</div>
                                            <div class="font-medium text-gray-900">{{ number_format($contribution, 2) }}</div>
                                        </td>
                                    @endforeach
                                    <td class="px-3 py-3 text-right">
                                        <span class="font-semibold text-gray-900">{{ number_format($item['final_value'], 4) }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <!-- Juri Ratings Detail Table - Minimalis -->
        @if(isset($juriRatings) && count($juriRatings) > 0)
            <div class="card">
                <h2 class="text-xl font-semibold mb-2 text-gray-900">Penilaian Juri</h2>
                <p class="text-xs text-gray-500 mb-6">Juri 1 dan rata-rata Juri 2 & 3</p>

                @foreach($juriRatings as $altData)
                    <div class="mb-8 last:mb-0">
                        <h3 class="text-sm font-semibold text-gray-700 mb-3">{{ $altData['name'] }} <span class="text-gray-400 font-normal">({{ $altData['code'] }})</span></h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-100 text-sm">
                                <thead>
                                    <tr>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Kriteria</th>
                                        <th class="px-3 py-2 text-right text-xs font-medium text-gray-500 uppercase">Juri 1</th>
                                        <th class="px-3 py-2 text-right text-xs font-medium text-gray-500 uppercase">Rata-rata Juri 2 & 3</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($altData['criteria'] as $critData)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-3 py-2 text-gray-700">{{ $critData['name'] }}</td>
                                            <td class="px-3 py-2 text-right">
                                                @if($critData['juri1_rating'] !== null)
                                                    <span class="font-medium text-gray-900">{{ number_format($critData['juri1_rating'], 2) }}</span>
                                                @else
                                                    <span class="text-gray-300">-</span>
                                                @endif
                                            </td>
                                            <td class="px-3 py-2 text-right">
                                                @if($critData['juri2_3_avg'] !== null)
                                                    <span class="font-medium text-gray-900">{{ number_format($critData['juri2_3_avg'], 2) }}</span>
                                                @else
                                                    <span class="text-gray-300">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    @endif
</div>

<!-- Chart Data for JavaScript -->
<script>
    // Prepare chart data from PHP
    const contributionData = @json($contributionData ?? []);
    const criteriaLabels = @json(isset($criteria) ? $criteria->pluck('name')->toArray() : []);

    let barChartInstance = null;
    let radarChartInstance = null;

    function updateChart() {
        const select = document.getElementById('alternativeSelect');
        const index = parseInt(select.value);
        showChart(index);
    }

    function showChart(index) {
        if (!contributionData[index]) return;

        const data = contributionData[index];
        const labels = data.criteria.map(c => c.name);
        const contributions = data.criteria.map(c => c.contribution);
        const normalized = data.criteria.map(c => c.normalized);
        const weights = data.criteria.map(c => c.weight);

        // Destroy existing charts
        if (barChartInstance) barChartInstance.destroy();
        if (radarChartInstance) radarChartInstance.destroy();

        // Bar Chart - Minimalis
        const barCtx = document.getElementById('barChart').getContext('2d');
        barChartInstance = new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Kontribusi Skor',
                    data: contributions,
                    backgroundColor: 'rgba(99, 102, 241, 0.1)',
                    borderColor: 'rgba(99, 102, 241, 1)',
                    borderWidth: 1.5,
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        titleFont: { size: 12 },
                        bodyFont: { size: 11 },
                        callbacks: {
                            label: function(context) {
                                const idx = context.dataIndex;
                                return [
                                    'Kontribusi: ' + contributions[idx].toFixed(4),
                                    'Normalisasi: ' + normalized[idx].toFixed(4),
                                    'Bobot: ' + weights[idx]
                                ];
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            font: { size: 11 },
                            color: '#6b7280'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: { size: 11 },
                            color: '#6b7280'
                        }
                    }
                }
            }
        });

        // Radar Chart - Minimalis
        const radarCtx = document.getElementById('radarChart').getContext('2d');
        radarChartInstance = new Chart(radarCtx, {
            type: 'radar',
            data: {
                labels: labels,
                datasets: [{
                    label: data.name,
                    data: contributions,
                    backgroundColor: 'rgba(99, 102, 241, 0.1)',
                    borderColor: 'rgba(99, 102, 241, 1)',
                    borderWidth: 2,
                    pointBackgroundColor: 'rgba(99, 102, 241, 1)',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: 'rgba(99, 102, 241, 1)',
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        titleFont: { size: 12 },
                        bodyFont: { size: 11 },
                        callbacks: {
                            label: function(context) {
                                const idx = context.dataIndex;
                                return [
                                    'Kontribusi: ' + contributions[idx].toFixed(4),
                                    'Normalisasi: ' + normalized[idx].toFixed(4)
                                ];
                            }
                        }
                    }
                },
                scales: {
                    r: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            font: { size: 11 },
                            color: '#6b7280',
                            stepSize: 5
                        },
                        pointLabels: {
                            font: { size: 11 },
                            color: '#6b7280'
                        }
                    }
                }
            }
        });
    }

    // Initialize chart on page load
    document.addEventListener('DOMContentLoaded', function() {
        if (contributionData && contributionData.length > 0) {
            updateChart();
        }
    });
</script>
@endsection

