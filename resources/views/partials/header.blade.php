<header x-data="{ mobileMenuOpen: false, profileOpen: false, scrolled: false }"
    class="py-4">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center">
            <!-- Logo -->
            <div class="flex items-center z-10">
                <a href="{{ route('home') }}" class="flex items-center group">
                    <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 p-2.5 rounded-lg mr-3 shadow-md group-hover:shadow-indigo-500/30 transition-all duration-300 group-hover:scale-105">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6">
                            <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.5 2.8C1.4 11.3 1 12.1 1 13v3c0 .6.4 1 1 1h2"></path>
                            <circle cx="7" cy="17" r="2"></circle>
                            <circle cx="17" cy="17" r="2"></circle>
                        </svg>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-bold text-xl text-gray-900 group-hover:text-indigo-600 transition-colors">GoRent</span>
                        <span class="text-xs text-gray-500 -mt-1">Rental Mobil Terpercaya</span>
                    </div>
                </a>
            </div>

            <!-- Navigation Links (Centered) -->
            @if(!Route::is('login') && !Route::is('register'))
            <nav class="hidden lg:flex items-center justify-center space-x-1 absolute left-1/2 transform -translate-x-1/2">
                @php
                $navItems = [
                ['route' => 'home', 'label' => 'Beranda'],
                ['route' => 'vehicles', 'label' => 'Daftar Kendaraan'],
                ['route' => 'about', 'label' => 'Tentang Kami'],
                ['route' => 'contact', 'label' => 'Hubungi Kami'],
                ];

                if (Auth::check() && Auth::user()->role == 'customer') {
                array_splice($navItems, 3, 0, [['route' => 'booking.index', 'label' => 'Pemesanan']]);
                }
                @endphp

                @foreach($navItems as $item)
                <a href="{{ route($item['route']) }}"
                    class="relative px-4 py-2 font-medium rounded-full transition-all duration-300 group
                              {{ request()->routeIs($item['route']) 
                                 ? 'text-indigo-600 bg-indigo-50' 
                                 : 'text-gray-700 hover:text-indigo-600 hover:bg-gray-50' }}">
                    {{ $item['label'] }}
                    @if(request()->routeIs($item['route']))
                    <span class="absolute bottom-1 left-1/2 transform -translate-x-1/2 w-8 h-1 bg-indigo-600 rounded-full"></span>
                    @else
                    <span class="absolute bottom-1 left-1/2 transform -translate-x-1/2 w-0 h-1 bg-indigo-600 rounded-full group-hover:w-8 transition-all duration-300"></span>
                    @endif
                </a>
                @endforeach
            </nav>
            @endif

            <!-- Right Side -->
            <div class="flex items-center space-x-4 z-10">
                @if(Route::has('login') && Route::currentRouteName() == 'register')
                <a href="{{ route('login') }}" class="font-medium text-gray-700 hover:text-indigo-600 transition-colors">
                    Masuk
                </a>
                @elseif(Route::has('register') && Route::currentRouteName() == 'login')
                <a href="{{ route('register') }}" class="font-medium text-gray-700 hover:text-indigo-600 transition-colors">
                    Daftar
                </a>
                @else
                @Auth
                <!-- Profile Dropdown -->
                <div class="relative">
                    <button @click="profileOpen = !profileOpen" @click.away="profileOpen = false" class="flex items-center space-x-2 focus:outline-none group">
                        <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center border-2 border-white shadow-sm overflow-hidden group-hover:border-indigo-200 transition-all">
                            <img
                                src="{{ Auth::user()->customer && Auth::user()->customer->image 
                                ? asset('storage/' . Auth::user()->customer->image) 
                                : asset('images/avatar/default-avatar.png') }}"
                                alt="Foto Profil" class="w-full h-full object-cover">
                        </div>
                        <div class="hidden md:block">
                            <div class="flex items-center">
                                <span class="font-medium text-gray-800 group-hover:text-indigo-600 transition-colors">{{ Auth::user()->customer->name }}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 group-hover:text-indigo-600 transition-colors ml-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </button>

                    <div x-show="profileOpen"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        class="absolute right-0 mt-3 w-64 bg-white rounded-xl shadow-xl py-2 z-50 border border-gray-100"
                        style="display: none;">
                        <div class="px-4 py-3 border-b border-gray-100">
                            <p class="text-sm text-gray-500">Masuk sebagai</p>
                            <p class="font-medium text-gray-900">{{ Auth::user()->customer->name }}</p>
                            <p class="text-sm text-gray-500 truncate">{{ Auth::user()->email }}</p>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Pengaturan Akun
                        </a>
                        <a href="{{ route('customer.history') }}" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Riwayat Pesanan
                        </a>
                        <div class="border-t border-gray-100 my-1"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex items-center w-full text-left px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>

                @else
                <div class="hidden md:flex space-x-3">
                    <a href="{{ route('login') }}" class="font-medium text-gray-700 hover:text-indigo-600 px-4 py-2 rounded-full hover:bg-gray-50 transition-all">Masuk</a>
                    <a href="{{ route('register') }}" class="font-medium bg-indigo-600 text-white px-5 py-2 rounded-full hover:bg-indigo-700 shadow-md hover:shadow-indigo-500/30 transition-all">Daftar</a>
                </div>
                @endAuth

                <!-- Mobile menu button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden flex items-center p-1 rounded-md text-gray-700 hover:text-indigo-600 hover:bg-gray-50 focus:outline-none transition-colors">
                    <svg x-show="!mobileMenuOpen" xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="mobileMenuOpen" xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                @endif
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div x-show="mobileMenuOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-10"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-10"
        class="lg:hidden fixed inset-0 z-40 pt-20"
        style="display: none;">

        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black/20 backdrop-blur-sm" @click="mobileMenuOpen = false"></div>

        <!-- Menu content -->
        <div class="relative bg-white border-t border-gray-100 shadow-xl px-4 py-6 overflow-y-auto max-h-[calc(100vh-5rem)]">
            <nav class="grid gap-y-4">
                <a href="{{ route('home') }}"
                    @click="mobileMenuOpen = false"
                    class="flex items-center px-4 py-3 rounded-xl {{ request()->routeIs('home') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 {{ request()->routeIs('home') ? 'text-indigo-600' : 'text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span class="font-medium">Beranda</span>
                </a>

                <a href="{{ route('vehicles') }}"
                    @click="mobileMenuOpen = false"
                    class="flex items-center px-4 py-3 rounded-xl {{ request()->routeIs('vehicles') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 {{ request()->routeIs('vehicles') ? 'text-indigo-600' : 'text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                    </svg>
                    <span class="font-medium">Daftar Kendaraan</span>
                </a>

                <a href="{{ route('about') }}"
                    @click="mobileMenuOpen = false"
                    class="flex items-center px-4 py-3 rounded-xl {{ request()->routeIs('about') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 {{ request()->routeIs('about') ? 'text-indigo-600' : 'text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="font-medium">Tentang Kami</span>
                </a>

                @if (Auth::check() && Auth::user()->role == 'customer')
                <a href="{{ route('booking.index') }}"
                    @click="mobileMenuOpen = false"
                    class="flex items-center px-4 py-3 rounded-xl {{ request()->routeIs('booking.index') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 {{ request()->routeIs('booking.index') ? 'text-indigo-600' : 'text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="font-medium">Pemesanan</span>
                </a>
                @endif

                <a href="{{ route('contact') }}"
                    @click="mobileMenuOpen = false"
                    class="flex items-center px-4 py-3 rounded-xl {{ request()->routeIs('contact') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 {{ request()->routeIs('contact') ? 'text-indigo-600' : 'text-gray-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <span class="font-medium">Hubungi Kami</span>
                </a>
            </nav>

            @guest
            <div class="mt-8 grid grid-cols-2 gap-4 px-4">
                <a href="{{ route('login') }}" class="font-medium text-center text-gray-700 hover:text-indigo-600 px-4 py-3 rounded-xl border border-gray-200 hover:border-indigo-600 transition-all">
                    Masuk
                </a>
                <a href="{{ route('register') }}" class="font-medium text-center bg-indigo-600 text-white px-4 py-3 rounded-xl hover:bg-indigo-700 shadow-md hover:shadow-indigo-500/30 transition-all">
                    Daftar
                </a>
            </div>
            @endguest
        </div>
    </div>

    @if(isset($pageTitle))
    <div class="container mx-auto px-4 mt-4 border-b border-gray-200 pb-4">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $pageTitle }}
        </h2>
    </div>
    @endif
</header>