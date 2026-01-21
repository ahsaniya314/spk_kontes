@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Tabel Perhitungan Agregasi SMART</h2>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Alternatif</th>
                    @foreach($criteria as $criterion)
                        <th>{{ $criterion->name }}<br><span class="text-xs">(W={{ number_format($criterion->weight,2) }})</span></th>
                    @endforeach
                    <th>Jumlah Akhir</th>
                </tr>
            </thead>
            <tbody>
                @foreach($alternatives as $alternative)
                    @include('results.partials.aggregation_smart_row', [
                        'alternative' => $alternative,
                        'criteria' => $criteria,
                        'normalized' => $normalized
                    ])
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
