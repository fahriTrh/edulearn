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

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm p-6 text-center hover:-translate-y-1 hover:shadow-md transition-all">
            <div class="text-3xl font-bold text-indigo-600 mb-2">{{ $totalUsers }}</div>
            <div class="text-gray-600 text-sm">Total Pengguna</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 text-center hover:-translate-y-1 hover:shadow-md transition-all">
            <div class="text-3xl font-bold text-indigo-600 mb-2">{{ $activeUsers }}</div>
            <div class="text-gray-600 text-sm">Aktif</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 text-center hover:-translate-y-1 hover:shadow-md transition-all">
            <div class="text-3xl font-bold text-indigo-600 mb-2">{{ $inactiveUsers }}</div>
            <div class="text-gray-600 text-sm">Tidak Aktif</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 text-center hover:-translate-y-1 hover:shadow-md transition-all">
            <div class="text-3xl font-bold text-indigo-600 mb-2">+{{ $newThisMonth }}</div>
            <div class="text-gray-600 text-sm">Bulan Ini</div>
        </div>
    </div>

    {{-- Toolbar --}}
    <div class="bg-white p-6 rounded-xl mb-8 shadow-sm flex flex-col md:flex-row gap-4 flex-wrap items-center">
        <div class="relative flex-1 min-w-[250px]">
            <x-heroicon-s-magnifying-glass class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" />
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama, email, atau NIM..." class="w-full p-3 pl-10 border-2 border-gray-200 rounded-lg outline-none focus:border-indigo-500">
        </div>
        <select wire:model.live="statusFilter" class="w-full md:w-auto p-3 border-2 border-gray-200 rounded-lg outline-none cursor-pointer bg-white focus:border-indigo-500">
            <option value="all">Semua Status</option>
            <option value="active">Aktif</option>
            <option value="inactive">Tidak Aktif</option>
            <option value="suspended">Suspended</option>
        </select>
        <button @click="showModal = true; $wire.resetForm()" class="w-full md:w-auto p-3 bg-linear-to-br from-purple-600 to-purple-800 text-white rounded-lg cursor-pointer font-semibold flex items-center justify-center gap-2 transition-all hover:-translate-y-0.5 hover:shadow-lg">
            <x-heroicon-s-plus-circle class="w-5 h-5" />
            <span>Tambah Mahasiswa</span>
        </button>
    </div>

    {{-- Users Table --}}
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[800px] border-collapse">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b-2 border-gray-200">Pengguna</th>
                        <th class="p-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b-2 border-gray-200">NIM</th>
                        <th class="p-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b-2 border-gray-200">Bergabung</th>
                        <th class="p-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b-2 border-gray-200">Status</th>
                        <th class="p-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b-2 border-gray-200">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mahasiswas as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="p-4 border-b border-gray-200">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-linear-to-br from-purple-600 to-purple-800 flex items-center justify-center text-white font-bold text-sm shrink-0">
                                    {{ strtoupper(substr($user['name'], 0, 2)) }}
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-800">{{ $user['name'] }}</div>
                                    <div class="text-sm text-gray-500">{{ $user['email'] }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="p-4 border-b border-gray-200 text-sm text-gray-700">{{ $user['nim'] }}</td>
                        <td class="p-4 border-b border-gray-200 text-sm text-gray-700">{{ $user['joinedDate'] }}</td>
                        <td class="p-4 border-b border-gray-200">
                            @php
                                $statusClasses = [
                                    'active' => 'bg-green-100 text-green-700',
                                    'inactive' => 'bg-red-100 text-red-700',
                                    'suspended' => 'bg-yellow-100 text-yellow-600'
                                ];
                                $statusTexts = [
                                    'active' => 'Aktif',
                                    'inactive' => 'Tidak Aktif',
                                    'suspended' => 'Suspended'
                                ];
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusClasses[$user['status']] ?? 'bg-gray-100 text-gray-600' }}">
                                {{ $statusTexts[$user['status']] ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="p-4 border-b border-gray-200 whitespace-nowrap">
                            <button wire:click="edit({{ $user['id'] }})" class="px-3 py-1 rounded-md font-semibold text-xs transition-all hover:-translate-y-0.5 bg-indigo-600 text-white hover:bg-indigo-700">Edit</button>
                            <button wire:click="delete({{ $user['id'] }})" wire:confirm="Apakah Anda yakin ingin menghapus data ini?" class="px-3 py-1 rounded-md font-semibold text-xs transition-all hover:-translate-y-0.5 bg-red-500 text-white hover:bg-red-600">Hapus</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-gray-500">Tidak ada data mahasiswa</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-200">
            {{ $mahasiswas->links() }}
        </div>
    </div>

    {{-- Add/Edit User Modal --}}
    <div x-show="showModal" style="display: none" class="fixed top-0 left-0 w-full h-full bg-black/50 z-1000 flex items-center justify-center p-4">
        <div class="bg-white p-8 rounded-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto" @click.away="showModal = false">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold">{{ $editingId ? 'Edit Mahasiswa' : 'Tambah Mahasiswa Baru' }}</h2>
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
                    <label class="block mb-2 font-semibold">NIM</label>
                    <input type="text" wire:model="nim" required class="w-full p-3 border-2 border-gray-200 rounded-lg outline-none focus:border-indigo-500">
                    @error('nim') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="mb-6">
                    <label class="block mb-2 font-semibold">Status</label>
                    <select wire:model="status" class="w-full p-3 border-2 border-gray-200 rounded-lg outline-none focus:border-indigo-500 bg-white">
                        <option value="active">Aktif</option>
                        <option value="inactive">Tidak Aktif</option>
                        <option value="suspended">Suspended</option>
                    </select>
                    @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <button type="submit" class="w-full p-3 bg-linear-to-br from-purple-600 to-purple-800 text-white rounded-lg cursor-pointer font-semibold text-base hover:opacity-90 hover:-translate-y-0.5">
                    {{ $editingId ? 'Update' : 'Tambah Mahasiswa' }}
                </button>
            </form>
        </div>
    </div>
</div>

