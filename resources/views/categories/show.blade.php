@extends('layouts.app')

@section('title', 'Detail Kategori')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">Detail Kategori: {{ $category->name }}</h2>
            <div>
                <a href="{{ route('categories.edit', $category) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mr-2">
                    Edit
                </a>
                <a href="{{ route('categories.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Kembali
                </a>
            </div>
        </div>

        <div class="mb-6">
            <p class="text-gray-700"><strong>Deskripsi:</strong> {{ $category->description ?? '-' }}</p>
        </div>

        <h3 class="text-xl font-semibold mb-4">Kriteria dalam Kategori ini ({{ $category->criteria->count() }})</h3>

        @if($category->criteria->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bobot</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($category->criteria as $criterion)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $criterion->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $criterion->weight }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs rounded {{ $criterion->type === 'benefit' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $criterion->type === 'benefit' ? 'Benefit' : 'Cost' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('criteria.show', $criterion) }}" class="text-blue-600 hover:text-blue-900">Lihat</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500">Belum ada kriteria dalam kategori ini.</p>
        @endif
    </div>
</div>
@endsection

