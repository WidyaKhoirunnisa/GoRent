@extends('layouts.admin')

@section('title', 'Kelola Pemesanan')
@section('header', 'Kelola Pemesanan')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                <i class="fas fa-calendar-check text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Total Pemesanan</p>
                <p class="text-2xl font-semibold text-gray-800">{{ $totalRentals ?? 0 }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-500">
                <i class="fas fa-car text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Sewa Aktif</p>
                <p class="text-2xl font-semibold text-gray-800">{{ $activeRentals ?? 0 }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-500">
                <i class="fas fa-clock text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Pembayaran Tertunda</p>
                <p class="text-2xl font-semibold text-gray-800">{{ $pendingPayments ?? 0 }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100 text-purple-500">
                <i class="fas fa-check-circle text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Selesai</p>
                <p class="text-2xl font-semibold text-gray-800">{{ $completedRentals ?? 0 }}</p>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="flex justify-between items-center px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-800">Semua Pemesanan</h2>
    </div>
    
    <div class="p-6">
        <!-- Pencarian dan Filter -->
        <form action="{{ route('bookings.manage.index') }}" method="GET" class="mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Cari berdasarkan nama, telepon, kendaraan..." class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status Pembayaran</label>
                    <select name="status" id="status" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach($paymentStatuses as $value => $label)
                            <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                    <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <div>
                    <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                    <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
            
            <div class="mt-4 flex justify-end">
                <a href="{{ route('bookings.manage.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 mr-2">
                    Reset
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Filter
                </button>
            </div>
        </form>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Pemesanan</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelanggan</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kendaraan</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pembayaran</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($rentals ?? [] as $rental)
                        <tr class="hover:bg-gray-50 cursor-pointer" onclick="window.location='{{ route('bookings.manage.show', $rental->id) }}'">
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                {{ $rental->payment_order_id ?? 'N/A' }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="flex flex-col">
                                    <div class="text-sm font-medium text-gray-900">{{ $rental->customer_name }}</div>
                                    <div class="text-sm text-gray-500">{{ $rental->customer_phone }}</div>
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="flex flex-col">
                                    <div class="text-sm font-medium text-gray-900">{{ $rental->vehicle->brand ?? 'N/A' }}</div>
                                    <div class="text-sm text-gray-500">{{ $rental->vehicle->no_plat ?? 'N/A' }}</div>
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="flex flex-col">
                                    <div class="text-sm font-medium text-gray-900">{{ $rental->rental_date ? $rental->rental_date->translatedFormat('d F Y') : 'N/A' }}</div>
                                    <div class="text-sm text-gray-500">{{ $rental->return_date ? $rental->return_date->translatedFormat('d F Y') : 'N/A' }}</div>
                                    <div class="text-xs text-gray-500">{{ $rental->duration }} hari</div>
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                Rp {{ number_format($rental->total_payment, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'expired' => 'bg-gray-100 text-gray-800',
                                        'paid' => 'bg-blue-100 text-blue-800',
                                        'confirmed' => 'bg-green-100 text-green-800',
                                        'completed' => 'bg-purple-100 text-purple-800',
                                        'cancelled' => 'bg-red-100 text-red-800',
                                    ];
                                    $statusColor = $statusColors[$rental->payment_status] ?? 'bg-gray-100 text-gray-800';
                                    
                                    $statusTranslation = [
                                        'pending' => 'Tertunda',
                                        'expired' => 'Kedaluwarsa',
                                        'paid' => 'Dibayar',
                                        'confirmed' => 'Dikonfirmasi',
                                        'completed' => 'Selesai',
                                        'cancelled' => 'Dibatalkan',
                                    ];
                                    $statusText = $statusTranslation[$rental->payment_status] ?? ucfirst($rental->payment_status);
                                @endphp
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColor }}">
                                    {{ $statusText }}
                                </span>
                                
                                @if($rental->isActive)
                                    <span class="ml-1 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Aktif
                                    </span>
                                @endif
                                
                                @if($rental->isOverdue)
                                    <span class="ml-1 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Terlambat
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium" onclick="event.stopPropagation()">
                                <div class="flex space-x-2">
                                    <a href="{{ route('bookings.manage.show', $rental->id) }}" class="text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('bookings.manage.edit', $rental->id) }}" class="text-green-600 hover:text-green-900">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('bookings.manage.destroy', $rental->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Apakah Anda yakin ingin menghapus pemesanan ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-3 text-center text-sm text-gray-500">Tidak ada pemesanan ditemukan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if(isset($rentals) && method_exists($rentals, 'links'))
            <div class="mt-4">
                {{ $rentals->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>
@endsection