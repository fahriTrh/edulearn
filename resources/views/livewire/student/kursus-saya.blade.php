<div>
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Kursus Saya</h1>
        <p class="text-gray-600">Kelola dan pantau progres pembelajaran Anda</p>
    </div>

    <!-- Stats Summary -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-6">
        <div class="bg-white rounded-xl shadow-sm p-6 text-center hover:-translate-y-1 transition-transform">
            <div class="text-4xl font-bold bg-linear-to-r from-indigo-600 to-purple-700 bg-clip-text text-transparent mb-2">{{ $totalCourses }}</div>
            <div class="text-gray-600 text-sm">Total Kursus</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 text-center hover:-translate-y-1 transition-transform">
            <div class="text-4xl font-bold bg-linear-to-r from-indigo-600 to-purple-700 bg-clip-text text-transparent mb-2">{{ $activeCourses }}</div>
            <div class="text-gray-600 text-sm">Sedang Berjalan</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 text-center hover:-translate-y-1 transition-transform">
            <div class="text-4xl font-bold bg-linear-to-r from-indigo-600 to-purple-700 bg-clip-text text-transparent mb-2">{{ $completedCourses }}</div>
            <div class="text-gray-600 text-sm">Selesai</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 text-center hover:-translate-y-1 transition-transform">
            <div class="text-4xl font-bold bg-linear-to-r from-indigo-600 to-purple-700 bg-clip-text text-transparent mb-2">{{ $avgProgress }}%</div>
            <div class="text-gray-600 text-sm">Rata-rata Progress</div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-xl shadow-sm p-4 mb-6 flex flex-wrap gap-2">
        <button wire:click="filterCourses('all')" class="px-6 py-2 rounded-full font-medium transition-all {{ $filter === 'all' ? 'bg-linear-to-r from-indigo-600 to-purple-700 text-white' : 'border-2 border-gray-200 text-gray-600 hover:border-indigo-600' }}">
            Semua
        </button>
        <button wire:click="filterCourses('active')" class="px-6 py-2 rounded-full font-medium transition-all {{ $filter === 'active' ? 'bg-linear-to-r from-indigo-600 to-purple-700 text-white' : 'border-2 border-gray-200 text-gray-600 hover:border-indigo-600' }}">
            Sedang Berjalan
        </button>
        <button wire:click="filterCourses('completed')" class="px-6 py-2 rounded-full font-medium transition-all {{ $filter === 'completed' ? 'bg-linear-to-r from-indigo-600 to-purple-700 text-white' : 'border-2 border-gray-200 text-gray-600 hover:border-indigo-600' }}">
            Selesai
        </button>
    </div>

    <!-- Courses Grid - Google Classroom Style -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @forelse($courses as $course)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-all group relative flex flex-col h-full">
            {{-- Header / Cover Image --}}
            <div class="h-32 relative overflow-hidden" 
                 style="background: {{ $course['cover_image'] ? 'url(' . $course['cover_image'] . ') center/cover' : 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)' }};">
                <div class="absolute inset-0 bg-black/10 transition-colors"></div>
                <div class="absolute top-3 right-3 px-2 py-1 bg-white/90 backdrop-blur rounded-lg shadow-sm border border-gray-100 flex items-center gap-1.5">
                    @if($course['status'] === 'completed')
                        <div class="w-1.5 h-1.5 rounded-full bg-green-500"></div>
                        <span class="text-xs font-bold text-gray-700">Selesai</span>
                    @else
                        <div class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></div>
                        <span class="text-xs font-bold text-gray-700">Aktif</span>
                    @endif
                </div>
            </div>
            
            {{-- Body --}}
            <div class="p-5 flex-1 flex flex-col">
                <h3 class="text-lg font-bold text-gray-900 mb-1 line-clamp-2 leading-tight" title="{{ $course['title'] }}">
                    {{ $course['title'] }}
                </h3>
                <p class="text-sm text-gray-500 mb-4">{{ $course['code'] }}</p>
                
                {{-- Instructor Info --}}
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-6 h-6 rounded-full bg-gray-100 border border-gray-200 flex items-center justify-center text-[10px] font-bold text-gray-600 shrink-0">
                        {{ strtoupper(substr($course['instructor'] ?? '?', 0, 1)) }}
                    </div>
                    <div class="text-sm text-gray-500 truncate">
                        {{ $course['instructor'] ?? 'Unknown' }}
                    </div>
                </div>
                
                {{-- Stats --}}
                <div class="grid grid-cols-2 gap-2 mb-4 text-xs text-gray-500">
                    <div class="flex items-center gap-1.5 bg-gray-50 p-2 rounded-lg">
                        <x-heroicon-s-document-text class="w-3.5 h-3.5 text-purple-500" />
                        <span>{{ $course['materials_count'] }} Materi</span>
                    </div>
                    <div class="flex items-center gap-1.5 bg-gray-50 p-2 rounded-lg">
                        <x-heroicon-s-clipboard-document-list class="w-3.5 h-3.5 text-orange-500" />
                        <span>{{ $course['assignments_count'] }} Tugas</span>
                    </div>
                </div>
                
                {{-- Progress Bar --}}
                <div class="mb-4">
                    <div class="flex justify-between text-xs mb-1.5">
                        <span class="font-medium text-gray-600">Progress Belajar</span>
                        <span class="font-bold {{ $course['progress'] >= 100 ? 'text-green-600' : 'text-blue-600' }}">{{ $course['progress'] }}%</span>
                    </div>
                    <div class="w-full h-2 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full {{ $course['progress'] >= 100 ? 'bg-green-500' : 'bg-blue-600' }} rounded-full transition-all duration-500 ease-out" style="width: {{ $course['progress'] }}%"></div>
                    </div>
                </div>
                
                <div class="mt-auto pt-4 border-t border-gray-50 flex gap-2">
                    @if($course['progress'] >= 100)
                        <a href="{{ route('mahasiswa.nilai') }}" 
                           class="flex-1 flex items-center justify-center gap-1.5 px-3 py-2 bg-green-50 text-green-700 hover:bg-green-100 rounded-lg text-sm font-semibold transition-colors">
                            <x-heroicon-s-star class="w-4 h-4" />
                            Lihat Nilai
                        </a>
                    @else
                        <a href="{{ route('mahasiswa.detail-kursus', $course['id']) }}" wire:navigate
                           class="flex-1 flex items-center justify-center gap-1.5 px-3 py-2 bg-blue-600 text-white hover:bg-blue-700 shadow-sm shadow-blue-200 rounded-lg text-sm font-semibold transition-all hover:shadow-md">
                            Lanjutkan
                        </a>
                    @endif
                    <a href="{{ route('mahasiswa.detail-kursus', $course['id']) }}" wire:navigate
                       class="flex items-center justify-center gap-1.5 px-3 py-2 bg-gray-50 text-gray-600 hover:bg-gray-100 rounded-lg text-sm font-semibold transition-colors"
                       title="Detail">
                        <x-heroicon-s-eye class="w-4 h-4" />
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12">
            <div class="flex justify-center mb-4">
                <x-heroicon-s-academic-cap class="w-16 h-16 text-gray-400" />
            </div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Belum ada kursus</h3>
            <p class="text-gray-600">Daftar ke kursus untuk memulai pembelajaran</p>
        </div>
        @endforelse
    </div>
</div>
