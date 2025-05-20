<div class="md:flex flex-col w-64 bg-gray-800 text-white fixed inset-y-0 z-10 transition duration-300 transform"
     :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen, 'md:translate-x-0': true}">
    <!-- Logo -->
    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-700">
        <div class="flex items-center">
            <span class="text-xl font-bold">GoRent Admin</span>
        </div>
        <button @click="sidebarOpen = false" class="md:hidden text-white">
            <i class="fas fa-times"></i>
        </button>
    </div>
    
    <!-- Navigation -->
    <nav class="flex-1 px-4 py-4 overflow-y-auto">
        <a href="{{ route('admin') }}" class="flex items-center px-4 py-3 text-white hover:bg-gray-700 rounded-lg mb-1 {{ request()->routeIs('admin') ? 'bg-gray-700' : '' }}">
            <i class="fas fa-tachometer-alt mr-3"></i>
            <span>Dashboard</span>
        </a>
        
        <!-- Kendaraan Section -->
        <div class="mt-4">
            <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Kendaraan</p>
        </div>
        <a href="{{ route('vehicles.manage.create') }}" class="flex items-center px-4 py-3 text-white hover:bg-gray-700 rounded-lg mb-1 {{ request()->routeIs('vehicles.manage.create') ? 'bg-gray-700' : '' }}">
            <i class="fas fa-plus-circle mr-3"></i>
            <span>Tambah Kendaraan Baru</span>
        </a>
        <a href="{{ route('vehicles.manage.index') }}" class="flex items-center px-4 py-3 text-white hover:bg-gray-700 rounded-lg mb-1 {{ request()->routeIs('vehicles.manage.index') ? 'bg-gray-700' : '' }}">
            <i class="fas fa-car-side mr-3"></i>
            <span>Lihat Semua Kendaraan</span>
        </a>
        
        <!-- Pengguna Section -->
        <div class="mt-4">
            <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Pengguna</p>
        </div>
        <a href="{{ route('customers.manage.index') }}" class="flex items-center px-4 py-3 text-white hover:bg-gray-700 rounded-lg mb-1 {{ request()->routeIs('customers.manage.index') ? 'bg-gray-700' : '' }}">
            <i class="fas fa-users mr-3"></i>
            <span>Semua Pengguna</span>
        </a>
        <a href="{{ route('customers.manage.create') }}" class="flex items-center px-4 py-3 text-white hover:bg-gray-700 rounded-lg mb-1 {{ request()->routeIs('customers.manage.create') ? 'bg-gray-700' : '' }}">
            <i class="fas fa-user-plus mr-3"></i>
            <span>Tambah Pengguna Baru</span>
        </a>
        
        <!-- Pemesanan Section -->
        <div class="mt-4">
            <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Pemesanan</p>
        </div>
        <a href="{{ route('bookings.manage.index') }}" class="flex items-center px-4 py-3 text-white hover:bg-gray-700 rounded-lg mb-1 {{ request()->routeIs('bookings.manage.index') ? 'bg-gray-700' : '' }}">
            <i class="fas fa-calendar-alt mr-3"></i>
            <span>Semua Pemesanan</span>
        </a>
        <a href="{{ route('bookings.manage.create.user-selection') }}" class="flex items-center px-4 py-3 text-white hover:bg-gray-700 rounded-lg mb-1 {{ request()->routeIs('bookings.manage.create.*') ? 'bg-gray-700' : '' }}">
            <i class="fas fa-plus-circle mr-3"></i>
            <span>Buat Pemesanan Baru</span>
        </a>
    </nav>
</div>
