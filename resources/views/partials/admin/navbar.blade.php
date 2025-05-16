<header class="bg-white shadow-sm z-10">
    <div class="flex items-center justify-between h-16 px-6">
        <div class="flex items-center">
            <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 focus:outline-none md:hidden">
                <i class="fas fa-bars"></i>
            </button>
            <h1 class="ml-4 text-xl font-semibold text-gray-800">{{ $title ?? 'Dasbor' }}</h1>
        </div>
        
        <div class="flex items-center">
            <div class="relative" x-data="{ notificationsOpen: false, notifications: [], unreadCount: {{ Auth::user()->unreadNotificationsCount() }} }">
                <button @click="notificationsOpen = !notificationsOpen" class="p-2 text-gray-500 rounded-full hover:bg-gray-100 focus:outline-none relative">
                    <i class="fas fa-bell"></i>
                    <span x-show="unreadCount > 0" class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
                </button>
                <div x-show="notificationsOpen" @click.away="notificationsOpen = false" 
                     class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg py-2 z-20" style="display: none;">
                    <div class="px-4 py-2 border-b flex justify-between items-center">
                        <p class="text-sm font-medium text-gray-700">Notifikasi</p>
                        <template x-if="unreadCount > 0">
                            <a href="{{ route('notifications.mark-all-read') }}" 
                               class="text-xs text-blue-600 hover:text-blue-800">
                                Tandai semua dibaca
                            </a>
                        </template>
                    </div>
                    <div id="notification-list" class="max-h-64 overflow-y-auto">
                        @forelse(Auth::user()->notifications()->latest()->limit(5)->get() as $notification)
                            <a href="{{ route('notifications.mark-as-read', $notification) }}" 
                               class="flex px-4 py-3 hover:bg-gray-100 {{ $notification->isRead() ? 'opacity-75' : 'border-l-2 border-blue-500' }}">
                                <div class="flex-shrink-0">
                                    <i class="{{ $notification->getIconClass() }}"></i>
                                </div>
                                <div class="ml-3 flex-grow">
                                    <p class="text-sm font-medium text-gray-900">{{ $notification->title }}</p>
                                    <p class="text-xs text-gray-500">{{ $notification->created_at->locale('id')->diffForHumans() }}</p>
                                </div>
                                @if(!$notification->isRead())
                                    <div class="flex-shrink-0">
                                        <span class="inline-block w-2 h-2 bg-blue-500 rounded-full"></span>
                                    </div>
                                @endif
                            </a>
                        @empty
                            <div class="px-4 py-3 text-sm text-gray-500 text-center">
                                Belum ada notifikasi
                            </div>
                        @endforelse
                    </div>
                    <a href="{{ route('notifications.index') }}" class="block text-center text-sm font-medium text-blue-600 px-4 py-2 hover:underline">
                        Lihat semua notifikasi
                    </a>
                </div>
            </div>
            
            <div class="relative ml-4" x-data="{ profileOpen: false }">
                <button @click="profileOpen = !profileOpen" class="flex items-center focus:outline-none">
                    <div class="w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center text-gray-700">
                        <i class="fas fa-user"></i>
                    </div>
                    <span class="ml-2 text-sm font-medium text-gray-700 hidden md:block">{{ Auth::user()->name ?? 'Admin' }}</span>
                    <i class="fas fa-chevron-down ml-1 text-sm text-gray-400 hidden md:block"></i>
                </button>
                <div x-show="profileOpen" @click.away="profileOpen = false" 
                     class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-20" style="display: none;">
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-user mr-2"></i> Profil
                    </a>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-cog mr-2"></i> Pengaturan
                    </a>
                    <div class="border-t border-gray-100"></div>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form-2').submit();" 
                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-sign-out-alt mr-2"></i> Keluar
                    </a>
                    <form id="logout-form-2" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Pastikan Echo sudah diinisialisasi di app.js
        if (window.Echo) {
            // Mendengarkan channel publik untuk notifikasi admin
            window.Echo.channel('admin-notifications')
                .listen('.notification.created', (e) => {
                    console.log('Notifikasi baru diterima:', e);
                    
                    // Hanya proses notifikasi untuk pengguna yang sedang login
                    if (e.notification.user_id == {{ Auth::id() }}) {
                        // Update counter notifikasi
                        const notificationComponent = Alpine.store('notifications');
                        if (notificationComponent) {
                            notificationComponent.unreadCount++;
                        }
                        
                        // Tambahkan notifikasi baru ke daftar
                        addNewNotification(e.notification);
                    }
                });
                
            // Mendengarkan channel pribadi untuk notifikasi spesifik pengguna
            window.Echo.private('user.{{ Auth::id() }}')
                .listen('.notification.created', (e) => {
                    console.log('Notifikasi pribadi diterima:', e);
                    
                    // Update counter notifikasi
                    const notificationComponent = Alpine.store('notifications');
                    if (notificationComponent) {
                        notificationComponent.unreadCount++;
                    }
                    
                    // Tambahkan notifikasi baru ke daftar
                    addNewNotification(e.notification);
                });
        }
        
        // Fungsi untuk menambahkan notifikasi baru ke daftar
        function addNewNotification(notification) {
            const list = document.getElementById('notification-list');
            if (!list) return;
            
            // Hapus pesan "Belum ada notifikasi" jika ada
            const emptyMessage = list.querySelector('.text-center');
            if (emptyMessage) {
                emptyMessage.remove();
            }
            
            // Buat elemen notifikasi baru
            const notifHTML = `
                <a href="/notifications/${notification.id}/read" 
                   class="flex px-4 py-3 hover:bg-gray-100 border-l-2 border-blue-500">
                    <div class="flex-shrink-0">
                        <i class="${notification.icon_class}"></i>
                    </div>
                    <div class="ml-3 flex-grow">
                        <p class="text-sm font-medium text-gray-900">${notification.title}</p>
                        <p class="text-xs text-gray-500">Baru saja</p>
                    </div>
                    <div class="flex-shrink-0">
                        <span class="inline-block w-2 h-2 bg-blue-500 rounded-full"></span>
                    </div>
                </a>`;
                
            // Tambahkan ke awal daftar
            list.insertAdjacentHTML('afterbegin', notifHTML);
            
            // Batasi jumlah notifikasi yang ditampilkan (opsional)
            const items = list.querySelectorAll('a');
            if (items.length > 5) {
                items[items.length - 1].remove();
            }
            
            // Tampilkan notifikasi toast (opsional)
            showToast(notification.title, notification.message);
        }
        
        // Fungsi untuk menampilkan toast notification (opsional)
        function showToast(title, message) {
            // Implementasi toast notification
            // Contoh sederhana:
            const toast = document.createElement('div');
            toast.className = 'fixed top-4 right-4 bg-white shadow-lg rounded-lg p-4 z-50 animate-fade-in-down';
            toast.innerHTML = `
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-bell text-blue-500"></i>
                    </div>
                    <div class="ml-3">
                        <p class="font-medium">${title}</p>
                        <p class="text-sm text-gray-500">${message}</p>
                    </div>
                    <button class="ml-4 text-gray-400 hover:text-gray-500">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
            
            document.body.appendChild(toast);
            
            // Hapus toast setelah 5 detik
            setTimeout(() => {
                toast.classList.add('animate-fade-out');
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }, 5000);
            
            // Tambahkan event listener untuk tombol close
            toast.querySelector('button').addEventListener('click', () => {
                toast.remove();
            });
        }
    });
</script>
@endpush

<style>
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes fadeOut {
        from {
            opacity: 1;
        }
        to {
            opacity: 0;
        }
    }
    
    .animate-fade-in-down {
        animation: fadeInDown 0.3s ease-out;
    }
    
    .animate-fade-out {
        animation: fadeOut 0.3s ease-out;
    }
</style>
