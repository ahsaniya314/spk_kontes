@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Tabel Agregasi Nilai Penilaian (Juri 1)</h2>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Alternatif</th>
                    <th>Kategori</th>
                    <th>Kriteria</th>
                    <th>Normalisasi Juri 1</th>
                    <th>Rata-rata Juri 2 & 3</th>
                    <th>Nilai Agregasi Akhir</th>
                    <th>Status Penilaian</th>
                </tr>
            </thead>
            <tbody>
                @foreach($aggregations as $row)
                    @include('results.partials.aggregation_row', [
                        'row' => $row,
                        'show_juri1' => true,
                        'show_average' => true,
                        'show_aggregation' => true
                    ])
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
