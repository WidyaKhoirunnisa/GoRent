@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-r from-indigo-600 to-purple-700 py-16 overflow-hidden">
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
                Hubungi Kami
            </h1>
            <p class="text-xl text-white/80">
                Kami siap membantu Anda dengan pertanyaan, saran, atau kebutuhan rental mobil Anda.
            </p>
        </div>
    </div>
</section>

<!-- Contact Info Cards -->
<section class="py-16 bg-white mt-20">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 -mt-24">
            <!-- Address -->
            <div class="bg-white rounded-xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 text-center">
                <div class="bg-indigo-600 p-4 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 text-white">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                    </svg>
                </div>
                <h2 class="text-xl font-bold mb-3 text-gray-800">Alamat</h2>
                <p class="text-gray-600">Kentingan Jl. Ir. Sutami No.36, Jebres, Surakarta</p>
                <a href="https://maps.google.com/?q=Kentingan Jl. Ir. Sutami No.36, Jebres, Surakarta" target="_blank" class="inline-block mt-4 text-indigo-600 hover:text-indigo-800 font-medium">Lihat di Peta</a>
            </div>

            <!-- Email -->
            <div class="bg-white rounded-xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 text-center">
                <div class="bg-indigo-600 p-4 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 text-white">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                </div>
                <h2 class="text-xl font-bold mb-3 text-gray-800">Email</h2>
                <p class="text-gray-600">melonpea12@gmail.com</p>
                <a href="mailto:melonpea12@gmail.com" class="inline-block mt-4 text-indigo-600 hover:text-indigo-800 font-medium">Kirim Email</a>
            </div>

            <!-- Phone -->
            <div class="bg-white rounded-xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 text-center">
                <div class="bg-indigo-600 p-4 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 text-white">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-bold mb-3 text-gray-800">Telepon</h2>
                <p class="text-gray-600">081999999999</p>
                <a href="tel:081999999999" class="inline-block mt-4 text-indigo-600 hover:text-indigo-800 font-medium">Hubungi Kami</a>
            </div>

            <!-- Opening Hours -->
            <div class="bg-white rounded-xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 text-center">
                <div class="bg-indigo-600 p-4 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 text-white">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                </div>
                <h2 class="text-xl font-bold mb-3 text-gray-800">Jam Operasional</h2>
                <p class="text-gray-600">Minggu-Senin: 10:00 - 22:00</p>
                <p class="inline-block mt-4 text-indigo-600 font-medium">Buka Sekarang</p>
            </div>
        </div>
    </div>
</section>

<!-- Contact Form and Map Section -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold mb-4 text-gray-800">Kirim Pesan</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Ada pertanyaan atau permintaan khusus? Jangan ragu untuk menghubungi kami. Tim kami siap membantu Anda.
            </p>
        </div>
        
        <div class="flex flex-col lg:flex-row gap-12">
            <!-- Contact Form -->
            <div class="lg:w-1/2">
                <div class="bg-white rounded-xl p-8 shadow-lg">
                    <form action="" method="POST">
                        @csrf
                        <div class="mb-6">
                            <x-input-label for="name" >Nama Lengkap</x-input-label>
                            <input type="text" id="name" name="name" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                        </div>
                        
                        <div class="mb-6">
                            <x-input-label for="email" >Email</x-input-label>
                            <input type="email" id="email" name="email" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                        </div>
                        
                        <div class="mb-6">
                            <x-input-label for="phone" >Nomor Telepon</x-input-label>
                            <input type="tel" id="phone" name="phone" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                        </div>
                        
                        <div class="mb-6">
                            <x-input-label for="subject" >Subjek</x-input-label>
                            <input type="text" id="subject" name="subject" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                        </div>
                        
                        <div class="mb-6">
                            <x-input-label for="message" >Pesan</x-input-label>
                            <textarea id="message" name="message" rows="5" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" required></textarea>
                        </div>
                        
                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-3 px-4 rounded-md transition duration-300">
                            Kirim Pesan
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Map -->
            <div class="lg:w-1/2">
                <div class="bg-white rounded-xl p-4 shadow-lg h-full">
                    <div class="rounded-lg overflow-hidden h-full">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3955.1523256849357!2d110.85481491477673!3d-7.559465994551843!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a16fdf072a90f%3A0xea50b255b0e6ce3e!2sUniversitas%20Sebelas%20Maret!5e0!3m2!1sid!2sid!4v1651234567890!5m2!1sid!2sid" 
                            width="100%" 
                            height="100%" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold mb-4 text-gray-800">Pertanyaan yang Sering Diajukan</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Temukan jawaban untuk pertanyaan umum tentang layanan rental mobil kami.
            </p>
        </div>
        
        <div class="max-w-3xl mx-auto">
            <div class="space-y-6">
                <!-- FAQ Item 1 -->
                <div class="bg-gray-50 rounded-xl p-6 hover:shadow-md transition-all duration-300">
                    <h3 class="text-xl font-bold mb-3 text-gray-800">Bagaimana cara memesan mobil?</h3>
                    <p class="text-gray-600">
                        Anda dapat memesan mobil melalui website kami, menghubungi kami melalui telepon, atau mengunjungi kantor kami secara langsung. Kami akan membantu Anda memilih mobil yang sesuai dengan kebutuhan Anda.
                    </p>
                </div>
                
                <!-- FAQ Item 2 -->
                <div class="bg-gray-50 rounded-xl p-6 hover:shadow-md transition-all duration-300">
                    <h3 class="text-xl font-bold mb-3 text-gray-800">Apa saja dokumen yang diperlukan untuk menyewa mobil?</h3>
                    <p class="text-gray-600">
                        Untuk menyewa mobil, Anda perlu menyediakan KTP, SIM yang masih berlaku, dan deposit sesuai dengan jenis mobil yang disewa. Untuk perusahaan, diperlukan juga dokumen perusahaan yang relevan.
                    </p>
                </div>
                
                <!-- FAQ Item 3 -->
                <div class="bg-gray-50 rounded-xl p-6 hover:shadow-md transition-all duration-300">
                    <h3 class="text-xl font-bold mb-3 text-gray-800">Apakah ada biaya tambahan yang perlu saya ketahui?</h3>
                    <p class="text-gray-600">
                        Harga sewa sudah termasuk asuransi dasar. Biaya tambahan mungkin berlaku untuk pengemudi tambahan, kursi anak, GPS, atau penggunaan di luar batas kilometer yang ditentukan. Semua biaya akan dijelaskan sebelum Anda menyelesaikan pemesanan.
                    </p>
                </div>
                
                <!-- FAQ Item 4 -->
                <div class="bg-gray-50 rounded-xl p-6 hover:shadow-md transition-all duration-300">
                    <h3 class="text-xl font-bold mb-3 text-gray-800">Bagaimana kebijakan pembatalan?</h3>
                    <p class="text-gray-600">
                        Pembatalan gratis hingga 48 jam sebelum waktu pengambilan. Pembatalan dalam 24-48 jam dikenakan biaya 50% dari total sewa. Pembatalan kurang dari 24 jam atau tidak hadir dikenakan biaya penuh.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
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
        <div class="max-w-3xl mx-auto text-center">
            <h2 class="text-3xl font-bold text-white mb-6">Siap Untuk Memulai Perjalanan Anda?</h2>
            <p class="text-white/80 mb-8">
                Hubungi kami sekarang untuk mendapatkan penawaran terbaik dan mulai menikmati pengalaman berkendara yang luar biasa.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ url('/vehicles') }}" class="px-8 py-3 bg-white text-indigo-700 rounded-lg font-semibold shadow-lg hover:bg-indigo-50 transition duration-300 text-center">
                    Lihat Armada Kami
                </a>
                <a href="{{ url('/booking') }}" class="px-8 py-3 bg-indigo-800 bg-opacity-50 text-white rounded-lg font-semibold border border-white/30 hover:bg-opacity-70 transition duration-300 text-center">
                    Pesan Sekarang
                </a>
            </div>
        </div>
    </div>
</section>
@endsection