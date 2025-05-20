@extends('layouts.admin')

@section('title', 'Manajemen Kendaraan')
@section('header', 'Manajemen Kendaraan')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold text-center mb-8">Kelola Kendaraan</h1>

    <!-- Pencarian dan Filter -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <form action="{{ route('vehicles.manage.index') }}" method="GET" class="mb-6" id="filterForm">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari Kendaraan</label>
                    <div class="relative">
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                            placeholder="Cari berdasarkan merek, nomor polisi, atau tipe..."
                            class="w-full px-4 py-2 pl-10 pr-10 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        @if(request('search'))
                        <button type="button" id="clearSearch" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        @endif
                    </div>
                </div>
                <div class="w-full md:w-1/4">
                    <label for="condition" class="block text-sm font-medium text-gray-700 mb-1">Kondisi</label>
                    <select name="condition" id="condition" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" onchange="updateReadyFilter()">
                        <option value="">Semua Kondisi</option>
                        <option value="Normal" {{ request('condition') == 'Normal' ? 'selected' : '' }}>Normal</option>
                        <option value="Service" {{ request('condition') == 'Service' ? 'selected' : '' }}>Servis</option>
                    </select>
                </div>
                <div class="w-full md:w-1/4">
                    <label for="ready" class="block text-sm font-medium text-gray-700 mb-1">Ketersediaan</label>
                    <select name="ready" id="ready" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" {{ request('condition') == 'Service' ? 'disabled' : '' }}>
                        <option value="">Semua Status</option>
                        <option value="1" {{ request('ready') == '1' ? 'selected' : '' }}>Tersedia</option>
                        <option value="0" {{ request('ready') == '0' || request('condition') == 'Service' ? 'selected' : '' }}>Tidak Tersedia</option>
                    </select>
                    @if(request('condition') == 'Service')
                    <input type="hidden" name="ready" value="0">
                    @endif
                </div>
                <div class="w-full md:w-auto flex items-end space-x-2">
                    <button type="submit" class="w-full md:w-auto px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        <i class="fas fa-filter mr-1"></i> Filter
                    </button>
                    @if(request()->anyFilled(['search', 'condition', 'ready', 'type']) && request('type') != 'all')
                    <a href="{{ route('vehicles.manage.index') }}" class="w-full md:w-auto px-6 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 flex items-center justify-center">
                        <i class="fas fa-undo-alt mr-1"></i> Reset
                    </a>
                    @endif
                </div>
            </div>
        </form>

        <!-- Informasi Filter -->
        <div class="mt-2 text-sm text-gray-600">
            <p><i class="fas fa-info-circle text-blue-500 mr-1"></i> Catatan: Gunakan filter untuk menemukan kendaraan dengan lebih cepat.</p>
        </div>
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
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($vehicles as $vehicle)
        <div class="bg-gray-50 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden">
            <div class="bg-white p-6 mb-4 flex items-center justify-center h-48">
                @if($vehicle->image)
                <img src="{{ asset('storage/vehicles/' . basename($vehicle->image)) }}"
                    alt="{{ $vehicle->brand }}"
                    class="h-full object-contain">
                @else
                <img src="{{ asset('images/placeholder.svg') }}"
                    alt="Tidak Ada Gambar"
                    class="h-full object-contain opacity-50">
                @endif
            </div>

            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h3 class="text-xl font-semibold">{{ $vehicle->brand }}</h3>
                        <p class="text-sm text-gray-500">{{ ucfirst($vehicle->type) }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-lg font-bold text-indigo-600">Rp {{ number_format($vehicle->price, 0, ',', '.') }}</p>
                        <p class="text-xs text-gray-500">per hari</p>
                    </div>
                </div>

                <div class="flex justify-between mb-6">
                    <div class="flex items-center text-sm text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 mr-1">
                            <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.5 2.8C1.4 11.3 1 12.1 1 13v3c0 .6.4 1 1 1h2"></path>
                            <circle cx="7" cy="17" r="2"></circle>
                            <circle cx="17" cy="17" r="2"></circle>
                        </svg>
                        {{ $vehicle->condition === 'Normal' ? 'Normal' : 'Servis' }}
                    </div>

                    <div class="flex items-center text-sm text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 mr-1">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        {{ ucfirst($vehicle->year) }}
                    </div>

                    <div class="flex items-center text-sm text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 mr-1">
                            <circle cx="13.5" cy="6.5" r="4"></circle>
                            <circle cx="19" cy="17" r="2"></circle>
                            <circle cx="6" cy="17" r="2"></circle>
                            <path d="M16 14h-5a2 2 0 0 0-1.95 1.55L8 19h8l-1.05-3.45A2 2 0 0 0 13 14Z"></path>
                        </svg>
                        <div class="w-3 h-3 rounded-full mr-1.5 border border-gray-300" style="background-color: {{ strtolower($vehicle->color) }};">
                        </div>
                        @php
                        $colorTranslations = [
                        'black' => 'Hitam',
                        'white' => 'Putih',
                        'red' => 'Merah',
                        'blue' => 'Biru',
                        'green' => 'Hijau',
                        'yellow' => 'Kuning',
                        'orange' => 'Oranye',
                        'purple' => 'Ungu',
                        'pink' => 'Merah Muda',
                        'brown' => 'Coklat',
                        'gray' => 'Abu-abu',
                        'silver' => 'Silver',
                        'gold' => 'Emas',
                        ];
                        $colorInIndonesian = $colorTranslations[strtolower($vehicle->color)] ?? ucfirst($vehicle->color);
                        @endphp
                        {{ $colorInIndonesian }}
                    </div>
                </div>

                <!-- Status Ketersediaan -->
                <div class="mb-4">
                    @if($vehicle->condition === 'Service')
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                        Tidak Tersedia
                    </span>
                    @else
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $vehicle->ready ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $vehicle->ready ? 'Tersedia' : 'Tidak Tersedia' }}
                    </span>
                    @endif

                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $vehicle->condition === 'Normal' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800' }} ml-2">
                        {{ $vehicle->condition }}
                    </span>
                </div>

                <div class="flex justify-between mt-4">
                    <a href="{{ route('vehicles.manage.edit', $vehicle->id) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded transition duration-200">
                        <i class="fas fa-edit mr-1"></i> Edit
                    </a>
                    <div x-data="{ open: false }">
                        <button
                            @click="open = true"
                            class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition duration-200">
                            <i class="fas fa-trash mr-1"></i> Hapus
                        </button>
                        <div
                            x-show="open"
                            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
                            x-cloak>
                            <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
                                <h2 class="text-xl font-bold mb-4">Konfirmasi Penghapusan</h2>
                                <p class="mb-6">Apakah Anda yakin ingin menghapus kendaraan ini? Tindakan ini tidak dapat dibatalkan.</p>
                                <div class="flex justify-end gap-4">
                                    <button
                                        @click="open = false"
                                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded">
                                        Batal
                                    </button>

                                    <form action="{{ route('vehicles.manage.destroy', $vehicle->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @if(count($vehicles) === 0)
    <div class="text-center py-12 bg-gray-50 rounded-lg">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mx-auto mb-4" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z" clip-rule="evenodd" />
        </svg>
        <p class="text-gray-500 text-lg">Tidak ada kendaraan ditemukan.</p>
        <p class="text-gray-500">Silakan coba filter yang berbeda atau tambahkan kendaraan baru.</p>
    </div>
    @else
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
    @endif
</div>

<script>
    function updateReadyFilter() {
        const conditionSelect = document.getElementById('condition');
        const readySelect = document.getElementById('ready');
        const filterForm = document.getElementById('filterForm');

        // Hapus hidden input jika ada sebelumnya
        const oldHiddenInput = document.querySelector('input[type="hidden"][name="ready"]');
        if (oldHiddenInput) {
            oldHiddenInput.remove();
        }

        // Hapus catatan sebelumnya
        const oldNote = document.getElementById('ready_note');
        if (oldNote) {
            oldNote.remove();
        }

        if (conditionSelect.value === 'Service') {
            readySelect.value = '0';
            readySelect.disabled = true;

            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'ready';
            hiddenInput.value = '0';
            filterForm.appendChild(hiddenInput);

            const note = document.createElement('p');
            note.id = 'ready_note';
            note.className = 'text-xs text-amber-600 mt-1';
            note.innerText = 'Kendaraan servis dianggap tidak tersedia.';
            readySelect.parentNode.appendChild(note);

        } else if (conditionSelect.value === 'Normal') {
            readySelect.disabled = true;
            readySelect.value = '1';

            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'ready';
            hiddenInput.value = '1';
            filterForm.appendChild(hiddenInput);

        } else {
            // Semua kondisi, enable ready
            readySelect.disabled = true;
            const hiddenInput = document.querySelector('input[type="hidden"][name="ready"]');
            if (hiddenInput) {
                hiddenInput.remove();
            }

            const noteElement = document.getElementById('ready_note');
            if (noteElement) {
                noteElement.remove();
            }
        }
    }


    // Jalankan fungsi saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        updateReadyFilter();

        // Tambahkan event listener untuk tombol clear search
        const clearSearchButton = document.getElementById('clearSearch');
        if (clearSearchButton) {
            clearSearchButton.addEventListener('click', function() {
                document.getElementById('search').value = '';
                // Submit form setelah menghapus nilai pencarian
                document.getElementById('filterForm').submit();
            });
        }
    });
</script>
@endsection