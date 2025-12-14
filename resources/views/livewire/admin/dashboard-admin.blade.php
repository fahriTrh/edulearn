<div>
    {{-- Stat Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        {{-- Stat Card 1: Mahasiswa (Blue) --}}
        <div class="bg-white rounded-xl shadow-sm p-6 hover:-translate-y-1 hover:shadow-md transition-all">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center">
                    <x-heroicon-s-users class="w-8 h-8 text-blue-600" />
                </div>
                <div>
                    <h3 class="text-3xl font-bold text-blue-600">{{ $total_mahasiswa }}</h3>
                    <p class="text-gray-600 text-sm">Total Mahasiswa</p>
                </div>
            </div>
        </div>
        
        {{-- Stat Card 2: Dosen (Purple) --}}
        <div class="bg-white rounded-xl shadow-sm p-6 hover:-translate-y-1 hover:shadow-md transition-all">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center">
                    <x-heroicon-s-academic-cap class="w-8 h-8 text-purple-600" />
                </div>
                <div>
                    <h3 class="text-3xl font-bold text-purple-600">{{ $total_instructor }}</h3>
                    <p class="text-gray-600 text-sm">Dosen Aktif</p>
                </div>
            </div>
        </div>
        
        {{-- Stat Card 3: Kelas (Orange) --}}
        <div class="bg-white rounded-xl shadow-sm p-6 hover:-translate-y-1 hover:shadow-md transition-all">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-orange-100 rounded-xl flex items-center justify-center">
                    <x-heroicon-s-book-open class="w-8 h-8 text-orange-600" />
                </div>
                <div>
                    <h3 class="text-3xl font-bold text-orange-600">{{ $total_class }}</h3>
                    <p class="text-gray-600 text-sm">Total Kursus</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
        <div class="mb-6">
            <h2 class="text-xl font-bold text-gray-900">Quick Actions</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <a href="/kelola-mahasiswa" wire:navigate class="p-4 bg-linear-to-br from-cyan-500 to-blue-600 text-white rounded-xl font-semibold flex flex-col items-center gap-2 transition-all hover:-translate-y-1 hover:shadow-lg no-underline">
                <x-heroicon-s-user-plus class="w-8 h-8" />
                <div>Tambah Mahasiswa</div>
            </a>
            <a href="/kelola-instruktur" wire:navigate class="p-4 bg-linear-to-br from-purple-500 to-pink-600 text-white rounded-xl font-semibold flex flex-col items-center gap-2 transition-all hover:-translate-y-1 hover:shadow-lg no-underline">
                <x-heroicon-s-academic-cap class="w-8 h-8" />
                <div>Tambah Dosen</div>
            </a>
            <a href="/kelola-kelas" wire:navigate class="p-4 bg-linear-to-br from-orange-400 to-red-500 text-white rounded-xl font-semibold flex flex-col items-center gap-2 transition-all hover:-translate-y-1 hover:shadow-lg no-underline">
                <x-heroicon-s-book-open class="w-8 h-8" />
                <div>Kelola Kelas</div>
            </a>
        </div>
    </div>


    {{-- Recent Activity Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{-- Recent Students --}}
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-900">Mahasiswa Baru</h2>
                <a href="/kelola-mahasiswa" wire:navigate class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">Lihat Semua</a>
            </div>
            <div class="space-y-4">
                @forelse($recent_students as $student)
                <div class="flex items-center gap-4 p-3 rounded-lg hover:bg-gray-50 transition-colors">
                    <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-sm shrink-0">
                        {{ strtoupper(substr($student->name, 0, 2)) }}
                    </div>
                    <div class="flex-1">
                        <div class="font-semibold text-gray-900">{{ $student->name }}</div>
                        <div class="text-xs text-gray-500">{{ $student->created_at->diffForHumans() }}</div>
                    </div>
                    <div class="text-xs px-2 py-1 bg-green-100 text-green-700 rounded-full font-semibold">
                        {{ $student->status }}
                    </div>
                </div>
                @empty
                <div class="text-center text-gray-500 py-4">Belum ada mahasiswa baru</div>
                @endforelse
            </div>
        </div>

        {{-- Recent Classes --}}
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-900">Kelas Terbaru</h2>
                <a href="/kelola-kelas" wire:navigate class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">Lihat Semua</a>
            </div>
            <div class="space-y-4">
                @forelse($recent_classes as $class)
                <div class="flex items-center gap-4 p-3 rounded-lg hover:bg-gray-50 transition-colors">
                    <div class="w-10 h-10 rounded-lg bg-orange-100 flex items-center justify-center text-orange-600 shrink-0">
                        <x-heroicon-s-book-open class="w-5 h-5" />
                    </div>
                    <div class="flex-1">
                        <div class="font-semibold text-gray-900">{{ $class->title }}</div>
                        <div class="text-xs text-gray-500">Oleh: {{ $class->instructor->user->name ?? 'Unknown' }}</div>
                    </div>
                    <div class="text-right">
                        <div class="text-xs font-medium text-gray-900">{{ $class->created_at->format('d M') }}</div>
                    </div>
                </div>
                @empty
                <div class="text-center text-gray-500 py-4">Belum ada kelas dibuat</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

