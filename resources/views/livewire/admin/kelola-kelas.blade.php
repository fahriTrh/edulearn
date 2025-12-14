<div>
    @if (session()->has('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    {{-- Toolbar --}}
    <div class="bg-white p-6 rounded-xl mb-8 shadow-sm flex flex-col md:flex-row gap-4 flex-wrap items-center">
        <div class="relative flex-1 min-w-[250px]">
            <x-heroicon-s-magnifying-glass class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" />
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari judul kelas, kode, atau instruktur..." class="w-full p-3 pl-10 border-2 border-gray-200 rounded-lg outline-none focus:border-indigo-500">
        </div>
    </div>

    {{-- Classes Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($classes as $class)
        <div class="bg-white rounded-xl overflow-hidden shadow-sm transition-all hover:-translate-y-1 hover:shadow-lg flex flex-col h-full">
            <div class="h-40 bg-gray-200 relative overflow-hidden">
                @if($class->cover_image)
                    <img src="{{ asset($class->cover_image) }}" alt="{{ $class->title }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-linear-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-4xl">
                        <x-heroicon-s-academic-cap class="w-16 h-16 opacity-50" />
                    </div>
                @endif
                <div class="absolute top-4 right-4 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-xs font-bold text-gray-700">
                    {{ $class->code }}
                </div>
            </div>
            
            <div class="p-6 flex-1 flex flex-col">
                <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2">{{ $class->title }}</h3>
                
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold text-gray-600">
                        {{ strtoupper(substr($class->instructor->user->name ?? '?', 0, 2)) }}
                    </div>
                    <div class="text-sm text-gray-600 truncate">
                        {{ $class->instructor->user->name ?? 'Unknown Instructor' }}
                    </div>
                </div>
                
                <div class="mt-auto pt-4 border-t border-gray-100 flex justify-between items-center">
                    <div class="text-xs text-gray-500">
                        {{ $class->created_at->format('d M Y') }}
                    </div>
                    
                    <div class="flex gap-2">
                        <a href="{{ route('admin.detail-kelas', $class->id) }}" 
                           class="text-indigo-600 hover:text-indigo-800 font-semibold text-sm flex items-center gap-1 transition-colors">
                            <x-heroicon-s-eye class="w-4 h-4" />
                            Detail
                        </a>
                        <button wire:click="delete({{ $class->id }})" 
                                wire:confirm="Apakah Anda yakin ingin menghapus kelas ini? Semua materi dan tugas di dalamnya akan terhapus." 
                                class="text-red-500 hover:text-red-700 font-semibold text-sm flex items-center gap-1 transition-colors">
                            <x-heroicon-s-trash class="w-4 h-4" />
                            Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-3 p-12 text-center bg-white rounded-xl border-dashed border-2 border-gray-200">
            <x-heroicon-o-book-open class="w-16 h-16 text-gray-300 mx-auto mb-4" />
            <h3 class="text-lg font-medium text-gray-900">Tidak ada kelas ditemukan</h3>
            <p class="text-gray-500 mt-1">Coba kata kunci pencarian lain.</p>
        </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $classes->links() }}
    </div>
</div>
