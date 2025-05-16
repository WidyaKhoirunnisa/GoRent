@extends('layouts.app')

@section('content')
<!-- About Us Hero Section -->
<section class="relative bg-gradient-to-r from-indigo-600 to-purple-700 py-20 overflow-hidden">
    <div class="absolute inset-0 opacity-20">
        <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%">
            <defs>
                <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                    <path d="M0 40L40 0M20 40L40 20M0 20L20 0" stroke="white" stroke-width="1" fill="none" />
                </pattern>
            </defs>
            <rect width="200%" height="100%" fill="url(#grid)" />
        </svg>
    </div>
    
    <div class="container mx-auto px-4 relative">
        <div class="max-w-3xl">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-6 leading-tight">
                Dimana Setiap Perjalanan Terasa Luar Biasa
            </h1>
            <p class="text-xl text-white/80 mb-8">
                Kami hadir untuk memberikan pengalaman berkendara terbaik dengan armada kendaraan berkualitas dan layanan pelanggan yang prima.
            </p>
        </div>
    </div>
    
    <div class="absolute bottom-0 right-0 w-full md:w-1/2 h-32 md:h-64 bg-white/10 backdrop-blur-sm rounded-tl-[100px] -z-0"></div>
</section>

<!-- Our Story Section -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row items-center gap-12">
            <div class="md:w-1/2">
                <img src="{{ asset('images/about/about_image.png')}}" alt="Our Story" class="rounded-lg shadow-xl w-full h-auto object-cover">
            </div>
            <div class="md:w-1/2">
                <h2 class="text-3xl font-bold mb-6 text-gray-800">Cerita Kami</h2>
                <p class="text-gray-700 mb-6 leading-relaxed">
                    Didirikan pada tahun 2010, GoRent bermula dari sebuah ide sederhana untuk menyediakan layanan rental mobil yang mudah, terjangkau, dan dapat diandalkan. Kami memulai dengan hanya 5 mobil dan sekarang telah berkembang menjadi salah satu penyedia layanan rental mobil terbesar di Indonesia dengan lebih dari 500 kendaraan.
                </p>
                <p class="text-gray-700 leading-relaxed">
                    Perjalanan kami tidak selalu mulus, tetapi komitmen kami untuk memberikan layanan terbaik tidak pernah berubah. Setiap tantangan yang kami hadapi telah membentuk kami menjadi perusahaan yang lebih kuat dan lebih baik dalam melayani pelanggan kami.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold mb-4 text-gray-800">Mengapa Memilih Kami</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Kami berkomitmen untuk memberikan pengalaman rental mobil terbaik dengan fokus pada kualitas, kenyamanan, dan kepuasan pelanggan.
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            <!-- Variety Brands Feature -->
            <div class="bg-white rounded-xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100">
                <div class="mb-6 bg-indigo-100 w-16 h-16 rounded-lg flex items-center justify-center hover:bg-indigo-600 transition-colors duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 text-indigo-600 hover:text-white transition-colors duration-300">
                        <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.5 2.8C1.4 11.3 1 12.1 1 13v3c0 .6.4 1 1 1h2"></path>
                        <circle cx="7" cy="17" r="2"></circle>
                        <circle cx="17" cy="17" r="2"></circle>
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-3 hover:text-indigo-600 transition-colors">Beragam Merek</h3>
                <p class="text-gray-600 mb-4">
                    Kami menyediakan berbagai pilihan merek mobil terkemuka untuk memenuhi kebutuhan dan preferensi Anda, dari ekonomis hingga premium.
                </p>
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h4 class="text-lg font-semibold mb-2">Kebebasan Maksimal</h4>
                    <p class="text-gray-600">
                        Nikmati kebebasan untuk memilih kendaraan yang sesuai dengan gaya dan kebutuhan Anda, tanpa kompromi pada kualitas dan kenyamanan.
                    </p>
                </div>
            </div>

            <!-- Awesome Support Feature -->
            <div class="bg-white rounded-xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100">
                <div class="mb-6 bg-indigo-100 w-16 h-16 rounded-lg flex items-center justify-center hover:bg-indigo-600 transition-colors duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 text-indigo-600 hover:text-white transition-colors duration-300">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-3 hover:text-indigo-600 transition-colors">Dukungan Luar Biasa</h3>
                <p class="text-gray-600 mb-4">
                    Tim dukungan pelanggan kami siap membantu Anda 24/7, memastikan pengalaman rental mobil Anda berjalan lancar dan tanpa masalah.
                </p>
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h4 class="text-lg font-semibold mb-2">Bantuan Darurat</h4>
                    <p class="text-gray-600">
                        Kami menyediakan layanan bantuan darurat 24 jam untuk memastikan Anda selalu mendapatkan bantuan kapan pun dan di mana pun Anda membutuhkannya.
                    </p>
                </div>
            </div>

            <!-- Flexibility Feature -->
            <div class="bg-white rounded-xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100">
                <div class="mb-6 bg-indigo-100 w-16 h-16 rounded-lg flex items-center justify-center hover:bg-indigo-600 transition-colors duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 text-indigo-600 hover:text-white transition-colors duration-300">
                        <path d="M12 2a10 10 0 1 0 10 10H12V2z"></path>
                        <path d="M20 12a8 8 0 1 0-16 0"></path>
                        <path d="M12 12v-8"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-3 hover:text-indigo-600 transition-colors">Fleksibilitas Bepergian</h3>
                <p class="text-gray-600 mb-4">
                    Kami menawarkan opsi pemesanan yang fleksibel, perpanjangan sewa yang mudah, dan lokasi pengambilan/pengembalian yang nyaman.
                </p>
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h4 class="text-lg font-semibold mb-2">Bebas Bepergian</h4>
                    <p class="text-gray-600">
                        Jelajahi destinasi Anda dengan bebas tanpa batasan jarak tempuh, dengan kendaraan yang nyaman dan andal.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold mb-4 text-gray-800">Tim Kami</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Kenali orang-orang hebat di balik layanan rental mobil terbaik kami.
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Team Member 1 -->
            <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300">
                <div class="h-64 bg-gray-200 overflow-hidden">
                    <img src="{{ asset('images/about/lebron.png') }}" alt="CEO" class="w-full h-full object-cover">
                </div>
                <div class="p-6 text-center">
                    <h3 class="text-xl font-bold mb-1 hover:text-indigo-600 transition-colors">Widya Khoirunnisa</h3>
                    <p class="text-indigo-600 mb-4">CEO & Founder</p>
                    <p class="text-gray-600 mb-4">
                        Memimpin visi perusahaan dengan lebih dari 15 tahun pengalaman di industri otomotif.
                    </p>
                    <div class="flex justify-center space-x-4">
                        <a href="#" class="text-gray-400 hover:text-indigo-600 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-linkedin" viewBox="0 0 16 16">
                                <path d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854V1.146zm4.943 12.248V6.169H2.542v7.225h2.401zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248-.822 0-1.359.54-1.359 1.248 0 .694.521 1.248 1.327 1.248h.016zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016a5.54 5.54 0 0 1 .016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225h2.4z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-indigo-600 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-twitter" viewBox="0 0 16 16">
                                <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Team Member 2 -->
            <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300">
                <div class="h-64 bg-gray-200 overflow-hidden">
                    <img src="{{ asset('images/about/lebron.png') }}" alt="COO" class="w-full h-full object-cover">
                </div>
                <div class="p-6 text-center">
                    <h3 class="text-xl font-bold mb-1 hover:text-indigo-600 transition-colors">Rizky Pratama</h3>
                    <p class="text-indigo-600 mb-4">COO</p>
                    <p class="text-gray-600 mb-4">
                        Mengawasi operasional harian dengan fokus pada efisiensi dan kepuasan pelanggan.
                    </p>
                    <div class="flex justify-center space-x-4">
                        <a href="#" class="text-gray-400 hover:text-indigo-600 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-linkedin" viewBox="0 0 16 16">
                                <path d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854V1.146zm4.943 12.248V6.169H2.542v7.225h2.401zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248-.822 0-1.359.54-1.359 1.248 0 .694.521 1.248 1.327 1.248h.016zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016a5.54 5.54 0 0 1 .016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225h2.4z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-indigo-600 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-twitter" viewBox="0 0 16 16">
                                <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Team Member 3 -->
            <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300">
                <div class="h-64 bg-gray-200 overflow-hidden">
                    <img src="{{ asset('images/about/lebron.png') }}" alt="CTO" class="w-full h-full object-cover">
                </div>
                <div class="p-6 text-center">
                    <h3 class="text-xl font-bold mb-1 hover:text-indigo-600 transition-colors">Yanuar AlHisyami</h3>
                    <p class="text-indigo-600 mb-4">CTO</p>
                    <p class="text-gray-600 mb-4">
                        Mengembangkan solusi teknologi untuk meningkatkan pengalaman pelanggan dan efisiensi operasional.
                    </p>
                    <div class="flex justify-center space-x-4">
                        <a href="#" class="text-gray-400 hover:text-indigo-600 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-linkedin" viewBox="0 0 16 16">
                                <path d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854V1.146zm4.943 12.248V6.169H2.542v7.225h2.401zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248-.822 0-1.359.54-1.359 1.248 0 .694.521 1.248 1.327 1.248h.016zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016a5.54 5.54 0 0 1 .016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225h2.4z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-indigo-600 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-twitter" viewBox="0 0 16 16">
                                <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Team Member 4 -->
            <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300">
                <div class="h-64 bg-gray-200 overflow-hidden">
                    <img src="{{ asset('images/about/lebron.png') }}" alt="CMO" class="w-full h-full object-cover">
                </div>
                <div class="p-6 text-center">
                    <h3 class="text-xl font-bold mb-1 hover:text-indigo-600 transition-colors">Rafi Prathama</h3>
                    <p class="text-indigo-600 mb-4">CMO</p>
                    <p class="text-gray-600 mb-4">
                        Mengembangkan strategi pemasaran inovatif untuk memperluas jangkauan dan meningkatkan brand awareness.
                    </p>
                    <div class="flex justify-center space-x-4">
                        <a href="#" class="text-gray-400 hover:text-indigo-600 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-linkedin" viewBox="0 0 16 16">
                                <path d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854V1.146zm4.943 12.248V6.169H2.542v7.225h2.401zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248-.822 0-1.359.54-1.359 1.248 0 .694.521 1.248 1.327 1.248h.016zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016a5.54 5.54 0 0 1 .016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225h2.4z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-indigo-600 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-twitter" viewBox="0 0 16 16">
                                <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-16 bg-gradient-to-r from-indigo-600 to-purple-700 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
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
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-white mb-4">Pencapaian Kami</h2>
            <p class="text-white/80 max-w-2xl mx-auto">
                Angka-angka yang menunjukkan komitmen kami dalam memberikan layanan terbaik.
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-8 border border-white/20 hover:bg-white/20 transition-colors duration-300">
                <div class="text-center">
                    <p class="text-4xl font-bold text-white mb-2">12+</p>
                    <p class="text-white/70">Tahun Pengalaman</p>
                </div>
            </div>
            
            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-8 border border-white/20 hover:bg-white/20 transition-colors duration-300">
                <div class="text-center">
                    <p class="text-4xl font-bold text-white mb-2">500+</p>
                    <p class="text-white/70">Kendaraan</p>
                </div>
            </div>
            
            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-8 border border-white/20 hover:bg-white/20 transition-colors duration-300">
                <div class="text-center">
                    <p class="text-4xl font-bold text-white mb-2">15k+</p>
                    <p class="text-white/70">Pelanggan Puas</p>
                </div>
            </div>
            
            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-8 border border-white/20 hover:bg-white/20 transition-colors duration-300">
                <div class="text-center">
                    <p class="text-4xl font-bold text-white mb-2">25+</p>
                    <p class="text-white/70">Kota Terlayani</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="bg-gradient-to-r from-indigo-600 to-purple-700 rounded-2xl overflow-hidden shadow-2xl">
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-2/3 p-8 md:p-12 lg:p-16">
                    <h2 class="text-3xl font-bold text-white mb-6">Siap Untuk Memulai Perjalanan Anda?</h2>
                    <p class="text-white/80 mb-8">
                        Hubungi kami sekarang untuk mendapatkan penawaran terbaik dan mulai menikmati pengalaman berkendara yang luar biasa.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ url('/vehicles') }}" class="px-8 py-3 bg-white text-indigo-700 rounded-lg font-semibold shadow-lg hover:bg-indigo-50 transition duration-300 text-center">
                            Lihat Armada Kami
                        </a>
                        <a href="{{ url('/contact') }}" class="px-8 py-3 bg-indigo-800 bg-opacity-50 text-white rounded-lg font-semibold border border-white/30 hover:bg-opacity-70 transition duration-300 text-center">
                            Hubungi Kami
                        </a>
                    </div>
                </div>
                <div class="md:w-1/3 relative">
                    <div class="absolute inset-0 bg-gradient-to-r from-indigo-600/50 to-transparent z-10"></div>
                    <img src="/placeholder.svg?height=400&width=300" alt="Car silhouette" class="w-full h-full object-cover" />
                </div>
            </div>
        </div>
    </div>
</section>
@endsection