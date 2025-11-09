<div>
    @if (session()->has('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <!-- Header with Create Button -->
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-2xl font-normal text-gray-900">Kelas</h1>
        <button wire:click="openModal" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium shadow-sm">
            + Buat Kelas
        </button>
    </div>

    <!-- Classes Grid - Google Classroom Style -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @forelse($classes as $class)
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden hover:shadow-md transition-shadow cursor-pointer group relative">
            <!-- Large Header Banner -->
            <div class="h-24 relative" 
                 style="background: {{ $class['coverImage'] ? 'url(' . $class['coverImage'] . ') center/cover' : 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)' }};">
                <div class="absolute inset-0 bg-black/20"></div>
                <!-- Delete Button -->
                <button wire:click="delete({{ $class['id'] }})" 
                        wire:confirm="Apakah Anda yakin ingin menghapus kelas ini? Tindakan ini tidak dapat dibatalkan."
                        class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity p-1.5 bg-red-500 hover:bg-red-600 text-white rounded shadow-lg" 
                        title="Hapus Kelas">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </button>
            </div>
            
            <!-- Class Info -->
            <div class="p-4">
                <h3 class="text-base font-medium text-gray-900 mb-1 line-clamp-2" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ $class['name'] }}</h3>
                <p class="text-sm text-gray-600 mb-2">{{ $class['code'] }}</p>
                <p class="text-xs text-gray-500 line-clamp-2 mb-3" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ Str::limit($class['desc'], 60) }}</p>
                
                <!-- Quick Stats -->
                <div class="flex items-center gap-3 text-xs text-gray-500 mb-3">
                    <span>{{ $class['students'] }} siswa</span>
                    <span>•</span>
                    <span>{{ $class['materials'] }} materi</span>
                </div>
                
                <!-- Enrollment Code (Collapsible) -->
                @if($class['enrollment_password'])
                <div class="mb-3 p-2 bg-gray-50 rounded text-xs">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-gray-600">Kode:</span>
                            @if($class['enrollment_enabled'])
                            <span class="px-1.5 py-0.5 bg-green-100 text-green-600 rounded text-xs">Aktif</span>
                            @else
                            <span class="px-1.5 py-0.5 bg-gray-100 text-gray-600 rounded text-xs">Nonaktif</span>
                            @endif
                    </div>
                    <code class="block px-2 py-1 bg-white border border-gray-200 rounded font-mono text-xs text-purple-600">{{ $class['enrollment_password'] }}</code>
                </div>
                @endif
                
                <!-- Actions -->
                <div class="flex gap-2 pt-3 border-t border-gray-100">
                    <a href="{{ route('dosen.detail-kelas', $class['id']) }}" 
                       class="flex-1 text-center px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded text-xs font-medium">
                        Buka
                    </a>
                    <button wire:click="edit({{ $class['id'] }})" 
                            class="px-3 py-1.5 text-gray-600 hover:bg-gray-100 rounded text-xs" title="Edit">
                        ⚙️
                    </button>
                    <button wire:click="openPasswordModal({{ $class['id'] }})" 
                            class="px-3 py-1.5 text-gray-600 hover:bg-gray-100 rounded text-xs" title="Kode Pendaftaran">
                        🔑
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12">
            <p class="text-gray-500">Belum ada kelas. Buat kelas pertama Anda!</p>
        </div>
        @endforelse
    </div>

    @if($showModal)
    <div class="fixed top-0 left-0 w-full h-full bg-black/50 z-[1000] flex items-center justify-center p-4">
        <div class="bg-white p-8 rounded-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold">{{ $editingId ? 'Edit Kelas' : 'Tambah Kelas Baru' }}</h2>
                <button wire:click="closeModal" class="text-2xl text-gray-500 hover:text-gray-800">✕</button>
            </div>
            <form wire:submit="save">
                <div class="mb-6">
                    <label class="block mb-2 font-semibold">Judul Kelas</label>
                    <input type="text" wire:model="title" required class="w-full p-3 border-2 border-gray-200 rounded-lg">
                    @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="mb-6">
                    <label class="block mb-2 font-semibold">Kode Kelas</label>
                    <input type="text" wire:model="code" required class="w-full p-3 border-2 border-gray-200 rounded-lg">
                    @error('code') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="mb-6">
                    <label class="block mb-2 font-semibold">Deskripsi</label>
                    <textarea wire:model="description" class="w-full p-3 border-2 border-gray-200 rounded-lg"></textarea>
                    @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="mb-6">
                    <label class="block mb-2 font-semibold">Semester</label>
                    <input type="text" wire:model="semester" required class="w-full p-3 border-2 border-gray-200 rounded-lg">
                    @error('semester') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="mb-6">
                    <label class="block mb-2 font-semibold">Status</label>
                    <select wire:model="status" class="w-full p-3 border-2 border-gray-200 rounded-lg">
                        <option value="active">Aktif</option>
                        <option value="inactive">Tidak Aktif</option>
                    </select>
                    @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="mb-6">
                    <label class="block mb-2 font-semibold">Kode Pendaftaran</label>
                    <div class="flex gap-2">
                        <input type="text" wire:model="enrollment_password" class="flex-1 p-3 border-2 border-gray-200 rounded-lg" placeholder="Kosongkan untuk generate otomatis">
                        <button type="button" wire:click="generatePassword" class="px-4 py-3 bg-purple-100 text-purple-600 rounded-lg font-semibold hover:bg-purple-200 transition-colors">
                            Generate
                        </button>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Biarkan kosong untuk generate otomatis saat membuat kelas</p>
                    @error('enrollment_password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="mb-6">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" wire:model="enrollment_enabled" class="w-5 h-5">
                        <span class="font-semibold">Aktifkan pendaftaran dengan kode</span>
                    </label>
                    <p class="text-xs text-gray-500 mt-1">Jika dinonaktifkan, mahasiswa tidak bisa mendaftar sendiri</p>
                </div>
                @if(!$editingId)
                <div class="mb-6">
                    <label class="block mb-2 font-semibold">Cover Image</label>
                    <input type="file" wire:model="cover_image" accept="image/*" class="w-full p-3 border-2 border-gray-200 rounded-lg">
                    @error('cover_image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                @endif
                <button type="submit" class="w-full p-3 bg-gradient-to-br from-purple-600 to-purple-800 text-white rounded-lg font-semibold">
                    {{ $editingId ? 'Update' : 'Tambah Kelas' }}
                </button>
            </form>
        </div>
    </div>
    @endif

    <!-- Password Management Modal -->
    @if($showPasswordModal)
    <div class="fixed top-0 left-0 w-full h-full bg-black/50 z-[1000] flex items-center justify-center p-4" wire:click="closePasswordModal">
        <div class="bg-white p-8 rounded-xl max-w-md w-full" wire:click.stop>
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold">Kelola Kode Pendaftaran</h2>
                <button wire:click="closePasswordModal" class="text-2xl text-gray-500 hover:text-gray-800">✕</button>
            </div>
            <form wire:submit.prevent="savePassword">
                <div class="mb-6">
                    <label class="block mb-2 font-semibold text-gray-900">Kode Pendaftaran *</label>
                    <div class="flex gap-2">
                        <input type="text" wire:model="enrollment_password" required class="flex-1 px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-purple-600 focus:outline-none font-mono" placeholder="Masukkan kode">
                        <button type="button" wire:click="generatePassword" class="px-4 py-3 bg-purple-100 text-purple-600 rounded-lg font-semibold hover:bg-purple-200 transition-colors">
                            Generate
                        </button>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Minimal 4 karakter, maksimal 20 karakter</p>
                    @error('enrollment_password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="mb-6">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" wire:model="enrollment_enabled" class="w-5 h-5">
                        <span class="font-semibold text-gray-900">Aktifkan pendaftaran dengan kode</span>
                    </label>
                    <p class="text-xs text-gray-500 mt-1 ml-7">Jika dinonaktifkan, mahasiswa tidak bisa mendaftar sendiri</p>
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="flex-1 px-6 py-3 bg-gradient-to-r from-purple-600 to-purple-800 text-white rounded-lg font-semibold hover:opacity-90 transition-opacity">
                        Simpan
                    </button>
                    <button type="button" wire:click="closePasswordModal" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg font-semibold hover:bg-gray-200 transition-colors">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>

