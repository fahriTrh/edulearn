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

    <div class="bg-white rounded-xl shadow-sm p-8">
        <h2 class="text-2xl font-bold mb-6">🔒 Ubah Password</h2>
        
        <form wire:submit="save">
            <div class="mb-6">
                <label class="block mb-2 font-semibold">Password Saat Ini <span class="text-red-500">*</span></label>
                <input type="password" wire:model="current_password" required class="w-full p-3 border-2 border-gray-200 rounded-lg">
                @error('current_password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-6">
                <label class="block mb-2 font-semibold">Password Baru <span class="text-red-500">*</span></label>
                <input type="password" wire:model="new_password" required class="w-full p-3 border-2 border-gray-200 rounded-lg">
                @error('new_password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-6">
                <label class="block mb-2 font-semibold">Konfirmasi Password Baru <span class="text-red-500">*</span></label>
                <input type="password" wire:model="new_password_confirmation" required class="w-full p-3 border-2 border-gray-200 rounded-lg">
                @error('new_password_confirmation') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="flex gap-4">
                <button type="button" onclick="window.history.back()" class="flex-1 p-3 bg-gray-200 text-gray-700 rounded-lg font-semibold">
                    Batal
                </button>
                <button type="submit" class="flex-1 p-3 bg-gradient-to-br from-purple-600 to-purple-800 text-white rounded-lg font-semibold">
                    💾 Simpan Password
                </button>
            </div>
        </form>
    </div>
</div>

