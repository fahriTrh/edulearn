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

    <!-- Courses Grid - Google Classroom Style -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @forelse($courses as $course)
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden hover:shadow-md transition-shadow cursor-pointer group">
            <!-- Large Header Banner -->
            <div class="h-24 relative" 
                 style="background: {{ $course['cover_image'] ? 'url(' . $course['cover_image'] . ') center/cover' : 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)' }};">
                <div class="absolute inset-0 bg-black/20"></div>
                <span class="absolute top-2 right-2 px-2 py-0.5 bg-white/90 {{ $course['status'] === 'completed' ? 'text-indigo-600' : 'text-green-600' }} rounded text-xs font-semibold">
                    {{ $course['status'] === 'completed' ? 'Selesai' : 'Aktif' }}
                </span>
            </div>
            
            <!-- Class Info -->
            <div class="p-4">
                <h3 class="text-base font-medium text-gray-900 mb-1 line-clamp-2" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ $course['title'] }}</h3>
                <p class="text-sm text-gray-600 mb-2">{{ $course['code'] }}</p>
                <p class="text-xs text-gray-500 mb-2">👨‍🏫 {{ $course['instructor'] }}</p>
                
                <!-- Quick Stats -->
                <div class="flex items-center gap-3 text-xs text-gray-500 mb-3">
                    <span>{{ $course['materials_count'] }} materi</span>
                    <span>•</span>
                    <span>{{ $course['assignments_count'] }} tugas</span>
                </div>
                
                <!-- Progress Bar -->
                <div class="mb-3">
                    <div class="flex justify-between text-xs mb-1">
                        <span class="text-gray-600">Progress</span>
                        <span class="font-semibold {{ $course['progress'] >= 100 ? 'text-green-600' : 'text-blue-600' }}">{{ $course['progress'] }}%</span>
                    </div>
                    <div class="w-full h-1.5 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full {{ $course['progress'] >= 100 ? 'bg-green-500' : 'bg-blue-600' }} rounded-full transition-all duration-300" style="width: {{ $course['progress'] }}%"></div>
                    </div>
                </div>
                
                <!-- Actions -->
                <div class="flex gap-2 pt-3 border-t border-gray-100">
                    @if($course['progress'] >= 100)
                        <a href="{{ route('mahasiswa.nilai') }}" 
                           class="flex-1 text-center px-3 py-1.5 bg-green-50 hover:bg-green-100 text-green-700 rounded text-xs font-medium">
                            Nilai
                        </a>
                    @else
                        <a href="{{ route('mahasiswa.detail-kursus', $course['id']) }}" 
                           class="flex-1 text-center px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded text-xs font-medium">
                            Lanjutkan
                        </a>
                    @endif
                    <a href="{{ route('mahasiswa.detail-kursus', $course['id']) }}" 
                       class="px-3 py-1.5 text-gray-600 hover:bg-gray-100 rounded text-xs" title="Detail">
                        Detail
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12">
            <div class="text-6xl mb-4">📚</div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Belum ada kursus</h3>
            <p class="text-gray-600">Daftar ke kursus untuk memulai pembelajaran</p>
        </div>
        @endforelse
    </div>
</div>
