<div id="enroll-class-modal-component">
    <!-- Enrollment Modal -->
    @if($showModal)
    <div class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4" wire:click="closeModal">
        <div class="bg-white rounded-xl max-w-md w-full p-6 shadow-xl" wire:click.stop>
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Daftar Kelas</h2>
                <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600 text-2xl">✕</button>
            </div>

            @if (session()->has('error'))
                <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded-lg text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Instructions -->
            <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <h3 class="text-sm font-semibold text-blue-900 mb-2">📋 Cara Mendaftar:</h3>
                <ol class="text-xs text-blue-800 space-y-1.5 list-decimal list-inside">
                    <li>Dapatkan kode pendaftaran dari instruktur kelas Anda</li>
                    <li>Masukkan kode pendaftaran di kolom di bawah ini</li>
                    <li>Klik tombol "Daftar" untuk bergabung ke kelas</li>
                    <li>Setelah berhasil, Anda akan diarahkan ke halaman detail kelas</li>
                </ol>
                <p class="text-xs text-blue-700 mt-3 font-medium">💡 Tips: Kode pendaftaran biasanya terdiri dari 4-20 karakter</p>
            </div>

            <form wire:submit.prevent="enroll" class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Kode Pendaftaran *</label>
                    <input 
                        type="text" 
                        wire:model="enrollment_code" 
                        required 
                        autofocus
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-indigo-600 focus:outline-none font-mono text-center text-lg tracking-wider uppercase"
                        placeholder="Masukkan kode"
                        maxlength="20"
                    >
                    @error('enrollment_code') 
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
                    @enderror
                    <p class="text-xs text-gray-500 mt-2 text-center">Masukkan kode yang diberikan oleh instruktur</p>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="submit" class="flex-1 px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-700 text-white rounded-lg font-semibold hover:opacity-90 transition-opacity">
                        Daftar
                    </button>
                    <button type="button" wire:click="closeModal" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg font-semibold hover:bg-gray-200 transition-colors">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>

