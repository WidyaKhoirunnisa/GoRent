@extends('layouts.app')

@section('title', 'Konfirmasi Pemesanan')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-5xl mx-auto">
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6 shadow-sm">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <p>{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8">
            <!-- Header Section -->
            <div class="p-8 bg-gradient-to-r from-green-500 to-emerald-600 text-white">
                <div class="flex items-center">
                    <div class="bg-white/20 p-3 rounded-full mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold">Pemesanan Berhasil!</h1>
                        <p class="text-white/90 mt-1">Pemesanan kendaraan Anda telah berhasil diselesaikan.</p>
                    </div>
                </div>
            </div>
            
            <!-- Payment Deadline Notice -->
            @if($rental->payment_status == 'pending')
            <div class="p-5 bg-amber-50 border-b border-amber-100">
                <div class="flex items-center">
                    <div class="bg-amber-100 p-2 rounded-full mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-amber-800">Batas Waktu Pembayaran: <span class="font-bold">{{ $rental->created_at->addHour()->format('d M Y H:i') }}</span></p>
                        <p class="text-sm text-amber-700">Harap selesaikan pembayaran Anda dalam waktu 1 jam untuk mengkonfirmasi pemesanan.</p>
                    </div>
                </div>
            </div>
            @endif
            
            <div class="p-8">
                <!-- Reservation Details -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 mr-2 text-indigo-600">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        Detail Pemesanan
                    </h2>
                    
                    <div class="bg-gray-50 rounded-2xl p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-white p-4 rounded-xl shadow-sm">
                                <p class="text-sm text-gray-500">ID Pemesanan</p>
                                <p class="font-medium text-gray-900">{{ $rental->id }}</p>
                            </div>
                            <div class="bg-white p-4 rounded-xl shadow-sm">
                                <p class="text-sm text-gray-500">Status</p>
                                <p class="font-medium">
                                    @if($rental->payment_status == 'pending')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Menunggu Pembayaran
                                        </span>
                                    @elseif($rental->payment_status == 'paid')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            Lunas
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            {{ ucfirst($rental->payment_status) }}
                                        </span>
                                    @endif
                                </p>
                            </div>
                            <div class="bg-white p-4 rounded-xl shadow-sm">
                                <p class="text-sm text-gray-500">Nama Pelanggan</p>
                                <p class="font-medium text-gray-900">{{ $rental->customer_name }}</p>
                            </div>
                            <div class="bg-white p-4 rounded-xl shadow-sm">
                                <p class="text-sm text-gray-500">Nomor Telepon</p>
                                <p class="font-medium text-gray-900">{{ $rental->customer_phone }}</p>
                            </div>
                            <div class="bg-white p-4 rounded-xl shadow-sm">
                                <p class="text-sm text-gray-500">Tanggal Pengambilan</p>
                                <p class="font-medium text-gray-900">{{ $rental->rental_date->format('d M Y') }}</p>
                            </div>
                            <div class="bg-white p-4 rounded-xl shadow-sm">
                                <p class="text-sm text-gray-500">Tanggal Pengembalian</p>
                                <p class="font-medium text-gray-900">{{ $rental->return_date->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Vehicle Information -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 mr-2 text-indigo-600">
                            <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.5 2.8C1.4 11.3 1 12.1 1 13v3c0 .6.4 1 1 1h2"></path>
                            <circle cx="7" cy="17" r="2"></circle>
                            <circle cx="17" cy="17" r="2"></circle>
                        </svg>
                        Informasi Kendaraan
                    </h2>
                    
                    <div class="bg-gray-50 rounded-2xl overflow-hidden">
                        <div class="flex flex-col md:flex-row">
                            <div class="md:w-1/3 bg-gradient-to-br from-gray-50 to-gray-100 p-6 flex items-center justify-center">
                                @if($rental->vehicle->image)
                                    <img src="{{ asset('storage/vehicles/' . basename($rental->vehicle->image)) }}" alt="{{ $rental->vehicle->brand }}" class="max-h-48 object-contain">
                                @else
                                    <div class="flex flex-col items-center justify-center text-gray-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <p class="text-sm font-medium">Tidak Ada Gambar</p>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="md:w-2/3 p-6">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-900">{{ $rental->vehicle->brand }}</h3>
                                        <p class="text-gray-600">{{ ucfirst($rental->vehicle->type) }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xl font-bold text-indigo-600">Rp {{ number_format($rental->vehicle->price, 0, ',', '.') }}</p>
                                        <p class="text-gray-600">per hari</p>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                                    <div class="bg-white p-3 rounded-lg shadow-sm">
                                        <p class="text-sm text-gray-500">Kondisi</p>
                                        <p class="font-medium text-gray-900">{{ ucfirst($rental->vehicle->condition) }}</p>
                                    </div>
                                    <div class="bg-white p-3 rounded-lg shadow-sm">
                                        <p class="text-sm text-gray-500">Tahun</p>
                                        <p class="font-medium text-gray-900">{{ $rental->vehicle->year }}</p>
                                    </div>
                                    <div class="bg-white p-3 rounded-lg shadow-sm">
                                        <p class="text-sm text-gray-500">Warna</p>
                                        <div class="flex items-center">
                                            <div class="w-3 h-3 rounded-full mr-1.5 border border-gray-300" style="background-color: {{ strtolower($rental->vehicle->color) }};"></div>
                                            <p class="font-medium text-gray-900">{{ ucfirst($rental->vehicle->color) }}</p>
                                        </div>
                                    </div>
                                    <div class="bg-white p-3 rounded-lg shadow-sm">
                                        <p class="text-sm text-gray-500">Plat Nomor</p>
                                        <p class="font-medium text-gray-900">{{ strtoupper($rental->vehicle->no_plat) }}</p>
                                    </div>
                                </div>
                                
                                <div class="bg-indigo-50 rounded-xl p-4">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-gray-700">Durasi:</span>
                                        <span class="font-medium">{{ $rental->duration }} {{ Str::plural('hari', $rental->duration) }}</span>
                                    </div>
                                    <div class="flex justify-between items-center pt-2 border-t border-indigo-100">
                                        <span class="font-bold text-gray-900">Total Harga:</span>
                                        <span class="text-xl font-bold text-indigo-600">Rp {{ number_format($rental->total_payment, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Payment Section -->
                @if($rental->payment_status == 'pending')
                <div class="bg-gradient-to-r from-indigo-50 to-purple-50 p-6 rounded-2xl mb-8 border border-indigo-100">
                    <div class="flex items-start">
                        <div class="bg-indigo-100 p-3 rounded-full mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-gray-900 mb-2">Selesaikan Pembayaran Anda</h3>
                            <p class="text-gray-600 mb-4">Harap selesaikan pembayaran Anda untuk mengkonfirmasi pemesanan. Pemesanan Anda akan otomatis dibatalkan jika pembayaran tidak diterima dalam waktu 1 jam.</p>
                            
                            <a href="{{ route('booking.payment', $rental->id) }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white rounded-xl font-medium hover:bg-indigo-700 transition-colors shadow-md hover:shadow-indigo-500/30">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                                Lanjutkan ke Pembayaran
                            </a>
                        </div>
                    </div>
                </div>
                @endif
                
                <!-- What's Next Section -->
                <div class="bg-gray-50 p-6 rounded-2xl">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Langkah Selanjutnya
                    </h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="bg-white p-2 rounded-full mr-3 shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <p class="text-gray-700">Tim kami akan meninjau pemesanan Anda dan mengirimkan email konfirmasi segera.</p>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="bg-white p-2 rounded-full mr-3 shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                </svg>
                            </div>
                            <p class="text-gray-700">Harap bawa SIM dan KTP Anda saat mengambil kendaraan.</p>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="bg-white p-2 rounded-full mr-3 shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <p class="text-gray-700">Kendaraan akan tersedia untuk diambil pada tanggal {{ $rental->rental_date->format('d M Y') }} di kantor kami.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Navigation Buttons -->
        <div class="flex flex-col sm:flex-row justify-between gap-4">
            <a href="{{ route('customer.history') }}" class="inline-flex items-center justify-center px-6 py-3 bg-white text-indigo-600 border border-indigo-200 rounded-xl font-medium hover:bg-indigo-50 transition-colors shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Lihat Pemesanan Saya
            </a>
            
            <a href="{{ route('home') }}" class="inline-flex items-center justify-center px-6 py-3 bg-indigo-600 text-white rounded-xl font-medium hover:bg-indigo-700 transition-colors shadow-md hover:shadow-indigo-500/30">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection
