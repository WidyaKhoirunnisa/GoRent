@extends('layouts.app')

@section('title', 'Edit Profil - GoRent')

@section('content')
<div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header Profil -->
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Profil Pengguna</h1>
            <p class="text-gray-600 dark:text-gray-400">Kelola informasi dan pengaturan akun Anda</p>
        </div>
        
        <!-- Navigasi Tab -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md mb-6 overflow-hidden">
            <div class="flex flex-wrap border-b border-gray-200 dark:border-gray-700">
                <button onclick="showTab('profile-info')" id="profile-info-tab" class="tab-button px-6 py-3 text-indigo-600 dark:text-indigo-400 border-b-2 border-indigo-600 dark:border-indigo-400 font-medium">
                    Informasi Profil
                </button>
                <button onclick="showTab('password')" id="password-tab" class="tab-button px-6 py-3 text-gray-500 dark:text-gray-400 font-medium">
                    Kata Sandi
                </button>
                <button onclick="showTab('delete-account')" id="delete-account-tab" class="tab-button px-6 py-3 text-gray-500 dark:text-gray-400 font-medium">
                    Hapus Akun
                </button>
            </div>
        </div>
        
        <!-- Konten Tab -->
        <div class="space-y-6">
            <div id="profile-info" class="tab-content bg-white dark:bg-gray-800 shadow-lg rounded-xl overflow-hidden transition-all duration-300 ease-in-out">
                <div class="p-6 sm:p-8">
                    <div class="max-w-xl mx-auto">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            <div id="password" class="tab-content bg-white dark:bg-gray-800 shadow-lg rounded-xl overflow-hidden hidden transition-all duration-300 ease-in-out">
                <div class="p-6 sm:p-8">
                    <div class="max-w-xl mx-auto">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            <div id="delete-account" class="tab-content bg-white dark:bg-gray-800 shadow-lg rounded-xl overflow-hidden hidden transition-all duration-300 ease-in-out">
                <div class="p-6 sm:p-8">
                    <div class="max-w-xl mx-auto">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function showTab(tabId) {
        // Sembunyikan semua konten tab
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.classList.add('hidden');
        });
        
        // Tampilkan konten tab yang dipilih
        document.getElementById(tabId).classList.remove('hidden');
        
        // Reset semua tombol tab
        document.querySelectorAll('.tab-button').forEach(button => {
            button.classList.remove('text-indigo-600', 'dark:text-indigo-400', 'border-b-2', 'border-indigo-600', 'dark:border-indigo-400');
            button.classList.add('text-gray-500', 'dark:text-gray-400');
        });
        
        // Aktifkan tombol tab yang dipilih
        document.getElementById(tabId + '-tab').classList.remove('text-gray-500', 'dark:text-gray-400');
        document.getElementById(tabId + '-tab').classList.add('text-indigo-600', 'dark:text-indigo-400', 'border-b-2', 'border-indigo-600', 'dark:border-indigo-400');
    }
</script>
@endsection