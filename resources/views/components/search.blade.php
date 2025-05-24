{{-- resources/views/components/search.blade.php --}}

<div class="search-component {{ $classes }}">
    <form action="{{ route($route) }}" method="GET" class="search-form">
        <div class="relative">
            @if($icon)
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                </svg>
            </div>
            @endif
            
            <input 
                type="search" 
                name="{{ $param }}" 
                value="{{ request($param) }}"
                class="block w-full p-2 {{ $icon ? 'pl-10' : 'pl-4' }} text-sm text-gray-900 border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500" 
                placeholder="{{ $placeholder }}"
            >
            
            <button type="submit" class="absolute right-2 bottom-1.5 bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-1 text-white">
                Cari
            </button>
        </div>
        
        {{ $slot }}
    </form>
</div>

<style>
    .search-component {
        margin-bottom: 1rem;
    }
    
    .search-form {
        width: 100%;
    }
</style>