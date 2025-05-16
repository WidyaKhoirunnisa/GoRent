@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
            <div>
                <h1 class="text-3xl font-bold mb-2">Riwayat Pemesanan Saya</h1>
                <p class="text-indigo-100">Kelola dan pantau semua pemesanan kendaraan Anda</p>
            </div>
            
            <div class="mt-4 md:mt-0 flex flex-wrap gap-4">
                <div class="bg-white bg-opacity-20 backdrop-blur-sm rounded-xl px-4 py-3 text-center">
                    <div class="text-sm text-indigo-100">Pemesanan Aktif</div>
                    <div class="text-2xl font-bold">{{ $allRentals->where('payment_status', 'confirmed')->count() }}</div>
                </div>
                <div class="bg-white bg-opacity-20 backdrop-blur-sm rounded-xl px-4 py-3 text-center">
                    <div class="text-sm text-indigo-100">Pemesanan Selesai</div>
                    <div class="text-2xl font-bold">{{ $allRentals->where('payment_status', 'completed')->count() }}</div>
                </div>
                <div class="bg-white bg-opacity-20 backdrop-blur-sm rounded-xl px-4 py-3 text-center">
                    <div class="text-sm text-indigo-100">Total Pemesanan</div>
                    <div class="text-2xl font-bold">{{ $allRentals->count() }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mx-auto px-4 py-8">
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-sm flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 mr-3 text-green-500">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                <polyline points="22 4 12 14.01 9 11.01"></polyline>
            </svg>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg shadow-sm flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 mr-3 text-red-500">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="12"></line>
                <line x1="12" y1="16" x2="12.01" y2="16"></line>
            </svg>
            <p>{{ session('error') }}</p>
        </div>
    @endif
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8">
            <!-- Filter and Search -->
            <div class="p-6 border-b border-gray-200">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('customer.history') }}" class="inline-flex items-center px-4 py-2 {{ $activeFilter == 'all' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} rounded-full text-sm font-medium">
                            Semua
                        </a>
                        <a href="{{ route('customer.history', ['filter' => 'pending']) }}" class="inline-flex items-center px-4 py-2 {{ $activeFilter == 'pending' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} rounded-full text-sm font-medium">
                            <span class="w-2 h-2 bg-yellow-500 rounded-full mr-2"></span>
                            Menunggu Pembayaran
                        </a>
                        <a href="{{ route('customer.history', ['filter' => 'paid']) }}" class="inline-flex items-center px-4 py-2 {{ $activeFilter == 'paid' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} rounded-full text-sm font-medium">
                            <span class="w-2 h-2 bg-blue-500 rounded-full mr-2"></span>
                            Sudah Dibayar
                        </a>
                        <a href="{{ route('customer.history', ['filter' => 'confirmed']) }}" class="inline-flex items-center px-4 py-2 {{ $activeFilter == 'confirmed' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} rounded-full text-sm font-medium">
                            <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                            Dikonfirmasi
                        </a>
                        <a href="{{ route('customer.history', ['filter' => 'completed']) }}" class="inline-flex items-center px-4 py-2 {{ $activeFilter == 'completed' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} rounded-full text-sm font-medium">
                            <span class="w-2 h-2 bg-purple-500 rounded-full mr-2"></span>
                            Selesai
                        </a>
                        <a href="{{ route('customer.history', ['filter' => 'cancelled']) }}" class="inline-flex items-center px-4 py-2 {{ $activeFilter == 'cancelled' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} rounded-full text-sm font-medium">
                            <span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span>
                            Dibatalkan
                        </a>
                    </div>
                    <div class="w-full md:w-auto flex flex-col sm:flex-row gap-2">
                        <form action="{{ route('customer.history') }}" method="GET" class="flex flex-col sm:flex-row gap-2">
                            @if($activeFilter != 'all')
                                <input type="hidden" name="filter" value="{{ $activeFilter }}">
                            @endif
                            <div class="relative">
                                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari pemesanan..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 w-full">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                </svg>
                            </div>
                            <select name="sort" onchange="this.form.submit()" class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="newest" {{ $activeSort == 'newest' ? 'selected' : '' }}>Terbaru</option>
                                <option value="oldest" {{ $activeSort == 'oldest' ? 'selected' : '' }}>Terlama</option>
                                <option value="price_high" {{ $activeSort == 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                                <option value="price_low" {{ $activeSort == 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>

            @if(count($rentals) > 0)
            <!-- Bookings List -->
            <div class="divide-y divide-gray-200">
                @foreach($rentals as $rental)
                <div class="p-6 hover:bg-gray-50 transition-colors">
                    <div class="flex flex-col lg:flex-row justify-between gap-6">
                        <!-- Vehicle Info -->
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 w-20 h-20 bg-gray-100 rounded-lg overflow-hidden flex items-center justify-center">
                                @if($rental->vehicle->image)
                                    <img class="w-full h-full object-contain" src="{{ asset('storage/vehicles/' . basename($rental->vehicle->image)) }}" alt="{{ $rental->vehicle->brand }}">
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-10 h-10 text-gray-400">
                                        <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.5 2.8C1.4 11.3 1 12.1 1 13v3c0 .6.4 1 1 1h2"></path>
                                        <circle cx="7" cy="17" r="2"></circle>
                                        <circle cx="17" cy="17" r="2"></circle>
                                    </svg>
                                @endif
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">{{ $rental->vehicle->brand }}</h3>
                                <div class="flex items-center text-sm text-gray-500 mt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 mr-1">
                                        <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.5 2.8C1.4 11.3 1 12.1 1 13v3c0 .6.4 1 1 1h2"></path>
                                        <circle cx="7" cy="17" r="2"></circle>
                                        <circle cx="17" cy="17" r="2"></circle>
                                    </svg>
                                    {{ ucfirst($rental->vehicle->type) }}
                                </div>
                                <div class="flex items-center gap-3 mt-2">
                                    <div class="flex items-center text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-indigo-500 mr-1">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                            <line x1="16" y1="2" x2="16" y2="6"></line>
                                            <line x1="8" y1="2" x2="8" y2="6"></line>
                                            <line x1="3" y1="10" x2="21" y2="10"></line>
                                        </svg>
                                        {{ $rental->rental_date->translatedFormat('d M Y') }} - {{ $rental->return_date->translatedFormat('d M Y') }}
                                    </div>
                                    <div class="text-sm bg-indigo-50 text-indigo-700 px-2 py-0.5 rounded">
                                        {{ $rental->duration }} {{ Str('hari', $rental->duration) }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Status and Price -->
                        <div class="flex flex-col sm:flex-row lg:flex-col justify-between gap-4 sm:gap-8 lg:gap-4">
                            <div class="text-right">
                                <div class="text-sm text-gray-500">Total Pembayaran</div>
                                <div class="text-xl font-bold text-gray-900">Rp {{ number_format($rental->total_payment, 0, ',', '.') }}</div>
                                <div class="text-sm text-gray-500">Rp {{ number_format($rental->vehicle->price, 0, ',', '.') }}/hari</div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm text-gray-500 mb-1">Status</div>
                                @php
                                    $statusClasses = [
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'paid' => 'bg-blue-100 text-blue-800',
                                        'confirmed' => 'bg-green-100 text-green-800',
                                        'completed' => 'bg-purple-100 text-purple-800',
                                        'cancelled' => 'bg-red-100 text-red-800',
                                        'expired' => 'bg-gray-100 text-gray-800'
                                    ];
                                    
                                    $statusIcons = [
                                        'pending' => '<circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline>',
                                        'paid' => '<path d="M2 16.1A5 5 0 0 1 5.9 20M2 12.05A9 9 0 0 1 9.95 20M2 8V6a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2h-6"></path><line x1="2" y1="20" x2="2" y2="20"></line>',
                                        'confirmed' => '<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline>',
                                        'completed' => '<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline>',
                                        'cancelled' => '<circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line>',
                                        'expired' => '<circle cx="12" cy="12" r="10"></circle><line x1="8" y1="12" x2="16" y2="12"></line>'
                                    ];
                                    
                                    $statusLabels = [
                                        'pending' => 'Menunggu Pembayaran',
                                        'paid' => 'Sudah Dibayar',
                                        'confirmed' => 'Dikonfirmasi',
                                        'completed' => 'Selesai',
                                        'cancelled' => 'Dibatalkan',
                                        'expired' => 'Kedaluwarsa'
                                    ];
                                @endphp
                                
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $statusClasses[$rental->payment_status] }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 mr-1">
                                        {!! $statusIcons[$rental->payment_status] !!}
                                    </svg>
                                    {{ $statusLabels[$rental->payment_status] }}
                                </span>
                                
                                @if($rental->payment_status == 'confirmed' && $rental->rental_date->isPast() && $rental->return_date->isFuture())
                                    <div class="mt-1 text-xs text-green-600 font-medium">Sedang Aktif</div>
                                @endif
                                
                                @if($rental->payment_status == 'paid')
                                    <div class="mt-1 text-xs text-blue-600 font-medium">Menunggu Konfirmasi Admin</div>
                                @endif
                                
                                @if($rental->payment_status == 'pending')
                                    <div class="mt-2 text-xs">
                                        <div class="font-medium">Batas Pembayaran:</div>
                                        <div>{{ $rental->created_at->addHour()->format('d M Y H:i') }}</div>
                                        @if($rental->is_expired)
                                            <div class="text-red-600 font-medium">Kedaluwarsa</div>
                                        @else
                                            <div class="text-orange-600">{{ now()->diffForHumans($rental->created_at->addHour(), true) }} lagi</div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="mt-6 flex flex-wrap items-center justify-end gap-3">
                        <a href="{{ route('customer.history-detail', $rental->id) }}" class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 mr-1.5">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                            Detail Lengkap
                        </a>
                        
                        @if($rental->payment_status == 'pending' && !$rental->is_expired)
                            <a href="{{ route('booking.payment', $rental->id) }}" class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 mr-1.5">
                                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                    <line x1="1" y1="10" x2="23" y2="10"></line>
                                </svg>
                                Bayar Sekarang
                            </a>
                        @endif
                        
                        @if(in_array($rental->payment_status, ['paid', 'confirmed', 'completed']))
                            <a href="{{ route('booking.receipt', $rental->id) }}" class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 mr-1.5">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="7 10 12 15 17 10"></polyline>
                                    <line x1="12" y1="15" x2="12" y2="3"></line>
                                </svg>
                                Unduh Bukti
                            </a>
                        @endif
                        
                        @if($rental->can_be_cancelled && in_array($rental->payment_status, ['pending', 'paid']))
                            <form action="{{ route('customer.cancel-booking', $rental->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 shadow-sm" onclick="return confirm('Apakah Anda yakin ingin membatalkan pemesanan ini?')">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 mr-1.5">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <line x1="15" y1="9" x2="9" y2="15"></line>
                                        <line x1="9" y1="9" x2="15" y2="15"></line>
                                    </svg>
                                    Batalkan
                                </button>
                            </form>
                        @endif
                    </div>

                    <!-- Expandable Details Section -->
                    <div id="details{{ $rental->id }}" class="mt-6 pt-6 border-t border-gray-200 hidden">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h4 class="text-lg font-medium text-gray-900 mb-4">Informasi Pemesanan</h4>
                                <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">ID Pemesanan</span>
                                        <span class="font-medium">{{ $rental->id }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Tanggal Pemesanan</span>
                                        <span class="font-medium">{{ $rental->created_at->format('d M Y, H:i') }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Tanggal Mulai</span>
                                        <span class="font-medium">{{ $rental->rental_date->format('d M Y') }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Tanggal Selesai</span>
                                        <span class="font-medium">{{ $rental->return_date->format('d M Y') }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Durasi</span>
                                        <span class="font-medium">{{ $rental->duration }} {{ Str::plural('hari', $rental->duration) }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Status Pembayaran</span>
                                        @php
                                            $paymentStatusColors = [
                                                'pending' => 'text-yellow-600',
                                                'paid' => 'text-blue-600',
                                                'confirmed' => 'text-green-600',
                                                'completed' => 'text-purple-600',
                                                'cancelled' => 'text-red-600',
                                                'expired' => 'text-gray-600'
                                            ];
                                            
                                            $paymentStatusLabels = [
                                                'pending' => 'Menunggu Pembayaran',
                                                'paid' => 'Sudah Dibayar',
                                                'confirmed' => 'Dikonfirmasi',
                                                'completed' => 'Selesai',
                                                'cancelled' => 'Dibatalkan',
                                                'expired' => 'Kedaluwarsa'
                                            ];
                                        @endphp
                                        <span class="font-medium {{ $paymentStatusColors[$rental->payment_status] }}">
                                            {{ $paymentStatusLabels[$rental->payment_status] }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <h4 class="text-lg font-medium text-gray-900 mb-4">Detail Kendaraan</h4>
                                <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Merek</span>
                                        <span class="font-medium">{{ $rental->vehicle->brand }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Tipe</span>
                                        <span class="font-medium">{{ ucfirst($rental->vehicle->type) }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Tahun</span>
                                        <span class="font-medium">{{ $rental->vehicle->year }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Warna</span>
                                        <span class="font-medium flex items-center">
                                            <span class="w-3 h-3 rounded-full mr-1.5 border border-gray-300" style="background-color: {{ strtolower($rental->vehicle->color) }}"></span>
                                            {{ ucfirst($rental->vehicle->color) }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Kondisi</span>
                                        <span class="font-medium">{{ ucfirst($rental->vehicle->condition) }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Harga per Hari</span>
                                        <span class="font-medium">Rp {{ number_format($rental->vehicle->price, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <!-- Empty State for Filtered Results -->
            <div class="p-12 text-center">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-indigo-100 rounded-full mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-10 h-10 text-indigo-600">
                        <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path>
                        <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>
                    </svg>
                </div>
                @if($activeFilter != 'all')
                    <h2 class="text-xl font-bold text-gray-800 mb-3">Tidak Ada Pemesanan {{ $statusLabels[$activeFilter] ?? '' }}</h2>
                    <p class="text-gray-600 mb-6 max-w-md mx-auto">Anda tidak memiliki pemesanan dengan status {{ $statusLabels[$activeFilter] ?? '' }} saat ini.</p>
                    <a href="{{ route('customer.history') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 mr-2">
                            <polyline points="15 18 9 12 15 6"></polyline>
                        </svg>
                        Lihat Semua Pemesanan
                    </a>
                @else
                    <h2 class="text-xl font-bold text-gray-800 mb-3">Belum Ada Pemesanan</h2>
                    <p class="text-gray-600 mb-6 max-w-md mx-auto">Anda belum melakukan pemesanan kendaraan. Mulai petualangan Anda dengan menyewa kendaraan sekarang!</p>
                    <a href="{{ route('booking.index') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 transition-colors shadow-md hover:shadow-indigo-500/30">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 mr-2">
                            <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.5 2.8C1.4 11.3 1 12.1 1 13v3c0 .6.4 1 1 1h2"></path>
                            <circle cx="7" cy="17" r="2"></circle>
                            <circle cx="17" cy="17" r="2"></circle>
                        </svg>
                        Sewa Kendaraan
                    </a>
                @endif
            </div>
            @endif
        </div>
</div>
@endsection
