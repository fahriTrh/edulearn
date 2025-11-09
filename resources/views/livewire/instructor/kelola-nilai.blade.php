<div>
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Kelola Nilai</h1>
        <p class="text-gray-600">Lihat dan kelola semua nilai mahasiswa</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Classes List -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Daftar Kelas</h2>
                <div class="space-y-3 max-h-[600px] overflow-y-auto">
                    @forelse($classes as $class)
                    <button 
                        wire:click="selectClass({{ $class->id }})"
                        class="w-full text-left p-4 border-2 rounded-lg transition-all {{ $selectedClassId == $class->id ? 'border-purple-600 bg-purple-50' : 'border-gray-200 hover:border-purple-300 hover:bg-gray-50' }}"
                    >
                        <h3 class="font-semibold text-gray-900 mb-1">{{ $class->title }}</h3>
                        <p class="text-sm text-gray-600 mb-2">{{ $class->code }}</p>
                        <div class="flex gap-3 text-xs">
                            <span class="px-2 py-1 bg-blue-100 text-blue-600 rounded">{{ $class->students->count() }} Mahasiswa</span>
                            <span class="px-2 py-1 bg-green-100 text-green-600 rounded">{{ $class->assignments->where('status', 'published')->count() }} Tugas</span>
                        </div>
                    </button>
                    @empty
                    <div class="text-center py-8 text-gray-500">
                        <p>Belum ada kelas</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Grades Content -->
        <div class="lg:col-span-2">
            @if($selectedClassId && $selectedClass)
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800">{{ $selectedClass->title }}</h2>
                        <p class="text-sm text-gray-600">{{ $selectedClass->code }}</p>
                    </div>
                    <button wire:click="clearSelection" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg font-semibold hover:bg-gray-200 transition-colors">
                        ← Kembali
                    </button>
                </div>

                @if($viewMode === 'class')
                <!-- Class View: All Assignments -->
                <div class="space-y-4">
                    @forelse($classGrades as $gradeData)
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-all">
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900 mb-1">{{ $gradeData['assignment_title'] }}</h3>
                                <p class="text-sm text-gray-600">Deadline: {{ \Carbon\Carbon::parse($gradeData['deadline'])->format('d M Y, H:i') }}</p>
                            </div>
                            <button 
                                wire:click="selectAssignment({{ $gradeData['assignment_id'] }})"
                                class="px-4 py-2 bg-purple-100 text-purple-600 rounded-lg font-semibold hover:bg-purple-200 transition-colors"
                            >
                                Lihat Detail
                            </button>
                        </div>
                        <div class="grid grid-cols-3 gap-4 text-sm">
                            <div>
                                <span class="text-gray-600">Total:</span>
                                <span class="font-semibold ml-2">{{ $gradeData['submissions_count'] }}/{{ $gradeData['total_students'] }}</span>
                            </div>
                            <div>
                                <span class="text-gray-600">Dinilai:</span>
                                <span class="font-semibold ml-2 text-green-600">{{ $gradeData['graded_count'] }}</span>
                            </div>
                            <div>
                                <span class="text-gray-600">Rata-rata:</span>
                                <span class="font-semibold ml-2 text-purple-600">{{ $gradeData['avg_score'] }}</span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-12 text-gray-500">
                        <div class="flex justify-center mb-4">
                            <x-heroicon-s-clipboard-document-list class="w-16 h-16 text-gray-400" />
                        </div>
                        <p>Belum ada tugas untuk kelas ini</p>
                    </div>
                    @endforelse
                </div>
                @elseif($viewMode === 'assignment' && $selectedAssignment)
                <!-- Assignment View: All Submissions -->
                <div>
                    <div class="mb-6 p-4 bg-purple-50 rounded-lg">
                        <h3 class="font-semibold text-gray-900 mb-1">{{ $selectedAssignment->title }}</h3>
                        <p class="text-sm text-gray-600">{{ $selectedAssignment->class->title ?? 'N/A' }}</p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 border-b-2 border-gray-200">No</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 border-b-2 border-gray-200">Nama</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 border-b-2 border-gray-200">NIM</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 border-b-2 border-gray-200">Nilai</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 border-b-2 border-gray-200">Dikirim</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 border-b-2 border-gray-200">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($assignmentGrades as $index => $grade)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 border-b border-gray-200 text-gray-700">{{ $index + 1 }}</td>
                                    <td class="px-4 py-3 border-b border-gray-200 font-semibold text-gray-900">{{ $grade['student_name'] }}</td>
                                    <td class="px-4 py-3 border-b border-gray-200 text-gray-700">{{ $grade['student_nim'] }}</td>
                                    <td class="px-4 py-3 border-b border-gray-200">
                                        @if($grade['score'] !== null)
                                            <span class="font-bold text-lg {{ $grade['score'] >= 70 ? 'text-green-600' : ($grade['score'] >= 60 ? 'text-yellow-600' : 'text-red-600') }}">
                                                {{ number_format($grade['score'], 2) }}
                                            </span>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 border-b border-gray-200 text-sm text-gray-600">
                                        {{ \Carbon\Carbon::parse($grade['submitted_at'])->format('d M Y, H:i') }}
                                    </td>
                                    <td class="px-4 py-3 border-b border-gray-200">
                                        @if($grade['score'] !== null)
                                            <span class="px-3 py-1 bg-green-100 text-green-600 rounded-full text-xs font-semibold">Dinilai</span>
                                        @else
                                            <span class="px-3 py-1 bg-orange-100 text-orange-600 rounded-full text-xs font-semibold">Pending</span>
                                        @endif
                                        @if($grade['is_late'])
                                            <span class="px-2 py-1 bg-red-100 text-red-600 rounded-full text-xs font-semibold ml-2">Terlambat</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                                        Belum ada submission untuk tugas ini
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            </div>
            @else
            <div class="bg-white rounded-xl shadow-sm p-12 text-center">
                <div class="flex justify-center mb-4">
                    <x-heroicon-s-chart-bar class="w-16 h-16 text-gray-400" />
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Pilih Kelas</h3>
                <p class="text-gray-600">Pilih kelas dari daftar di sebelah kiri untuk melihat nilai</p>
            </div>
            @endif
        </div>
    </div>
</div>
