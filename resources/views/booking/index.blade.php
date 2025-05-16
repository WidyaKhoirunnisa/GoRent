@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-indigo-600 to-purple-700 p-6 text-white">
                <h1 class="text-2xl md:text-3xl font-bold">Pilih Tanggal Pemesanan Anda</h1>
                <p class="mt-2 opacity-90">Tentukan tanggal sewa dan kembali untuk menemukan kendaraan yang tersedia</p>
            </div>
            
            <!-- Booking Progress -->
            <div class="px-6 py-4 border-b border-gray-200 mb-6">
                <div class="flex items-center justify-between max-w-3xl mx-auto">
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold">1</div>
                        <span class="text-sm mt-2 font-medium text-indigo-600">Pilih Tanggal</span>
                    </div>
                    <div class="flex-1 h-1 bg-gray-300 mx-2"></div>
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 bg-gray-300 text-white rounded-full flex items-center justify-center font-bold">2</div>
                        <span class="text-sm mt-2 text-gray-600">Pilih Kendaraan</span>
                    </div>
                    <div class="flex-1 h-1 bg-gray-300 mx-2"></div>
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 bg-gray-300 text-white rounded-full flex items-center justify-center font-bold">3</div>
                        <span class="text-sm mt-2 text-gray-600">Buat Pesanan</span>
                    </div>
                </div>
            </div>

            <div class="px-6 py-8">
                <!-- Header -->
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold text-gray-900">Cari Mobil Tersedia</h2>
                    <p class="text-gray-600 mt-2">Pilih tanggal untuk melihat kendaraan yang tersedia untuk disewa</p>
                </div>

                @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p>{{ session('error') }}</p>
                    </div>
                </div>
                @endif

                <!-- Search Form -->
                <div class="max-w-lg mx-auto">
                    <div class="bg-gradient-to-br from-indigo-600 to-purple-700 rounded-xl p-6 shadow-xl">
                        <h3 class="text-xl font-semibold text-white mb-6">Pesan Kendaraan Anda</h3>

                        <form action="{{ route('booking.check-availability') }}" method="GET">
                            <!-- Rental Date -->
                            <div class="mb-4">
                                <label for="rental_date" class="block text-sm font-medium text-white text-left mb-2">
                                    Tanggal Sewa
                                </label>
                                <div class="relative">
                                    <input type="date" id="rental_date" name="rental_date"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 pl-10"
                                        min="{{ date('Y-m-d') }}"
                                        value="{{ old('rental_date', date('Y-m-d')) }}"
                                        required onclick="this.showPicker()">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                </div>
                                @error('rental_date')
                                <p class="text-red-300 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Return Date -->
                            <div class="mb-6">
                                <label for="return_date" class="block text-sm font-medium text-white text-left mb-2">
                                    Tanggal Kembali
                                </label>
                                <div class="relative">
                                    <input type="date" id="return_date" name="return_date"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 pl-10"
                                        min="{{ date('Y-m-d') }}"
                                        value="{{ old('return_date', date('Y-m-d', strtotime('+3 days'))) }}"
                                        required onclick="this.showPicker()">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                </div>
                                @error('return_date')
                                <p class="text-red-300 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Durasi Sewa Info -->
                            <div class="mb-6 bg-white bg-opacity-10 rounded-lg p-4 text-white">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                    </svg>
                                    <p>Durasi Sewa: <span id="rental_duration" class="font-bold">3</span> hari</p>
                                </div>
                            </div>

                            <!-- Search Button -->
                            <button type="submit" class="w-full py-3 px-4 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-lg transition duration-200 text-center shadow-md hover:shadow-lg transform hover:-translate-y-0.5 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9 9a2 2 0 114 0 2 2 0 01-4 0z" />
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a4 4 0 00-3.446 6.032l-2.261 2.26a1 1 0 101.414 1.415l2.261-2.261A4 4 0 1011 5z" clip-rule="evenodd" />
                                </svg>
                                Cari Kendaraan
                            </button>
                        </form>
                    </div>
                </div>
                
                <!-- Informasi Tambahan -->
                <div class="max-w-lg mx-auto mt-8">
                    <div class="bg-indigo-50 rounded-xl p-6 border border-indigo-100">
                        <h3 class="text-lg font-semibold text-indigo-800 mb-4 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                            Informasi Penting
                        </h3>
                        <ul class="space-y-2 text-indigo-700">
                            <li class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 mt-0.5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                <span>Pengambilan dan pengembalian kendaraan dapat dilakukan pada jam operasional kami (08.00 - 20.00 WIB).</span>
                            </li>
                            <li class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 mt-0.5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                <span>Harga sewa dihitung per hari penuh, termasuk hari pengambilan dan pengembalian.</span>
                            </li>
                            <li class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 mt-0.5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                <span>Pastikan untuk membawa SIM dan KTP yang masih berlaku saat pengambilan kendaraan.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Validasi tanggal
        const rentalDateInput = document.getElementById('rental_date');
        const returnDateInput = document.getElementById('return_date');
        const rentalDurationSpan = document.getElementById('rental_duration');

        function updateMinReturnDate() {
            const rentalDate = new Date(rentalDateInput.value);

            // Format tanggal ke YYYY-MM-DD untuk tanggal sewa
            const year = rentalDate.getFullYear();
            const month = String(rentalDate.getMonth() + 1).padStart(2, '0');
            const day = String(rentalDate.getDate()).padStart(2, '0');

            // Set tanggal minimum return sama dengan tanggal sewa (untuk booking 1 hari)
            returnDateInput.min = `${year}-${month}-${day}`;

            // Jika tanggal kembali lebih awal dari tanggal sewa, sesuaikan
            if (new Date(returnDateInput.value) < rentalDate) {
                returnDateInput.value = `${year}-${month}-${day}`;
            }

            updateRentalDuration();
        }

        function updateRentalDuration() {
            const rentalDate = new Date(rentalDateInput.value);
            const returnDate = new Date(returnDateInput.value);

            // Set waktu ke tengah hari untuk menghindari masalah zona waktu
            rentalDate.setHours(12, 0, 0, 0);
            returnDate.setHours(12, 0, 0, 0);

            // Hitung selisih hari
            const timeDiff = returnDate.getTime() - rentalDate.getTime();
            const dayDiff = Math.round(timeDiff / (1000 * 3600 * 24));

            // Update teks durasi
            rentalDurationSpan.textContent = dayDiff + 1; // +1 karena hari sewa dihitung
        }

        rentalDateInput.addEventListener('change', updateMinReturnDate);
        returnDateInput.addEventListener('change', updateRentalDuration);

        // Inisialisasi saat halaman dimuat
        updateMinReturnDate();
    });
</script>
@endsection
