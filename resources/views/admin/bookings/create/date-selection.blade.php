@extends('layouts.admin')

@section('title', 'Pilih Tanggal Rental')
@section('header', 'Pilih Tanggal Rental')

@section('content')
<div class="mb-6">
    <a href="{{ route('bookings.manage.create.user-selection') }}" class="flex items-center text-blue-600 hover:text-blue-900">
        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Pemilihan Customer
    </a>
</div>

<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-800">Pilih Tanggal Rental</h2>
    </div>
    
    <div class="p-6">
        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 p-4 mb-6 rounded">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-500"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700 font-medium">Harap perbaiki kesalahan berikut:</p>
                        <ul class="mt-1 text-sm text-red-700 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <div class="mb-4">
            <div class="flex items-center bg-blue-50 p-4 rounded-lg">
                <div class="flex-shrink-0 bg-blue-100 rounded-full p-2">
                    <i class="fas fa-user text-blue-500"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-700">Customer di[ilih]:</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $user->name }}</p>
                    <p class="text-sm text-gray-500">{{ $user->email }}</p>
                </div>
            </div>
        </div>

        <form action="{{ route('bookings.manage.create.vehicle-selection') }}" method="GET">
            <input type="hidden" name="user_id" value="{{ $user->id }}">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <x-input-label for="rental_date" >Tanggal Sewa</x-input-label>
                    <input type="date" name="rental_date" id="rental_date" value="{{ old('rental_date', date('Y-m-d')) }}" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                
                <div>
                    <x-input-label for="return_date" >Tanggal Kembali</x-input-label>
                    <input type="date" name="return_date" id="return_date" value="{{ old('return_date', date('Y-m-d', strtotime('+1 day'))) }}" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
            </div>
            
            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                   Pilih Kendaraan <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Date validation
    const rentalDateInput = document.getElementById('rental_date');
    const returnDateInput = document.getElementById('return_date');

    rentalDateInput.addEventListener('change', function() {
        // Ensure return date is not before rental date
        if (returnDateInput.value < rentalDateInput.value) {
            returnDateInput.value = rentalDateInput.value;
        }
        
        // Set min date for return date
        returnDateInput.min = rentalDateInput.value;
    });

    // Set min date for rental date (today)
    const today = new Date().toISOString().split('T')[0];
    rentalDateInput.min = today;

    // If return date is before rental date, update it
    if (returnDateInput.value < rentalDateInput.value) {
        returnDateInput.value = rentalDateInput.value;
    }
    
    // Set min date for return date
    returnDateInput.min = rentalDateInput.value;
});
</script>
@endsection
