@extends('layouts.app')

@section('title', 'Pembayaran')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-5xl mx-auto">
        <div class="mb-6">
            <a href="{{ url()->previous() }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 transition-colors font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 mr-2">
                    <path d="M19 12H5"></path>
                    <path d="M12 19l-7-7 7-7"></path>
                </svg>
                Kembali
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8">
            <div class="p-8 bg-gradient-to-r from-indigo-600 to-purple-700 text-white">
                <div class="flex items-center">
                    <div class="bg-white/20 p-3 rounded-full mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold">Pembayaran</h1>
                        <p class="text-white/90 mt-1">Selesaikan pembayaran untuk mengkonfirmasi pemesanan Anda</p>
                    </div>
                </div>
            </div>

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

            <div class="p-8">
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 mr-2 text-indigo-600">
                            <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                            <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                            <path d="M9 14h6"></path>
                            <path d="M9 18h6"></path>
                            <path d="M9 10h6"></path>
                        </svg>
                        Ringkasan Pesanan
                    </h2>

                    <div class="bg-gray-50 rounded-2xl p-6">
                        <div class="flex flex-col md:flex-row mb-6">
                            <div class="md:w-1/3 mb-4 md:mb-0 md:pr-6">
                                <div class="bg-white p-4 rounded-xl shadow-sm h-full">
                                    <p class="text-sm text-gray-500 mb-1">ID Pemesanan</p>
                                    <p class="font-medium text-gray-900">{{ $rental->id }}</p>
                                    
                                    <div class="border-t border-gray-100 my-3"></div>
                                    
                                    <p class="text-sm text-gray-500 mb-1">Kendaraan</p>
                                    <p class="font-medium text-gray-900">{{ $rental->vehicle->brand }} ({{ ucfirst($rental->vehicle->type) }})</p>
                                    
                                    <div class="border-t border-gray-100 my-3"></div>
                                    
                                    <p class="text-sm text-gray-500 mb-1">Periode Sewa</p>
                                    <p class="font-medium text-gray-900">{{ $rental->rental_date->format('d M Y') }} - {{ $rental->return_date->format('d M Y') }}</p>
                                </div>
                            </div>
                            
                            <div class="md:w-2/3">
                                <div class="bg-white p-4 rounded-xl shadow-sm h-full">
                                    <h3 class="font-medium text-gray-900 mb-4">Detail Pembayaran</h3>
                                    
                                    <div class="space-y-3">
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Harga Sewa ({{ $rental->duration }} hari)</span>
                                            <span>Rp {{ number_format($rental->vehicle->price * $rental->duration, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Biaya Layanan</span>
                                            <span>Rp 0</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Pajak</span>
                                            <span>Termasuk</span>
                                        </div>
                                        <div class="flex justify-between pt-3 border-t border-gray-100">
                                            <span class="font-bold text-gray-900">Total Pembayaran</span>
                                            <span class="font-bold text-indigo-600">Rp {{ number_format($rental->total_payment, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 mr-2 text-indigo-600">
                            <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                            <line x1="1" y1="10" x2="23" y2="10"></line>
                        </svg>
                        Metode Pembayaran
                    </h2>

                    <form action="{{ route('booking.process-payment', $rental->id) }}" method="POST" class="bg-gray-50 rounded-2xl p-6">
                        @csrf
                        
                        <input type="hidden" name="payment_method" value="bank_transfer">
                        
                        <div class="bg-white p-6 rounded-xl border border-gray-200 mb-6">
                            <h3 class="font-medium text-gray-900 mb-4">Detail Transfer Bank</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label for="bank_name" class="block text-sm font-medium text-gray-700 mb-1">Pilih Bank</label>
                                    <select id="bank_name" name="bank_name" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                                        <option value="bca">Bank BCA</option>
                                        <option value="bni">Bank BNI</option>
                                        <option value="mandiri">Bank Mandiri</option>
                                        <option value="bri">Bank BRI</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label for="account_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Pemilik Rekening</label>
                                    <input type="text" id="account_name" name="account_name" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors" required>
                                </div>
                            </div>
                            
                            <div class="bg-indigo-50 p-4 rounded-lg">
                                <div class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600 mt-0.5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="text-sm text-gray-700">Setelah melakukan pembayaran, Anda akan menerima email konfirmasi dengan detail pemesanan Anda.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="submit" class="px-8 py-4 bg-indigo-600 text-white rounded-xl font-medium hover:bg-indigo-700 transition-colors shadow-md hover:shadow-indigo-500/30 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 mr-2">
                                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                    <line x1="1" y1="10" x2="23" y2="10"></line>
                                </svg>
                                Bayar Sekarang
                            </button>
                        </div>
                    </form>
                </div>
                
                <div class="bg-gray-50 rounded-2xl p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        Pembayaran Aman
                    </h3>
                    
                    <div class="flex flex-col md:flex-row gap-6">
                        <div class="flex-1 bg-white p-4 rounded-xl shadow-sm">
                            <div class="flex items-center mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                <h4 class="font-medium text-gray-900">Transaksi Aman</h4>
                            </div>
                            <p class="text-sm text-gray-600">Semua transaksi pembayaran dilindungi dengan enkripsi SSL 256-bit.</p>
                        </div>
                        
                        <div class="flex-1 bg-white p-4 rounded-xl shadow-sm">
                            <div class="flex items-center mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z" />
                                </svg>
                                <h4 class="font-medium text-gray-900">Jaminan Harga</h4>
                            </div>
                            <p class="text-sm text-gray-600">Tidak ada biaya tersembunyi. Apa yang Anda lihat adalah apa yang Anda bayar.</p>
                        </div>
                        
                        <div class="flex-1 bg-white p-4 rounded-xl shadow-sm">
                            <div class="flex items-center mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <h4 class="font-medium text-gray-900">Pembayaran Fleksibel</h4>
                            </div>
                            <p class="text-sm text-gray-600">Berbagai metode pembayaran tersedia untuk kenyamanan Anda.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection