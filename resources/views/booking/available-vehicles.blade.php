@extends('layouts.app')

@section('title', 'Kendaraan Tersedia')

@section('content')
<div class="container mx-auto px-4 py-8">

    <div class="flex items-center mb-10">
        <a href="{{ route('booking.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 transition-colors font-medium">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 mr-2">
                <path d="M19 12H5"></path>
                <path d="M12 19l-7-7 7-7"></path>
            </svg>
            Kembali
        </a>
    </div>
    <!-- Booking Progress -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between max-w-3xl mx-auto">
                <div class="flex flex-col items-center">
                    <div class="w-10 h-10 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold">1</div>
                    <span class="text-sm mt-2 text-gray-600">Pilih Tanggal</span>
                </div>
                <div class="flex-1 h-1 bg-indigo-600 mx-2"></div>
                <div class="flex flex-col items-center">
                    <div class="w-10 h-10 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold">2</div>
                    <span class="text-sm mt-2 font-medium text-indigo-600">Pilih Kendaraan</span>
                </div>
                <div class="flex-1 h-1 bg-gray-300 mx-2"></div>
                <div class="flex flex-col items-center">
                    <div class="w-10 h-10 bg-gray-300 text-white rounded-full flex items-center justify-center font-bold">3</div>
                    <span class="text-sm mt-2 text-gray-600">Buat Pesanan</span>
                </div>
            </div>
        </div>

        <!-- Header Section -->
        <div class="bg-gradient-to-r from-indigo-600 to-purple-700 p-8 text-white">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold mb-2">Kendaraan Tersedia</h1>
                    <div class="flex items-center text-white/90">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 mr-2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        <span>{{ \Carbon\Carbon::parse($rental_date)->translatedFormat('d F Y') }} - {{ \Carbon\Carbon::parse($return_date)->translatedFormat('d F Y') }}</span>
                        <span class="mx-2">•</span>
                        <span class="font-medium">{{ $rental_duration }} {{ Str('hari', $rental_duration) }}</span>
                    </div>
                </div>

                <div class="mt-4 md:mt-0 bg-white/10 backdrop-blur-sm px-5 py-3 rounded-xl border border-white/20">
                    <div class="text-sm text-white/80">Total Durasi Sewa</div>
                    <div class="text-2xl font-bold">{{ $rental_duration }} {{ Str('Hari', $rental_duration) }}</div>
                </div>
            </div>
        </div>
    </div>

    @if(session('error'))
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg shadow-sm">
        <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p>{{ session('error') }}</p>
        </div>
    </div>
    @endif

    @if(count($vehicles) > 0)
    <!-- Vehicle Type Filters -->
    <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Filter Jenis Kendaraan</h2>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('booking.check-availability', ['type' => 'all', 'rental_date' => $rental_date, 'return_date' => $return_date]) }}"
                class="inline-flex items-center px-6 py-3 rounded-full transition-all duration-300 {{ $activeType === 'all' ? 'bg-indigo-600 text-white shadow-md' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 mr-2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="8" y1="12" x2="16" y2="12"></line>
                    <line x1="12" y1="8" x2="12" y2="16"></line>
                </svg>
                Semua Kendaraan
            </a>

            @foreach($vehicleTypes as $vehicleType)
            <a href="{{ route('booking.check-availability', ['type' => $vehicleType, 'rental_date' => $rental_date, 'return_date' => $return_date]) }}"
                class="inline-flex items-center px-6 py-3 rounded-full transition-all duration-300 {{ $activeType === $vehicleType ? 'bg-indigo-600 text-white shadow-md' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 mr-2">
                    <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.5 2.8C1.4 11.3 1 12.1 1 13v3c0 .6.4 1 1 1h2"></path>
                    <circle cx="7" cy="17" r="2"></circle>
                    <circle cx="17" cy="17" r="2"></circle>
                </svg>
                {{ ucfirst($vehicleType) }}
            </a>
            @endforeach
        </div>
    </div>

    <!-- Results Summary -->
    <div class="flex justify-between items-center mb-6">
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
        :showActions="true"
        :showStatus="false"
        :showRentalInfo="true"
        :rentalDuration="$rental_duration"
        :rentalDate="$rental_date"
        :returnDate="$return_date"
        customerView />

    @else
    <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-yellow-100 rounded-full mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-10 h-10 text-yellow-600">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="12"></line>
                <line x1="12" y1="16" x2="12.01" y2="16"></line>
            </svg>
        </div>
        <h2 class="text-2xl font-bold text-gray-800 mb-3">Tidak Ada Kendaraan Tersedia</h2>
        <p class="text-gray-600 mb-8 max-w-md mx-auto">Maaf, tidak ada kendaraan yang tersedia untuk tanggal yang dipilih. Silakan coba tanggal yang berbeda.</p>
        <a href="{{ route('booking.index') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 transition-colors shadow-md hover:shadow-indigo-500/30">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 mr-2">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                <line x1="16" y1="2" x2="16" y2="6"></line>
                <line x1="8" y1="2" x2="8" y2="6"></line>
                <line x1="3" y1="10" x2="21" y2="10"></line>
            </svg>
            Ubah Tanggal
        </a>
    </div>
    @endif
</div>
@endsection