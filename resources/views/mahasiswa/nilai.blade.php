@extends('mahasiswa.app')

@section('title', 'Nilai - EduLearn')

@section('content')
<div class="min-h-screen bg-gray-50 p-4 md:p-8">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Nilai</h1>
        <p class="text-gray-600 text-lg">Pantau pencapaian dan progres belajar Anda di setiap kursus</p>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Card 1 -->
        <div class="bg-white p-6 md:p-8 rounded-xl shadow-sm border-l-4 border-purple-600">
            <div class="text-gray-600 text-sm mb-2">Rata-rata Nilai</div>
            <div class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-purple-600 to-purple-800 bg-clip-text text-transparent mb-2">
                85.5
            </div>
            <div class="text-green-500 text-sm">📊 Dari 8 kursus selesai</div>
        </div>

        <!-- Card 2 -->
        <div class="bg-white p-6 md:p-8 rounded-xl shadow-sm border-l-4 border-purple-600">
            <div class="text-gray-600 text-sm mb-2">Kursus Selesai</div>
            <div class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-purple-600 to-purple-800 bg-clip-text text-transparent mb-2">
                8
            </div>
            <div class="text-green-500 text-sm">✅ Selesai</div>
        </div>

        <!-- Card 3 -->
        <div class="bg-white p-6 md:p-8 rounded-xl shadow-sm border-l-4 border-purple-600">
            <div class="text-gray-600 text-sm mb-2">Kursus Aktif</div>
            <div class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-purple-600 to-purple-800 bg-clip-text text-transparent mb-2">
                5
            </div>
            <div class="text-green-500 text-sm">🎯 Sedang berjalan</div>
        </div>

        <!-- Card 4 -->
        <div class="bg-white p-6 md:p-8 rounded-xl shadow-sm border-l-4 border-purple-600">
            <div class="text-gray-600 text-sm mb-2">Total Jam Belajar</div>
            <div class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-purple-600 to-purple-800 bg-clip-text text-transparent mb-2">
                328
            </div>
            <div class="text-green-500 text-sm">⏱️ Jam pembelajaran</div>
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
                            <th class="px-4 py-4 text-left text-sm font-semibold text-gray-700 border-b-2 border-gray-200">Durasi</th>
                            <th class="px-4 py-4 text-left text-sm font-semibold text-gray-700 border-b-2 border-gray-200">Nilai</th>
                            <th class="px-4 py-4 text-left text-sm font-semibold text-gray-700 border-b-2 border-gray-200">Status</th>
                            <th class="px-4 py-4 text-left text-sm font-semibold text-gray-700 border-b-2 border-gray-200">Instruktur</th>
                            <th class="px-4 py-4 text-left text-sm font-semibold text-gray-700 border-b-2 border-gray-200">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Row 1 -->
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-4 border-b border-gray-200">
                                <div class="font-semibold text-gray-800">Pemrograman Web Lanjut</div>
                                <div class="text-sm text-purple-600 mt-1">💻 Pemrograman</div>
                            </td>
                            <td class="px-4 py-4 border-b border-gray-200 text-gray-700">24 Jam</td>
                            <td class="px-4 py-4 border-b border-gray-200 font-semibold text-lg text-purple-600">88</td>
                            <td class="px-4 py-4 border-b border-gray-200">
                                <span class="inline-block px-4 py-2 rounded-full text-sm font-semibold bg-green-100 text-green-600">Lulus</span>

                            </td>
                            <td class="px-4 py-4 border-b border-gray-200 text-gray-700">Dr. Budi Santoso</td>
                            <td class="px-4 py-4 border-b border-gray-200">
                                <button onclick="toggleBreakdown(1)" class="px-4 py-2 border-2 border-purple-600 text-purple-600 rounded-lg font-semibold hover:bg-purple-600 hover:text-white transition-colors">
                                    Detail
                                </button>
                            </td>
                        </tr>
                        <tr id="breakdown-1" class="hidden">
                            <td colspan="6" class="px-4 py-4 border-b border-gray-200">
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <div class="flex justify-between py-2 border-b border-gray-200">
                                        <span class="text-gray-700">📝 Quiz & Latihan (30%)</span>
                                        <span class="font-semibold text-gray-800">85/100</span>
                                    </div>
                                    <div class="flex justify-between py-2 border-b border-gray-200">
                                        <span class="text-gray-700">📋 Tugas & Project (40%)</span>
                                        <span class="font-semibold text-gray-800">90/100</span>
                                    </div>
                                    <div class="flex justify-between py-2">
                                        <span class="text-gray-700">🎯 Ujian Akhir (30%)</span>
                                        <span class="font-semibold text-gray-800">88/100</span>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- Row 2 -->
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-4 border-b border-gray-200">
                                <div class="font-semibold text-gray-800">Struktur Data & Algoritma</div>
                                <div class="text-sm text-purple-600 mt-1">🔢 Algoritma</div>
                            </td>
                            <td class="px-4 py-4 border-b border-gray-200 text-gray-700">30 Jam</td>
                            <td class="px-4 py-4 border-b border-gray-200 font-semibold text-lg text-purple-600">85</td>
                            <td class="px-4 py-4 border-b border-gray-200">
                                <span class="inline-block px-4 py-2 rounded-full text-sm font-semibold bg-green-100 text-green-600">Lulus</span>
                            </td>
                            <td class="px-4 py-4 border-b border-gray-200 text-gray-700">Prof. Siti Nurhaliza</td>
                            <td class="px-4 py-4 border-b border-gray-200">
                                <button onclick="toggleBreakdown(2)" class="px-4 py-2 border-2 border-purple-600 text-purple-600 rounded-lg font-semibold hover:bg-purple-600 hover:text-white transition-colors">
                                    Detail
                                </button>
                            </td>
                        </tr>
                        <tr id="breakdown-2" class="hidden">
                            <td colspan="6" class="px-4 py-4 border-b border-gray-200">
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <div class="flex justify-between py-2 border-b border-gray-200">
                                        <span class="text-gray-700">📝 Quiz & Latihan (30%)</span>
                                        <span class="font-semibold text-gray-800">82/100</span>
                                    </div>
                                    <div class="flex justify-between py-2 border-b border-gray-200">
                                        <span class="text-gray-700">📋 Tugas & Project (40%)</span>
                                        <span class="font-semibold text-gray-800">88/100</span>
                                    </div>
                                    <div class="flex justify-between py-2">
                                        <span class="text-gray-700">🎯 Ujian Akhir (30%)</span>
                                        <span class="font-semibold text-gray-800">85/100</span>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- Row 3 -->
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-4 border-b border-gray-200">
                                <div class="font-semibold text-gray-800">Desain Interaksi</div>
                                <div class="text-sm text-purple-600 mt-1">🎨 Design</div>
                            </td>
                            <td class="px-4 py-4 border-b border-gray-200 text-gray-700">20 Jam</td>
                            <td class="px-4 py-4 border-b border-gray-200 font-semibold text-lg text-purple-600">90</td>
                            <td class="px-4 py-4 border-b border-gray-200">
                                <span class="inline-block px-4 py-2 rounded-full text-sm font-semibold bg-green-100 text-green-600">Lulus</span>
                            </td>
                            <td class="px-4 py-4 border-b border-gray-200 text-gray-700">Andi Wijaya, M.Kom</td>
                            <td class="px-4 py-4 border-b border-gray-200">
                                <button onclick="toggleBreakdown(3)" class="px-4 py-2 border-2 border-purple-600 text-purple-600 rounded-lg font-semibold hover:bg-purple-600 hover:text-white transition-colors">
                                    Detail
                                </button>
                            </td>
                        </tr>
                        <tr id="breakdown-3" class="hidden">
                            <td colspan="6" class="px-4 py-4 border-b border-gray-200">
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <div class="flex justify-between py-2 border-b border-gray-200">
                                        <span class="text-gray-700">📝 Quiz & Latihan (25%)</span>
                                        <span class="font-semibold text-gray-800">88/100</span>
                                    </div>
                                    <div class="flex justify-between py-2 border-b border-gray-200">
                                        <span class="text-gray-700">🎨 Project Design (45%)</span>
                                        <span class="font-semibold text-gray-800">92/100</span>
                                    </div>
                                    <div class="flex justify-between py-2">
                                        <span class="text-gray-700">🎯 Ujian Akhir (30%)</span>
                                        <span class="font-semibold text-gray-800">90/100</span>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- Row 4 -->
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-4 border-b border-gray-200">
                                <div class="font-semibold text-gray-800">Machine Learning Dasar</div>
                                <div class="text-sm text-purple-600 mt-1">🤖 AI & ML</div>
                            </td>
                            <td class="px-4 py-4 border-b border-gray-200 text-gray-700">32 Jam</td>
                            <td class="px-4 py-4 border-b border-gray-200 font-semibold text-lg text-purple-600">82</td>
                            <td class="px-4 py-4 border-b border-gray-200">
                                <span class="inline-block px-4 py-2 rounded-full text-sm font-semibold bg-blue-100 text-blue-600">Lulus</span>
                            </td>
                            <td class="px-4 py-4 border-b border-gray-200 text-gray-700">Dr. Maya Sari</td>
                            <td class="px-4 py-4 border-b border-gray-200">
                                <button onclick="toggleBreakdown(4)" class="px-4 py-2 border-2 border-purple-600 text-purple-600 rounded-lg font-semibold hover:bg-purple-600 hover:text-white transition-colors">
                                    Detail
                                </button>
                            </td>
                        </tr>
                        <tr id="breakdown-4" class="hidden">
                            <td colspan="6" class="px-4 py-4 border-b border-gray-200">
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <div class="flex justify-between py-2 border-b border-gray-200">
                                        <span class="text-gray-700">📝 Quiz & Latihan (30%)</span>
                                        <span class="font-semibold text-gray-800">80/100</span>
                                    </div>
                                    <div class="flex justify-between py-2 border-b border-gray-200">
                                        <span class="text-gray-700">📋 Tugas & Project (40%)</span>
                                        <span class="font-semibold text-gray-800">85/100</span>
                                    </div>
                                    <div class="flex justify-between py-2">
                                        <span class="text-gray-700">🎯 Ujian Akhir (30%)</span>
                                        <span class="font-semibold text-gray-800">80/100</span>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- Row 5 -->
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-4 border-b border-gray-200">
                                <div class="font-semibold text-gray-800">Database Management System</div>
                                <div class="text-sm text-purple-600 mt-1">🗄️ Database</div>
                            </td>
                            <td class="px-4 py-4 border-b border-gray-200 text-gray-700">28 Jam</td>
                            <td class="px-4 py-4 border-b border-gray-200 font-semibold text-lg text-purple-600">-</td>
                            <td class="px-4 py-4 border-b border-gray-200">
                                <span class="inline-block px-4 py-2 rounded-full text-sm font-semibold bg-orange-100 text-orange-600">Berlangsung</span>
                            </td>
                            <td class="px-4 py-4 border-b border-gray-200 text-gray-700">Ir. Joko Widodo</td>
                            <td class="px-4 py-4 border-b border-gray-200">
                                <button onclick="toggleBreakdown(5)" class="px-4 py-2 border-2 border-purple-600 text-purple-600 rounded-lg font-semibold hover:bg-purple-600 hover:text-white transition-colors">
                                    Detail
                                </button>
                            </td>
                        </tr>
                        <tr id="breakdown-5" class="hidden">
                            <td colspan="6" class="px-4 py-4 border-b border-gray-200">
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <div class="flex justify-between py-2 border-b border-gray-200">
                                        <span class="text-gray-700">📝 Quiz & Latihan (30%)</span>
                                        <span class="font-semibold text-gray-800">75/100</span>
                                    </div>
                                    <div class="flex justify-between py-2 border-b border-gray-200">
                                        <span class="text-gray-700">📋 Tugas (40%)</span>
                                        <span class="font-semibold text-gray-800">Belum selesai</span>
                                    </div>
                                    <div class="flex justify-between py-2">
                                        <span class="text-gray-700">🎯 Ujian Akhir (30%)</span>
                                        <span class="font-semibold text-gray-800">Belum tersedia</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Mobile Cards -->
            <div class="lg:hidden space-y-4">
                @foreach([
                    ['name' => 'Pemrograman Web Lanjut', 'category' => '💻 Pemrograman', 'duration' => '24 Jam', 'score' => '88', 'status' => 'Lulus', 'statusClass' => 'bg-green-100 text-green-600', 'hasCertificate' => true, 'instructor' => 'Dr. Budi Santoso', 'id' => 1, 'breakdown' => [['name' => '📝 Quiz & Latihan (30%)', 'score' => '85/100'], ['name' => '📋 Tugas & Project (40%)', 'score' => '90/100'], ['name' => '🎯 Ujian Akhir (30%)', 'score' => '88/100']]],
                    ['name' => 'Struktur Data & Algoritma', 'category' => '🔢 Algoritma', 'duration' => '30 Jam', 'score' => '85', 'status' => 'Lulus', 'statusClass' => 'bg-green-100 text-green-600', 'hasCertificate' => true, 'instructor' => 'Prof. Siti Nurhaliza', 'id' => 2, 'breakdown' => [['name' => '📝 Quiz & Latihan (30%)', 'score' => '82/100'], ['name' => '📋 Tugas & Project (40%)', 'score' => '88/100'], ['name' => '🎯 Ujian Akhir (30%)', 'score' => '85/100']]],
                    ['name' => 'Desain Interaksi', 'category' => '🎨 Design', 'duration' => '20 Jam', 'score' => '90', 'status' => 'Lulus', 'statusClass' => 'bg-green-100 text-green-600', 'hasCertificate' => true, 'instructor' => 'Andi Wijaya, M.Kom', 'id' => 3, 'breakdown' => [['name' => '📝 Quiz & Latihan (25%)', 'score' => '88/100'], ['name' => '🎨 Project Design (45%)', 'score' => '92/100'], ['name' => '🎯 Ujian Akhir (30%)', 'score' => '90/100']]],
                    ['name' => 'Machine Learning Dasar', 'category' => '🤖 AI & ML', 'duration' => '32 Jam', 'score' => '82', 'status' => 'Lulus', 'statusClass' => 'bg-blue-100 text-blue-600', 'hasCertificate' => true, 'instructor' => 'Dr. Maya Sari', 'id' => 4, 'breakdown' => [['name' => '📝 Quiz & Latihan (30%)', 'score' => '80/100'], ['name' => '📋 Tugas & Project (40%)', 'score' => '85/100'], ['name' => '🎯 Ujian Akhir (30%)', 'score' => '80/100']]],
                    ['name' => 'Database Management System', 'category' => '🗄️ Database', 'duration' => '28 Jam', 'score' => '-', 'status' => 'Berlangsung', 'statusClass' => 'bg-orange-100 text-orange-600', 'hasCertificate' => false, 'instructor' => 'Ir. Joko Widodo', 'id' => 5, 'breakdown' => [['name' => '📝 Quiz & Latihan (30%)', 'score' => '75/100'], ['name' => '📋 Tugas (40%)', 'score' => 'Belum selesai'], ['name' => '🎯 Ujian Akhir (30%)', 'score' => 'Belum tersedia']]]
                ] as $course)
                <div class="bg-white border border-gray-200 rounded-lg p-4">
                    <div class="font-semibold text-gray-800 mb-1">{{ $course['name'] }}</div>
                    <div class="text-sm text-purple-600 mb-3">{{ $course['category'] }}</div>
                    
                    <div class="grid grid-cols-2 gap-2 text-sm mb-3">
                        <div>
                            <span class="text-gray-500">Durasi:</span>
                            <span class="font-medium text-gray-700 ml-1">{{ $course['duration'] }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Nilai:</span>
                            <span class="font-semibold text-purple-600 ml-1 text-lg">{{ $course['score'] }}</span>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold {{ $course['statusClass'] }}">{{ $course['status'] }}</span>
                    </div>
                    
                    <div class="text-sm text-gray-600 mb-3">
                        <span class="text-gray-500">Instruktur:</span> {{ $course['instructor'] }}
                    </div>
                    
                    <button onclick="toggleBreakdown({{ $course['id'] }})" class="w-full px-4 py-2 border-2 border-purple-600 text-purple-600 rounded-lg font-semibold hover:bg-purple-600 hover:text-white transition-colors">
                        Lihat Detail
                    </button>
                    
                    <div id="breakdown-{{ $course['id'] }}" class="hidden mt-3 bg-gray-50 p-3 rounded-lg">
                        @foreach($course['breakdown'] as $item)
                        <div class="flex justify-between py-2 {{ !$loop->last ? 'border-b border-gray-200' : '' }}">
                            <span class="text-sm text-gray-700">{{ $item['name'] }}</span>
                            <span class="text-sm font-semibold text-gray-800">{{ $item['score'] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function toggleBreakdown(id) {
        const breakdown = document.getElementById(`breakdown-${id}`);
        breakdown.classList.toggle('hidden');
    }
</script>
@endpush