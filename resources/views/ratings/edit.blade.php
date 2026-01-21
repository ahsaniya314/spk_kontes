@extends('layouts.app')

@section('title', 'Edit Penilaian')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <h2 class="text-2xl font-bold mb-4">Edit Penilaian</h2>

        <form action="{{ route('ratings.update', $rating) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Alternatif</label>
                <input type="text" value="{{ $rating->alternative->code }} - {{ $rating->alternative->name }}" disabled
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-500 bg-gray-100">
                <p class="text-gray-500 text-xs mt-1">Alternatif tidak dapat diubah</p>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Kriteria</label>
                <input type="text" value="{{ $rating->criterion->category->name }} - {{ $rating->criterion->name }}" disabled
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-500 bg-gray-100">
                <p class="text-gray-500 text-xs mt-1">Kriteria tidak dapat diubah</p>
            </div>

            <div class="mb-4">
                <label for="value" class="block text-gray-700 text-sm font-bold mb-2">Nilai *</label>
                <input type="number" name="value" id="value" value="{{ old('value', $rating->value) }}" step="0.01" min="0" required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                @error('value')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ route('ratings.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Batal
                </a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

