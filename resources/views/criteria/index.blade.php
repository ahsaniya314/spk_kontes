@extends('layouts.app')

@section('title', 'Daftar Kriteria')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">Daftar Kriteria</h2>
            <a href="{{ route('criteria.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Tambah Kriteria
            </a>
        </div>

        @if($criteria->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bobot</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($criteria as $criterion)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ ($criteria->currentPage() - 1) * $criteria->perPage() + $loop->iteration }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $criterion->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $criterion->category->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $criterion->weight }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs rounded {{ $criterion->type === 'benefit' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $criterion->type === 'benefit' ? 'Benefit' : 'Cost' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('criteria.show', $criterion) }}" class="text-blue-600 hover:text-blue-900 mr-2">Lihat</a>
                                    <a href="{{ route('criteria.edit', $criterion) }}" class="text-green-600 hover:text-green-900 mr-2">Edit</a>
                                    <form action="{{ route('criteria.destroy', $criterion) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kriteria ini?');">
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
                {{ $criteria->links() }}
            </div>
        @else
            <p class="text-gray-500">Belum ada kriteria. <a href="{{ route('criteria.create') }}" class="text-blue-500">Tambah kriteria pertama</a></p>
        @endif
    </div>
</div>
@endsection

