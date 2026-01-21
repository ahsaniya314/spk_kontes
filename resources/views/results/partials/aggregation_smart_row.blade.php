<tr>
    <td>{{ $alternative->name }}</td>
    @php $total = 0; @endphp
    @foreach($criteria as $criterion)
        <td>
            <div><b>W:</b> {{ number_format($criterion->weight, 2) }}</div>
            <div><b>U(X):</b> {{ number_format($normalized[$alternative->id][$criterion->id] ?? 0, 2) }}</div>
            <div><b>W*U(X):</b> {{ number_format(($criterion->weight * ($normalized[$alternative->id][$criterion->id] ?? 0)), 2) }}</div>
            @php $total += $criterion->weight * ($normalized[$alternative->id][$criterion->id] ?? 0); @endphp
        </td>
    @endforeach
    <td><b>{{ number_format($total, 2) }}</b></td>
</tr>
