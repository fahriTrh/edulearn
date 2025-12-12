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

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm p-6 hover:-translate-y-1 hover:shadow-md transition-all">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center">
                    <x-heroicon-s-users class="w-8 h-8 text-blue-600" />
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $totalStudents }}</h3>
                    <p class="text-gray-600 text-sm">Total Mahasiswa</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 hover:-translate-y-1 hover:shadow-md transition-all">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center">
                    <x-heroicon-s-clipboard-document-list class="w-8 h-8 text-purple-600" />
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $totalAssignments }}</h3>
                    <p class="text-gray-600 text-sm">Total Tugas</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 hover:-translate-y-1 hover:shadow-md transition-all">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center">
                    <x-heroicon-s-academic-cap class="w-8 h-8 text-green-600" />
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $totalMaterials }}</h3>
                    <p class="text-gray-600 text-sm">Total Materi</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 hover:-translate-y-1 hover:shadow-md transition-all">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-orange-100 rounded-xl flex items-center justify-center">
                    <x-heroicon-s-clock class="w-8 h-8 text-orange-600" />
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $pendingSubmissions }}</h3>
                    <p class="text-gray-600 text-sm">Pending Review</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions & Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Quick Actions -->
        <div class="lg:col-span-1 space-y-4">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Quick Actions</h2>
                <div class="space-y-3">
                    <a href="{{ route('dosen.kelas') }}" class="flex items-center justify-center gap-2 w-full px-4 py-3 bg-gradient-to-r from-purple-600 to-purple-800 text-white rounded-lg font-semibold hover:opacity-90 transition-opacity text-center">
                        <x-heroicon-s-academic-cap class="w-5 h-5" />
                        Kelola Kelas
                    </a>
                    <a href="{{ route('dosen.nilai') }}" class="flex items-center justify-center gap-2 w-full px-4 py-3 bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded-lg font-semibold hover:opacity-90 transition-opacity text-center">
                        <x-heroicon-s-chart-bar class="w-5 h-5" />
                        Nilai
                    </a>
                    <a href="{{ route('dosen.jadwal') }}" class="flex items-center justify-center gap-2 w-full px-4 py-3 bg-gradient-to-r from-green-600 to-green-800 text-white rounded-lg font-semibold hover:opacity-90 transition-opacity text-center">
                        <x-heroicon-s-calendar class="w-5 h-5" />
                        Kelola Jadwal
                    </a>
                </div>
            </div>

            <!-- Today's Schedule -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Jadwal Hari Ini</h2>
                <div class="space-y-3">
                    @forelse($todaySchedules as $schedule)
                    <div class="p-3 border border-gray-200 rounded-lg">
                        <div class="flex items-center gap-2 text-purple-600 font-semibold text-sm mb-1">
                            <x-heroicon-s-clock class="w-4 h-4" />
                            <span>{{ $schedule->start_time->format('H:i') }}</span>
                            @if($schedule->end_time)
                                <span>- {{ $schedule->end_time->format('H:i') }}</span>
                            @endif
                        </div>
                        <h4 class="font-semibold text-gray-900 text-sm">{{ $schedule->title }}</h4>
                        <p class="text-xs text-gray-600">{{ $schedule->class->title ?? 'N/A' }}</p>
                        @if($schedule->is_online && $schedule->meeting_link)
                            <a href="{{ $schedule->meeting_link }}" target="_blank" class="text-xs text-blue-600 hover:underline mt-1 inline-block">
                                Join Meeting →
                            </a>
                        @endif
                    </div>
                    @empty
                    <p class="text-sm text-gray-500 text-center py-4">Tidak ada jadwal hari ini</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Upcoming Deadlines -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Deadline Mendatang</h2>
                <div class="space-y-3">
                    @forelse($upcomingDeadlines as $assignment)
                    <div class="p-4 border border-gray-200 rounded-lg hover:border-purple-300 transition-colors">
                        <div class="flex justify-between items-start mb-2">
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-900">{{ $assignment->title }}</h4>
                                <p class="text-sm text-gray-600">{{ $assignment->class->title ?? 'N/A' }}</p>
                            </div>
                            <span class="px-3 py-1 bg-orange-100 text-orange-600 rounded-full text-xs font-semibold">
                                {{ (int) floor(now()->diffInDays($assignment->deadline, false)) }} hari lagi
                            </span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <x-heroicon-s-calendar class="w-4 h-4" />
                            <span>{{ $assignment->deadline->format('d M Y, H:i') }}</span>
                        </div>
                    </div>
                    @empty
                    <p class="text-sm text-gray-500 text-center py-4">Tidak ada deadline mendatang</p>
                    @endforelse
                </div>
            </div>

            <!-- Recent Submissions -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Submission Terbaru</h2>
                <div class="space-y-3">
                    @forelse($recentSubmissions as $submission)
                    <div class="p-4 border border-gray-200 rounded-lg hover:border-purple-300 transition-colors">
                        <div class="flex justify-between items-start mb-2">
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-900">{{ $submission->user->name ?? 'N/A' }}</h4>
                                <p class="text-sm text-gray-600">{{ $submission->assignment->title ?? 'N/A' }}</p>
                                <p class="text-xs text-gray-500">{{ $submission->assignment->class->title ?? 'N/A' }}</p>
                            </div>
                            @if($submission->score !== null)
                                <span class="px-3 py-1 bg-green-100 text-green-600 rounded-full text-xs font-semibold">
                                    {{ $submission->score }}/100
                                </span>
                            @else
                                <span class="px-3 py-1 bg-orange-100 text-orange-600 rounded-full text-xs font-semibold">
                                    Pending
                                </span>
                            @endif
                        </div>
                        <div class="flex items-center gap-2 text-xs text-gray-500">
                            <x-heroicon-s-calendar class="w-4 h-4" />
                            <span>{{ \Carbon\Carbon::createFromTimestamp($submission->submitted_at)->format('d M Y, H:i') }}</span>
                        </div>
                    </div>
                    @empty
                    <p class="text-sm text-gray-500 text-center py-4">Belum ada submission</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Class Performance -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-6">Ringkasan Kelas</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($classPerformance as $class)
            <a href="{{ route('dosen.detail-kelas', $class['id']) }}" wire:navigate class="block border border-gray-200 rounded-lg p-4 hover:shadow-md transition-all relative group">
                <button wire:click.stop="deleteClass({{ $class['id'] }})" 
                        wire:confirm="Apakah Anda yakin ingin menghapus kelas ini? Tindakan ini tidak dapat dibatalkan."
                        class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity p-1.5 text-red-600 hover:bg-red-50 rounded z-10" 
                        title="Hapus Kelas">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </button>
                <h3 class="font-semibold text-gray-900 mb-1 pr-8">{{ $class['title'] }}</h3>
                <p class="text-sm text-gray-600 mb-3">{{ $class['code'] }}</p>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Mahasiswa:</span>
                        <span class="font-semibold">{{ $class['total_students'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Tugas:</span>
                        <span class="font-semibold">{{ $class['total_assignments'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Submission:</span>
                        <span class="font-semibold">{{ $class['submissions_count'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Rata-rata Nilai:</span>
                        <span class="font-semibold text-purple-600">{{ $class['avg_score'] }}</span>
                    </div>
                </div>
            </a>
            @empty
            <div class="col-span-full text-center py-8 text-gray-500">
                <p>Belum ada kelas</p>
            </div>
            @endforelse
        </div>
    </div>
</div>


