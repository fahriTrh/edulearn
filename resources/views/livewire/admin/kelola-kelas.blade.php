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
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-all group relative flex flex-col h-full">
            {{-- Header / Cover Image --}}
            <div class="h-32 bg-gray-200 relative overflow-hidden">
                @if($class->cover_image)
                    <img src="{{ asset($class->cover_image) }}" alt="{{ $class->title }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-linear-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white">
                        <x-heroicon-s-academic-cap class="w-12 h-12 opacity-50" />
                    </div>
                @endif
                <div class="absolute top-3 right-3 bg-white/90 backdrop-blur px-2 py-1 rounded-lg text-xs font-bold text-gray-700 shadow-sm border border-gray-100">
                    {{ $class->code }}
                </div>
            </div>
            
            {{-- Body --}}
            <div class="p-5 flex-1 flex flex-col">
                <h3 class="text-lg font-bold text-gray-900 mb-1 line-clamp-2 leading-tight" title="{{ $class->title }}">
                    {{ $class->title }}
                </h3>
                
                {{-- Instructor Info --}}
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-6 h-6 rounded-full bg-gray-100 border border-gray-200 flex items-center justify-center text-[10px] font-bold text-gray-600 shrink-0">
                        {{ strtoupper(substr($class->instructor->user->name ?? '?', 0, 1)) }}
                    </div>
                    <div class="text-sm text-gray-500 truncate">
                        {{ $class->instructor->user->name ?? 'Unknown' }}
                    </div>
                </div>

                {{-- Admin Stats --}}
                <div class="grid grid-cols-2 gap-2 mb-4 text-xs text-gray-500">
                    <div class="flex items-center gap-1.5 bg-gray-50 p-2 rounded-lg">
                        <x-heroicon-s-users class="w-3.5 h-3.5 text-blue-500" />
                        <span>{{ $class->students_count ?? 0 }} Siswa</span>
                    </div>
                    <div class="flex items-center gap-1.5 bg-gray-50 p-2 rounded-lg">
                        <x-heroicon-s-calendar class="w-3.5 h-3.5 text-orange-500" />
                        <span>{{ $class->created_at->format('d M y') }}</span>
                    </div>
                </div>

                <div class="mt-auto pt-4 border-t border-gray-50 flex gap-2">
                    <a href="{{ route('admin.detail-kelas', $class->id) }}" 
                       class="flex-1 flex items-center justify-center gap-1.5 px-3 py-2 bg-indigo-50 text-indigo-700 hover:bg-indigo-100 rounded-lg text-sm font-semibold transition-colors">
                        <x-heroicon-s-eye class="w-4 h-4" />
                        Detail
                    </a>
                    <button wire:click="delete({{ $class->id }})" 
                            wire:confirm="Apakah Anda yakin ingin menghapus kelas ini? Semua materi dan tugas di dalamnya akan terhapus." 
                            class="flex items-center justify-center gap-1.5 px-3 py-2 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg text-sm font-semibold transition-colors"
                            title="Hapus Kelas">
                        <x-heroicon-s-trash class="w-4 h-4" />
                    </button>
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
