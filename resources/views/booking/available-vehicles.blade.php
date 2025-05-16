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
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($vehicles as $vehicle)
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
            <div class="bg-white p-6 flex items-center justify-center h-48">
                @if($vehicle->image)
                <img src="{{ asset('storage/vehicles/' . basename($vehicle->image)) }}" alt="{{ $vehicle->brand }}" class="max-h-full max-w-full object-contain">
                @else
                <div class="flex flex-col items-center justify-center text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="text-sm font-medium">Tidak Ada Gambar</p>
                </div>
                @endif
            </div>

            <div class="p-6">
                <div class="flex justify-between items-center mb-3">
                    <div>
                        <h3 class="font-bold text-lg text-gray-900">{{ $vehicle->brand }}</h3>
                        <p class="text-sm text-gray-500">{{ ucfirst($vehicle->type) }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-indigo-600">Rp {{ number_format($vehicle->price, 0, ',', '.') }}</p>
                        <p class="text-xs text-gray-500">per hari</p>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-2 mb-4">
                    <div class="flex flex-col items-center bg-gray-50 rounded-lg p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-indigo-500 mb-1">
                            <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.5 2.8C1.4 11.3 1 12.1 1 13v3c0 .6.4 1 1 1h2"></path>
                            <circle cx="7" cy="17" r="2"></circle>
                            <circle cx="17" cy="17" r="2"></circle>
                        </svg>
                        <span class="text-xs font-medium">{{ ucfirst($vehicle->condition) }}</span>
                    </div>

                    <div class="flex flex-col items-center bg-gray-50 rounded-lg p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-indigo-500 mb-1">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        <span class="text-xs font-medium">{{ $vehicle->year }}</span>
                    </div>

                    <div class="flex flex-col items-center bg-gray-50 rounded-lg p-2">
                        <div class="flex items-center mb-1">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-indigo-500">
                                <circle cx="13.5" cy="6.5" r="4"></circle>
                                <circle cx="19" cy="17" r="2"></circle>
                                <circle cx="6" cy="17" r="2"></circle>
                                <path d="M16 14h-5a2 2 0 0 0-1.95 1.55L8 19h8l-1.05-3.45A2 2 0 0 0 13 14Z"></path>
                            </svg>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full mr-1 border border-gray-300" style="background-color: {{ strtolower($vehicle->color) }}"></div>
                            <span class="text-xs font-medium">{{ ucfirst($vehicle->color) }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-indigo-50 rounded-xl p-4 mb-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm text-gray-600">Total untuk {{ $rental_duration }} {{ Str('hari', $rental_duration) }}:</p>
                            <p class="text-xl font-bold text-indigo-600">Rp {{ number_format($vehicle->price * $rental_duration, 0, ',', '.') }}</p>
                        </div>
                        <div class="bg-white rounded-full p-2 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-indigo-600">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                        </div>
                    </div>
                </div>

                <form action="{{ route('booking.book-vehicle', $vehicle->id) }}" method="GET">
                    <input type="hidden" name="rental_date" value="{{ $rental_date }}">
                    <input type="hidden" name="return_date" value="{{ $return_date }}">
                    <button type="submit" class="w-full py-3 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 transition-colors shadow-md hover:shadow-indigo-500/30 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 mr-2">
                            <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Sewa Kendaraan Ini
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>

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