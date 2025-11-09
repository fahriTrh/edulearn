<div>
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Kursus Saya</h1>
        <p class="text-gray-600">Kelola dan pantau progres pembelajaran Anda</p>
    </div>

    <!-- Stats Summary -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-6">
        <div class="bg-white rounded-xl shadow-sm p-6 text-center hover:-translate-y-1 transition-transform">
            <div class="text-4xl font-bold bg-gradient-to-r from-indigo-600 to-purple-700 bg-clip-text text-transparent mb-2">{{ $totalCourses }}</div>
            <div class="text-gray-600 text-sm">Total Kursus</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 text-center hover:-translate-y-1 transition-transform">
            <div class="text-4xl font-bold bg-gradient-to-r from-indigo-600 to-purple-700 bg-clip-text text-transparent mb-2">{{ $activeCourses }}</div>
            <div class="text-gray-600 text-sm">Sedang Berjalan</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 text-center hover:-translate-y-1 transition-transform">
            <div class="text-4xl font-bold bg-gradient-to-r from-indigo-600 to-purple-700 bg-clip-text text-transparent mb-2">{{ $completedCourses }}</div>
            <div class="text-gray-600 text-sm">Selesai</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 text-center hover:-translate-y-1 transition-transform">
            <div class="text-4xl font-bold bg-gradient-to-r from-indigo-600 to-purple-700 bg-clip-text text-transparent mb-2">{{ $avgProgress }}%</div>
            <div class="text-gray-600 text-sm">Rata-rata Progress</div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-xl shadow-sm p-4 mb-6 flex flex-wrap gap-2">
        <button wire:click="filterCourses('all')" class="px-6 py-2 rounded-full font-medium transition-all {{ $filter === 'all' ? 'bg-gradient-to-r from-indigo-600 to-purple-700 text-white' : 'border-2 border-gray-200 text-gray-600 hover:border-indigo-600' }}">
            Semua
        </button>
        <button wire:click="filterCourses('active')" class="px-6 py-2 rounded-full font-medium transition-all {{ $filter === 'active' ? 'bg-gradient-to-r from-indigo-600 to-purple-700 text-white' : 'border-2 border-gray-200 text-gray-600 hover:border-indigo-600' }}">
            Sedang Berjalan
        </button>
        <button wire:click="filterCourses('completed')" class="px-6 py-2 rounded-full font-medium transition-all {{ $filter === 'completed' ? 'bg-gradient-to-r from-indigo-600 to-purple-700 text-white' : 'border-2 border-gray-200 text-gray-600 hover:border-indigo-600' }}">
            Selesai
        </button>
    </div>

    <!-- Courses Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($courses as $course)
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden hover:-translate-y-2 hover:shadow-xl transition-all">
            <div class="h-36 {{ $course['cover_image'] ? '' : 'bg-gradient-to-br from-indigo-600 to-purple-700' }} flex items-center justify-center text-5xl relative" style="{{ $course['cover_image'] ? "background-image: url('{$course['cover_image']}'); background-size: cover; background-position: center;" : '' }}">
                @if(!$course['cover_image'])
                    📚
                @endif
                <span class="absolute top-4 right-4 px-3 py-1 bg-white/90 {{ $course['status'] === 'completed' ? 'text-indigo-600' : 'text-green-600' }} rounded-full text-xs font-semibold">
                    {{ $course['status'] === 'completed' ? 'Selesai' : 'Aktif' }}
                </span>
            </div>
            <div class="p-6">
                <span class="inline-block px-3 py-1 bg-indigo-100 text-indigo-600 rounded-full text-xs font-semibold mb-3">{{ $course['code'] }}</span>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $course['title'] }}</h3>
                <div class="flex items-center gap-1 text-gray-600 text-sm mb-4">
                    <span>👨‍🏫</span>
                    <span>{{ $course['instructor'] }}</span>
                </div>
                <div class="flex gap-4 text-sm text-gray-600 mb-4 pt-4 border-t border-gray-200">
                    <div class="flex items-center gap-1">
                        <span>📄</span> {{ $course['materials_count'] }} Materi
                    </div>
                    <div class="flex items-center gap-1">
                        <span>📋</span> {{ $course['assignments_count'] }} Tugas
                    </div>
                    <div class="flex items-center gap-1">
                        <span>👥</span> {{ $course['students_count'] }}
                    </div>
                </div>
                <div class="mb-4">
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-gray-600">Progress Pembelajaran</span>
                        <span class="font-semibold {{ $course['progress'] >= 100 ? 'text-green-600' : 'text-indigo-600' }}">{{ $course['progress'] }}%</span>
                    </div>
                    <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full {{ $course['progress'] >= 100 ? 'bg-gradient-to-r from-green-500 to-emerald-500' : 'bg-gradient-to-r from-indigo-600 to-purple-700' }} rounded-full transition-all duration-300" style="width: {{ $course['progress'] }}%"></div>
                    </div>
                </div>
                <div class="flex gap-2">
                    @if($course['progress'] >= 100)
                        <a href="{{ route('mahasiswa.nilai') }}" class="flex-1 px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-700 text-white rounded-lg font-semibold hover:-translate-y-1 hover:shadow-lg transition-all text-center">
                            Lihat Nilai
                        </a>
                    @else
                        <button class="flex-1 px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-700 text-white rounded-lg font-semibold hover:-translate-y-1 hover:shadow-lg transition-all">
                            Lanjutkan
                        </button>
                    @endif
                    <button class="px-4 py-2 bg-gray-100 text-indigo-600 rounded-lg font-semibold hover:bg-gray-200 transition-colors">
                        Detail
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center bg-white p-16 rounded-2xl shadow-sm">
            <div class="text-6xl mb-4">📚</div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Belum ada kursus</h3>
            <p class="text-gray-600">Daftar ke kursus untuk memulai pembelajaran</p>
        </div>
        @endforelse
    </div>
</div>
