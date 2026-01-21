@extends('layouts.app')

@section('title', 'Input Penilaian')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <h2 class="text-2xl font-bold mb-4">Input Penilaian</h2>

        <form action="{{ route('ratings.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="alternative_id" class="block text-gray-700 text-sm font-bold mb-2">Alternatif *</label>
                <select name="alternative_id" id="alternative_id" required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="">Pilih Alternatif</option>
                    @foreach($alternatives as $alternative)
                        <option value="{{ $alternative->id }}" {{ old('alternative_id') == $alternative->id ? 'selected' : '' }}>
                            {{ $alternative->code }} - {{ $alternative->name }}
                        </option>
                    @endforeach
                </select>
                @error('alternative_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="criterion_id" class="block text-gray-700 text-sm font-bold mb-2">Kriteria *</label>
                <select name="criterion_id" id="criterion_id" required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="">Pilih Kriteria</option>
                    @foreach($criteria as $criterion)
                        <option value="{{ $criterion->id }}" {{ old('criterion_id') == $criterion->id ? 'selected' : '' }}>
                            [{{ $criterion->category->name }}] {{ $criterion->name }} (Bobot: {{ $criterion->weight }})
                        </option>
                    @endforeach
                </select>
                @error('criterion_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="value" class="block text-gray-700 text-sm font-bold mb-2">Nilai *</label>
                <input type="number" name="value" id="value" value="{{ old('value') }}" step="0.01" min="0" required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <p class="text-gray-500 text-xs mt-1">Masukkan nilai penilaian (minimal 0)</p>
                @error('value')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ route('ratings.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Batal
                </a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

