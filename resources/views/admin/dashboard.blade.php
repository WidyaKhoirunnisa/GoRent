@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('header', 'Dashboard Admin')

@section('content')
<!-- Ringkasan Statistik -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <!-- Statistik Kendaraan -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                <i class="fas fa-car text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Total Kendaraan</p>
                <p class="text-2xl font-semibold text-gray-800">{{ $totalVehicles }}</p>
            </div>
        </div>
        <div class="mt-4 flex justify-between items-center">
            <div>
                <span class="text-green-500 text-sm">{{ $availableVehicles }}</span>
                <span class="text-xs text-gray-500">Tersedia</span>
            </div>
            <div>
                <span class="text-yellow-500 text-sm">{{ $serviceVehicles }}</span>
                <span class="text-xs text-gray-500">Dalam Servis</span>
            </div>
            <div>
                <span class="text-red-500 text-sm">{{ $totalVehicles - $availableVehicles - $serviceVehicles }}</span>
                <span class="text-xs text-gray-500">Disewa</span>
            </div>
        </div>
    </div>
    
    <!-- Statistik Pengguna -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-500">
                <i class="fas fa-users text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Total Pengguna</p>
                <p class="text-2xl font-semibold text-gray-800">{{ $totalUsers }}</p>
            </div>
        </div>
        <div class="mt-4 flex justify-between items-center">
            <div>
                <span class="text-blue-500 text-sm">{{ $totalCustomers }}</span>
                <span class="text-xs text-gray-500">Pelanggan</span>
            </div>
            <div>
                <span class="text-purple-500 text-sm">{{ $newUsersThisMonth }}</span>
                <span class="text-xs text-gray-500">Baru Bulan Ini</span>
            </div>
        </div>
    </div>
    
    <!-- Statistik Pemesanan -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100 text-purple-500">
                <i class="fas fa-calendar-check text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Total Pemesanan</p>
                <p class="text-2xl font-semibold text-gray-800">{{ $totalBookings }}</p>
            </div>
        </div>
        <div class="mt-4 flex justify-between items-center">
            <div>
                <span class="text-green-500 text-sm">{{ $activeRentals }}</span>
                <span class="text-xs text-gray-500">Aktif</span>
            </div>
            <div>
                <span class="text-yellow-500 text-sm">{{ $pendingPayments }}</span>
                <span class="text-xs text-gray-500">Menunggu Pembayaran</span>
            </div>
        </div>
    </div>
    
    <!-- Statistik Pendapatan -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-500">
                <i class="fas fa-money-bill-wave text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Total Pendapatan</p>
                <p class="text-2xl font-semibold text-gray-800">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            </div>
        </div>
        <div class="mt-4">
            <div class="flex items-center">
                <span class="text-green-500 text-sm">Rp {{ number_format($revenueThisMonth, 0, ',', '.') }}</span>
                <span class="text-xs text-gray-500 ml-2">Bulan Ini</span>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Grafik Pendapatan Bulanan -->
    <div class="lg:col-span-2 bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Pendapatan Bulanan</h2>
        </div>
        <div class="p-6">
            <canvas id="revenueChart" height="300"></canvas>
        </div>
    </div>
    
    <!-- Distribusi Jenis Kendaraan -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Jenis Kendaraan</h2>
        </div>
        <div class="p-6">
            <canvas id="vehicleTypesChart" height="300"></canvas>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Pemesanan Terbaru -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="flex justify-between items-center px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Pemesanan Terbaru</h2>
            <a href="{{ route('bookings.manage.index') }}" class="text-sm text-blue-600 hover:underline">Lihat Semua</a>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelanggan</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kendaraan</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($recentBookings as $booking)
                            <tr class="hover:bg-gray-50 cursor-pointer" onclick="window.location='{{ route('bookings.manage.show', $booking->id) }}'">
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $booking->customer_name }}</div>
                                    <div class="text-sm text-gray-500">{{ $booking->customer_phone }}</div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $booking->vehicle->brand ?? 'N/A' }}</div>
                                    <div class="text-sm text-gray-500">{{ $booking->vehicle->no_plat ?? 'N/A' }}</div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $booking->rental_date ? $booking->rental_date->translatedFormat('d F Y') : 'N/A' }}</div>
                                    <div class="text-sm text-gray-500">{{ $booking->return_date ? $booking->return_date->translatedFormat('d F Y') : 'N/A' }}</div>
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
                                        $statusColor = $statusColors[$booking->payment_status] ?? 'bg-gray-100 text-gray-800';
                                        
                                        $statusTranslation = [
                                            'pending' => 'Menunggu Pembayaran',
                                            'expired' => 'Kedaluwarsa',
                                            'paid' => 'Dibayar',
                                            'confirmed' => 'Dikonfirmasi',
                                            'completed' => 'Selesai',
                                            'cancelled' => 'Dibatalkan',
                                        ];
                                        $statusText = $statusTranslation[$booking->payment_status] ?? ucfirst($booking->payment_status);
                                    @endphp
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColor }}">
                                        {{ $statusText }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-3 text-center text-sm text-gray-500">Tidak ada pemesanan terbaru</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Kendaraan Populer -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="flex justify-between items-center px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Kendaraan Populer</h2>
            <a href="{{ route('vehicles.manage.index') }}" class="text-sm text-blue-600 hover:underline">Lihat Semua</a>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kendaraan</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Plat Nomor</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga/Hari</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pemesanan</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($popularVehicles as $vehicle)
                            <tr class="hover:bg-gray-50 cursor-pointer" onclick="window.location='{{ route('vehicles.manage.edit', $vehicle->id) }}'">
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            @if($vehicle->image)
                                                <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $vehicle->image) }}" alt="{{ $vehicle->brand }}">
                                            @else
                                                <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                                    <i class="fas fa-car text-gray-500"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $vehicle->brand }}</div>
                                            <div class="text-sm text-gray-500">{{ $vehicle->type }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $vehicle->no_plat }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">Rp {{ number_format($vehicle->price, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ $vehicle->rentals_count }} pemesanan
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-3 text-center text-sm text-gray-500">Tidak ada kendaraan populer</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Aksi Cepat -->
<div class="mt-6 bg-white rounded-lg shadow-md overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-800">Aksi Cepat</h2>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('vehicles.manage.create') }}" class="flex flex-col items-center justify-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                <div class="p-3 rounded-full bg-blue-100 text-blue-500 mb-2">
                    <i class="fas fa-car-side text-xl"></i>
                </div>
                <span class="text-sm font-medium text-gray-700">Tambah Kendaraan</span>
            </a>
            
            <a href="{{ route('customers.manage.create') }}" class="flex flex-col items-center justify-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                <div class="p-3 rounded-full bg-green-100 text-green-500 mb-2">
                    <i class="fas fa-user-plus text-xl"></i>
                </div>
                <span class="text-sm font-medium text-gray-700">Tambah Pengguna</span>
            </a>
            
            <a href="{{ route('bookings.manage.create.user-selection') }}" class="flex flex-col items-center justify-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                <div class="p-3 rounded-full bg-purple-100 text-purple-500 mb-2">
                    <i class="fas fa-calendar-plus text-xl"></i>
                </div>
                <span class="text-sm font-medium text-gray-700">Buat Pemesanan</span>
            </a>
            
            <a href="{{ route('bookings.manage.index', ['status'=>'pending']) }}" class="flex flex-col items-center justify-center p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition-colors">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-500 mb-2">
                    <i class="fas fa-clock text-xl"></i>
                </div>
                <span class="text-sm font-medium text-gray-700">Pemesanan Tertunda</span>
            </a>
        </div>
    </div>
</div>
<script>
    // Grafik Pendapatan Bulanan
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(revenueCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_column($monthlyRevenue, 'month')) !!},
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: {!! json_encode(array_column($monthlyRevenue, 'revenue')) !!},
                backgroundColor: 'rgba(59, 130, 246, 0.5)',
                borderColor: 'rgba(59, 130, 246, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            label += 'Rp ' + context.raw.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                            return label;
                        }
                    }
                }
            }
        }
    });
    
    // Grafik Jenis Kendaraan
    const vehicleTypesCtx = document.getElementById('vehicleTypesChart').getContext('2d');
    const vehicleTypesChart = new Chart(vehicleTypesCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($vehicleTypes->pluck('type')->toArray()) !!},
            datasets: [{
                data: {!! json_encode($vehicleTypes->pluck('count')->toArray()) !!},
                backgroundColor: [
                    'rgba(59, 130, 246, 0.5)',
                    'rgba(16, 185, 129, 0.5)',
                    'rgba(245, 158, 11, 0.5)',
                    'rgba(239, 68, 68, 0.5)',
                    'rgba(139, 92, 246, 0.5)',
                    'rgba(236, 72, 153, 0.5)'
                ],
                borderColor: [
                    'rgba(59, 130, 246, 1)',
                    'rgba(16, 185, 129, 1)',
                    'rgba(245, 158, 11, 1)',
                    'rgba(239, 68, 68, 1)',
                    'rgba(139, 92, 246, 1)',
                    'rgba(236, 72, 153, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.raw;
                            const percentage = {!! json_encode($vehicleTypes->pluck('percentage')->toArray()) !!}[context.dataIndex];
                            return `${label}: ${value} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
</script>
@endsection