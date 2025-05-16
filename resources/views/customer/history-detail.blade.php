@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header Card -->
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-t-2xl p-6 text-white">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold">Detail Pemesanan</h1>
                    <p class="opacity-90 mt-1">ID Pemesanan: #{{ $rental->id }}</p>
                </div>
                <div class="flex flex-col items-end">
                    <span class="px-4 py-1.5 rounded-full text-sm font-semibold 
                        @if($rental->payment_status == 'confirmed') bg-green-500 
                        @elseif($rental->payment_status == 'paid') bg-blue-500 
                        @elseif($rental->payment_status == 'pending') bg-yellow-500 
                        @elseif($rental->payment_status == 'completed') bg-purple-500 
                        @elseif($rental->payment_status == 'cancelled') bg-red-500 
                        @else bg-gray-500 @endif">
                        @if($rental->payment_status == 'confirmed')
                        Dikonfirmasi
                        @elseif($rental->payment_status == 'paid')
                        Dibayar
                        @elseif($rental->payment_status == 'pending')
                        Menunggu Pembayaran
                        @elseif($rental->payment_status == 'completed')
                        Selesai
                        @elseif($rental->payment_status == 'cancelled')
                        Dibatalkan
                        @else
                        {{ ucfirst($rental->payment_status) }}
                        @endif
                    </span>
                    <span class="text-sm mt-1 opacity-90">{{ $rental->created_at->translatedFormat('d M Y, H:i') }}</span>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="bg-white rounded-b-2xl shadow-lg overflow-hidden">
            <!-- Timeline Section -->
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-indigo-600">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                    </div>
                    <div class="flex-1 h-1 bg-indigo-600"></div>
                    <div class="w-8 h-8 rounded-full @if($rental->payment_status == 'paid' || $rental->payment_status == 'confirmed' || $rental->payment_status == 'completed') bg-indigo-100 @else bg-gray-100 @endif flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 @if($rental->payment_status == 'paid' || $rental->payment_status == 'confirmed' || $rental->payment_status == 'completed') text-indigo-600 @else text-gray-400 @endif">
                            <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                            <line x1="1" y1="10" x2="23" y2="10"></line>
                        </svg>
                    </div>
                    <div class="flex-1 h-1 @if($rental->payment_status == 'confirmed' || $rental->payment_status == 'completed') bg-indigo-600 @else bg-gray-200 @endif"></div>
                    <div class="w-8 h-8 rounded-full @if($rental->payment_status == 'confirmed' || $rental->payment_status == 'completed') bg-indigo-100 @else bg-gray-100 @endif flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 @if($rental->payment_status == 'confirmed' || $rental->payment_status == 'completed') text-indigo-600 @else text-gray-400 @endif">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                    </div>
                    <div class="flex-1 h-1 @if($rental->payment_status == 'completed') bg-indigo-600 @else bg-gray-200 @endif"></div>
                    <div class="w-8 h-8 rounded-full @if($rental->payment_status == 'completed') bg-indigo-100 @else bg-gray-100 @endif flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 @if($rental->payment_status == 'completed') text-indigo-600 @else text-gray-400 @endif">
                            <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.5 2.8C1.4 11.3 1 12.1 1 13v3c0 .6.4 1 1 1h2"></path>
                            <circle cx="7" cy="17" r="2"></circle>
                            <circle cx="17" cy="17" r="2"></circle>
                        </svg>
                    </div>
                </div>
                <div class="flex justify-between text-xs text-gray-600 mt-2 px-1">
                    <span>Pemesanan</span>
                    <span>Pembayaran</span>
                    <span>Konfirmasi</span>
                    <span>Selesai</span>
                </div>
            </div>

            <!-- Vehicle Information -->
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-xl font-bold mb-4 text-gray-800 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 mr-2 text-indigo-600">
                        <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.5 2.8C1.4 11.3 1 12.1 1 13v3c0 .6.4 1 1 1h2"></path>
                        <circle cx="7" cy="17" r="2"></circle>
                        <circle cx="17" cy="17" r="2"></circle>
                    </svg>
                    Informasi Kendaraan
                </h2>

                <div class="bg-gray-50 rounded-xl p-4 mb-4">
                    <div class="flex flex-col md:flex-row">
                        <div class="md:w-1/3 mb-4 md:mb-0 md:pr-6 flex items-center justify-center">
                            @if($rental->vehicle->image)
                            <img src="{{ asset('storage/vehicles/' . basename($rental->vehicle->image)) }}" alt="{{ $rental->vehicle->brand }}" class="w-full h-48 object-cover rounded-lg">
                            @else
                            <div class="w-full h-48 bg-gray-200 rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-12 h-12 text-gray-400">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                    <polyline points="21 15 16 10 5 21"></polyline>
                                </svg>
                            </div>
                            @endif
                        </div>

                        <div class="md:w-2/3">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800">{{ $rental->vehicle->brand }}</h3>
                                    <p class="text-gray-600">{{ ucfirst($rental->vehicle->type) }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xl font-bold text-indigo-600">Rp {{ number_format($rental->vehicle->price, 0, ',', '.') }}</p>
                                    <p class="text-gray-600">per hari</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <div class="bg-white p-3 rounded-lg shadow-sm">
                                    <p class="text-xs text-gray-500 mb-1">Kondisi</p>
                                    <p class="font-medium text-gray-800">{{ ucfirst($rental->vehicle->condition) }}</p>
                                </div>
                                <div class="bg-white p-3 rounded-lg shadow-sm">
                                    <p class="text-xs text-gray-500 mb-1">Tahun</p>
                                    <p class="font-medium text-gray-800">{{ $rental->vehicle->year }}</p>
                                </div>
                                <div class="bg-white p-3 rounded-lg shadow-sm">
                                    <p class="text-xs text-gray-500 mb-1">Warna</p>
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 rounded-full mr-2" style="background-color: {{ strtolower($rental->vehicle->color) }}"></div>
                                        <p class="font-medium text-gray-800">{{ ucfirst($rental->vehicle->color) }}</p>
                                    </div>
                                </div>
                                <div class="bg-white p-3 rounded-lg shadow-sm">
                                    <p class="text-xs text-gray-500 mb-1">Plat Nomor</p>
                                    <p class="font-medium text-gray-800">{{ $rental->vehicle->no_plat }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reservation Information -->
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-xl font-bold mb-4 text-gray-800 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 mr-2 text-indigo-600">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                    Informasi Pemesanan
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-500 mb-1">Tanggal Pengambilan</p>
                        <p class="font-semibold text-gray-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 mr-1 text-indigo-600">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                            {{ $rental->rental_date->translatedFormat('d F Y') }}
                        </p>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-500 mb-1">Tanggal Pengembalian</p>
                        <p class="font-semibold text-gray-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 mr-1 text-indigo-600">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                            {{ $rental->return_date->translatedFormat('d F Y') }}
                        </p>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-500 mb-1">Durasi Sewa</p>
                        <p class="font-semibold text-gray-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 mr-1 text-indigo-600">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                            {{ $rental->duration }} {{ Str('hari', $rental->duration) }}
                        </p>
                    </div>

                    @if($rental->pickup_location)
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-500 mb-1">Lokasi Pengambilan</p>
                        <p class="font-semibold text-gray-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 mr-1 text-indigo-600">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                            {{ $rental->pickup_location }}
                        </p>
                    </div>
                    @endif

                    @if($rental->return_location)
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-500 mb-1">Lokasi Pengembalian</p>
                        <p class="font-semibold text-gray-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 mr-1 text-indigo-600">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                            {{ $rental->return_location }}
                        </p>
                    </div>
                    @endif

                    @if($rental->payment_status == 'pending')
                    <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200">
                        <p class="text-sm text-yellow-700 mb-1">Batas Waktu Pembayaran</p>
                        <p class="font-semibold text-yellow-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 mr-1 text-yellow-600">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                            {{ $rental->created_at->addHour()->translatedFormat('d F Y, H:i') }}
                            @if($rental->is_expired)
                            <span class="text-xs bg-red-100 text-red-800 px-2 py-0.5 rounded ml-2">Kedaluwarsa</span>
                            @else
                            <span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-0.5 rounded ml-2">
                                {{ now()->diffForHumans($rental->created_at->addHour(), true) }} tersisa
                            </span>
                            @endif
                        </p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Payment Information -->
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-xl font-bold mb-4 text-gray-800 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 mr-2 text-indigo-600">
                        <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                        <line x1="1" y1="10" x2="23" y2="10"></line>
                    </svg>
                    Informasi Pembayaran
                </h2>

                <div class="bg-gray-50 rounded-xl p-6">
                    <div class="flex flex-col md:flex-row justify-between mb-6">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Status Pembayaran</p>
                            <p class="font-semibold 
                                @if($rental->payment_status == 'confirmed') text-green-600 
                                @elseif($rental->payment_status == 'paid') text-blue-600 
                                @elseif($rental->payment_status == 'pending') text-yellow-600 
                                @elseif($rental->payment_status == 'completed') text-purple-600 
                                @elseif($rental->payment_status == 'cancelled') text-red-600 
                                @else text-gray-600 @endif">
                                @if($rental->payment_status == 'confirmed')
                                Pembayaran Dikonfirmasi
                                @elseif($rental->payment_status == 'paid')
                                Pembayaran Dibayar (Menunggu Konfirmasi)
                                @elseif($rental->payment_status == 'pending')
                                Menunggu Pembayaran
                                @elseif($rental->payment_status == 'completed')
                                Pembayaran Selesai
                                @elseif($rental->payment_status == 'cancelled')
                                Pembayaran Dibatalkan
                                @else
                                {{ ucfirst($rental->payment_status) }}
                                @endif
                            </p>
                        </div>

                        @if($rental->payment_status == 'paid' || $rental->payment_status == 'confirmed' || $rental->payment_status == 'completed')
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Tanggal Pembayaran</p>
                            <p class="font-semibold text-gray-800">
                                {{ $rental->updated_at->translatedFormat('d F Y, H:i') }}
                            </p>
                        </div>
                        @endif
                    </div>

                    <div class="border-t border-gray-200 pt-4">
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Harga Sewa ({{ $rental->duration }} {{ Str('hari', $rental->duration) }})</span>
                            <span class="font-medium">Rp {{ number_format($rental->vehicle->price * $rental->duration, 0, ',', '.') }}</span>
                        </div>

                        @if(isset($rental->additional_fee) && $rental->additional_fee > 0)
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Biaya Tambahan</span>
                            <span class="font-medium">Rp {{ number_format($rental->additional_fee, 0, ',', '.') }}</span>
                        </div>
                        @endif

                        @if(isset($rental->discount) && $rental->discount > 0)
                        <div class="flex justify-between mb-2 text-green-600">
                            <span>Diskon</span>
                            <span class="font-medium">- Rp {{ number_format($rental->discount, 0, ',', '.') }}</span>
                        </div>
                        @endif

                        <div class="flex justify-between pt-4 border-t border-gray-200 mt-4">
                            <span class="font-bold text-gray-800">Total Pembayaran</span>
                            <span class="font-bold text-indigo-600 text-xl">Rp {{ number_format($rental->total_payment, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer Information -->
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-xl font-bold mb-4 text-gray-800 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 mr-2 text-indigo-600">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    Informasi Penyewa
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-500 mb-1">Nama</p>
                        <p class="font-semibold text-gray-800">{{ $rental->customer_name }}</p>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-500 mb-1">Nomor KTP (NIK)</p>
                        <p class="font-semibold text-gray-800">{{ $rental->customer_nik }}</p>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-500 mb-1">Nomor Telepon</p>
                        <p class="font-semibold text-gray-800">{{ $rental->customer_phone }}</p>
                    </div>

                    @if($rental->customer_gender)
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-500 mb-1">Jenis Kelamin</p>
                        <p class="font-semibold text-gray-800">
                            @switch($rental->customer_gender)
                            @case('male')
                            Laki-laki
                            @break
                            @case('female')
                            Perempuan
                            @break
                            @default
                            Tidak diketahui
                            @endswitch</p>
                    </div>
                    @endif

                    @if($rental->customer_address)
                    <div class="bg-gray-50 p-4 rounded-lg md:col-span-2">
                        <p class="text-sm text-gray-500 mb-1">Alamat</p>
                        <p class="font-semibold text-gray-800">{{ $rental->customer_address }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="p-6">
                <div class="flex flex-wrap gap-4 justify-between">
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('customer.history') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 mr-2">
                                <path d="M19 12H5"></path>
                                <path d="M12 19l-7-7 7-7"></path>
                            </svg>
                            Kembali
                        </a>

                        @if($rental->payment_status == 'pending' && !$rental->is_expired)
                        <a href="{{ route('booking.payment', $rental->id) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 mr-2">
                                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                <line x1="1" y1="10" x2="23" y2="10"></line>
                            </svg>
                            Bayar Sekarang
                        </a>
                        @endif

                        @if($rental->can_be_cancelled)
                        <form action="{{ route('customer.cancel-booking', $rental->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors" onclick="return confirm('Apakah Anda yakin ingin membatalkan pemesanan ini?')">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 mr-2">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="15" y1="9" x2="9" y2="15"></line>
                                    <line x1="9" y1="9" x2="15" y2="15"></line>
                                </svg>
                                Batalkan Pemesanan
                            </button>
                        </form>
                        @endif
                    </div>

                    <div>
                        @if($rental->payment_status == 'paid' || $rental->payment_status == 'confirmed' || $rental->payment_status == 'completed')
                        <a href="{{ route('booking.receipt', $rental->id) }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 mr-2">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="7 10 12 15 17 10"></polyline>
                                <line x1="12" y1="15" x2="12" y2="3"></line>
                            </svg>
                            Unduh Bukti Pembayaran
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection