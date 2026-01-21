@extends('layouts.app')

@section('title', 'Daftar Alternatif')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">Daftar Alternatif</h2>
            @can('input-rating')
            <a href="{{ route('alternatives.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Tambah Alternatif
            </a>
            @endcan
        </div>

        @if($alternatives->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($alternatives as $alternative)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ ($alternatives->currentPage() - 1) * $alternatives->perPage() + $loop->iteration }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $alternative->code }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $alternative->name }}</td>
                                <td class="px-6 py-4">{{ $alternative->description ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('alternatives.show', $alternative) }}" class="text-blue-600 hover:text-blue-900 mr-2">Lihat</a>
                                    @can('input-rating')
                                    <a href="{{ route('alternatives.edit', $alternative) }}" class="text-green-600 hover:text-green-900 mr-2">Edit</a>
                                    @endcan
                                    @can('manage-criteria')
                                    <form action="{{ route('alternatives.destroy', $alternative) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus alternatif ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                    </form>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $alternatives->links() }}
            </div>
        @else
            <p class="text-gray-500">Belum ada alternatif. @can('input-rating')<a href="{{ route('alternatives.create') }}" class="text-blue-500">Tambah alternatif pertama</a>@endcan</p>
        @endif
    </div>
</div>
@endsection

