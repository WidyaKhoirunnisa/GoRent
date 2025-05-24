@extends('layouts.admin')

@section('title', 'Edit Kendaraan')
@section('header', 'Edit Kendaraan')

@section('content')
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-800">Edit Detail Kendaraan</h2>
    </div>

    <div class="p-6">
        @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 p-4 mb-6 rounded">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-500"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-700 font-medium">Mohon perbaiki kesalahan berikut:</p>
                    <ul class="mt-1 text-sm text-red-700 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif

        <form action="{{ route('vehicles.manage.update', $vehicle->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Kolom Kiri -->
                <div>
                    <div class="mb-4">
                        <x-input-label >Merek/Model</x-input-label>
                        <div class="px-4 py-2 bg-gray-100 border border-gray-300 rounded-md text-gray-700">
                            {{ $vehicle->brand }}
                        </div>
                        <input type="hidden" name="brand" value="{{ $vehicle->brand }}">
                    </div>

                    <div class="mb-4">
                        <x-input-label >Jenis Kendaraan</x-input-label>
                        <div class="px-4 py-2 bg-gray-100 border border-gray-300 rounded-md text-gray-700 capitalize">
                            {{ $vehicle->type }}
                        </div>
                        <input type="hidden" name="type" value="{{ $vehicle->type }}">
                    </div>

                    <div class="mb-4">
                        <x-input-label >Tahun</x-input-label>
                        <div class="px-4 py-2 bg-gray-100 border border-gray-300 rounded-md text-gray-700">
                            {{ $vehicle->year }}
                        </div>
                        <input type="hidden" name="year" value="{{ $vehicle->year }}">
                    </div>

                    <div class="mb-4">
                        <x-input-label >Plat Nomor</x-input-label>
                        <div class="px-4 py-2 bg-gray-100 border border-gray-300 rounded-md text-gray-700">
                            {{ $vehicle->no_plat }}
                        </div>
                        <input type="hidden" name="no_plat" value="{{ $vehicle->no_plat }}">
                    </div>
                </div>

                <!-- Kolom Kanan -->
                <div>
                    <div class="mb-4">
                        <x-input-label >Warna</x-input-label>
                        <div class="px-4 py-2 bg-gray-100 border border-gray-300 rounded-md text-gray-700 flex items-center">
                            <div class="w-4 h-4 rounded-full mr-2 border border-gray-300" style="background-color: {{ strtolower($vehicle->color) }};"></div>
                            @php
                        $colorTranslations = [
                        'black' => 'Hitam',
                        'white' => 'Putih',
                        'red' => 'Merah',
                        'blue' => 'Biru',
                        'green' => 'Hijau',
                        'yellow' => 'Kuning',
                        'orange' => 'Oranye',
                        'purple' => 'Ungu',
                        'pink' => 'Merah Muda',
                        'brown' => 'Coklat',
                        'gray' => 'Abu-abu',
                        'silver' => 'Silver',
                        'gold' => 'Emas',
                        ];
                        $colorInIndonesian = $colorTranslations[strtolower($vehicle->color)] ?? ucfirst($vehicle->color);
                        @endphp
                        {{ $colorInIndonesian }}
                        </div>
                        <input type="hidden" name="color" value="{{ $vehicle->color }}">
                    </div>

                    <div class="mb-4">
                        <x-input-label for="condition" >Kondisi</x-input-label>
                        <select name="condition" id="condition" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="updateAvailability()">
                            <option value="Normal" {{ old('condition', $vehicle->condition) == 'Normal' ? 'selected' : '' }}>Normal</option>
                            <option value="Service" {{ old('condition', $vehicle->condition) == 'Service' ? 'selected' : '' }}>Service</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <x-input-label for="price" >Harga Sewa (per hari)</x-input-label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500">Rp</span>
                            </div>
                            <input type="number" name="price" id="price" value="{{ old('price', $vehicle->price) }}"
                                class="w-full pl-10 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <div class="mb-4">
                        <x-input-label for="ready" >Ketersediaan</x-input-label>
                        <select name="ready" id="ready" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="1" {{ old('ready', $vehicle->ready ? '1' : '0') == '1' ? 'selected' : '' }}>Tersedia</option>
                            <option value="0" {{ old('ready', $vehicle->ready ? '1' : '0') == '0' ? 'selected' : '' }}>Tidak Tersedia</option>
                        </select>
                        <p class="text-xs text-gray-500 mt-1" id="availability_note"></p>
                    </div>
                </div>
            </div>

            <!-- Bagian Gambar Kendaraan -->
            @if($vehicle->image)
            <div class="mt-6">
                <x-input-label class="block text-sm font-medium text-gray-700 mb-2">Gambar Kendaraan Saat Ini</x-input-label>
                <div class="mt-1 flex justify-center p-4 border border-gray-300 rounded-md">
                    <img src="{{ asset('storage/'.$vehicle->image) }}" alt="{{ $vehicle->brand }}" class="h-48 object-contain">
                </div>
            </div>
            @endif

            <!-- Tombol Submit -->
            <div class="mt-6 flex justify-end">
                <a href="{{ route('vehicles.manage.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 mr-2">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Perbarui Kendaraan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Fungsi untuk memperbarui ketersediaan berdasarkan kondisi
    function updateAvailability() {
        const conditionSelect = document.getElementById('condition');
        const readySelect = document.getElementById('ready');
        const availabilityNote = document.getElementById('availability_note');

        if (conditionSelect.value === 'Service') {
            // Jika kondisi adalah Service, maka otomatis set ketersediaan ke Tidak Tersedia
            readySelect.value = '0';
            readySelect.setAttribute('readonly', true);
            readySelect.classList.add('bg-gray-100', 'pointer-events-none');
            availabilityNote.textContent = 'Kendaraan dalam servis otomatis tidak tersedia.';
            availabilityNote.classList.add('text-amber-600');
        } else {
            // Jika kondisi Normal, maka enable dropdown ketersediaan
            readySelect.value = '1';
            readySelect.removeAttribute('readonly');
            readySelect.classList.remove('bg-gray-100', 'pointer-events-none');
            availabilityNote.textContent = '';
            availabilityNote.classList.remove('text-amber-600');
        }
    }

    // Jalankan fungsi saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        updateAvailability();
    });
</script>
@endsection