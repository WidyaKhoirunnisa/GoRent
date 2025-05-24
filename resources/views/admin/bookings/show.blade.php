@extends('layouts.admin')

@section('title', 'Detail Pemesanan')
@section('header', 'Detail Pemesanan')

@section('content')
<div class="mb-6">
    <a href="{{ route('bookings.manage.index') }}" class="flex items-center text-blue-600 hover:text-blue-900">
        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Pemesanan
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Informasi Pemesanan -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-lg font-semibold text-gray-800">Informasi Pemesanan</h2>
                <div>
                    @php
                    $statusTranslation = [
                    'pending' => 'Menunggu Pembayaran',
                    'expired' => 'Kedaluwarsa',
                    'paid' => 'Dibayar',
                    'confirmed' => 'Dikonfirmasi',
                    'completed' => 'Selesai',
                    'cancelled' => 'Dibatalkan',
                    ];
                    $statusText = $statusTranslation[$rental->payment_status] ?? ucfirst($rental->payment_status);
                    @endphp
                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                        @if($rental->payment_status == 'pending') bg-yellow-100 text-yellow-800
                        @elseif($rental->payment_status == 'expired') bg-gray-100 text-gray-800
                        @elseif($rental->payment_status == 'paid') bg-blue-100 text-blue-800
                        @elseif($rental->payment_status == 'confirmed') bg-green-100 text-green-800
                        @elseif($rental->payment_status == 'completed') bg-purple-100 text-purple-800
                        @elseif($rental->payment_status == 'cancelled') bg-red-100 text-red-800
                        @endif">
                        {{ $statusText }}
                    </span>

                    @if($rental->isActive)
                    <span class="ml-1 px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                        Aktif
                    </span>
                    @endif

                    @if($rental->isOverdue)
                    <span class="ml-1 px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                        Terlambat
                    </span>
                    @endif
                </div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-md font-medium text-gray-700 mb-3">Detail Pemesanan</h3>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">ID Pemesanan:</span>
                                <span class="text-sm font-medium">{{ $rental->id ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Tanggal Sewa:</span>
                                <span class="text-sm font-medium">{{ $rental->rental_date ? $rental->rental_date->format('d M Y, H:i') : 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Tanggal Kembali:</span>
                                <span class="text-sm font-medium">{{ $rental->return_date ? $rental->return_date->format('d M Y, H:i') : 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Durasi:</span>
                                <span class="text-sm font-medium">{{ $rental->duration }} hari</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Total Pembayaran:</span>
                                <span class="text-sm font-medium">Rp {{ number_format($rental->total_payment, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Dibuat Pada:</span>
                                <span class="text-sm font-medium">{{ $rental->created_at ? $rental->created_at->format('d M Y, H:i') : 'N/A' }}</span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-md font-medium text-gray-700 mb-3">Informasi Pelanggan</h3>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Nama:</span>
                                <span class="text-sm font-medium">{{ $rental->customer_name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">NIK:</span>
                                <span class="text-sm font-medium">{{ $rental->customer_nik }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Telepon:</span>
                                <span class="text-sm font-medium">{{ $rental->customer_phone }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Jenis Kelamin:</span>
                                <span class="text-sm font-medium">{{ $rental->customer_gender == 'male' ? 'Laki-laki' : 'Perempuan' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Alamat:</span>
                                <span class="text-sm font-medium">{{ $rental->customer_address }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Timeline Status di halaman detail -->
                <div class="mt-6">
                    <h3 class="text-md font-medium text-gray-700 mb-3">Alur Status Pemesanan</h3>

                    @php
                    $statuses = ['pending', 'paid', 'confirmed', 'completed'];
                    $statusLabels = [
                    'pending' => 'Tertunda',
                    'paid' => 'Dibayar',
                    'confirmed' => 'Dikonfirmasi',
                    'completed' => 'Selesai'
                    ];

                    $currentIndex = array_search($rental->payment_status, $statuses);
                    $currentIndex = $currentIndex !== false ? $currentIndex : -1;
                    @endphp

                    <div class="relative">
                        <!-- Timeline Bar -->
                        <div class="absolute top-5 left-5 right-5 h-1 bg-gray-200"></div>

                        <!-- Timeline Steps -->
                        <div class="flex justify-between relative">
                            @foreach($statuses as $index => $status)
                            <div class="flex flex-col items-center relative">
                                <!-- Status Circle -->
                                <div class="w-10 h-10 rounded-full flex items-center justify-center z-10
                        @if($index < $currentIndex) bg-green-500 text-white
                        @elseif($index == $currentIndex) bg-blue-500 text-white
                        @else bg-gray-200 text-gray-500
                        @endif">
                                    @if($index < $currentIndex)
                                        <i class="fas fa-check"></i>
                                        @else
                                        {{ $index + 1 }}
                                        @endif
                                </div>

                                <!-- Status Label -->
                                <span class="text-sm font-medium mt-2">{{ $statusLabels[$status] }}</span>

                                <!-- Update Button (only for next status) -->
                                @if($index == $currentIndex + 1 && $rental->payment_status != 'completed' && $rental->payment_status != 'cancelled')
                                <form action="{{ route('bookings.update-status', $rental->id) }}" method="POST" class="mt-2">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="payment_status" value="{{ $status }}">
                                    <button type="submit" class="px-2 py-1 text-xs bg-blue-500 text-white rounded hover:bg-blue-600">
                                        Perbarui
                                    </button>
                                </form>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Special Status Buttons -->
                    @if($rental->payment_status != 'cancelled' && $rental->payment_status != 'expired')
                    <div class="mt-6 flex justify-end space-x-3">
                        <x-modal>
                            <x-slot name="trigger">
                                <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600">
                                    Batalkan Pemesanan
                                </button>
                            </x-slot>

                            <h2 class="text-xl font-bold mb-4">Konfirmasi Pembatalan</h2>
                            <p class="mb-6">Apakah Anda yakin ingin membatalkan Pemesanan ini?</p>
                            <div class="flex justify-end gap-4">
                                <button
                                    @click="open = false"
                                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded">
                                    Batal
                                </button>

                                <form action="{{ route('bookings.update-status', $rental->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="payment_status" value="cancelled">
                                    <button
                                        type="submit"
                                        class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                        Batalkan
                                    </button>
                                </form>
                            </div>
                        </x-modal>

                        @if($rental->payment_status == 'pending')
                        <form action="{{ route('bookings.update-status', $rental->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="payment_status" value="expired">
                            <button type="submit" class="px-3 py-1 bg-gray-500 text-white rounded-md hover:bg-gray-600"
                                onclick="return confirm('Apakah Anda yakin ingin menandai pemesanan ini sebagai kedaluwarsa?')">
                                Tandai Kedaluwarsa
                            </button>
                        </form>
                        @endif
                    </div>
                    @endif
                </div>

                <div class="mt-6 flex justify-end space-x-4">
                    <a href="{{ route('bookings.manage.edit', $rental->id) }}" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                        <i class="fas fa-edit mr-2"></i> Edit Pemesanan
                    </a>
                    <x-modal>
                        <x-slot name="trigger">
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                <i class="fas fa-trash mr-2"></i> Hapus Pemesanan
                            </button>
                        </x-slot>

                        <h2 class="text-xl font-bold mb-4">Konfirmasi Penghapusan</h2>
                        <p class="mb-6">Apakah Anda yakin ingin menghapus Pemesanan ini? Tindakan ini tidak dapat dibatalkan.</p>
                        <div class="flex justify-end gap-4">
                            <button
                                @click="open = false"
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded">
                                Batal
                            </button>

                            <form action="{{ route('bookings.manage.destroy', $rental->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </x-modal>
                </div>
            </div>
        </div>
    </div>

    <!-- Informasi Kendaraan -->
    <div>
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">Informasi Kendaraan</h2>
            </div>

            <div class="p-6">
                @if($rental->vehicle)
                <div class="flex flex-col items-center mb-4">
                    @if($rental->vehicle->image)
                    <img src="{{ asset('storage/' . $rental->vehicle->image) }}" alt="{{ $rental->vehicle->brand }}" class="h-40 w-auto object-cover rounded-md mb-4">
                    @else
                    <div class="h-40 w-full bg-gray-200 flex items-center justify-center rounded-md mb-4">
                        <i class="fas fa-car text-4xl text-gray-500"></i>
                    </div>
                    @endif
                    <h3 class="text-lg font-medium text-gray-900">{{ $rental->vehicle->brand }}</h3>
                    <p class="text-sm text-gray-500">{{ $rental->vehicle->type }}</p>
                </div>

                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Plat Nomor:</span>
                        <span class="text-sm font-medium">{{ $rental->vehicle->no_plat }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Warna:</span>
                        <span class="text-sm font-medium">{{ $rental->vehicle->color }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Tahun:</span>
                        <span class="text-sm font-medium">{{ $rental->vehicle->year }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Harga per Hari:</span>
                        <span class="text-sm font-medium">Rp {{ number_format($rental->vehicle->price, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Kondisi:</span>
                        <span class="text-sm font-medium">{{ $rental->vehicle->condition }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Ketersediaan:</span>
                        <span class="text-sm font-medium">{{ $rental->vehicle->ready ? 'Tersedia' : 'Tidak Tersedia' }}</span>
                    </div>
                </div>
                @else
                <div class="text-center py-4">
                    <p class="text-gray-500">Informasi kendaraan tidak tersedia</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection