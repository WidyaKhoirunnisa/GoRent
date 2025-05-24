<section class="space-y-6">
    <header class="mb-6">
        <div class="flex items-center mb-2">
            <div class="bg-gradient-to-r from-red-600 to-pink-600 p-2 rounded-lg mr-3">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-white">
                    <polyline points="3 6 5 6 21 6"></polyline>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                    <line x1="10" y1="11" x2="10" y2="17"></line>
                    <line x1="14" y1="11" x2="14" y2="17"></line>
                </svg>
            </div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">
                {{ __('Hapus Akun') }}
            </h2>
        </div>

        <p class="text-sm text-gray-600 dark:text-gray-400">
            {{ __('Setelah akun Anda dihapus, semua sumber daya dan data akan dihapus secara permanen. Sebelum menghapus akun Anda, harap unduh data atau informasi apa pun yang ingin Anda simpan.') }}
        </p>
    </header>

    <div class="bg-red-50 dark:bg-red-900/30 p-4 rounded-lg border border-red-200 dark:border-red-800 mb-6">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-red-600 dark:text-red-400">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800 dark:text-red-300">Peringatan</h3>
                <div class="mt-2 text-sm text-red-700 dark:text-red-400">
                    <p>Tindakan ini tidak dapat dibatalkan. Semua data Anda akan dihapus secara permanen, termasuk:</p>
                    <ul class="list-disc pl-5 space-y-1 mt-2">
                        <li>Informasi profil dan akun</li>
                        <li>Riwayat pemesanan dan transaksi</li>
                        <li>Preferensi dan pengaturan</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="flex justify-center">
        <x-danger-button
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
            class="bg-gradient-to-r from-red-600 to-pink-600 hover:from-red-700 hover:to-pink-700 transition-all duration-200 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 mr-2">
                <polyline points="3 6 5 6 21 6"></polyline>
                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                <line x1="10" y1="11" x2="10" y2="17"></line>
                <line x1="14" y1="11" x2="14" y2="17"></line>
            </svg>
            {{ __('Hapus Akun') }}
        </x-danger-button>
    </div>

    <x-modal id="confirm-user-deletion">
        <x-slot name="trigger">
            {{-- Kosongkan jika kamu trigger pakai JavaScript atau Tombol di luar modal --}}
        </x-slot>

        <div class="p-6">
            <div class="flex items-center mb-4 text-red-600 dark:text-red-400">
                <svg ... class="w-8 h-8 mr-3">...</svg>
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Apakah Anda yakin ingin menghapus akun Anda?') }}
                </h2>
            </div>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Setelah akun Anda dihapus anda tidak bisa mengembalikan lagi') }}
            </p>

            <form method="post" action="{{ route('profile.destroy') }}" class="mt-6">
                @csrf
                @method('delete')

                <div>
                    <x-input-label for="password" value="{{ __('Kata Sandi') }}" class="sr-only" />

                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg ... class="w-5 h-5 text-gray-400">...</svg>
                        </div>
                        <x-text-input
                            id="password"
                            name="password"
                            type="password"
                            class="pl-10 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 focus:border-red-500 focus:ring-red-500 transition-colors"
                            placeholder="{{ __('Kata Sandi') }}" />
                    </div>

                    <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end">
                    <x-secondary-button x-on:click="$dispatch('close-modal', 'confirm-user-deletion')" class="mr-3">
                        {{ __('Batal') }}
                    </x-secondary-button>

                    <x-danger-button class="bg-gradient-to-r from-red-600 to-pink-600 hover:from-red-700 hover:to-pink-700 transition-all duration-200">
                        {{ __('Hapus Akun') }}
                    </x-danger-button>
                </div>
            </form>
        </div>
    </x-modal>

</section>