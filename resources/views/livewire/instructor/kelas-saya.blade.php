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
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-all group relative flex flex-col h-full">
            {{-- Header / Cover Image --}}
            <div class="h-32 relative overflow-hidden" 
                 style="background: {{ $class['coverImage'] ? 'url(' . $class['coverImage'] . ') center/cover' : 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)' }};">
                <div class="absolute inset-0 bg-black/10 group-hover:bg-black/20 transition-colors"></div>
                
                {{-- Delete Button (Top Right) --}}
                <button wire:click="delete({{ $class['id'] }})" 
                        wire:confirm="Apakah Anda yakin ingin menghapus kelas ini? Tindakan ini tidak dapat dibatalkan."
                        class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition-all p-1.5 bg-white/90 text-red-600 hover:text-red-700 rounded-lg shadow-sm" 
                        title="Hapus Kelas">
                    <x-heroicon-s-trash class="w-4 h-4" />
                </button>
            </div>
            
            {{-- Body --}}
            <div class="p-5 flex-1 flex flex-col">
                <h3 class="text-lg font-bold text-gray-900 mb-1 line-clamp-2 leading-tight" title="{{ $class['name'] }}">
                    {{ $class['name'] }}
                </h3>
                <p class="text-sm text-gray-500 mb-4">{{ $class['code'] }}</p>
                
                {{-- Instructor Stats --}}
                <div class="grid grid-cols-2 gap-2 mb-4 text-xs text-gray-500">
                    <div class="flex items-center gap-1.5 bg-gray-50 p-2 rounded-lg">
                        <x-heroicon-s-users class="w-3.5 h-3.5 text-blue-500" />
                        <span>{{ $class['students'] }} Siswa</span>
                    </div>
                    <div class="flex items-center gap-1.5 bg-gray-50 p-2 rounded-lg">
                        <x-heroicon-s-document-text class="w-3.5 h-3.5 text-purple-500" />
                        <span>{{ $class['materials'] }} Materi</span>
                    </div>
                </div>

                {{-- Enrollment Code --}}
                @if($class['enrollment_password'])
                <div class="mb-4 p-2 bg-purple-50 rounded-lg border border-purple-100 flex justify-between items-center group/code cursor-help" title="Kode Pendaftaran">
                    <div class="flex items-center gap-1.5">
                        <x-heroicon-s-key class="w-3.5 h-3.5 text-purple-500" />
                        <span class="text-xs font-semibold text-purple-700">{{ $class['enrollment_password'] }}</span>
                    </div>
                    @if($class['enrollment_enabled'])
                        <div class="w-2 h-2 rounded-full bg-green-500" title="Aktif"></div>
                    @else
                        <div class="w-2 h-2 rounded-full bg-gray-300" title="Nonaktif"></div>
                    @endif
                </div>
                @endif
                
                <div class="mt-auto pt-4 border-t border-gray-50 flex gap-2">
                    <a href="{{ route('dosen.detail-kelas', $class['id']) }}" wire:navigate
                       class="flex-1 flex items-center justify-center gap-1.5 px-3 py-2 bg-indigo-50 text-indigo-700 hover:bg-indigo-100 rounded-lg text-sm font-semibold transition-colors">
                        Buka
                    </a>
                    <button wire:click="edit({{ $class['id'] }})" 
                            class="flex items-center justify-center gap-1.5 px-3 py-2 bg-gray-50 text-gray-600 hover:bg-gray-100 rounded-lg text-sm font-semibold transition-colors"
                            title="Edit">
                        <x-heroicon-s-cog-6-tooth class="w-4 h-4" />
                    </button>
                    <button wire:click="openPasswordModal({{ $class['id'] }})" 
                            class="flex items-center justify-center gap-1.5 px-3 py-2 bg-gray-50 text-gray-600 hover:bg-gray-100 rounded-lg text-sm font-semibold transition-colors"
                            title="Kode Pendaftaran">
                        <x-heroicon-s-key class="w-4 h-4" />
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
    <div class="fixed top-0 left-0 w-full h-full bg-black/50 z-1000 flex items-center justify-center p-4">
        <div class="bg-white p-8 rounded-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold">{{ $editingId ? 'Edit Kelas' : 'Tambah Kelas Baru' }}</h2>
                <button wire:click="closeModal" class="text-gray-500 hover:text-gray-800">
                    <x-heroicon-s-x-mark class="w-6 h-6" />
                </button>
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
                <button type="submit" class="w-full p-3 bg-linear-to-br from-purple-600 to-purple-800 text-white rounded-lg font-semibold">
                    {{ $editingId ? 'Update' : 'Tambah Kelas' }}
                </button>
            </form>
        </div>
    </div>
    @endif

    <!-- Password Management Modal -->
    @if($showPasswordModal)
    <div class="fixed top-0 left-0 w-full h-full bg-black/50 z-1000 flex items-center justify-center p-4" wire:click="closePasswordModal">
        <div class="bg-white p-8 rounded-xl max-w-md w-full" wire:click.stop>
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold">Kelola Kode Pendaftaran</h2>
                <button wire:click="closePasswordModal" class="text-gray-500 hover:text-gray-800">
                    <x-heroicon-s-x-mark class="w-6 h-6" />
                </button>
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
                    <button type="submit" class="flex-1 px-6 py-3 bg-linear-to-r from-purple-600 to-purple-800 text-white rounded-lg font-semibold hover:opacity-90 transition-opacity">
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

