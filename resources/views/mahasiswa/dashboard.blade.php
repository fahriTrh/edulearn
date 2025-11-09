@extends('mahasiswa.app')

@section('title', 'Dashboard')

@section('content')
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Stat Card 1 -->
        <div class="bg-white rounded-xl shadow-sm p-6 hover:-translate-y-1 hover:shadow-md transition-all">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-indigo-100 rounded-xl flex items-center justify-center text-2xl">
                    📚
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">8</h3>
                    <p class="text-gray-600 text-sm">Kursus Aktif</p>
                </div>
            </div>
        </div>

        <!-- Stat Card 2 -->
        <div class="bg-white rounded-xl shadow-sm p-6 hover:-translate-y-1 hover:shadow-md transition-all">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center text-2xl">
                    ✅
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">24</h3>
                    <p class="text-gray-600 text-sm">Tugas Selesai</p>
                </div>
            </div>
        </div>

        <!-- Stat Card 3 -->
        <div class="bg-white rounded-xl shadow-sm p-6 hover:-translate-y-1 hover:shadow-md transition-all">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-orange-100 rounded-xl flex items-center justify-center text-2xl">
                    ⏰
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">3</h3>
                    <p class="text-gray-600 text-sm">Tugas Pending</p>
                </div>
            </div>
        </div>

        <!-- Stat Card 4 -->
        <div class="bg-white rounded-xl shadow-sm p-6 hover:-translate-y-1 hover:shadow-md transition-all">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-red-100 rounded-xl flex items-center justify-center text-2xl">
                    🎯
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">85.5</h3>
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
                <a href="#" class="text-indigo-600 text-sm font-semibold hover:underline">Lihat Semua →</a>
            </div>

            <div class="space-y-4">
                <!-- Course Card 1 -->
                <div class="flex gap-4 p-4 border border-gray-200 rounded-xl hover:border-indigo-600 hover:shadow-md transition-all cursor-pointer">
                    <div class="w-20 h-20 bg-gradient-to-br from-indigo-600 to-purple-700 rounded-lg flex items-center justify-center text-3xl flex-shrink-0">
                        💻
                    </div>
                    <div class="flex-1">
                        <h3 class="font-semibold text-gray-900 mb-1">Pemrograman Web Lanjut</h3>
                        <p class="text-gray-600 text-sm mb-3">Dosen: Dr. Budi Santoso • 12 Materi</p>
                        <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-indigo-600 to-purple-700 rounded-full transition-all duration-300" style="width: 75%"></div>
                        </div>
                        <p class="text-indigo-600 text-sm font-medium mt-2">75% selesai</p>
                    </div>
                </div>

                <!-- Course Card 2 -->
                <div class="flex gap-4 p-4 border border-gray-200 rounded-xl hover:border-indigo-600 hover:shadow-md transition-all cursor-pointer">
                    <div class="w-20 h-20 bg-gradient-to-br from-indigo-600 to-purple-700 rounded-lg flex items-center justify-center text-3xl flex-shrink-0">
                        🔢
                    </div>
                    <div class="flex-1">
                        <h3 class="font-semibold text-gray-900 mb-1">Struktur Data & Algoritma</h3>
                        <p class="text-gray-600 text-sm mb-3">Dosen: Prof. Siti Nurhaliza • 15 Materi</p>
                        <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-indigo-600 to-purple-700 rounded-full transition-all duration-300" style="width: 60%"></div>
                        </div>
                        <p class="text-indigo-600 text-sm font-medium mt-2">60% selesai</p>
                    </div>
                </div>

                <!-- Course Card 3 -->
                <div class="flex gap-4 p-4 border border-gray-200 rounded-xl hover:border-indigo-600 hover:shadow-md transition-all cursor-pointer">
                    <div class="w-20 h-20 bg-gradient-to-br from-indigo-600 to-purple-700 rounded-lg flex items-center justify-center text-3xl flex-shrink-0">
                        🎨
                    </div>
                    <div class="flex-1">
                        <h3 class="font-semibold text-gray-900 mb-1">Desain Interaksi</h3>
                        <p class="text-gray-600 text-sm mb-3">Dosen: Andi Wijaya, M.Kom • 10 Materi</p>
                        <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-indigo-600 to-purple-700 rounded-full transition-all duration-300" style="width: 45%"></div>
                        </div>
                        <p class="text-indigo-600 text-sm font-medium mt-2">45% selesai</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Schedule & Assignments -->
        <div class="space-y-6">
            <!-- Schedule -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Jadwal Hari Ini</h2>

                <div class="space-y-4">
                    <div class="border-l-4 border-indigo-600 bg-gray-50 rounded-lg p-4">
                        <div class="text-indigo-600 font-semibold text-sm mb-1">08:00 - 10:00</div>
                        <h4 class="font-semibold text-gray-900 mb-1">Pemrograman Web Lanjut</h4>
                        <p class="text-gray-600 text-sm">Lab Komputer 3 • Online</p>
                    </div>

                    <div class="border-l-4 border-indigo-600 bg-gray-50 rounded-lg p-4">
                        <div class="text-indigo-600 font-semibold text-sm mb-1">10:30 - 12:00</div>
                        <h4 class="font-semibold text-gray-900 mb-1">Struktur Data</h4>
                        <p class="text-gray-600 text-sm">Ruang A301 • Offline</p>
                    </div>

                    <div class="border-l-4 border-indigo-600 bg-gray-50 rounded-lg p-4">
                        <div class="text-indigo-600 font-semibold text-sm mb-1">13:00 - 15:00</div>
                        <h4 class="font-semibold text-gray-900 mb-1">Desain Interaksi</h4>
                        <p class="text-gray-600 text-sm">Studio Design • Hybrid</p>
                    </div>
                </div>
            </div>

            <!-- Assignments -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Tugas Mendatang</h2>

                <div class="space-y-4">
                    <div class="p-4 border border-gray-200 rounded-lg">
                        <h4 class="font-semibold text-gray-900 mb-2">Project Website E-Commerce</h4>
                        <div class="flex items-center justify-between">
                            <p class="text-red-500 text-sm font-semibold">⏰ Deadline: 2 hari lagi</p>
                            <span class="px-3 py-1 bg-orange-100 text-orange-600 rounded-full text-xs font-semibold">Pending</span>
                        </div>
                    </div>

                    <div class="p-4 border border-gray-200 rounded-lg">
                        <h4 class="font-semibold text-gray-900 mb-2">Analisis Algoritma Sorting</h4>
                        <div class="flex items-center justify-between">
                            <p class="text-red-500 text-sm font-semibold">⏰ Deadline: 5 hari lagi</p>
                            <span class="px-3 py-1 bg-orange-100 text-orange-600 rounded-full text-xs font-semibold">Pending</span>
                        </div>
                    </div>

                    <div class="p-4 border border-gray-200 rounded-lg">
                        <h4 class="font-semibold text-gray-900 mb-2">Quiz Database Management</h4>
                        <div class="flex items-center justify-between">
                            <p class="text-green-500 text-sm font-semibold">✓ Diserahkan</p>
                            <span class="px-3 py-1 bg-green-100 text-green-600 rounded-full text-xs font-semibold">Selesai</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection