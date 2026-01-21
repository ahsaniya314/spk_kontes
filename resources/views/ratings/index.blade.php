@extends('layouts.app')

@section('title', 'Daftar Penilaian Saya')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">Daftar Penilaian Saya</h2>
            <a href="{{ route('ratings.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Input Penilaian Baru
            </a>
        </div>

        @if($ratings->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alternatif</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kriteria</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($ratings as $rating)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ ($ratings->currentPage() - 1) * $ratings->perPage() + $loop->iteration }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $rating->alternative->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $rating->criterion->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $rating->criterion->category->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap font-semibold">{{ $rating->value }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('ratings.edit', $rating) }}" class="text-green-600 hover:text-green-900 mr-2">Edit</a>
                                    <form action="{{ route('ratings.destroy', $rating) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus penilaian ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $ratings->links() }}
            </div>
        @else
            <p class="text-gray-500">Belum ada penilaian. <a href="{{ route('ratings.create') }}" class="text-blue-500">Input penilaian pertama</a></p>
        @endif
    </div>
</div>
@endsection

