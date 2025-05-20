@extends('layouts.admin')

@section('title', 'Kelola Pengguna')
@section('header', 'Kelola Pengguna')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                <i class="fas fa-users text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Total Pengguna</p>
                <p class="text-2xl font-semibold text-gray-800">{{ $totalUsers ?? 0 }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-500">
                <i class="fas fa-user-check text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Pelanggan Terdaftar</p>
                <p class="text-2xl font-semibold text-gray-800">{{ $totalCustomers ?? 0 }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100 text-purple-500">
                <i class="fas fa-car-side text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Pelanggan Aktif</p>
                <p class="text-2xl font-semibold text-gray-800">{{ $activeCustomers ?? 0 }}</p>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="flex justify-between items-center px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-800">Semua Pengguna</h2>
        <a href="{{ route('customers.manage.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            <i class="fas fa-plus mr-2"></i> Tambah Pengguna Baru
        </a>
    </div>

    <div class="p-6">
        <!-- Form Pencarian -->
        <form action="{{ route('customers.manage.index') }}" method="GET" class="mb-6">
            <div class="flex">
                <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Cari berdasarkan nama, email, telepon..." class="flex-1 px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-r-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pengguna</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kontak</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peran</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Terdaftar</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($users ?? [] as $user)
                    <tr>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                                        <i class="fas fa-user"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    @if($user->customer)
                                    <div class="text-sm font-medium text-gray-900">{{ $user->customer->name }}</div>
                                    @endif
                                    <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            @if($user->customer)
                            <div class="text-sm text-gray-900">{{ $user->customer->phone ?? 'N/A' }}</div>
                            <div class="text-sm text-gray-500">{{ $user->customer->address ? Str::limit($user->customer->address, 30) : 'N/A' }}</div>
                            @else
                            <div class="text-sm text-gray-500">Profil pelanggan tidak tersedia</div>
                            @endif
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                                {{ ucfirst($user->role ?? 'user') }}
                            </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                            {{ $user->created_at->translatedFormat('d F Y') }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('customers.manage.show', $user->id) }}" class="text-blue-600 hover:text-blue-900">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('customers.manage.edit', $user->id) }}" class="text-green-600 hover:text-green-900">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <div x-data="{ open: false }">
                                    <button
                                        @click="open = true"
                                        class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-trash mr-1"></i>
                                    </button>
                                    <div
                                        x-show="open"
                                        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
                                        x-cloak>
                                        <div class="bg-white rounded-lg shadow-lg p-6">
                                            <h2 class="text-xl font-bold mb-4">Konfirmasi Penghapusan</h2>
                                            <p class="mb-6">Apakah Anda yakin ingin menghapus pengguna ini? Tindakan ini tidak dapat dibatalkan.</p>
                                            <div class="flex justify-end gap-4">
                                                <button
                                                    @click="open = false"
                                                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded">
                                                    Batal
                                                </button>

                                                <form action="{{ route('customers.manage.destroy', $user->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        type="submit"
                                                        class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-3 text-center text-sm text-gray-500">Tidak ada pengguna ditemukan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(isset($users) && method_exists($users, 'links'))
        <div class="mt-4">
            {{ $users->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>
@endsection