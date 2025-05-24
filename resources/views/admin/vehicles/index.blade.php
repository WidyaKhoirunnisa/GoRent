@extends('layouts.admin')

@section('title', 'Manajemen Kendaraan')
@section('header', 'Manajemen Kendaraan')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold text-center mb-8">Kelola Kendaraan</h1>

    <!-- Pencarian dan Filter -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        @php
        $vehicleFiltersData = [
        [
        'type' => 'text',
        'name' => 'search',
        'label' => 'Cari Kendaraan',
        'placeholder' => 'Cari berdasarkan merek, nomor polisi, atau tipe...'
        // Catatan: Ikon search dan tombol clear di dalam input adalah kustomisasi HTML/CSS
        // yang tidak langsung dibuat oleh komponen ini.
        ],
        [
        'type' => 'select',
        'name' => 'condition',
        'label' => 'Kondisi',
        'options' => [
        '' => 'Semua Kondisi', // Opsi "Semua" dengan value kosong
        'Normal' => 'Normal',
        'Service' => 'Service',
        ]
        // Catatan: Atribut onchange="updateReadyFilter()" perlu ditangani via JS di view utama.
        ]
        ];
        @endphp
        <x-admin-search
            route="vehicles.manage.index"
            :filters="$vehicleFiltersData"
            :filters-grid-cols="2" {{-- Sesuaikan jumlah kolom grid jika perlu. Misal 3 untuk 3 filter utama. --}} />
    </div>

    <!-- Filter Jenis Kendaraan -->
    <div class="flex flex-wrap justify-center gap-4 mb-8">
        <div class="flex flex-wrap justify-center gap-4 mb-4">
            <a href="{{ route('vehicles.manage.index', array_merge(request()->except('type', 'page'), ['type' => 'all'])) }}"
                class="inline-flex items-center px-6 py-2 rounded-full {{ $activeType === 'all' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-800' }}">
                Semua Kendaraan
            </a>

            <a href="{{ route('vehicles.manage.index', array_merge(request()->except('type', 'page'), ['type' => 'sedan'])) }}"
                class="inline-flex items-center px-6 py-2 rounded-full {{ $activeType === 'sedan' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-800' }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 mr-2">
                    <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.5 2.8C1.4 11.3 1 12.1 1 13v3c0 .6.4 1 1 1h2"></path>
                    <circle cx="7" cy="17" r="2"></circle>
                    <circle cx="17" cy="17" r="2"></circle>
                </svg>
                Sedan
            </a>

            <a href="{{ route('vehicles.manage.index', array_merge(request()->except('type', 'page'), ['type' => 'city car'])) }}"
                class="inline-flex items-center px-6 py-2 rounded-full {{ $activeType === 'city car' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-800' }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 mr-2">
                    <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.5 2.8C1.4 11.3 1 12.1 1 13v3c0 .6.4 1 1 1h2"></path>
                    <circle cx="7" cy="17" r="2"></circle>
                    <circle cx="17" cy="17" r="2"></circle>
                </svg>
                City Car
            </a>

            <a href="{{ route('vehicles.manage.index', array_merge(request()->except('type', 'page'), ['type' => 'pickup'])) }}"
                class="inline-flex items-center px-6 py-2 rounded-full {{ $activeType === 'pickup' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-800' }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 mr-2">
                    <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.5 2.8C1.4 11.3 1 12.1 1 13v3c0 .6.4 1 1 1h2"></path>
                    <circle cx="7" cy="17" r="2"></circle>
                    <circle cx="17" cy="17" r="2"></circle>
                </svg>
                Pickup
            </a>

            <a href="{{ route('vehicles.manage.index', array_merge(request()->except('type', 'page'), ['type' => 'suv'])) }}"
                class="inline-flex items-center px-6 py-2 rounded-full {{ $activeType === 'suv' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-800' }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 mr-2">
                    <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.5 2.8C1.4 11.3 1 12.1 1 13v3c0 .6.4 1 1 1h2"></path>
                    <circle cx="7" cy="17" r="2"></circle>
                    <circle cx="17" cy="17" r="2"></circle>
                </svg>
                SUV
            </a>

            <a href="{{ route('vehicles.manage.index', array_merge(request()->except('type', 'page'), ['type' => 'minivan'])) }}"
                class="inline-flex items-center px-6 py-2 rounded-full {{ $activeType === 'minivan' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-800' }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 mr-2">
                    <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.5 2.8C1.4 11.3 1 12.1 1 13v3c0 .6.4 1 1 1h2"></path>
                    <circle cx="7" cy="17" r="2"></circle>
                    <circle cx="17" cy="17" r="2"></circle>
                </svg>
                Minivan
            </a>
        </div>
    </div>

    <!-- Tombol Tambah dan Opsi Per Halaman -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-8">
        <a href="{{ route('vehicles.manage.create') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-6 rounded-full transition duration-200 mb-4 md:mb-0">
            <i class="fas fa-plus mr-2"></i> Tambah Kendaraan Baru
        </a>

        <div class="flex items-center space-x-2">
            <span class="text-gray-600">Tampilkan:</span>
            @foreach ([6, 12, 24, 48] as $perPage)
            <a href="{{ route('vehicles.manage.index', array_merge(request()->except('per_page', 'page'), ['per_page' => $perPage])) }}"
                class="px-3 py-1 {{ request('per_page', 12) == $perPage ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-800' }} rounded-md">
                {{ $perPage }}
            </a>
            @endforeach
        </div>
    </div>

    <!-- Informasi Hasil -->
    @if(request('search') || request('condition') || request('ready') || (request('type') && request('type') != 'all'))
    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3 flex-grow">
                <p class="text-sm text-blue-700">
                    Menampilkan hasil pencarian untuk
                    @if(request('search'))<span class="font-medium">"{{ request('search') }}"</span>@endif
                    @if(request('condition'))<span class="font-medium">kondisi {{ request('condition') }}</span>@endif
                    @if(request('ready') !== null && request('ready') !== '')<span class="font-medium">{{ request('ready') == '1' ? 'tersedia' : 'tidak tersedia' }}</span>@endif
                    @if(request('type') && request('type') != 'all')<span class="font-medium">tipe {{ request('type') }}</span>@endif
                </p>
            </div>
            <div class="ml-auto">
                <a href="{{ route('vehicles.manage.index') }}" class="text-sm text-blue-700 hover:underline flex items-center">
                    <i class="fas fa-times-circle mr-1"></i> Reset Filter
                </a>
            </div>
        </div>
    </div>
    @endif

    <!-- Grid Kendaraan -->
    <x-vehicle-grid
        :vehicles="$vehicles"
        :showPrice="true"
        :showStatus="true"
        :showRentalInfo="false"
        :showActions="true"
        :isAdmin="true" />

    <!-- Informasi Pagination -->
    <div class="mt-6 text-center text-gray-600">
        Menampilkan {{ $vehicles->firstItem() ?? 0 }} - {{ $vehicles->lastItem() ?? 0 }} dari {{ $vehicles->total() }} kendaraan
    </div>

    <!-- Pagination Navigation -->
    <div class="mt-8 flex justify-center">
        @if ($vehicles->hasPages())
        <div class="flex flex-wrap items-center justify-center gap-2">
            <!-- Tombol Previous -->
            @if ($vehicles->onFirstPage())
            <span class="px-4 py-2 bg-gray-200 text-gray-500 rounded-md cursor-not-allowed">
                <i class="fas fa-chevron-left mr-1"></i> Sebelumnya
            </span>
            @else
            <a href="{{ $vehicles->appends(request()->except('page'))->previousPageUrl() }}"
                class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition duration-200">
                <i class="fas fa-chevron-left mr-1"></i> Sebelumnya
            </a>
            @endif

            <!-- Nomor Halaman -->
            <div class="flex items-center space-x-1">
                @php
                $start = max($vehicles->currentPage() - 2, 1);
                $end = min($start + 4, $vehicles->lastPage());
                $start = max(min($end - 4, $start), 1);
                @endphp

                @if ($start > 1)
                <a href="{{ $vehicles->appends(request()->except('page'))->url(1) }}"
                    class="px-3 py-1 rounded-md hover:bg-gray-100">1</a>
                @if ($start > 2)
                <span class="px-1">...</span>
                @endif
                @endif

                @for ($i = $start; $i <= $end; $i++)
                    @if ($i==$vehicles->currentPage())
                    <span class="px-3 py-1 bg-indigo-600 text-white rounded-md">{{ $i }}</span>
                    @else
                    <a href="{{ $vehicles->appends(request()->except('page'))->url($i) }}"
                        class="px-3 py-1 rounded-md hover:bg-gray-100">{{ $i }}</a>
                    @endif
                    @endfor

                    @if ($end < $vehicles->lastPage())
                        @if ($end < $vehicles->lastPage() - 1)
                            <span class="px-1">...</span>
                            @endif
                            <a href="{{ $vehicles->appends(request()->except('page'))->url($vehicles->lastPage()) }}"
                                class="px-3 py-1 rounded-md hover:bg-gray-100">{{ $vehicles->lastPage() }}</a>
                            @endif
            </div>

            <!-- Tombol Next -->
            @if ($vehicles->hasMorePages())
            <a href="{{ $vehicles->appends(request()->except('page'))->nextPageUrl() }}"
                class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition duration-200">
                Selanjutnya <i class="fas fa-chevron-right ml-1"></i>
            </a>
            @else
            <span class="px-4 py-2 bg-gray-200 text-gray-500 rounded-md cursor-not-allowed">
                Selanjutnya <i class="fas fa-chevron-right ml-1"></i>
            </span>
            @endif
        </div>
        @endif
    </div>
</div>
@endsection