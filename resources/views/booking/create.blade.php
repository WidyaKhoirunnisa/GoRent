@extends('layouts.app')

@section('title', 'Konfirmasi Pemesanan')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header Section -->
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
            <div class="bg-gradient-to-r from-indigo-600 to-purple-700 p-6 text-white">
                <h1 class="text-2xl md:text-3xl font-bold">Selesaikan Pemesanan Anda</h1>
                <p class="mt-2 opacity-90">Lengkapi informasi di bawah ini untuk menyelesaikan pemesanan kendaraan Anda</p>
            </div>

            @if(session('error'))
            <div class="mx-6 mt-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p>{{ session('error') }}</p>
                </div>
            </div>
            @endif

            <!-- Booking Progress -->
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between max-w-3xl mx-auto">
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold">1</div>
                        <span class="text-sm mt-2 text-gray-600">Pilih Tanggal</span>
                    </div>
                    <div class="flex-1 h-1 bg-indigo-600 mx-2"></div>
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold">2</div>
                        <span class="text-sm mt-2 text-gray-600">Pilih Kendaraan</span>
                    </div>
                    <div class="flex-1 h-1 bg-indigo-600 mx-2"></div>
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold">3</div>
                        <span class="text-sm mt-2 font-medium text-indigo-600">Buat Pesanan</span>
                    </div>
                </div>
            </div>

            <!-- Vehicle Information -->
            <div class="p-6 md:p-8">
                <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 mr-2 text-indigo-600">
                        <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.5 2.8C1.4 11.3 1 12.1 1 13v3c0 .6.4 1 1 1h2"></path>
                        <circle cx="7" cy="17" r="2"></circle>
                        <circle cx="17" cy="17" r="2"></circle>
                    </svg>
                    Informasi Kendaraan
                </h2>

                <div class="bg-gray-50 rounded-2xl overflow-hidden mb-8">
                    <div class="flex flex-col md:flex-row">
                        <div class="md:w-1/3 bg-gradient-to-br from-gray-50 to-gray-100 p-6 flex items-center justify-center">
                            @if($vehicle->image)
                            <img src="{{ asset('storage/vehicles/' . basename($vehicle->image)) }}" alt="{{ $vehicle->brand }}" class="max-h-48 object-contain">
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
                                    <h3 class="text-xl font-bold text-gray-900">{{ $vehicle->brand }}</h3>
                                    <p class="text-gray-600">{{ ucfirst($vehicle->type) }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xl font-bold text-indigo-600">Rp {{ number_format($vehicle->price, 0, ',', '.') }}</p>
                                    <p class="text-gray-600">per hari</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                                <div class="bg-white p-3 rounded-lg shadow-sm">
                                    <p class="text-sm text-gray-500">Kondisi</p>
                                    <p class="font-medium text-gray-900">{{ ucfirst($vehicle->condition) }}</p>
                                </div>
                                <div class="bg-white p-3 rounded-lg shadow-sm">
                                    <p class="text-sm text-gray-500">Tahun</p>
                                    <p class="font-medium text-gray-900">{{ $vehicle->year }}</p>
                                </div>
                                <div class="bg-white p-3 rounded-lg shadow-sm">
                                    <p class="text-sm text-gray-500">Warna</p>
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 rounded-full mr-1.5 border border-gray-300" style="background-color: {{ strtolower($vehicle->color) }};"></div>
                                        <p class="font-medium text-gray-900">{{ ucfirst($vehicle->color) }}</p>
                                    </div>
                                </div>
                                <div class="bg-white p-3 rounded-lg shadow-sm">
                                    <p class="text-sm text-gray-500">Plat Nomor</p>
                                    <p class="font-medium text-gray-900">{{ strtoupper($vehicle->no_plat) }}</p>
                                </div>
                            </div>

                            <div class="bg-indigo-50 rounded-xl p-4">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-gray-700">Periode Sewa:</span>
                                    <span class="font-medium flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 mr-1 text-indigo-600">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                            <line x1="16" y1="2" x2="16" y2="6"></line>
                                            <line x1="8" y1="2" x2="8" y2="6"></line>
                                            <line x1="3" y1="10" x2="21" y2="10"></line>
                                        </svg>
                                        {{ \Carbon\Carbon::parse($rental_date)->translatedFormat('d M Y') }} - {{ \Carbon\Carbon::parse($return_date)->translatedFormat('d M Y') }}
                                    </span>
                                </div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-gray-700">Durasi:</span>
                                    <span class="font-medium">{{ $rental_duration }} {{ Str('hari', $rental_duration) }}</span>
                                </div>
                                <div class="flex justify-between items-center pt-2 border-t border-indigo-100">
                                    <span class="font-bold text-gray-900">Total Harga:</span>
                                    <span class="text-xl font-bold text-indigo-600">Rp {{ number_format($total_payment, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Customer Information Form -->
                <form action="{{ route('booking.store') }}" method="POST" x-data="{ expired: false }" x-bind:class="{ 'opacity-50 pointer-events-none': expired }">
                    @csrf

                    <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">
                    <input type="hidden" name="rental_date" value="{{ $rental_date }}">
                    <input type="hidden" name="return_date" value="{{ $return_date }}">
                    <input type="hidden" name="booking_id" value="{{ $booking_id ?? '' }}">
                    <input type="hidden" name="booking_start_time" value="{{ $booking_start_time ?? time() }}">
                    <input type="hidden" name="total_payment" value="{{ $total_payment }}">

                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 mr-2 text-indigo-600">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        Informasi Pelanggan
                    </h2>

                    <div class="bg-gray-50 rounded-2xl p-6 mb-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                                <input type="text" id="name" name="name"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                    value="{{ old('name', $customer ? $customer->name : '') }}"
                                    required
                                    x-bind:disabled="expired">
                                @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="nik" class="block text-sm font-medium text-gray-700 mb-1">Nomor KTP (NIK)</label>
                                <input type="text" id="nik" name="nik"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                    value="{{ old('nik', $customer ? $customer->nik : '') }}"
                                    required
                                    x-bind:disabled="expired">
                                @error('nik')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                                <input type="text" id="phone" name="phone"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                    value="{{ old('phone', $customer ? $customer->phone : '') }}"
                                    required
                                    x-bind:disabled="expired">
                                @error('phone')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="gender" class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                                <select id="gender" name="gender"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                    required
                                    x-bind:disabled="expired">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="male" {{ (old('gender', $customer ? $customer->gender : '') == 'male') ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="female" {{ (old('gender', $customer ? $customer->gender : '') == 'female') ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('gender')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                                <textarea id="address" name="address" rows="3"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                    required
                                    x-bind:disabled="expired">{{ old('address', $customer ? $customer->address : '') }}</textarea>
                                @error('address')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            @auth
                            <div class="flex items-center">
                                <input id="update_profile" name="update_profile" type="checkbox"
                                    class="h-5 w-5 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded transition-colors"
                                    x-bind:disabled="expired">
                                <label for="update_profile" class="ml-2 block text-sm text-gray-700">
                                    Perbarui profil saya dengan informasi ini
                                </label>
                            </div>
                            @endauth
                        </div>
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="terms" name="terms" type="checkbox" required
                                    class="h-5 w-5 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded transition-colors"
                                    x-bind:disabled="expired">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="terms" class="font-medium text-gray-700">Saya menyetujui syarat dan ketentuan penyewaan</label>
                                <p class="text-gray-500 mt-1">Dengan mencentang kotak ini, Anda menyetujui <a href="#" class="text-indigo-600 hover:text-indigo-500 underline">Syarat Layanan</a> dan <a href="#" class="text-indigo-600 hover:text-indigo-500 underline">Kebijakan Privasi</a> kami.</p>
                            </div>
                        </div>
                        @error('terms')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Order Summary -->
                    <div class="bg-indigo-50 rounded-2xl p-6 mb-8">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Ringkasan Pesanan</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Harga Sewa ({{ $rental_duration }} hari)</span>
                                <span>Rp {{ number_format($vehicle->price * $rental_duration, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Biaya Layanan</span>
                                <span>Rp 0</span>
                            </div>
                            <div class="flex justify-between pt-3 border-t border-indigo-100">
                                <span class="font-bold text-gray-900">Total Pembayaran</span>
                                <span class="font-bold text-indigo-600">Rp {{ number_format($total_payment, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                            class="px-8 py-4 bg-indigo-600 text-white rounded-xl font-medium hover:bg-indigo-700 transition-colors shadow-md hover:shadow-indigo-500/30 flex items-center"
                            x-bind:disabled="expired" x-show="!expired">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 mr-2">
                                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                <line x1="1" y1="10" x2="23" y2="10"></line>
                            </svg>
                            Selesaikan Pemesanan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Custom radio button behavior
    document.addEventListener('DOMContentLoaded', function() {
        const radioInputs = document.querySelectorAll('input[name="payment_method"]');
        
        function updateRadioStyles() {
            radioInputs.forEach(input => {
                const radioDiv = input.parentElement.querySelector('.payment-radio');
                const radioCheckedDiv = input.parentElement.querySelector('.payment-radio-checked');
                const parentDiv = input.parentElement;
                
                if (input.checked) {
                    radioCheckedDiv.classList.remove('hidden');
                    radioDiv.classList.add('border-indigo-600');
                    parentDiv.classList.add('border-indigo-500');
                    parentDiv.classList.add('bg-indigo-50');
                } else {
                    radioCheckedDiv.classList.add('hidden');
                    radioDiv.classList.remove('border-indigo-600');
                    parentDiv.classList.remove('border-indigo-500');
                    parentDiv.classList.remove('bg-indigo-50');
                }
            });
        }
        
        radioInputs.forEach(input => {
            input.addEventListener('change', updateRadioStyles);
        });
        
        // Initial update
        updateRadioStyles();
    });
</script>
@endsection
