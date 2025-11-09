<div>
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Nilai & Sertifikat</h1>
        <p class="text-gray-600 text-lg">Pantau pencapaian dan progres belajar Anda di setiap kursus</p>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 md:p-8 rounded-xl shadow-sm border-l-4 border-purple-600">
            <div class="text-gray-600 text-sm mb-2">Rata-rata Nilai</div>
            <div class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-purple-600 to-purple-800 bg-clip-text text-transparent mb-2">
                {{ $avgGrade }}
            </div>
            <div class="text-green-500 text-sm">📊 Dari {{ $completedCourses }} kursus selesai</div>
        </div>

        <div class="bg-white p-6 md:p-8 rounded-xl shadow-sm border-l-4 border-purple-600">
            <div class="text-gray-600 text-sm mb-2">Sertifikat</div>
            <div class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-purple-600 to-purple-800 bg-clip-text text-transparent mb-2">
                {{ $totalCertificates }}
            </div>
            <div class="text-green-500 text-sm">🏆 Total sertifikat</div>
        </div>

        <div class="bg-white p-6 md:p-8 rounded-xl shadow-sm border-l-4 border-purple-600">
            <div class="text-gray-600 text-sm mb-2">Kursus Aktif</div>
            <div class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-purple-600 to-purple-800 bg-clip-text text-transparent mb-2">
                {{ $activeCourses }}
            </div>
            <div class="text-green-500 text-sm">🎯 Sedang berjalan</div>
        </div>

        <div class="bg-white p-6 md:p-8 rounded-xl shadow-sm border-l-4 border-purple-600">
            <div class="text-gray-600 text-sm mb-2">Predikat A</div>
            <div class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-purple-600 to-purple-800 bg-clip-text text-transparent mb-2">
                {{ $gradeACertificates }}
            </div>
            <div class="text-green-500 text-sm">⭐ Dengan predikat A</div>
        </div>
    </div>

    <!-- Grades Table Section -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="p-6 md:p-8">
            <h2 class="text-xl md:text-2xl font-semibold text-gray-800 mb-6">Daftar Nilai Kursus</h2>
            
            <!-- Desktop Table -->
            <div class="hidden lg:block overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-4 text-left text-sm font-semibold text-gray-700 border-b-2 border-gray-200">Nama Kursus</th>
                            <th class="px-4 py-4 text-left text-sm font-semibold text-gray-700 border-b-2 border-gray-200">Kode</th>
                            <th class="px-4 py-4 text-left text-sm font-semibold text-gray-700 border-b-2 border-gray-200">Nilai</th>
                            <th class="px-4 py-4 text-left text-sm font-semibold text-gray-700 border-b-2 border-gray-200">Status</th>
                            <th class="px-4 py-4 text-left text-sm font-semibold text-gray-700 border-b-2 border-gray-200">Instruktur</th>
                            <th class="px-4 py-4 text-left text-sm font-semibold text-gray-700 border-b-2 border-gray-200">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($coursesWithGrades as $course)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-4 border-b border-gray-200">
                                <div class="font-semibold text-gray-800">{{ $course['title'] }}</div>
                                <div class="text-sm text-purple-600 mt-1">{{ $course['code'] }}</div>
                            </td>
                            <td class="px-4 py-4 border-b border-gray-200 text-gray-700">{{ $course['code'] }}</td>
                            <td class="px-4 py-4 border-b border-gray-200 font-semibold text-lg text-purple-600">
                                {{ $course['final_score'] ? number_format($course['final_score'], 0) : '-' }}
                            </td>
                            <td class="px-4 py-4 border-b border-gray-200">
                                @if($course['status'] === 'completed')
                                    <span class="inline-block px-4 py-2 rounded-full text-sm font-semibold bg-green-100 text-green-600">Lulus</span>
                                    @if($course['has_certificate'])
                                        <span class="inline-flex items-center gap-1 px-2 py-1 bg-yellow-400 rounded-lg text-xs font-semibold ml-2">🏆 Sertifikat</span>
                                    @endif
                                @else
                                    <span class="inline-block px-4 py-2 rounded-full text-sm font-semibold bg-orange-100 text-orange-600">Berlangsung</span>
                                @endif
                            </td>
                            <td class="px-4 py-4 border-b border-gray-200 text-gray-700">{{ $course['instructor'] }}</td>
                            <td class="px-4 py-4 border-b border-gray-200">
                                @if($course['grades']->count() > 0 || $course['final_score'])
                                    <div class="flex gap-2">
                                        <button class="px-4 py-2 border-2 border-purple-600 text-purple-600 rounded-lg font-semibold hover:bg-purple-600 hover:text-white transition-colors">
                                            Detail
                                        </button>
                                        @if($course['has_certificate'])
                                            <button class="px-4 py-2 bg-gradient-to-r from-purple-600 to-purple-800 text-white rounded-lg font-semibold hover:opacity-90 transition-opacity">
                                                🏆 Sertifikat
                                            </button>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-gray-400 text-sm">Belum ada nilai</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                                Belum ada kursus dengan nilai
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Cards -->
            <div class="lg:hidden space-y-4">
                @forelse($coursesWithGrades as $course)
                <div class="bg-white border border-gray-200 rounded-lg p-4">
                    <div class="font-semibold text-gray-800 mb-1">{{ $course['title'] }}</div>
                    <div class="text-sm text-purple-600 mb-3">{{ $course['code'] }}</div>
                    
                    <div class="grid grid-cols-2 gap-2 text-sm mb-3">
                        <div>
                            <span class="text-gray-500">Kode:</span>
                            <span class="font-medium text-gray-700 ml-1">{{ $course['code'] }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Nilai:</span>
                            <span class="font-semibold text-purple-600 ml-1 text-lg">{{ $course['final_score'] ? number_format($course['final_score'], 0) : '-' }}</span>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        @if($course['status'] === 'completed')
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-600">Lulus</span>
                            @if($course['has_certificate'])
                                <span class="inline-flex items-center gap-1 px-2 py-1 bg-yellow-400 rounded-lg text-xs font-semibold ml-2">🏆 Sertifikat</span>
                            @endif
                        @else
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-orange-100 text-orange-600">Berlangsung</span>
                        @endif
                    </div>
                    
                    <div class="text-sm text-gray-600 mb-3">
                        <span class="text-gray-500">Instruktur:</span> {{ $course['instructor'] }}
                        @if($course['completed_date'])
                            <br>
                            <span class="text-gray-500">Selesai:</span> {{ $course['completed_date'] }}
                        @endif
                    </div>
                    
                    @if($course['grades']->count() > 0 || $course['final_score'])
                        <div class="flex gap-2">
                            <button class="flex-1 px-4 py-2 border-2 border-purple-600 text-purple-600 rounded-lg font-semibold hover:bg-purple-600 hover:text-white transition-colors">
                                Detail
                            </button>
                            @if($course['has_certificate'])
                                <button class="flex-1 px-4 py-2 bg-gradient-to-r from-purple-600 to-purple-800 text-white rounded-lg font-semibold hover:opacity-90 transition-opacity">
                                    🏆 Sertifikat
                                </button>
                            @endif
                        </div>
                    @endif
                </div>
                @empty
                <div class="text-center py-8 text-gray-500">
                    Belum ada kursus dengan nilai
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
