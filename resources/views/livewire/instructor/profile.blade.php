<div>
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Profile</h1>
        <p class="text-gray-600">Kelola informasi profil dan kredensial Anda</p>
    </div>

    <!-- Tabs -->
    <div class="bg-white rounded-xl shadow-sm p-1 mb-6">
        <div class="flex gap-2">
            <button 
                wire:click="switchTab('profile')"
                class="flex-1 px-6 py-3 rounded-lg font-semibold transition-all {{ $activeTab === 'profile' ? 'bg-gradient-to-r from-purple-600 to-purple-800 text-white' : 'text-gray-600 hover:bg-gray-100' }}"
            >
                👤 Informasi Profil
            </button>
            <button 
                wire:click="switchTab('instructor')"
                class="flex-1 px-6 py-3 rounded-lg font-semibold transition-all {{ $activeTab === 'instructor' ? 'bg-gradient-to-r from-purple-600 to-purple-800 text-white' : 'text-gray-600 hover:bg-gray-100' }}"
            >
                <x-heroicon-s-academic-cap class="w-5 h-5" />
                Informasi Instruktur
            </button>
            <button 
                wire:click="switchTab('password')"
                class="flex-1 px-6 py-3 rounded-lg font-semibold transition-all {{ $activeTab === 'password' ? 'bg-gradient-to-r from-purple-600 to-purple-800 text-white' : 'text-gray-600 hover:bg-gray-100' }}"
            >
                <x-heroicon-s-lock-closed class="w-5 h-5" />
                Ubah Password
            </button>
        </div>
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

    <!-- Tab 1: Profile Information -->
    @if($activeTab === 'profile')
    <div class="bg-white rounded-xl shadow-sm p-8">
        <h2 class="text-2xl font-bold mb-6">👤 Informasi Profil</h2>
        
        <form wire:submit.prevent="saveProfile">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block mb-2 font-semibold text-gray-900">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" wire:model="name" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-purple-600 focus:outline-none">
                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-gray-900">Email <span class="text-red-500">*</span></label>
                    <input type="email" wire:model="email" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-purple-600 focus:outline-none">
                    @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-gray-900">No. Telepon</label>
                    <input type="text" wire:model="phone" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-purple-600 focus:outline-none" placeholder="08xxxxxxxxxx">
                    @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-gray-900">Tanggal Lahir</label>
                    <input type="date" wire:model="birth_date" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-purple-600 focus:outline-none">
                    @error('birth_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block mb-2 font-semibold text-gray-900">Alamat</label>
                    <input type="text" wire:model="address" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-purple-600 focus:outline-none" placeholder="Alamat lengkap">
                    @error('address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block mb-2 font-semibold text-gray-900">Bio</label>
                    <textarea wire:model="bio" rows="4" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-purple-600 focus:outline-none resize-none" placeholder="Tuliskan bio singkat tentang Anda"></textarea>
                    @error('bio') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block mb-2 font-semibold text-gray-900">Foto Profil</label>
                    <div class="flex items-center gap-4">
                        @if($user->avatar)
                            <img src="{{ asset($user->avatar) }}" alt="Avatar" class="w-20 h-20 rounded-full object-cover border-2 border-gray-200">
                        @else
                            <div class="w-20 h-20 rounded-full bg-gray-200 flex items-center justify-center text-2xl">
                                👤
                            </div>
                        @endif
                        <div class="flex-1">
                            <input type="file" wire:model="avatar" accept="image/*" class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:border-purple-600 focus:outline-none">
                            <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG. Maksimal 2MB</p>
                            @error('avatar') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex gap-4 pt-4 border-t border-gray-200">
                <button type="submit" class="px-8 py-3 bg-gradient-to-r from-purple-600 to-purple-800 text-white rounded-lg font-semibold hover:opacity-90 transition-opacity">
                    💾 Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
    @endif

    <!-- Tab 2: Instructor Information -->
    @if($activeTab === 'instructor')
    <div class="bg-white rounded-xl shadow-sm p-8">
        <h2 class="flex items-center gap-2 text-2xl font-bold mb-6">
            <x-heroicon-s-academic-cap class="w-7 h-7" />
            Informasi Instruktur
        </h2>
        
        <form wire:submit.prevent="saveInstructorInfo">
            <div class="space-y-6 mb-6">
                <div>
                    <label class="block mb-2 font-semibold text-gray-900">Gelar Akademik</label>
                    <input type="text" wire:model="instructor_title" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-purple-600 focus:outline-none" placeholder="Contoh: Dr., Prof., M.Kom., dll">
                    @error('instructor_title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-gray-900">Keahlian/Spesialisasi <span class="text-red-500">*</span></label>
                    <input type="text" wire:model="specialization" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-purple-600 focus:outline-none" placeholder="Contoh: Pemrograman Web, Database, Machine Learning">
                    @error('specialization') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-gray-900">Deskripsi</label>
                    <textarea wire:model="description" rows="6" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-purple-600 focus:outline-none resize-none" placeholder="Tuliskan deskripsi tentang keahlian dan pengalaman Anda"></textarea>
                    @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="flex gap-4 pt-4 border-t border-gray-200">
                <button type="submit" class="px-8 py-3 bg-gradient-to-r from-purple-600 to-purple-800 text-white rounded-lg font-semibold hover:opacity-90 transition-opacity">
                    💾 Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
    @endif

    <!-- Tab 3: Change Password -->
    @if($activeTab === 'password')
    <div class="bg-white rounded-xl shadow-sm p-8">
        <h2 class="flex items-center gap-2 text-2xl font-bold mb-6">
            <x-heroicon-s-lock-closed class="w-7 h-7" />
            Ubah Password
        </h2>
        
        <form wire:submit.prevent="savePassword">
            <div class="space-y-6 mb-6">
                <div>
                    <label class="block mb-2 font-semibold text-gray-900">Password Saat Ini <span class="text-red-500">*</span></label>
                    <input type="password" wire:model="current_password" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-purple-600 focus:outline-none">
                    @error('current_password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-gray-900">Password Baru <span class="text-red-500">*</span></label>
                    <input type="password" wire:model="new_password" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-purple-600 focus:outline-none">
                    <p class="text-sm text-gray-500 mt-1">Minimal 8 karakter</p>
                    @error('new_password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-gray-900">Konfirmasi Password Baru <span class="text-red-500">*</span></label>
                    <input type="password" wire:model="new_password_confirmation" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-purple-600 focus:outline-none">
                    @error('new_password_confirmation') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="flex gap-4 pt-4 border-t border-gray-200">
                <button type="submit" class="px-8 py-3 bg-gradient-to-r from-purple-600 to-purple-800 text-white rounded-lg font-semibold hover:opacity-90 transition-opacity">
                    💾 Simpan Password
                </button>
            </div>
        </form>
    </div>
    @endif
</div>
