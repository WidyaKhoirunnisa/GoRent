@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Car Header Section -->
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold">{{ $vehicle->brand }}</h1>
            <p class="text-gray-600">{{ ucfirst($vehicle->type) }}</p>
            <div class="flex items-center mt-1">
                <span class="text-2xl font-bold text-indigo-600">$25</span>
                <span class="text-gray-500 ml-1">/ day</span>
            </div>
        </div>
        <a class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-lg font-semibold rounded-lg shadow-md transition duration-200">
            Rent a Car
        </a>
    </div>
    

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Car Image Section -->
        <div>
            <!-- Main Car Image -->
            <div class="bg-white rounded-lg p-4 mb-4">
                @if($vehicle->image)
                <img src="{{ asset('images/vehicles/' . $vehicle->image) }}" alt="{{ $vehicle->brand }}" class="w-full h-auto object-contain">
                @else
                <img src="/placeholder.svg?" alt="{{ $vehicle->brand }}" class="w-full h-auto object-contain">
                @endif
            </div>
        </div>

        <!-- Car Details Section -->
        <div>
            <!-- Technical Specifications -->
            <div class="mb-8">
                <h2 class="text-xl font-bold mb-4">Deskripsi Kendaraan</h2>

                <div class="grid grid-cols-3 gap-4">
                    <!-- Plat Nomer -->
                    <div class="bg-gray-100 rounded-lg p-4">
                        <div class="flex justify-center mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2 " stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 mr-1">
                            <rect x="2" y="6" width="20" height="12" rx="2" ry="2"></rect>
                            <line x1="2" y1="13" x2="22" y2="13"></line>
                        </svg>
                        </div>
                        <div class="text-center">
                            <p class="text-sm font-medium">Nomer Plat</p>
                            <p class="text-gray-500">{{ ucfirst($vehicle->no_plat) }}</p>
                        </div>
                    </div>

                    <!-- Tahun Pembuatan -->
                    <div class="bg-gray-100 rounded-lg p-4">
                        <div class="flex justify-center mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 mr-1">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                        </div>
                        <div class="text-center">
                            <p class="text-sm font-medium">Tahun Pembuatan</p>
                            <p class="text-gray-500">{{ ucfirst($vehicle->year) }}</p>
                        </div>
                    </div>

                    <!-- Warna -->
                    <div class="bg-gray-100 rounded-lg p-4">
                        <div class="flex justify-center mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 mr-1">
                                <circle cx="13.5" cy="6.5" r="4"></circle>
                                <circle cx="19" cy="17" r="2"></circle>
                                <circle cx="6" cy="17" r="2"></circle>
                                <path d="M16 14h-5a2 2 0 0 0-1.95 1.55L8 19h8l-1.05-3.45A2 2 0 0 0 13 14Z"></path>
                            </svg>
                        </div>
                         <div class="text-center">
                            <p class="text-sm font-medium">Warna</p>
                            <p class="text-gray-500">{{ ucfirst($vehicle->color) }}</p>
                        </div>
                    </div>

                    <!-- Kondisi -->
                    <div class="bg-gray-100 rounded-lg p-4">
                        <div class="flex justify-center mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 mr-1">
                                <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.5 2.8C1.4 11.3 1 12.1 1 13v3c0 .6.4 1 1 1h2"></path>
                                <circle cx="7" cy="17" r="2"></circle>
                                <circle cx="17" cy="17" r="2"></circle>
                            </svg>
                        </div>
                        <div class="text-center">
                            <p class="text-sm font-medium">Kondisi</p>
                            <p class="text-gray-500">{{ ucfirst($vehicle->condition) }}</p>
                        </div>
                    </div>

                    <!-- Ketersediaan -->
                    <div class="bg-gray-100 rounded-lg p-4">
                        <div class="flex justify-center mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 mr-1">
                                <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.5 2.8C1.4 11.3 1 12.1 1 13v3c0 .6.4 1 1 1h2"></path>
                                <circle cx="7" cy="17" r="2"></circle>
                                <circle cx="17" cy="17" r="2"></circle>
                            </svg>
                        </div>
                        <div class="text-center">
                            <p class="text-sm font-medium">Ketersediaan</p>
                            <p class="text-gray-500">{{ $vehicle->ready == 1 ? 'Tersedia' : 'Tidak Tersedia' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection