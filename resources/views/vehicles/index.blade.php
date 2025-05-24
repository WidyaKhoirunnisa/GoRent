@extends('layouts.app')

@section('content')
<!-- Header Section -->
<section class="relative bg-gradient-to-r from-indigo-600 to-purple-700 py-16 overflow-hidden">
    <div class="absolute inset-0 opacity-20">
        <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%">
            <defs>
                <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                    <path d="M0 40L40 0M20 40L40 20M0 20L20 0" stroke="white" stroke-width="1" fill="none" />
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#grid)" />
        </svg>
    </div>
    <div class="container mx-auto px-4 relative">
        <h1 class="text-4xl md:text-5xl font-bold text-white text-center mb-4">Jelajahi Koleksi Kendaraan Kami</h1>
        <p class="text-white/80 text-center max-w-2xl mx-auto">Temukan kendaraan sempurna untuk perjalanan Anda dari berbagai pilihan mobil berkualitas kami</p>
    </div>
</section>

<div class="container mx-auto px-4 py-12">
    <!-- Vehicle Type Filters -->
    <div class="bg-white rounded-xl shadow-lg p-6 -mt-12 mb-12 relative z-10">
        <h2 class="text-xl font-semibold text-gray-800 mb-4 text-center">Pilih Jenis Kendaraan</h2>
        <div class="flex flex-wrap justify-center gap-3">
            <a href="{{ route('vehicles', ['type' => 'all']) }}"
                class="inline-flex items-center px-6 py-3 rounded-full transition-all duration-300 {{ $activeType === 'all' ? 'bg-indigo-600 text-white shadow-md' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 mr-2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="8" y1="12" x2="16" y2="12"></line>
                    <line x1="12" y1="8" x2="12" y2="16"></line>
                </svg>
                Semua Kendaraan
            </a>

            <a href="{{ route('vehicles', ['type' => 'sedan']) }}"
                class="inline-flex items-center px-6 py-3 rounded-full transition-all duration-300 {{ $activeType === 'sedan' ? 'bg-indigo-600 text-white shadow-md' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 mr-2">
                    <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.5 2.8C1.4 11.3 1 12.1 1 13v3c0 .6.4 1 1 1h2"></path>
                    <circle cx="7" cy="17" r="2"></circle>
                    <circle cx="17" cy="17" r="2"></circle>
                </svg>
                Sedan
            </a>

            <a href="{{ route('vehicles', ['type' => 'city car']) }}"
                class="inline-flex items-center px-6 py-3 rounded-full transition-all duration-300 {{ $activeType === 'city car' ? 'bg-indigo-600 text-white shadow-md' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 mr-2">
                    <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.5 2.8C1.4 11.3 1 12.1 1 13v3c0 .6.4 1 1 1h2"></path>
                    <circle cx="7" cy="17" r="2"></circle>
                    <circle cx="17" cy="17" r="2"></circle>
                </svg>
                City Car
            </a>

            <a href="{{ route('vehicles', ['type' => 'pickup']) }}"
                class="inline-flex items-center px-6 py-3 rounded-full transition-all duration-300 {{ $activeType === 'pickup' ? 'bg-indigo-600 text-white shadow-md' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 mr-2">
                    <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.5 2.8C1.4 11.3 1 12.1 1 13v3c0 .6.4 1 1 1h2"></path>
                    <circle cx="7" cy="17" r="2"></circle>
                    <circle cx="17" cy="17" r="2"></circle>
                </svg>
                Pickup
            </a>

            <a href="{{ route('vehicles', ['type' => 'suv']) }}"
                class="inline-flex items-center px-6 py-3 rounded-full transition-all duration-300 {{ $activeType === 'suv' ? 'bg-indigo-600 text-white shadow-md' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 mr-2">
                    <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.5 2.8C1.4 11.3 1 12.1 1 13v3c0 .6.4 1 1 1h2"></path>
                    <circle cx="7" cy="17" r="2"></circle>
                    <circle cx="17" cy="17" r="2"></circle>
                </svg>
                SUV
            </a>

            <a href="{{ route('vehicles', ['type' => 'minivan']) }}"
                class="inline-flex items-center px-6 py-3 rounded-full transition-all duration-300 {{ $activeType === 'minivan' ? 'bg-indigo-600 text-white shadow-md' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 mr-2">
                    <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.5 2.8C1.4 11.3 1 12.1 1 13v3c0 .6.4 1 1 1h2"></path>
                    <circle cx="7" cy="17" r="2"></circle>
                    <circle cx="17" cy="17" r="2"></circle>
                </svg>
                Minivan
            </a>
        </div>
    </div>

    <!-- Results Summary -->
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-2xl font-bold text-gray-800">
            @if($activeType === 'all')
            Semua Kendaraan
            @else
            {{ ucfirst($activeType) }}
            @endif
        </h2>
        <p class="text-gray-600">{{ count($vehicles) }} kendaraan ditemukan</p>
    </div>

    <!-- Vehicle Grid -->
    <x-vehicle-grid
        :vehicles="$vehicles"
        :showPrice="true"
        :showStatus="false"
        :showActions="true"
        :showRentalInfo="false"
        :isAdmin="false"
        :customerView="true"
        emptyMessage="Tidak Ada Kendaraan Ditemukan"
        emptyDescription="Kami tidak dapat menemukan kendaraan yang sesuai dengan kriteria Anda." />


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

<!-- Call to Action -->
<section class="bg-gray-50 py-16 mt-12">
    <div class="container mx-auto px-4">
        <div class="bg-gradient-to-r from-indigo-600 to-purple-700 rounded-2xl overflow-hidden shadow-xl">
            <div class="p-8 md:p-12 text-center">
                <h2 class="text-3xl font-bold text-white mb-4">Siap Memesan Kendaraan Impian Anda?</h2>
                <p class="text-white/80 max-w-2xl mx-auto mb-8">Silahkan lakukan pemesanan kendaraan berdasarkan kebutuhan perjalanan Anda.</p>
                <a href="{{ url('/booking') }}" class="inline-block px-8 py-4 bg-white text-indigo-700 rounded-lg font-semibold hover:bg-indigo-50 transition-colors duration-300">
                    Pesan Sekarang
                </a>
            </div>
        </div>
    </div>
</section>
@endsection