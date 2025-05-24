<!-- resources/views/components/vehicle-grid.blade.php -->
@props([
    'vehicles', 
    'showPrice' => true,
    'showActions' => true,
    'showStatus' => true,
    'showRentalInfo' => false,
    'rentalDuration' => null,
    'rentalDate' => null,
    'returnDate' => null,
    'userId' => null,
    'isAdmin' => false,
    'emptyMessage' => 'Tidak ada kendaraan ditemukan.',
    'emptyDescription' => 'Silakan coba filter yang berbeda atau tambahkan kendaraan baru.',
    'actionRoute' => null,
    'customerView' => false // Tambahkan prop baru untuk tampilan customer
])

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    @forelse($vehicles as $vehicle)
    <div class="{{ $customerView ? 'bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 group border border-gray-100' : 'bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden' }}">
        <!-- Vehicle Image -->
        <div class="bg-white p-6 {{ $customerView ? 'flex items-center justify-center h-56 overflow-hidden' : 'mb-4 flex items-center justify-center h-48' }}">
            @if($vehicle->image)
            <img {{ $customerView ? 'loading="lazy"' : '' }} src="{{ asset('storage/' . $vehicle->image) }}" 
                 alt="{{ $vehicle->brand }}" 
                 class="{{ $customerView ? 'h-40 object-contain group-hover:scale-110 transition-transform duration-500' : 'max-h-full max-w-full object-contain' }}">
            @else
            <div class="flex flex-col items-center justify-center text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <p class="text-sm font-medium">Tidak Ada Gambar</p>
            </div>
            @endif
        </div>

        <div class="p-6">
            <!-- Vehicle Info Header -->
            <div class="flex justify-between items-center mb-4">
                <div class="{{ $customerView ? 'w-1/2 truncate' : '' }}">
                    <h3 class="{{ $customerView ? 'text-xl font-bold truncate' : 'text-xl font-semibold' }}">{{ $vehicle->brand }}</h3>
                    <p class="text-sm text-gray-500">{{ ucfirst($vehicle->type) }}</p>
                </div>
                @if($showPrice)
                <div class="text-right">
                    <p class="{{ $customerView ? 'text-2xl font-bold text-indigo-600' : 'text-lg font-bold text-indigo-600' }}">Rp {{ number_format($vehicle->price, 0, ',', '.') }}</p>
                    <p class="text-xs text-gray-500">per hari</p>
                </div>
                @endif
            </div>

            <!-- Vehicle Details -->
            @if($customerView)
            <div class="grid grid-cols-3 gap-2 mb-6">
                <div class="flex flex-col items-center bg-gray-50 rounded-lg p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-indigo-500 mb-1">
                        <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.5 2.8C1.4 11.3 1 12.1 1 13v3c0 .6.4 1 1 1h2"></path>
                        <circle cx="7" cy="17" r="2"></circle>
                        <circle cx="17" cy="17" r="2"></circle>
                    </svg>
                    <span class="text-xs font-medium">{{ ucfirst($vehicle->condition) }}</span>
                </div>
                
                <div class="flex flex-col items-center bg-gray-50 rounded-lg p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-indigo-500 mb-1">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                    <span class="text-xs font-medium">{{ $vehicle->year }}</span>
                </div>
                
                <div class="flex flex-col items-center bg-gray-50 rounded-lg p-2">
                    <div class="flex items-center mb-1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-indigo-500">
                            <circle cx="13.5" cy="6.5" r="4"></circle>
                            <circle cx="19" cy="17" r="2"></circle>
                            <circle cx="6" cy="17" r="2"></circle>
                            <path d="M16 14h-5a2 2 0 0 0-1.95 1.55L8 19h8l-1.05-3.45A2 2 0 0 0 13 14Z"></path>
                        </svg>
                    </div>
                    <div class="flex items-center">
                        <div class="w-3 h-3 rounded-full mr-1 border border-gray-300" style="background-color: {{ strtolower($vehicle->color) }}"></div>
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
                        <span class="text-xs font-medium">{{ $colorInIndonesian }}</span>
                    </div>
                </div>
            </div>
            @else
            <div class="flex justify-between mb-6">
                <div class="flex items-center text-sm text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 mr-1">
                        <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.5 2.8C1.4 11.3 1 12.1 1 13v3c0 .6.4 1 1 1h2"></path>
                        <circle cx="7" cy="17" r="2"></circle>
                        <circle cx="17" cy="17" r="2"></circle>
                    </svg>
                    {{ $vehicle->condition === 'Normal' ? 'Normal' : 'Servis' }}
                </div>

                <div class="flex items-center text-sm text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 mr-1">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                    {{ $vehicle->year }}
                </div>

                <div class="flex items-center text-sm text-gray-600">
                    <div class="w-3 h-3 rounded-full mr-1.5 border border-gray-300" style="background-color: {{ strtolower($vehicle->color) }};">
                    </div>
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
            </div>
            @endif

            <!-- Status Badges (Optional) -->
            @if($showStatus)
            <div class="mb-4">
                @if($vehicle->condition === 'Service')
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                    Tidak Tersedia
                </span>
                @else
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $vehicle->ready ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $vehicle->ready ? 'Tersedia' : 'Tidak Tersedia' }}
                </span>
                @endif

                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $vehicle->condition === 'Normal' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800' }} ml-2">
                    {{ $vehicle->condition }}
                </span>
            </div>
            @endif

            <!-- Rental Information (Optional) -->
            @if($showRentalInfo && $rentalDuration)
            <div class="bg-indigo-50 rounded-xl p-4 mb-4">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-600">Total untuk {{ $rentalDuration }} {{ Str('hari', $rentalDuration) }}:</p>
                        <p class="text-xl font-bold text-indigo-600">Rp {{ number_format($vehicle->price * $rentalDuration, 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-white rounded-full p-2 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-indigo-600">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                    </div>
                </div>
            </div>
            @endif

            <!-- Action Buttons (Optional) -->
            @if($showActions)
                <!-- Admin Actions -->
                @if(isset($isAdmin) && $isAdmin)
                    <div class="flex justify-between mt-4">
                        <a href="{{ route('vehicles.manage.edit', $vehicle->id) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded transition duration-200">
                            <i class="fas fa-edit mr-1"></i> Edit
                        </a>
                        <x-modal>
                            <x-slot name="trigger">
                                <button
                                    @click="open = true"
                                    class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition duration-200">
                                    <i class="fas fa-trash mr-1"></i> Hapus
                                </button>
                            </x-slot>

                            <h2 class="text-xl font-bold mb-4">Konfirmasi Penghapusan</h2>
                            <p class="mb-6">Apakah Anda yakin ingin menghapus Kendaraan ini? Tindakan ini tidak dapat dibatalkan.</p>
                            <div class="flex justify-end gap-4">
                                <button
                                    @click="open = false"
                                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded">
                                    Batal
                                </button>

                                <form action="{{ route('vehicles.manage.destroy', $vehicle->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </x-modal>
                    </div>
                <!-- Rental Actions -->
                @elseif($showRentalInfo && $rentalDate && $returnDate)
                    <form action="{{ $actionRoute ?? route('booking.book-vehicle', $vehicle->id) }}" method="GET">
                        <input type="hidden" name="rental_date" value="{{ $rentalDate }}">
                        <input type="hidden" name="return_date" value="{{ $returnDate }}">
                        @if($userId)
                        <input type="hidden" name="user_id" value="{{ $userId }}">
                        @endif
                        <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">
                        <button type="submit" class="w-full py-3 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 transition-colors shadow-md hover:shadow-indigo-500/30 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 mr-2">
                                <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Sewa Kendaraan Ini
                        </button>
                    </form>
                <!-- Customer View Action -->
                @elseif($customerView)
                    <a href="{{ route('vehicles.details', $vehicle->id) }}" class="block w-full py-3 text-center bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 transition-colors duration-300">Lihat Detail</a>
                <!-- Custom Action Slot -->
                @else
                    {{ $actions ?? '' }}
                @endif
            @endif
        </div>
    </div>
    @empty
    <div class="col-span-full {{ $customerView ? 'bg-white rounded-xl p-12 text-center shadow-md border border-gray-100' : 'bg-white rounded-lg shadow-md p-12 text-center' }}">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-yellow-100 rounded-full mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-10 h-10 text-yellow-600">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="12"></line>
                <line x1="12" y1="16" x2="12.01" y2="16"></line>
            </svg>
        </div>
        <h2 class="text-2xl font-bold text-gray-800 mb-3">{{ $emptyMessage }}</h2>
        <p class="text-gray-600 mb-8 max-w-md mx-auto">{{ $emptyDescription }}</p>
        
        @if($customerView)
        <a href="{{ route('vehicles', ['type' => 'all']) }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 transition-colors duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 mr-2">
                <polyline points="15 18 9 12 15 6"></polyline>
            </svg>
            Lihat Semua Kendaraan
        </a>
        @else
        {{ $emptyAction ?? '' }}
        @endif
    </div>
    @endforelse
</div>