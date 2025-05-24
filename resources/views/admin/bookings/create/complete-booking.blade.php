@extends('layouts.admin')

@section('title', 'Selesaikan Pemesanan')
@section('header', 'Selesaikan Pemesanan')

@section('content')
<div class="mb-6">
    <a href="{{ url()->previous() }}" class="flex items-center text-blue-600 hover:text-blue-900">
        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Pemilihan Kendaraan
    </a>
</div>

<div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-800">Ringkasan Pemesanan</h2>
    </div>

    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Informasi Kendaraan -->
            <div>
                <h3 class="text-md font-medium text-gray-700 mb-4">Informasi Kendaraan</h3>

                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                    <div class="flex items-start">
                        <div class="w-24 h-24 bg-white rounded-md flex items-center justify-center mr-4">
                            @if($vehicle->image)
                            <img src="{{ asset('storage/' . $vehicle->image) }}" alt="{{ $vehicle->brand }}" class="h-20 object-contain">
                            @else
                            <i class="fas fa-car text-4xl text-gray-400"></i>
                            @endif
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold text-gray-800">{{ $vehicle->brand }}</h4>
                            <p class="text-sm text-gray-500 capitalize">{{ $vehicle->type }}</p>
                            <div class="flex items-center mt-2 text-sm text-gray-600">
                                <span class="mr-3">{{ $vehicle->no_plat }}</span>
                                <span class="mr-3">{{ $vehicle->year }}</span>
                                <div class="flex items-center">
                                    <div class="w-3 h-3 rounded-full mr-1 border border-gray-300" style="background-color: {{ strtolower($vehicle->color) }};"></div>
                                    {{ ucfirst($vehicle->color) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <h3 class="text-md font-medium text-gray-700 mb-4">Detail Penyewaan</h3>

                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <p class="text-sm text-gray-500">Dari</p>
                            <p class="font-medium text-gray-800">{{ $rentalDate->translatedFormat('d F Y') }}</p>
                        </div>
                        <div class="text-gray-400">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Sampai</p>
                            <p class="font-medium text-gray-800">{{ $returnDate->translatedFormat('d F Y') }}</p>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-4">
                        <div class="flex justify-between mb-2">
                            <span class="text-sm text-gray-500">Harga Per Hari</span>
                            <span class="font-medium text-gray-800">Rp {{ number_format($vehicle->price, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span class="text-sm text-gray-500">Durasi</span>
                            <span class="font-medium text-gray-800">{{ $days }} {{ Str('hari', $days) }}</span>
                        </div>
                        <div class="flex justify-between pt-2 border-t border-gray-200">
                            <span class="text-sm font-medium text-gray-700">Total Pembayaran</span>
                            <span class="font-bold text-blue-600">Rp {{ number_format($totalPayment, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informasi Pelanggan -->
            <div>
                <h3 class="text-md font-medium text-gray-700 mb-4">Informasi Pelanggan</h3>

                <form action="{{ route('bookings.manage.store') }}" method="POST">
                    @csrf

                    <input type="hidden" name="rental_date" value="{{ $rentalDate->format('Y-m-d') }}">
                    <input type="hidden" name="return_date" value="{{ $returnDate->format('Y-m-d') }}">
                    <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <input type="hidden" name="total_payment" value="{{ $totalPayment }}">

                    <div class="space-y-4">
                        <div>
                            <x-input-label for="customer_name">Nama Pelanggan</x-input-label>
                            <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name', $user->customer->name ?? $user->name) }}" class="w-full px-4 py-2 border border-gray-300 rounded-md" required>
                            @error('customer_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-input-label for="customer_nik">NIK</x-input-label>
                            <input type="text" name="customer_nik" id="customer_nik" value="{{ old('customer_nik', $user->customer->nik ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-md" required>
                            @error('customer_nik')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-input-label for="customer_phone">Nomor Telepon</x-input-label>
                            <input type="text" name="customer_phone" id="customer_phone" value="{{ old('customer_phone', $user->customer->phone ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-md" required>
                            @error('customer_phone')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-input-label for="customer_gender">Jenis Kelamin</x-input-label>
                            <select name="customer_gender" id="customer_gender" class="w-full px-4 py-2 border border-gray-300 rounded-md" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="male" {{ old('customer_gender', $user->customer->gender ?? '') == 'male' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="female" {{ old('customer_gender', $user->customer->gender ?? '') == 'female' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('customer_gender')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-input-label for="customer_address">Alamat</x-input-label>
                            <textarea name="customer_address" id="customer_address" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-md" required>{{ old('customer_address', $user->customer->address ?? '') }}</textarea>
                            @error('customer_address')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-input-label for="payment_status">Status Pembayaran</x-input-label>
                            <input type="hidden" name="payment_status" id="payment_status" value="confirmed">
                            <div name="payment_status" id="payment_status" class="w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-200">
                                Confirmed
                            </div>
                            @error('payment_status')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="w-full py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Selesaikan Pemesanan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection