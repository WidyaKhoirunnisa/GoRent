@extends('layouts.admin')

@section('title', 'Pilih Kendaraan')
@section('header', 'Pilih Kendaraan')

@section('content')
<div class="mb-6">
    <a href="{{ route('bookings.manage.create.date-selection', ['user_id' => $user->id]) }}" class="flex items-center text-blue-600 hover:text-blue-900">
        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Pemilihan Tanggal
    </a>
</div>

<div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-800">Detail Pemesanan</h2>
    </div>

    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="flex items-center bg-blue-50 p-4 rounded-lg">
                <div class="flex-shrink-0 bg-blue-100 rounded-full p-2">
                    <i class="fas fa-user text-blue-500"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-700">Pelanggan:</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $user->name }}</p>
                    <p class="text-sm text-gray-500">{{ $user->email }}</p>
                </div>
            </div>

            <div class="flex items-center bg-green-50 p-4 rounded-lg">
                <div class="flex-shrink-0 bg-green-100 rounded-full p-2">
                    <i class="fas fa-calendar text-green-500"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-700">Periode Sewa:</p>
                    <p class="text-lg font-semibold text-gray-900">
                        {{ \Carbon\Carbon::parse($rentalDate)->translatedFormat('d M Y') }} sampai {{ \Carbon\Carbon::parse($returnDate)->translatedFormat('d M Y') }}
                    </p>
                    <p class="text-sm text-gray-500">{{ $rentalDuration }} {{ Str('hari', $rentalDuration) }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<h2 class="text-xl font-bold mb-4">Kendaraan Tersedia</h2>

@if(session('error'))
<div class="bg-red-100 border-l-4 border-red-500 p-4 mb-6 rounded">
    {{ session('error') }}
</div>
@endif

<!-- Filter Tipe Kendaraan -->
<div class="flex flex-wrap justify-center gap-4 mb-8">
    <a href="{{ route('bookings.manage.create.vehicle-selection', ['type' => 'all', 'rental_date' => $rentalDate, 'return_date' => $returnDate, 'user_id' => $user->id]) }}"
        class="inline-flex items-center px-6 py-2 rounded-full {{ $activeType === 'all' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-800' }}">
        Semua kendaraan
    </a>

    @foreach($vehicleTypes as $vehicleType)
    <a href="{{ route('bookings.manage.create.vehicle-selection', ['type' => $vehicleType, 'rental_date' => $rentalDate, 'return_date' => $returnDate, 'user_id' => $user->id]) }}"
        class="inline-flex items-center px-6 py-2 rounded-full {{ $activeType === $vehicleType ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-800' }}">
        <i class="fas fa-car mr-2"></i>
        {{ ucfirst($vehicleType) }}
    </a>
    @endforeach
</div>

<!-- Grid Kendaraan -->
<x-vehicle-grid
    :vehicles="$vehicles"
    :rentalDuration="$rentalDuration"
    :rentalDate="$rentalDate"
    :returnDate="$returnDate"
    :userId="$user->id"
    :actionRoute="route('bookings.manage.create.complete-booking')"
    :showPrice="true"
    :showActions="true"
    :showStatus="false"
    :showRentalInfo="true" />

@endsection