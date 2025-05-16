@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-r from-indigo-600 to-purple-700 overflow-hidden">
    <div class="absolute inset-0 opacity-20">
        <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%">
            <defs>
                <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                    <path d="M0 40L40 0M20 40L40 20M0 20L20 0" stroke="white" stroke-width="1" fill="none" />
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#grid)" />
        </svg>
    </div>
    <div class="container mx-auto px-4 py-20 md:py-28 relative">
        <div class="max-w-3xl">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 leading-tight py-20">
                Perjalanan Nyaman dengan Mobil Pilihan Anda
            </h1>
            <p class="text-lg text-white/80 mb-8 max-w-xl">
                Nikmati pengalaman berkendara premium dengan armada mobil berkualitas dan layanan terbaik untuk setiap kebutuhan perjalanan Anda.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 mb-10">
                <a href="{{ url('/vehicles') }}" class="px-8 py-3 bg-white text-indigo-700 rounded-lg font-semibold shadow-lg hover:bg-indigo-50 transition duration-300 text-center">
                    Lihat Semua Mobil
                </a>
                <a href="{{ url('/booking') }}" class="px-8 py-3 bg-indigo-800 bg-opacity-50 text-white rounded-lg font-semibold border border-white/30 hover:bg-opacity-70 transition duration-300 text-center">
                    Pesan Sekarang
                </a>
            </div>
        </div>
    </div>
    <div class="absolute bottom-0 right-0 w-full md:w-1/2 h-32 md:h-64 bg-white/10 backdrop-blur-sm rounded-tl-[100px] -z-0"></div>
</section>

<!-- Features Section -->
<section class="container mx-auto px-4">
    <div class="text-center py-20">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Mengapa Memilih Kami?</h2>
        <p class="text-gray-600 max-w-2xl mx-auto">Kami menyediakan layanan rental mobil terbaik dengan fokus pada kenyamanan, ketersediaan, dan harga yang terjangkau.</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
        <!-- Availability Feature -->
        <div class="bg-white rounded-xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 group">
            <div class="mb-6 bg-indigo-100 w-16 h-16 rounded-lg flex items-center justify-center group-hover:bg-indigo-600 transition-colors duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 text-indigo-600 group-hover:text-white transition-colors duration-300">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
            </div>
            <h3 class="text-xl font-bold mb-3">Ketersediaan Armada</h3>
            <p class="text-gray-600">Kami menyediakan berbagai pilihan mobil yang siap disewa kapan saja sesuai kebutuhan Anda dengan proses pemesanan yang cepat dan mudah.</p>
        </div>

        <!-- Comfort Feature -->
        <div class="bg-white rounded-xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 group">
            <div class="mb-6 bg-indigo-100 w-16 h-16 rounded-lg flex items-center justify-center group-hover:bg-indigo-600 transition-colors duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 text-indigo-600 group-hover:text-white transition-colors duration-300">
                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                    <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                    <line x1="12" y1="22.08" x2="12" y2="12"></line>
                </svg>
            </div>
            <h3 class="text-xl font-bold mb-3">Kenyamanan Berkendara</h3>
            <p class="text-gray-600">Nikmati perjalanan yang nyaman dengan mobil yang bersih, terawat, dan berkualitas tinggi untuk pengalaman berkendara terbaik.</p>
        </div>

        <!-- Savings Feature -->
        <div class="bg-white rounded-xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 group">
            <div class="mb-6 bg-indigo-100 w-16 h-16 rounded-lg flex items-center justify-center group-hover:bg-indigo-600 transition-colors duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 text-indigo-600 group-hover:text-white transition-colors duration-300">
                    <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                    <line x1="2" y1="10" x2="22" y2="10"></line>
                </svg>
            </div>
            <h3 class="text-xl font-bold mb-3">Harga Terjangkau</h3>
            <p class="text-gray-600">Dapatkan layanan terbaik dengan harga sewa yang kompetitif dan sesuai anggaran Anda, tanpa biaya tersembunyi.</p>
        </div>
    </div>
</section>

<!-- Car Selection Section -->
<section class="container mx-auto px-4 py-20 bg-gray-50">
    <div class="flex flex-col md:flex-row justify-between items-center mb-12 py-20">
        <div>
            <h2 class="text-3xl md:text-4xl font-bold mb-3">Pilih Mobil Sesuai Kebutuhan</h2>
            <p class="text-gray-600 max-w-xl">Temukan mobil yang sempurna untuk setiap perjalanan Anda dengan berbagai pilihan yang kami sediakan.</p>
        </div>
        <a href="{{ url('/vehicles') }}" class="mt-4 md:mt-0 flex items-center text-indigo-600 font-semibold hover:text-indigo-800 transition-colors group">
            Lihat Semua
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform">
                <path d="M5 12h14"></path>
                <path d="m12 5 7 7-7 7"></path>
            </svg>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-10">
        @foreach($randomVehicles as $suitsVehicle)
        <!-- Car Card -->
        <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 group">
            <div class="bg-white-100 p-6 flex items-center justify-center h-56 overflow-hidden">
                @if($suitsVehicle->image)
                    <img src="{{ asset('storage/vehicles/' . basename($suitsVehicle->image)) }}" 
                         alt="{{ $suitsVehicle->brand }}" 
                         class="h-40 object-contain group-hover:scale-110 transition-transform duration-500">
                @else
                    <img src="{{ asset('images/placeholder.svg') }}" 
                         alt="No Image" 
                         class="h-40 object-contain opacity-50 group-hover:scale-110 transition-transform duration-500">
                @endif
            </div>
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <div class="w-1/2 truncate">
                        <h3 class="text-xl font-bold truncate">{{ $suitsVehicle->brand }}</h3>
                        <p class="text-gray-500">{{ $suitsVehicle->type }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-2xl font-bold text-indigo-600">Rp {{ number_format($suitsVehicle->price, 0, ',', '.') }}</p>
                        <p class="text-sm text-gray-500">per hari</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-3 gap-2 mb-6">
                    <div class="flex flex-col items-center bg-gray-50 rounded-lg p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-indigo-500 mb-1">
                            <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.5 2.8C1.4 11.3 1 12.1 1 13v3c0 .6.4 1 1 1h2"></path>
                            <circle cx="7" cy="17" r="2"></circle>
                            <circle cx="17" cy="17" r="2"></circle>
                        </svg>
                        <span class="text-xs font-medium">{{ ucfirst($suitsVehicle->condition) }}</span>
                    </div>
                    
                    <div class="flex flex-col items-center bg-gray-50 rounded-lg p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-indigo-500 mb-1">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        <span class="text-xs font-medium">{{ $suitsVehicle->year }}</span>
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
                            <div class="w-3 h-3 rounded-full mr-1 border border-gray-300" style="background-color: {{ strtolower($suitsVehicle->color) }}"></div>
                            <span class="text-xs font-medium">{{ ucfirst($suitsVehicle->color) }}</span>
                        </div>
                    </div>
                </div>
                
                <a href="{{ route('vehicles.details', $suitsVehicle->id) }}" class="block w-full py-3 text-center bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 transition-colors duration-300">Lihat Detail</a>
            </div>
        </div>
        @endforeach
    </div>
</section>

<!-- Facts Section -->
<section class="py-20 bg-gradient-to-br from-indigo-600 to-purple-700 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 py-20">
        <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="smallGrid" width="20" height="20" patternUnits="userSpaceOnUse">
                    <path d="M 20 0 L 0 0 0 20" fill="none" stroke="white" stroke-width="0.5" />
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#smallGrid)" />
        </svg>
    </div>
    
    <div class="container mx-auto px-4 relative">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Facts In Numbers</h2>
            <p class="text-white/80 max-w-2xl mx-auto">Kami telah melayani ribuan pelanggan dengan armada berkualitas selama bertahun-tahun, menjadikan kami pilihan terpercaya untuk kebutuhan rental mobil Anda.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-8 border border-white/20 hover:bg-white/20 transition-colors duration-300">
                <div class="bg-amber-500 p-4 rounded-xl inline-block mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 text-white">
                        <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.5 2.8C1.4 11.3 1 12.1 1 13v3c0 .6.4 1 1 1h2"></path>
                        <circle cx="7" cy="17" r="2"></circle>
                        <circle cx="17" cy="17" r="2"></circle>
                    </svg>
                </div>
                <p class="text-3xl font-bold text-white mb-1">540+</p>
                <p class="text-white/70">Mobil Tersedia</p>
            </div>

            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-8 border border-white/20 hover:bg-white/20 transition-colors duration-300">
                <div class="bg-amber-500 p-4 rounded-xl inline-block mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 text-white">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                </div>
                <p class="text-3xl font-bold text-white mb-1">20k+</p>
                <p class="text-white/70">Pelanggan Puas</p>
            </div>

            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-8 border border-white/20 hover:bg-white/20 transition-colors duration-300">
                <div class="bg-amber-500 p-4 rounded-xl inline-block mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 text-white">
                        <path d="M12 2a10 10 0 1 0 10 10H12V2z"></path>
                        <path d="M20 12a8 8 0 1 0-16 0"></path>
                        <path d="M12 12v-8"></path>
                    </svg>
                </div>
                <p class="text-3xl font-bold text-white mb-1">25+</p>
                <p class="text-white/70">Tahun Pengalaman</p>
            </div>

            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-8 border border-white/20 hover:bg-white/20 transition-colors duration-300">
                <div class="bg-amber-500 p-4 rounded-xl inline-block mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 text-white">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                </div>
                <p class="text-3xl font-bold text-white mb-1">200km+</p>
                <p class="text-white/70">Kilometer Ditempuh</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="bg-gradient-to-r from-indigo-600 to-purple-700 rounded-2xl overflow-hidden shadow-2xl">
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 p-8 md:p-12 lg:p-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">Nikmati Setiap Perjalanan dengan Kenyamanan Terbaik</h2>
                    <p class="text-white/80 mb-8">Temukan mobil yang sempurna untuk perjalanan Anda berikutnya. Cukup masukkan lokasi dan kami akan menunjukkan pilihan terbaik untuk Anda.</p>

                    <form class="flex flex-col sm:flex-row gap-3">
                        <input type="text" placeholder="Masukkan Kota" class="px-6 py-4 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-amber-500 shadow-lg" />
                        <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white px-6 py-4 rounded-lg font-semibold shadow-lg transition-colors duration-300 whitespace-nowrap">
                            Cari Mobil
                        </button>
                    </form>
                </div>
                <div class="md:w-1/2 relative">
                    <div class="absolute inset-0 bg-gradient-to-r from-indigo-600/50 to-transparent z-10"></div>
                    <img src="/placeholder.svg?height=400&width=600" alt="Car silhouette" class="w-full h-full object-cover" />
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="container mx-auto px-4 py-20">
    <div class="text-center mb-16">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Apa Kata Pelanggan Kami</h2>
        <p class="text-gray-600 max-w-2xl mx-auto">Dengarkan pengalaman pelanggan yang telah menggunakan layanan rental mobil kami.</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100">
            <div class="flex items-center mb-6">
                <div class="mr-4">
                    <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center">
                        <span class="text-indigo-600 font-bold">AS</span>
                    </div>
                </div>
                <div>
                    <h4 class="font-bold">Andi Suryadi</h4>
                    <div class="flex text-amber-400">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                        </svg>
                    </div>
                </div>
            </div>
            <p class="text-gray-600">"Pelayanan sangat memuaskan. Mobil bersih dan terawat dengan baik. Proses pemesanan juga sangat mudah dan cepat. Pasti akan kembali lagi!"</p>
        </div>
        
        <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100">
            <div class="flex items-center mb-6">
                <div class="mr-4">
                    <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center">
                        <span class="text-indigo-600 font-bold">DP</span>
                    </div>
                </div>
                <div>
                    <h4 class="font-bold">Dewi Pratiwi</h4>
                    <div class="flex text-amber-400">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-gray-300">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                        </svg>
                    </div>
                </div>
            </div>
            <p class="text-gray-600">"Harga sangat terjangkau untuk kualitas mobil yang diberikan. Customer service juga sangat responsif dan membantu. Recommended!"</p>
        </div>
        
        <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100">
            <div class="flex items-center mb-6">
                <div class="mr-4">
                    <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center">
                        <span class="text-indigo-600 font-bold">BW</span>
                    </div>
                </div>
                <div>
                    <h4 class="font-bold">Budi Wibowo</h4>
                    <div class="flex text-amber-400">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                        </svg>
                    </div>
                </div>
            </div>
            <p class="text-gray-600">"Sudah beberapa kali sewa mobil di sini dan selalu puas dengan pelayanannya. Mobil selalu dalam kondisi prima dan siap pakai. Terima kasih!"</p>
        </div>
    </div>
</section>
@endsection
