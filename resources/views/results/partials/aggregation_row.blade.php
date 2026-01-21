<tr>
    <td>{{ $row->alternative }}</td>
    <td>{{ $row->category }}</td>
    <td>{{ $row->criterion }}</td>
    @if(isset($show_juri1))
        <td>{{ $row->normalized_juri1 ?? '-' }}</td>
    @endif
    @if(isset($show_juri2))
        <td>{{ $row->normalized_juri2 ?? '-' }}</td>
    @endif
    @if(isset($show_juri3))
        <td>{{ $row->normalized_juri3 ?? '-' }}</td>
    @endif
    @if(isset($show_average))
        <td>
            @if(isset($row->normalized_juri2, $row->normalized_juri3))
                {{ number_format(($row->normalized_juri2 + $row->normalized_juri3) / 2, 3) }}
            @else
                -
            @endif
        </td>
    @endif
    @if(isset($show_aggregation))
        <td>
            @if(isset($row->normalized_juri1, $row->normalized_juri2, $row->normalized_juri3))
                {{ number_format($row->aggregation, 3) }}
            @else
                -
            @endif
        </td>
    @endif
    <td>
        @if((isset($show_juri1) && !isset($row->normalized_juri1)) || (isset($show_juri2) && !isset($row->normalized_juri2)) || (isset($show_juri3) && !isset($row->normalized_juri3)))
            <span class="text-warning">Belum Lengkap</span>
        @else
            <span class="text-success">Lengkap</span>
        @endif
    </td>
</tr>
