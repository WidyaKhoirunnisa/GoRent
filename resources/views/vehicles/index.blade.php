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
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($vehicles as $vehicle)
        <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 group border border-gray-100">
            <div class="bg-white p-6 flex items-center justify-center h-56 overflow-hidden">
                @if($vehicle->image)
                    <img loading="lazy" src="{{ asset('storage/vehicles/' . basename($vehicle->image)) }}" 
                         alt="{{ $vehicle->brand }}" 
                         class="h-40 object-contain group-hover:scale-110 transition-transform duration-500">
                @else
                    <img src="{{ asset('images/placeholder.svg') }}" 
                         alt="No Image" 
                         class="h-40 object-contain opacity-50 group-hover:scale-110 transition-transform duration-500">
                @endif
            </div>
            
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <div class="w-1/2 truncate">
                        <h3 class="text-xl font-bold truncate">{{ $vehicle->brand }}</h3>
                        <p class="text-gray-500">{{ ucfirst($vehicle->type) }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-2xl font-bold text-indigo-600">Rp {{ number_format($vehicle->price, 0, ',', '.') }}</p>
                        <p class="text-sm text-gray-500">per hari</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-3 gap-2 mb-6">
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
                
                <a href="{{ route('vehicles.details', $vehicle->id) }}" class="block w-full py-3 text-center bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 transition-colors duration-300">Lihat Detail</a>
            </div>
        </div>
        @endforeach
    </div>
    
    @if(count($vehicles) === 0)
    <div class="bg-white rounded-xl p-12 text-center shadow-md border border-gray-100">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-16 h-16 mx-auto text-gray-400 mb-4">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="12" y1="8" x2="12" y2="12"></line>
            <line x1="12" y1="16" x2="12.01" y2="16"></line>
        </svg>
        <h3 class="text-xl font-bold text-gray-800 mb-2">Tidak Ada Kendaraan Ditemukan</h3>
        <p class="text-gray-600 mb-6">Kami tidak dapat menemukan kendaraan yang sesuai dengan kriteria Anda.</p>
        <a href="{{ route('vehicles', ['type' => 'all']) }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 transition-colors duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 mr-2">
                <polyline points="15 18 9 12 15 6"></polyline>
            </svg>
            Lihat Semua Kendaraan
        </a>
    </div>
    @endif
    
    <!-- Pagination (if needed) -->
    @if(isset($vehicles) && method_exists($vehicles, 'links') && $vehicles->hasPages())
    <div class="mt-12">
        {{ $vehicles->links() }}
    </div>
    @endif
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

