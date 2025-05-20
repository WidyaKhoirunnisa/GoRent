@extends('layouts.admin')

@section('title', 'Tambah Kendaraan Baru')
@section('header', 'Tambah Kendaraan Baru')

@section('content')
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-800">Detail Kendaraan</h2>
    </div>

    <div class="p-6">
        @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 p-4 mb-6 rounded">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-500"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-700 font-medium">Silakan perbaiki kesalahan berikut:</p>
                    <ul class="mt-1 text-sm text-red-700 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif

        <form action="{{ route('vehicles.manage.store') }}" method="POST" enctype="multipart/form-data" id="vehicleForm">
            @csrf
            <!-- Hidden input for ready field -->
            <input type="hidden" name="ready" id="ready_hidden" value="{{ old('ready', '1') }}">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Kolom Kiri -->
                <div>
                    <div class="mb-4">
                        <label for="brand" class="block text-sm font-medium text-gray-700 mb-1">Merek/Model <span class="text-red-500">*</span></label>
                        <input type="text" name="brand" id="brand" value="{{ old('brand') }}" placeholder="Contoh: Toyota Avanza"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>

                    <div class="mb-4">
                        <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Jenis Kendaraan <span class="text-red-500">*</span></label>
                        <select name="type" id="type" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <option value="">Pilih Jenis Kendaraan</option>
                            <option value="sedan" {{ old('type') == 'sedan' ? 'selected' : '' }}>Sedan</option>
                            <option value="city car" {{ old('type') == 'city car' ? 'selected' : '' }}>City Car</option>
                            <option value="suv" {{ old('type') == 'suv' ? 'selected' : '' }}>SUV</option>
                            <option value="pickup" {{ old('type') == 'pickup' ? 'selected' : '' }}>Pickup</option>
                            <option value="minivan" {{ old('type') == 'minivan' ? 'selected' : '' }}>Minivan</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="year" class="block text-sm font-medium text-gray-700 mb-1">Tahun <span class="text-red-500">*</span></label>
                        <input type="number" name="year" id="year" value="{{ old('year') }}" placeholder="Contoh: 2022"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>

                    <div class="mb-4">
                        <label for="no_plat" class="block text-sm font-medium text-gray-700 mb-1">Nomor Polisi <span class="text-red-500">*</span></label>
                        <input type="text" name="no_plat" id="no_plat" value="{{ old('no_plat') }}" placeholder="Contoh: B 1234 ABC"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                </div>

                <!-- Kolom Kanan -->
                <div>
                    <div class="mb-4">
                        <label for="color" class="block text-sm font-medium text-gray-700 mb-1">Warna <span class="text-red-500">*</span></label>
                        <div class="flex items-center space-x-2">
                            <select name="color" id="color" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required onchange="updateColorPreview()">
                                <option value="">Pilih Warna</option>
                                <option value="black" {{ old('color') == 'black' ? 'selected' : '' }} data-color="#000000">Hitam</option>
                                <option value="white" {{ old('color') == 'white' ? 'selected' : '' }} data-color="#FFFFFF">Putih</option>
                                <option value="red" {{ old('color') == 'red' ? 'selected' : '' }} data-color="#FF0000">Merah</option>
                                <option value="blue" {{ old('color') == 'blue' ? 'selected' : '' }} data-color="#0000FF">Biru</option>
                                <option value="green" {{ old('color') == 'green' ? 'selected' : '' }} data-color="#008000">Hijau</option>
                                <option value="yellow" {{ old('color') == 'yellow' ? 'selected' : '' }} data-color="#FFFF00">Kuning</option>
                                <option value="orange" {{ old('color') == 'orange' ? 'selected' : '' }} data-color="#FFA500">Oranye</option>
                                <option value="purple" {{ old('color') == 'purple' ? 'selected' : '' }} data-color="#800080">Ungu</option>
                                <option value="pink" {{ old('color') == 'pink' ? 'selected' : '' }} data-color="#FFC0CB">Merah Muda</option>
                                <option value="brown" {{ old('color') == 'brown' ? 'selected' : '' }} data-color="#A52A2A">Coklat</option>
                                <option value="gray" {{ old('color') == 'gray' ? 'selected' : '' }} data-color="#808080">Abu-abu</option>
                                <option value="silver" {{ old('color') == 'silver' ? 'selected' : '' }} data-color="#C0C0C0">Silver</option>
                                <option value="gold" {{ old('color') == 'gold' ? 'selected' : '' }} data-color="#FFD700">Emas</option>
                            </select>
                            <div id="colorPreview" class="w-8 h-8 rounded-full border border-gray-300"></div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="condition" class="block text-sm font-medium text-gray-700 mb-1">Kondisi <span class="text-red-500">*</span></label>
                        <select name="condition" id="condition" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required onchange="updateAvailability()">
                            <option value="Normal" {{ old('condition', 'Normal') == 'Normal' ? 'selected' : '' }}>Normal</option>
                            <option value="Service" {{ old('condition') == 'Service' ? 'selected' : '' }}>Servis</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Harga Sewa (per hari) <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500">Rp</span>
                            </div>
                            <input type="number" name="price" id="price" value="{{ old('price') }}" placeholder="Contoh: 500000"
                                class="w-full pl-10 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Ketersediaan <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div id="availability_display" class="flex items-center p-2 rounded-md {{ old('condition') == 'Service' ? 'bg-red-50 border border-red-200' : 'bg-green-50 border border-green-200' }}">
                                <span id="availability_text" class="{{ old('condition') == 'Service' ? 'text-red-700' : 'text-green-700' }} font-medium">
                                    {{ old('condition') == 'Service' ? 'Tidak Tersedia' : 'Tersedia' }}
                                </span>
                            </div>
                            <p class="text-xs text-gray-500 mt-1" id="availability_note">
                                {{ old('condition') == 'Service' ? 'Kendaraan dalam servis otomatis tidak tersedia.' : 'Kendaraan dalam kondisi normal tersedia untuk disewa.' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upload Gambar -->
            <div class="mt-6">
                <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Gambar Kendaraan <span class="text-red-500">*</span></label>
                <div id="dropzone"
                    class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md cursor-pointer hover:border-blue-400 transition">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                            viewBox="0 0 48 48" aria-hidden="true">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600">
                            <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500">
                                <span>Unggah berkas</span>
                            </label>
                            <p class="pl-1">atau seret dan lepas</p>
                        </div>
                        <p class="text-xs text-gray-500">PNG, JPG, JPEG maksimal 10MB</p>
                    </div>
                </div>

                <!-- Input tersembunyi -->
                <input id="image" name="image" type="file" accept="image/*" class="hidden" onchange="previewImage(event)">

                <!-- Pratinjau gambar -->
                <div class="mt-4">
                    <img id="preview" class="hidden w-100 h-100 object-cover rounded-md mx-auto" />
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="mt-6 flex justify-end">
                <a href="{{ route('admin') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 mr-2">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Tambah Kendaraan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('preview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function updateColorPreview() {
        const colorSelect = document.getElementById('color');
        const colorPreview = document.getElementById('colorPreview');
        const selectedOption = colorSelect.options[colorSelect.selectedIndex];
        
        if (selectedOption && selectedOption.dataset.color) {
            colorPreview.style.backgroundColor = selectedOption.dataset.color;
        } else {
            colorPreview.style.backgroundColor = 'transparent';
        }
    }

    function updateAvailability() {
        const conditionSelect = document.getElementById('condition');
        const readyHidden = document.getElementById('ready_hidden');
        const availabilityDisplay = document.getElementById('availability_display');
        const availabilityText = document.getElementById('availability_text');
        const availabilityNote = document.getElementById('availability_note');
        
        if (conditionSelect.value === 'Service') {
            // Jika kondisi adalah Service, maka otomatis set ketersediaan ke Tidak Tersedia
            readyHidden.value = '0';
            
            // Update tampilan
            availabilityDisplay.classList.remove('bg-green-50', 'border-green-200');
            availabilityDisplay.classList.add('bg-red-50', 'border-red-200');
            
            availabilityText.classList.remove('text-green-700');
            availabilityText.classList.add('text-red-700');
            availabilityText.textContent = 'Tidak Tersedia';
            
            availabilityNote.textContent = 'Kendaraan dalam servis otomatis tidak tersedia.';
        } else {
            // Jika kondisi Normal, maka set ketersediaan ke Tersedia
            readyHidden.value = '1';
            
            // Update tampilan
            availabilityDisplay.classList.remove('bg-red-50', 'border-red-200');
            availabilityDisplay.classList.add('bg-green-50', 'border-green-200');
            
            availabilityText.classList.remove('text-red-700');
            availabilityText.classList.add('text-green-700');
            availabilityText.textContent = 'Tersedia';
            
            availabilityNote.textContent = 'Kendaraan dalam kondisi normal tersedia untuk disewa.';
        }
    }

    document.getElementById('dropzone').addEventListener('click', function () {
        document.getElementById('image').click();
    });

    document.getElementById('dropzone').addEventListener('dragover', function (e) {
        e.preventDefault();
        this.classList.add('border-blue-400');
    });

    document.getElementById('dropzone').addEventListener('dragleave', function (e) {
        e.preventDefault();
        this.classList.remove('border-blue-400');
    });

    document.getElementById('dropzone').addEventListener('drop', function (e) {
        e.preventDefault();
        this.classList.remove('border-blue-400');
        const fileInput = document.getElementById('image');
        fileInput.files = e.dataTransfer.files;
        previewImage({ target: fileInput });
    });

    // Form validation before submit
    document.getElementById('vehicleForm').addEventListener('submit', function(e) {
        // Ensure all required fields are filled
        const requiredFields = this.querySelectorAll('[required]');
        let isValid = true;
        
        requiredFields.forEach(field => {
            if (!field.value) {
                isValid = false;
                field.classList.add('border-red-500');
            } else {
                field.classList.remove('border-red-500');
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            alert('Silakan isi semua field yang wajib diisi.');
        }
    });

    // Jalankan fungsi saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        updateColorPreview();
        updateAvailability();
        
        // Set default value for condition if not already set
        const conditionSelect = document.getElementById('condition');
        if (!conditionSelect.value) {
            conditionSelect.value = 'Normal';
            updateAvailability();
        }
    });
</script>

@endsection
