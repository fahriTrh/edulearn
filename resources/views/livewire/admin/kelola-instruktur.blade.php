<div x-data="{ showModal: @entangle('showModal') }">
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

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm p-6 text-center hover:-translate-y-1 hover:shadow-md transition-all">
            <div class="text-3xl font-bold text-indigo-600 mb-2">{{ $instructors->count() }}</div>
            <div class="text-gray-600 text-sm">Total Dosen</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 text-center hover:-translate-y-1 hover:shadow-md transition-all">
            <div class="text-3xl font-bold text-indigo-600 mb-2">{{ $instructors->where('status', 'active')->count() }}</div>
            <div class="text-gray-600 text-sm">Aktif</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 text-center hover:-translate-y-1 hover:shadow-md transition-all">
            <div class="text-3xl font-bold text-indigo-600 mb-2">{{ $instructors->sum('courses') }}</div>
            <div class="text-gray-600 text-sm">Total Kursus</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 text-center hover:-translate-y-1 hover:shadow-md transition-all">
            <div class="text-3xl font-bold text-indigo-600 mb-2">{{ number_format($instructors->avg('rating'), 1) }}</div>
            <div class="text-gray-600 text-sm">Rata-rata Rating</div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl mb-8 shadow-sm flex flex-col md:flex-row gap-4 flex-wrap items-center">
        <div class="relative flex-1 min-w-[250px]">
            <x-heroicon-s-magnifying-glass class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" />
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama atau keahlian..." class="w-full p-3 pl-10 border-2 border-gray-200 rounded-lg outline-none focus:border-indigo-500">
        </div>
        <select wire:model.live="statusFilter" class="w-full md:w-auto p-3 border-2 border-gray-200 rounded-lg outline-none cursor-pointer bg-white focus:border-indigo-500">
            <option value="all">Semua Status</option>
            <option value="active">Aktif</option>
            <option value="inactive">Tidak Aktif</option>
        </select>
        <select wire:model.live="specialtyFilter" class="w-full md:w-auto p-3 border-2 border-gray-200 rounded-lg outline-none cursor-pointer bg-white focus:border-indigo-500">
            <option value="all">Semua Keahlian</option>
            <option value="Pemrograman">Pemrograman</option>
            <option value="Design">Design</option>
            <option value="Data Science">Data Science</option>
            <option value="Mobile">Mobile</option>
        </select>
        <button @click="showModal = true; $wire.resetForm()" class="w-full md:w-auto p-3 bg-linear-to-br from-purple-600 to-purple-800 text-white rounded-lg cursor-pointer font-semibold flex items-center justify-center gap-2 transition-all hover:-translate-y-0.5 hover:shadow-lg">
            <x-heroicon-s-plus-circle class="w-5 h-5" />
            <span>Tambah Dosen</span>
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($instructors as $instructor)
        <div class="bg-white rounded-xl overflow-hidden shadow-sm transition-all hover:-translate-y-1 hover:shadow-lg">
            <div class="bg-linear-to-br from-purple-600 to-purple-800 p-6 text-center relative">
                <div class="absolute top-4 right-4 px-3 py-1 rounded-full text-xs font-semibold bg-white/90 {{ $instructor['status'] === 'active' ? 'text-green-600' : 'text-red-600' }}">
                    ● {{ $instructor['status'] === 'active' ? 'Aktif' : 'Tidak Aktif' }}
                </div>
                <div class="w-24 h-24 rounded-full bg-white text-purple-700 flex items-center justify-center text-4xl font-bold mx-auto border-4 border-white/30">
                    {{ strtoupper(substr($instructor['name'], 0, 2)) }}
                </div>
            </div>
            <div class="p-6">
                <div class="text-xl font-bold text-gray-900 text-center mb-1">{{ $instructor['name'] }}</div>
                <div class="flex items-center justify-center gap-1 text-center text-indigo-600 text-sm font-medium mb-4">
                    <x-heroicon-s-trophy class="w-4 h-4" />
                    {{ $instructor['specialty'] }}
                </div>
                
                <div class="flex items-center gap-2 justify-center mb-4">
                    <x-heroicon-s-star class="w-5 h-5 text-yellow-500" />
                    <span class="font-bold text-gray-800">{{ $instructor['rating'] }}</span>
                    <span class="text-gray-500 text-sm">({{ $instructor['students'] }} mahasiswa)</span>
                </div>
                
                <div class="space-y-2 mb-4">
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <x-heroicon-s-envelope class="w-4 h-4" />
                        <span>{{ $instructor['email'] }}</span>
                    </div>
                    <div class="flex items-start gap-2 text-sm text-gray-600">
                        <x-heroicon-s-document-text class="w-4 h-4 mt-0.5" />
                        <span class="flex-1">{{ Str::limit($instructor['bio'], 50) }}...</span>
                    </div>
                </div>
                
                <div class="grid grid-cols-3 gap-4 p-4 bg-gray-50 rounded-lg mb-6">
                    <div class="text-center">
                        <div class="text-lg font-bold text-indigo-600">{{ $instructor['courses'] }}</div>
                        <div class="text-xs text-gray-500">Kursus</div>
                    </div>
                    <div class="text-center">
                        <div class="text-lg font-bold text-indigo-600">{{ $instructor['students'] }}</div>
                        <div class="text-xs text-gray-500">Mahasiswa</div>
                    </div>
                    <div class="text-center">
                        <div class="text-lg font-bold text-indigo-600">{{ $instructor['rating'] }}</div>
                        <div class="text-xs text-gray-500">Rating</div>
                    </div>
                </div>
                
                <div class="flex gap-2">
                    <button wire:click="edit({{ $instructor['id'] }})" class="flex-1 p-3 rounded-lg font-semibold text-sm transition-all hover:-translate-y-0.5 text-center bg-indigo-600 text-white hover:bg-indigo-700">Edit</button>
                    <button wire:click="delete({{ $instructor['id'] }})" wire:confirm="Apakah Anda yakin ingin menghapus data ini?" class="flex-1 p-3 rounded-lg font-semibold text-sm transition-all hover:-translate-y-0.5 text-center bg-red-500 text-white hover:bg-red-600">Hapus</button>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-3 p-8 text-center text-gray-500">Tidak ada data dosen</div>
        @endforelse
    </div>
    
    <div class="mt-8">
        {{ $instructors->links() }}
    </div>

    <div x-show="showModal" style="display: none" class="fixed top-0 left-0 w-full h-full bg-black/50 z-1000 flex items-center justify-center p-4">
        <div class="bg-white p-8 rounded-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto" @click.away="showModal = false">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold">{{ $editingId ? 'Edit Dosen' : 'Tambah Dosen Baru' }}</h2>
                <button @click="showModal = false" class="text-gray-500 hover:text-gray-800">
                    <x-heroicon-s-x-mark class="w-6 h-6" />
                </button>
            </div>
            <form wire:submit="save">
                <div class="mb-6">
                    <label class="block mb-2 font-semibold">Nama Lengkap</label>
                    <input type="text" wire:model="name" required class="w-full p-3 border-2 border-gray-200 rounded-lg outline-none focus:border-indigo-500">
                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="mb-6">
                    <label class="block mb-2 font-semibold">Email</label>
                    <input type="email" wire:model="email" required class="w-full p-3 border-2 border-gray-200 rounded-lg outline-none focus:border-indigo-500">
                    @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="mb-6">
                    <label class="block mb-2 font-semibold">Keahlian/Spesialisasi</label>
                    <input type="text" wire:model="specialization" placeholder="e.g., Pemrograman Web, UI/UX" required class="w-full p-3 border-2 border-gray-200 rounded-lg outline-none focus:border-indigo-500">
                    @error('specialization') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="mb-6">
                    <label class="block mb-2 font-semibold">Bio/Deskripsi</label>
                    <textarea wire:model="description" placeholder="Pengalaman dan latar belakang dosen..." required class="w-full p-3 border-2 border-gray-200 rounded-lg outline-none focus:border-indigo-500 min-h-[120px] resize-y"></textarea>
                    @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                @if($editingId)
                <div class="mb-6">
                    <label class="block mb-2 font-semibold">Status</label>
                    <select wire:model="status" class="w-full p-3 border-2 border-gray-200 rounded-lg outline-none focus:border-indigo-500 bg-white">
                        <option value="active">Aktif</option>
                        <option value="inactive">Tidak Aktif</option>
                        <option value="suspended">Suspended</option>
                    </select>
                    @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                @endif
                <button type="submit" class="w-full p-3 bg-linear-to-br from-purple-600 to-purple-800 text-white rounded-lg cursor-pointer font-semibold text-base hover:opacity-90 hover:-translate-y-0.5">
                    {{ $editingId ? 'Update' : 'Tambah Dosen' }}
                </button>
            </form>
        </div>
    </div>
</div>

