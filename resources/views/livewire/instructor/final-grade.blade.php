<div>
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Final Grade</h1>
        <p class="text-gray-600">Hitung dan publikasikan nilai akhir</p>
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

        <!-- Final Grades Content -->
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

                <!-- Class Summary -->
                @if($classSummary)
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6 p-4 bg-gray-50 rounded-lg">
                    <div>
                        <div class="text-2xl font-bold text-gray-900">{{ $classSummary['total_students'] }}</div>
                        <div class="text-sm text-gray-600">Total Mahasiswa</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-purple-600">{{ $classSummary['calculated_count'] }}</div>
                        <div class="text-sm text-gray-600">Sudah Dihitung</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-green-600">{{ $classSummary['published_count'] }}</div>
                        <div class="text-sm text-gray-600">Dipublikasikan</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-blue-600">{{ $classSummary['avg_score'] }}</div>
                        <div class="text-sm text-gray-600">Rata-rata</div>
                    </div>
                </div>
                @endif

                <!-- Actions -->
                <div class="flex gap-3 mb-6">
                    <button 
                        wire:click="calculateFinalGrades({{ $selectedClassId }})"
                        wire:confirm="Apakah Anda yakin ingin menghitung ulang nilai akhir? Ini akan memperbarui semua nilai yang sudah ada."
                        class="px-6 py-3 bg-gradient-to-r from-purple-600 to-purple-800 text-white rounded-lg font-semibold hover:opacity-90 transition-opacity"
                    >
                        🔄 Hitung Nilai Akhir
                    </button>
                    @if($classSummary && $classSummary['calculated_count'] > 0)
                        @if($classSummary['is_published'])
                            <button 
                                wire:click="unpublishGrades({{ $selectedClassId }})"
                                wire:confirm="Apakah Anda yakin ingin membatalkan publikasi nilai akhir?"
                                class="px-6 py-3 bg-orange-600 text-white rounded-lg font-semibold hover:bg-orange-700 transition-colors"
                            >
                                📤 Batalkan Publikasi
                            </button>
                        @else
                            <button 
                                wire:click="publishGrades({{ $selectedClassId }})"
                                wire:confirm="Apakah Anda yakin ingin mempublikasikan nilai akhir? Mahasiswa akan dapat melihat nilai mereka."
                                class="px-6 py-3 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition-colors"
                            >
                                📤 Publikasikan Nilai
                            </button>
                        @endif
                    @endif
                </div>

                <!-- Final Grades Table -->
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 border-b-2 border-gray-200">No</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 border-b-2 border-gray-200">Nama</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 border-b-2 border-gray-200">NIM</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 border-b-2 border-gray-200">Nilai Akhir</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 border-b-2 border-gray-200">Huruf</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 border-b-2 border-gray-200">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($finalGrades as $index => $grade)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 border-b border-gray-200 text-gray-700">{{ $index + 1 }}</td>
                                <td class="px-4 py-3 border-b border-gray-200 font-semibold text-gray-900">{{ $grade->user->name ?? 'N/A' }}</td>
                                <td class="px-4 py-3 border-b border-gray-200 text-gray-700">{{ $grade->user->nim ?? 'N/A' }}</td>
                                <td class="px-4 py-3 border-b border-gray-200">
                                    <span class="font-bold text-lg {{ $grade->total_score >= 70 ? 'text-green-600' : ($grade->total_score >= 60 ? 'text-yellow-600' : 'text-red-600') }}">
                                        {{ number_format($grade->total_score, 2) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 border-b border-gray-200">
                                    <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $grade->letter_grade === 'A' ? 'bg-green-100 text-green-600' : ($grade->letter_grade === 'B' ? 'bg-blue-100 text-blue-600' : ($grade->letter_grade === 'C' ? 'bg-yellow-100 text-yellow-600' : 'bg-red-100 text-red-600')) }}">
                                        {{ $grade->letter_grade }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 border-b border-gray-200">
                                    @if($grade->status === 'published')
                                        <span class="px-3 py-1 bg-green-100 text-green-600 rounded-full text-xs font-semibold">Dipublikasikan</span>
                                    @else
                                        <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-semibold">Draft</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                                    Belum ada nilai akhir. Klik "Hitung Nilai Akhir" untuk menghitung.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @else
            <div class="bg-white rounded-xl shadow-sm p-12 text-center">
                <div class="flex justify-center mb-4">
                    <x-heroicon-s-chart-bar class="w-16 h-16 text-gray-400" />
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Pilih Kelas</h3>
                <p class="text-gray-600">Pilih kelas dari daftar di sebelah kiri untuk menghitung nilai akhir</p>
            </div>
            @endif
        </div>
    </div>

    @if(session()->has('success'))
        <script>
            setTimeout(() => {
                showNotification('{{ session('success') }}', 'success');
            }, 100);
        </script>
    @endif
</div>
