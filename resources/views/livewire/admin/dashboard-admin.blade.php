<div>
    {{-- Stat Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        {{-- Stat Card 1 --}}
        <div class="bg-white rounded-xl shadow-sm p-6 hover:-translate-y-1 hover:shadow-md transition-all">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-indigo-100 rounded-xl flex items-center justify-center">
                    <x-heroicon-s-users class="w-8 h-8 text-indigo-600" />
                </div>
                <div>
                    <h3 class="text-3xl font-bold text-indigo-600">{{ $total_mahasiswa }}</h3>
                    <p class="text-gray-600 text-sm">Total Mahasiswa</p>
                </div>
            </div>
        </div>
        
        {{-- Stat Card 2 --}}
        <div class="bg-white rounded-xl shadow-sm p-6 hover:-translate-y-1 hover:shadow-md transition-all">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center">
                    <x-heroicon-s-academic-cap class="w-8 h-8 text-green-600" />
                </div>
                <div>
                    <h3 class="text-3xl font-bold text-indigo-600">{{ $total_class }}</h3>
                    <p class="text-gray-600 text-sm">Total Kursus</p>
                </div>
            </div>
        </div>
        
        {{-- Stat Card 3 --}}
        <div class="bg-white rounded-xl shadow-sm p-6 hover:-translate-y-1 hover:shadow-md transition-all">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-orange-100 rounded-xl flex items-center justify-center">
                    <x-heroicon-s-academic-cap class="w-8 h-8 text-orange-600" />
                </div>
                <div>
                    <h3 class="text-3xl font-bold text-indigo-600">{{ $total_instructor }}</h3>
                    <p class="text-gray-600 text-sm">Instruktur Aktif</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
        <div class="mb-6">
            <h2 class="text-xl font-bold text-gray-900">Quick Actions</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="/kelola-mahasiswa" class="p-4 bg-gradient-to-br from-purple-600 to-purple-800 text-white rounded-xl font-semibold flex flex-col items-center gap-2 transition-all hover:-translate-y-1 hover:shadow-lg no-underline">
                <x-heroicon-s-user-plus class="w-8 h-8" />
                <div>Tambah Mahasiswa</div>
            </a>
            <a href="/kelola-instruktur" class="p-4 bg-gradient-to-br from-purple-600 to-purple-800 text-white rounded-xl font-semibold flex flex-col items-center gap-2 transition-all hover:-translate-y-1 hover:shadow-lg no-underline">
                <x-heroicon-s-academic-cap class="w-8 h-8" />
                <div>Tambah Instruktur</div>
            </a>
        </div>
    </div>
</div>

