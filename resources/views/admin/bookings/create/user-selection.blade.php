@extends('layouts.admin')

@section('title', 'Pilih Customer')
@section('header', 'Pilih Customer')

@section('content')
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-800">Pilih Customer</h2>
    </div>
    
    <div class="p-6">
        <!-- Form Pencarian -->
        <form action="{{ route('bookings.manage.create.user-selection') }}" method="GET" class="mb-8">
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 shadow-sm">
                <div class="flex flex-col md:flex-row md:items-end gap-4">
                    <div class="flex-grow">
                        <x-input-label for="search">
                            <i class="fas fa-search text-gray-400 mr-1"></i> Cari Customer
                        </x-input-label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user text-gray-400"></i>
                            </div>
                            <input 
                                type="text" 
                                id="search"
                                name="search" 
                                placeholder="Cari berdasarkan nama, email, nomor telepon, atau ID..." 
                                value="{{ request('search') }}" 
                                class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                autofocus
                            >
                            @if(request('search'))
                                <a href="{{ route('bookings.manage.create.user-selection') }}" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 transition-colors duration-200">
                                    <i class="fas fa-times"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <button type="submit" class="px-5 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200 flex items-center">
                            <i class="fas fa-search mr-2"></i> Cari
                        </button>
                    </div>
                </div>
            </div>
        </form>

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

        <!-- Daftar Customer -->
        @if($users->isEmpty())
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">
                            @if(request('search'))
                                Tidak ada Customer yang cocok dengan "<strong>{{ request('search') }}</strong>". Silakan coba pencarian lain atau 
                                <a href="{{ route('customers.manage.create') }}" class="font-medium underline">tambah Customer baru</a>.
                            @else
                                Tidak ada Customer ditemukan. Silakan <a href="{{ route('customers.manage.create') }}" class="font-medium underline">tambah Customer baru</a>.
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        @else
            <!-- Tabel Customer -->
            <div class="mb-6">
                <h3 class="text-md font-medium text-gray-700 mb-3">
                    @if(request('search'))
                        Hasil Pencarian untuk "{{ request('search') }}"
                    @else
                        Customer Terbaru
                    @endif
                </h3>
                <div class="border border-gray-200 rounded-md overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Telepon</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($users as $user)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $user->customer->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">
                                            {{ $user->customer->phone ?? 'Tidak tersedia' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('bookings.manage.create.date-selection', ['user_id' => $user->id]) }}" 
                                           class="text-blue-600 hover:text-blue-900 bg-blue-100 hover:bg-blue-200 px-3 py-1 rounded-md">
                                            Pilih <i class="fas fa-arrow-right ml-1"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <div class="flex justify-between mt-6">
            <a href="{{ route('customers.manage.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                <i class="fas fa-plus mr-2"></i> Tambah Customer Baru
            </a>
        </div>

        <!-- Navigasi Halaman -->
        @if($users->hasPages())
            <div class="mt-6">
                {{ $users->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
