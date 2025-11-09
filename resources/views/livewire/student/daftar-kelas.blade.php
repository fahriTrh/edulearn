<div>
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Daftar Kelas</h1>
        <p class="text-gray-600">Daftar kelas baru dengan kode pendaftaran dari instruktur</p>
    </div>

    @if(session()->has('success'))
        <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if(session()->has('error'))
        <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <!-- Search Bar -->
    <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
        <div class="flex gap-4">
            <div class="flex-1">
                <input 
                    type="text" 
                    wire:model.live.debounce.300ms="search" 
                    placeholder="Cari kelas berdasarkan nama, kode, atau deskripsi..." 
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-purple-600 focus:outline-none"
                >
            </div>
        </div>
    </div>

    <!-- Available Classes Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($availableClasses as $class)
        <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-lg transition-all">
            <div class="h-40 bg-gradient-to-br from-indigo-600 to-purple-700 flex items-center justify-center text-5xl relative">
                @if($class['cover_image'])
                    <img src="{{ $class['cover_image'] }}" alt="{{ $class['title'] }}" class="w-full h-full object-cover">
                @else
                    📚
                @endif
                @if($class['is_full'])
                    <span class="absolute top-4 right-4 px-3 py-1 bg-red-500 text-white rounded-full text-xs font-semibold">
                        Penuh
                    </span>
                @endif
            </div>
            <div class="p-6">
                <span class="inline-block px-3 py-1 bg-indigo-100 text-indigo-600 rounded-full text-xs font-semibold mb-3">{{ $class['code'] }}</span>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $class['title'] }}</h3>
                <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ $class['description'] ?? 'Tidak ada deskripsi' }}</p>
                
                <div class="flex items-center gap-1 text-gray-600 text-sm mb-4">
                    <span>👨‍🏫</span>
                    <span>{{ $class['instructor_title'] ? $class['instructor_title'] . ' ' : '' }}{{ $class['instructor'] }}</span>
                </div>
                
                <div class="flex gap-4 text-sm text-gray-600 mb-4 pt-4 border-t border-gray-200">
                    <div class="flex items-center gap-1">
                        <span>👥</span> {{ $class['students_count'] }}/{{ $class['max_students'] }} Mahasiswa
                    </div>
                    <div class="flex items-center gap-1">
                        <span>📅</span> {{ $class['semester'] }}
                    </div>
                </div>
                
                @if($class['is_full'])
                    <button disabled class="w-full px-4 py-2 bg-gray-300 text-gray-600 rounded-lg font-semibold cursor-not-allowed">
                        Kelas Penuh
                    </button>
                @else
                    <button 
                        wire:click="joinClass({{ $class['id'] }}, '{{ $class['title'] }}')"
                        class="w-full px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-700 text-white rounded-lg font-semibold hover:shadow-lg transition-all"
                    >
                        Daftar Kelas
                    </button>
                @endif
            </div>
        </div>
        @empty
        <div class="col-span-full text-center bg-white p-16 rounded-xl shadow-sm">
            <div class="text-6xl mb-4">🔍</div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">
                @if($search)
                    Tidak ada kelas yang ditemukan
                @else
                    Tidak ada kelas yang tersedia
                @endif
            </h3>
            <p class="text-gray-600">
                @if($search)
                    Coba gunakan kata kunci lain untuk mencari kelas
                @else
                    Semua kelas yang tersedia sudah Anda ikuti atau belum ada kelas yang membuka pendaftaran
                @endif
            </p>
        </div>
        @endforelse
    </div>

    <!-- Join Class Modal -->
    @if($showJoinModal)
    <div class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4" wire:click="closeJoinModal">
        <div class="bg-white rounded-2xl max-w-md w-full p-6" wire:click.stop>
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Daftar Kelas</h2>
                <button wire:click="closeJoinModal" class="text-gray-400 hover:text-gray-600 text-2xl">✕</button>
            </div>

            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $selectedClassName }}</h3>
                <p class="text-sm text-gray-600">Masukkan kode pendaftaran yang diberikan oleh instruktur</p>
            </div>

            <form wire:submit.prevent="confirmJoin" class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Kode Pendaftaran *</label>
                    <input 
                        type="text" 
                        wire:model="enrollment_password" 
                        required 
                        autofocus
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-purple-600 focus:outline-none font-mono text-center text-lg tracking-wider"
                        placeholder="Masukkan kode"
                    >
                    @error('enrollment_password') 
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
                    @enderror
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="submit" class="flex-1 px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-700 text-white rounded-lg font-semibold hover:opacity-90 transition-opacity">
                        Daftar
                    </button>
                    <button type="button" wire:click="closeJoinModal" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg font-semibold hover:bg-gray-200 transition-colors">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
