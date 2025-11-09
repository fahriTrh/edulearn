<div>
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Stat Card 1 -->
        <div class="bg-white rounded-xl shadow-sm p-6 hover:-translate-y-1 hover:shadow-md transition-all">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-indigo-100 rounded-xl flex items-center justify-center">
                    <x-heroicon-s-academic-cap class="w-8 h-8 text-indigo-600" />
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $activeCourses }}</h3>
                    <p class="text-gray-600 text-sm">Kursus Aktif</p>
                </div>
            </div>
        </div>

        <!-- Stat Card 2 -->
        <div class="bg-white rounded-xl shadow-sm p-6 hover:-translate-y-1 hover:shadow-md transition-all">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center">
                    <x-heroicon-s-check-circle class="w-8 h-8 text-green-600" />
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $completedAssignments }}</h3>
                    <p class="text-gray-600 text-sm">Tugas Selesai</p>
                </div>
            </div>
        </div>

        <!-- Stat Card 3 -->
        <div class="bg-white rounded-xl shadow-sm p-6 hover:-translate-y-1 hover:shadow-md transition-all">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-orange-100 rounded-xl flex items-center justify-center">
                    <x-heroicon-s-clock class="w-8 h-8 text-orange-600" />
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $pendingAssignments }}</h3>
                    <p class="text-gray-600 text-sm">Tugas Pending</p>
                </div>
            </div>
        </div>

        <!-- Stat Card 4 -->
        <div class="bg-white rounded-xl shadow-sm p-6 hover:-translate-y-1 hover:shadow-md transition-all">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-red-100 rounded-xl flex items-center justify-center">
                    <x-heroicon-s-trophy class="w-8 h-8 text-red-600" />
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $averageGrade }}</h3>
                    <p class="text-gray-600 text-sm">Rata-rata Nilai</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Courses in Progress -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-900">Kursus Sedang Berjalan</h2>
                <a href="{{ route('mahasiswa.kursus') }}" wire:navigate class="text-indigo-600 text-sm font-semibold hover:underline">Lihat Semua →</a>
            </div>

            <div class="space-y-4">
                @forelse($coursesInProgress as $course)
                <a href="{{ route('mahasiswa.detail-kursus', $course['id']) }}" wire:navigate class="flex gap-4 p-4 border border-gray-200 rounded-xl hover:border-indigo-600 hover:shadow-md transition-all cursor-pointer">
                    <div class="w-20 h-20 bg-gradient-to-br from-indigo-600 to-purple-700 rounded-lg flex items-center justify-center flex-shrink-0">
                        @if($course['cover_image'])
                            <img src="{{ $course['cover_image'] }}" alt="{{ $course['title'] }}" class="w-full h-full object-cover rounded-lg">
                        @else
                            <x-heroicon-s-academic-cap class="w-10 h-10 text-white" />
                        @endif
                    </div>
                    <div class="flex-1">
                        <h3 class="font-semibold text-gray-900 mb-1">{{ $course['title'] }}</h3>
                        <p class="text-gray-600 text-sm mb-3">Dosen: {{ $course['instructor'] }} • {{ $course['materials_count'] }} Materi</p>
                        <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-indigo-600 to-purple-700 rounded-full transition-all duration-300" style="width: {{ $course['progress'] }}%"></div>
                        </div>
                        <p class="text-indigo-600 text-sm font-medium mt-2">{{ $course['progress'] }}% selesai</p>
                    </div>
                </a>
                @empty
                <div class="text-center py-8 text-gray-500">
                    <p class="mb-2">Belum ada kursus aktif</p>
                    <a href="{{ route('mahasiswa.kursus') }}" wire:navigate class="text-indigo-600 hover:underline">Lihat semua kursus →</a>
                </div>
                @endforelse
            </div>
        </div>

            <!-- Assignments -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Tugas Mendatang</h2>

                <div class="space-y-4">
                    @forelse($upcomingAssignments as $assignment)
                    <div class="p-4 border border-gray-200 rounded-lg hover:border-indigo-600 transition-colors">
                        <h4 class="font-semibold text-gray-900 mb-2">{{ $assignment['title'] }}</h4>
                        <p class="text-gray-600 text-xs mb-2">{{ $assignment['class_name'] }}</p>
                        <div class="flex items-center justify-between">
                            @if($assignment['days_left'] < 0)
                                <p class="flex items-center gap-1 text-red-500 text-sm font-semibold">
                                    <x-heroicon-s-clock class="w-4 h-4" />
                                    Terlambat {{ abs($assignment['days_left']) }} hari
                                </p>
                            @elseif($assignment['days_left'] <= 3)
                                <p class="flex items-center gap-1 text-red-500 text-sm font-semibold">
                                    <x-heroicon-s-clock class="w-4 h-4" />
                                    Deadline: {{ $assignment['days_left'] }} hari lagi
                                </p>
                            @elseif($assignment['days_left'] <= 7)
                                <p class="flex items-center gap-1 text-orange-500 text-sm font-semibold">
                                    <x-heroicon-s-clock class="w-4 h-4" />
                                    Deadline: {{ $assignment['days_left'] }} hari lagi
                                </p>
                            @else
                                <p class="flex items-center gap-1 text-gray-500 text-sm font-semibold">
                                    <x-heroicon-s-clock class="w-4 h-4" />
                                    Deadline: {{ $assignment['days_left'] }} hari lagi
                                </p>
                            @endif
                            @if($assignment['is_submitted'])
                                @if($assignment['is_graded'])
                                    <span class="px-3 py-1 bg-green-100 text-green-600 rounded-full text-xs font-semibold">Dinilai</span>
                                @else
                                    <span class="px-3 py-1 bg-blue-100 text-blue-600 rounded-full text-xs font-semibold">Diserahkan</span>
                                @endif
                            @else
                                <span class="px-3 py-1 bg-orange-100 text-orange-600 rounded-full text-xs font-semibold">Pending</span>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8 text-gray-500 text-sm">
                        <p>Tidak ada tugas mendatang</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

