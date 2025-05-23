<section>
    <header class="mb-6">
        <div class="flex items-center mb-2">
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-2 rounded-lg mr-3">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-white">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
            </div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">
                {{ __('Informasi Profil') }}
            </h2>
        </div>

        <p class="text-sm text-gray-600 dark:text-gray-400">
            {{ __("Perbarui informasi profil dan alamat email akun Anda.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- Form upload gambar -->
        <div class="mb-8 flex flex-col items-center">
            <div class="relative mb-4">
                <div class="w-32 h-32 rounded-full overflow-hidden bg-gray-200 dark:bg-gray-700 border-4 border-white dark:border-gray-800 shadow-lg">
                    <img
                        src="{{ $user->customer && $user->customer->image 
                ? asset('storage/' . $user->customer->image) 
                : asset('images/avatar/default-avatar.png') }}"
                        alt="Foto Profil"
                        class="w-full h-full object-cover"
                        id="avatar-preview">
                </div>
                <label for="image" class="absolute bottom-0 right-0 bg-indigo-600 hover:bg-indigo-700 text-white p-2 rounded-full cursor-pointer shadow-md transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="17 8 12 3 7 8"></polyline>
                        <line x1="12" y1="3" x2="12" y2="15"></line>
                    </svg>
                </label>
                <input type="file" id="image" name="image_upload" class="hidden" accept="image/*">
                <!-- Input tersembunyi untuk menyimpan data gambar yang sudah di-crop -->
                <input type="hidden" name="image" id="cropped_image">
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-400">Klik ikon untuk mengganti foto profil</p>
        </div>

        <!-- Modal untuk crop gambar -->
        <div id="cropperModal" class="fixed inset-0 z-50 flex items-center justify-center hidden">
            <div class="absolute inset-0 bg-black bg-opacity-50"></div>
            <div class="relative bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-3xl w-full mx-4 p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Sesuaikan Foto Profil</h3>
                    <button type="button" id="closeModal" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="md:col-span-2">
                        <div class="bg-gray-100 dark:bg-gray-700 rounded-lg">
                            <img id="cropperImage" class="max-w-full">
                        </div>
                    </div>
                    <div class="flex flex-col justify-between">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Preview</p>
                            <div class="preview bg-gray-200 dark:bg-gray-700"></div>

                            <div class="mt-4">
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Kontrol</p>
                                <div class="flex flex-wrap gap-2">
                                    <button type="button" id="rotateLeft" class="p-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 rounded">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                        </svg>
                                    </button>
                                    <button type="button" id="rotateRight" class="p-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 rounded">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                    </button>
                                    <button type="button" id="zoomIn" class="p-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 rounded">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                        </svg>
                                    </button>
                                    <button type="button" id="zoomOut" class="p-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 rounded">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM13 10H7" />
                                        </svg>
                                    </button>
                                    <button type="button" id="reset" class="p-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 rounded">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="button" id="applyCrop" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-lg shadow transition-colors">
                                Terapkan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informasi Dasar -->
        <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-lg border border-gray-100 dark:border-gray-700">
            <h3 class="text-md font-semibold text-gray-800 dark:text-gray-200 mb-4">Informasi Dasar</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama -->
                <div>
                    <x-input-label for="name" :value="__('Nama')" class="text-gray-700 dark:text-gray-300" />
                    <div class="relative mt-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-gray-400">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </div>
                        <x-text-input id="name" name="name" type="text" class="pl-10 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 focus:border-indigo-500 focus:ring-indigo-500 transition-colors" :value="old('name', $user->customer->name ?? '')" autofocus autocomplete="name" placeholder="Masukkan nama lengkap" />
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Email')" class="text-gray-700 dark:text-gray-300" />
                    <div class="relative mt-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-gray-400">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                        </div>
                        <x-text-input id="email" name="email" type="email" class="pl-10 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 focus:border-indigo-500 focus:ring-indigo-500 transition-colors" :value="old('email', $user->email)" required autocomplete="username" placeholder="nama@email.com" />
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="mt-2 bg-yellow-50 dark:bg-yellow-900/30 p-3 rounded-lg border border-yellow-200 dark:border-yellow-800">
                        <p class="text-sm text-yellow-800 dark:text-yellow-200 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 mr-2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="8" x2="12" y2="12"></line>
                                <line x1="12" y1="16" x2="12.01" y2="16"></line>
                            </svg>
                            {{ __('Alamat email Anda belum diverifikasi.') }}
                        </p>

                        <button form="send-verification" class="mt-2 text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 mr-1">
                                <path d="M22 2L11 13"></path>
                                <path d="M22 2l-7 20-4-9-9-4 20-7z"></path>
                            </svg>
                            {{ __('Kirim ulang email verifikasi') }}
                        </button>

                        @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-sm text-green-600 dark:text-green-400 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 mr-1">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                            </svg>
                            {{ __('Tautan verifikasi baru telah dikirim ke alamat email Anda.') }}
                        </p>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Informasi Pribadi -->
        <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-lg border border-gray-100 dark:border-gray-700">
            <h3 class="text-md font-semibold text-gray-800 dark:text-gray-200 mb-4">Informasi Pribadi</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- NIK -->
                <div>
                    <x-input-label for="nik" :value="__('NIK')" class="text-gray-700 dark:text-gray-300" />
                    <div class="relative mt-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-gray-400">
                                <rect x="3" y="4" width="18" height="16" rx="2"></rect>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                        </div>
                        <x-text-input id="nik" name="nik" type="text" class="pl-10 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 focus:border-indigo-500 focus:ring-indigo-500 transition-colors" :value="old('nik', $user->customer->nik ?? '')" placeholder="Masukkan NIK" />
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('nik')" />
                </div>

                <!-- Jenis Kelamin -->
                <div>
                    <x-input-label for="gender" :value="__('Jenis Kelamin')" class="text-gray-700 dark:text-gray-300" />
                    <div class="relative mt-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-gray-400">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="M12 2a15 15 0 0 1 0 20"></path>
                            </svg>
                        </div>
                        <select id="gender" name="gender" class="pl-10 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 focus:border-indigo-500 focus:ring-indigo-500 transition-colors">
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="male" {{ old('gender', $user->customer->gender ?? '') == 'male' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="female" {{ old('gender', $user->customer->gender ?? '') == 'female' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('gender')" />
                </div>

                <!-- Nomor Telepon -->
                <div>
                    <x-input-label for="phone" :value="__('Nomor Telepon')" class="text-gray-700 dark:text-gray-300" />
                    <div class="relative mt-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-gray-400">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                            </svg>
                        </div>
                        <x-text-input id="phone" name="phone" type="text" class="pl-10 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 focus:border-indigo-500 focus:ring-indigo-500 transition-colors" :value="old('phone', $user->customer->phone ?? '')" placeholder="Masukkan nomor telepon" />
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                </div>

                <!-- Alamat -->
                <div class="md:col-span-2">
                    <x-input-label for="address" :value="__('Alamat')" class="text-gray-700 dark:text-gray-300" />
                    <div class="relative mt-1">
                        <div class="absolute top-3 left-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-gray-400">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                        </div>
                        <textarea id="address" name="address" rows="3" class="pl-10 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 focus:border-indigo-500 focus:ring-indigo-500 transition-colors" placeholder="Masukkan alamat lengkap">{{ old('address', $user->customer->address ?? '') }}</textarea>
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('address')" />
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between pt-4">
            <div class="text-sm text-gray-500 dark:text-gray-400">
                <span class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 mr-1">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="16" x2="12" y2="12"></line>
                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                    </svg>
                    Terakhir diperbarui: {{ $user->customer && $user->customer->updated_at ? $user->customer->updated_at->format('d M Y H:i') : '-' }}
                </span>
            </div>

            <div class="flex items-center gap-4">
                <x-primary-button class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 mr-2">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                        <polyline points="17 21 17 13 7 13 7 21"></polyline>
                        <polyline points="7 3 7 8 15 8"></polyline>
                    </svg>
                    {{ __('Simpan') }}
                </x-primary-button>

                @if (session('status') === 'profile-updated')
                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-900/30 py-1 px-3 rounded-full border border-green-200 dark:border-green-800 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 mr-1">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                    {{ __('Tersimpan.') }}
                </div>
                @endif
            </div>
        </div>
    </form>
</section>

<script>
    // Preview foto profil saat diunggah
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatar-preview').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('cropperModal');
        const closeModal = document.getElementById('closeModal');
        const imageInput = document.getElementById('image');
        const cropperImage = document.getElementById('cropperImage');
        const avatarPreview = document.getElementById('avatar-preview');
        const croppedImageInput = document.getElementById('cropped_image');
        const applyCropBtn = document.getElementById('applyCrop');
        
        let cropper;
        
        // Buka modal dan inisialisasi cropper saat gambar dipilih
        imageInput.addEventListener('change', function(e) {
            if (e.target.files.length) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    cropperImage.src = e.target.result;
                    modal.classList.remove('hidden');
                    
                    // Hancurkan cropper sebelumnya jika ada
                    if (cropper) {
                        cropper.destroy();
                    }
                    
                    // Inisialisasi cropper baru
                    cropper = new Cropper(cropperImage, {
                        aspectRatio: 1, // Rasio 1:1 untuk foto profil bulat
                        viewMode: 1, // Batasi area pemotongan ke dalam gambar
                        preview: '.preview', // Elemen untuk preview
                        dragMode: 'move', // Memungkinkan menggeser gambar
                        autoCropArea: 0.8, // Area pemotongan 80% dari ukuran gambar
                        responsive: true,
                        restore: false,
                        guides: true,
                        center: true,
                        highlight: false,
                        cropBoxMovable: true,
                        cropBoxResizable: true,
                        toggleDragModeOnDblclick: false,
                    });
                };
                reader.readAsDataURL(e.target.files[0]);
            }
        });
        
        // Tutup modal
        closeModal.addEventListener('click', function() {
            modal.classList.add('hidden');
            imageInput.value = ''; // Reset input file
        });
        
        // Terapkan crop
        applyCropBtn.addEventListener('click', function() {
            const canvas = cropper.getCroppedCanvas({
                width: 320, // Ukuran output
                height: 320,
                minWidth: 256,
                minHeight: 256,
                maxWidth: 4096,
                maxHeight: 4096,
                fillColor: '#fff',
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high',
            });
            
            // Tampilkan hasil crop di preview
            avatarPreview.src = canvas.toDataURL('image/jpeg', 0.9);
            
            // Simpan data gambar yang sudah di-crop ke input tersembunyi
            croppedImageInput.value = canvas.toDataURL('image/jpeg', 0.9);
            
            // Tutup modal
            modal.classList.add('hidden');
        });
        
        // Kontrol tambahan
        document.getElementById('rotateLeft').addEventListener('click', function() {
            cropper.rotate(-90);
        });
        
        document.getElementById('rotateRight').addEventListener('click', function() {
            cropper.rotate(90);
        });
        
        document.getElementById('zoomIn').addEventListener('click', function() {
            cropper.zoom(0.1);
        });
        
        document.getElementById('zoomOut').addEventListener('click', function() {
            cropper.zoom(-0.1);
        });
        
        document.getElementById('reset').addEventListener('click', function() {
            cropper.reset();
        });
    });
</script>

<style>
    .cropper-container {
        width: 100%;
        height: 300px;
    }

    .preview {
        overflow: hidden;
        width: 160px;
        height: 160px;
        margin: 0 auto;
        border-radius: 50%;
        border: 4px solid white;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
</style>