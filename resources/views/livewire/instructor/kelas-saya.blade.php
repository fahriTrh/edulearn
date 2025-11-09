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

    <div class="mb-6 flex justify-end">
        <button wire:click="openModal" class="p-3 bg-gradient-to-br from-purple-600 to-purple-800 text-white rounded-lg font-semibold">
            ➕ Tambah Kelas
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($classes as $class)
        <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-lg transition-all">
            <div class="p-6">
                <h3 class="text-xl font-bold mb-2">{{ $class['name'] }}</h3>
                <p class="text-sm text-gray-600 mb-2">{{ $class['code'] }}</p>
                <p class="text-sm text-gray-500 mb-4">{{ Str::limit($class['desc'], 100) }}</p>
                <div class="flex gap-2 mb-4">
                    <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs">{{ $class['materials'] }} Materi</span>
                    <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs">{{ $class['assignments'] }} Tugas</span>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('dosen.detail-kelas', $class['id']) }}" class="flex-1 text-center p-2 bg-indigo-600 text-white rounded-lg text-sm font-semibold">Detail</a>
                    <button wire:click="edit({{ $class['id'] }})" class="flex-1 p-2 bg-gray-600 text-white rounded-lg text-sm font-semibold">Edit</button>
                    <button wire:click="delete({{ $class['id'] }})" wire:confirm="Apakah Anda yakin?" class="flex-1 p-2 bg-red-600 text-white rounded-lg text-sm font-semibold">Hapus</button>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-3 text-center text-gray-500 p-8">Belum ada kelas</div>
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
</div>

