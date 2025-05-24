{{-- resources/views/components/search-form.blade.php --}}
@props([
    'route',
    'filters' => [], // Array konfigurasi filter
    'param' => 'search', // Untuk mode search sederhana
    'placeholder' => 'Cari...', // Untuk mode search sederhana
    'filtersGridCols' => 4, // Jumlah kolom grid untuk filter
    'simpleSearchLabel' => 'Cari' // Label untuk mode search sederhana
])

<form action="{{ route($route) }}" method="GET" class="mb-6">
    @if(count($filters) > 0)
        {{-- Tampilkan form filter lengkap --}}
        <div class="grid grid-cols-1 md:grid-cols-{{ $filtersGridCols }} gap-4">
            @foreach($filters as $filterConfig)
                <div>
                    <x-input-label for="{{ $filterConfig['name'] }}" >{{ $filterConfig['label'] }}</x-input-label>

                    @if($filterConfig['type'] === 'text')
                        <input type="text"
                               name="{{ $filterConfig['name'] }}"
                               id="{{ $filterConfig['name'] }}"
                               value="{{ request($filterConfig['name'], $filterConfig['default'] ?? '') }}"
                               placeholder="{{ $filterConfig['placeholder'] ?? '' }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">

                    @elseif($filterConfig['type'] === 'select')
                        <select name="{{ $filterConfig['name'] }}"
                                id="{{ $filterConfig['name'] }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @if(!empty($filterConfig['placeholder_option']))
                                <option value="">{{ $filterConfig['placeholder_option'] }}</option>
                            @endif
                            @foreach($filterConfig['options'] as $value => $label)
                                <option value="{{ $value }}" {{ (string)request($filterConfig['name']) === (string)$value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>

                    @elseif($filterConfig['type'] === 'date')
                        <input type="date"
                               name="{{ $filterConfig['name'] }}"
                               id="{{ $filterConfig['name'] }}"
                               value="{{ request($filterConfig['name'], $filterConfig['default'] ?? '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @endif
                </div>
            @endforeach
        </div>
    @else
        {{-- Tampilkan input search sederhana --}}
        <div>
            <x-input-label for="{{ $param }}" >{{ $simpleSearchLabel }}</x-input-label>
            <input
                type="text"
                name="{{ $param }}"
                id="{{ $param }}" {{-- Tambahkan id untuk label --}}
                value="{{ request($param) }}"
                placeholder="{{ $placeholder }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
    @endif

    {{-- Tombol Aksi (Reset & Submit) --}}
    <div class="mt-4 flex justify-end">
        <a href="{{ route($route) }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 mr-2">
            Reset
        </a>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            {{ count($filters) > 0 ? 'Filter' : 'Cari' }}
        </button>
    </div>
</form>