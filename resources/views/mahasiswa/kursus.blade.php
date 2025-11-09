@extends('mahasiswa.app')

@section('title', 'Kursus Saya')

@section('content')
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Kursus Saya</h1>
        <p class="text-gray-600">Kelola dan pantau progres pembelajaran Anda</p>
    </div>

    <!-- Stats Summary -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-6">
        <div class="bg-white rounded-xl shadow-sm p-6 text-center hover:-translate-y-1 transition-transform">
            <div class="text-4xl font-bold bg-gradient-to-r from-indigo-600 to-purple-700 bg-clip-text text-transparent mb-2">8</div>
            <div class="text-gray-600 text-sm">Total Kursus</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 text-center hover:-translate-y-1 transition-transform">
            <div class="text-4xl font-bold bg-gradient-to-r from-indigo-600 to-purple-700 bg-clip-text text-transparent mb-2">5</div>
            <div class="text-gray-600 text-sm">Sedang Berjalan</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 text-center hover:-translate-y-1 transition-transform">
            <div class="text-4xl font-bold bg-gradient-to-r from-indigo-600 to-purple-700 bg-clip-text text-transparent mb-2">3</div>
            <div class="text-gray-600 text-sm">Selesai</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 text-center hover:-translate-y-1 transition-transform">
            <div class="text-4xl font-bold bg-gradient-to-r from-indigo-600 to-purple-700 bg-clip-text text-transparent mb-2">65%</div>
            <div class="text-gray-600 text-sm">Rata-rata Progress</div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-xl shadow-sm p-4 mb-6 flex flex-wrap gap-2">
        <button onclick="filterCourses('all', this)" class="filter-tab px-6 py-2 rounded-full font-medium transition-all bg-gradient-to-r from-indigo-600 to-purple-700 text-white">
            Semua
        </button>
        <button onclick="filterCourses('active', this)" class="filter-tab px-6 py-2 rounded-full font-medium transition-all border-2 border-gray-200 text-gray-600 hover:border-indigo-600">
            Sedang Berjalan
        </button>
        <button onclick="filterCourses('completed', this)" class="filter-tab px-6 py-2 rounded-full font-medium transition-all border-2 border-gray-200 text-gray-600 hover:border-indigo-600">
            Selesai
        </button>
    </div>

    <!-- Courses Grid -->
    <div id="coursesGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Course Card 1 -->
        <div class="course-card bg-white rounded-2xl shadow-sm overflow-hidden hover:-translate-y-2 hover:shadow-xl transition-all cursor-pointer" data-status="active">
            <div class="h-36 bg-gradient-to-br from-indigo-600 to-purple-700 flex items-center justify-center text-5xl relative">
                💻
                <span class="absolute top-4 right-4 px-3 py-1 bg-white/90 text-green-600 rounded-full text-xs font-semibold">Aktif</span>
            </div>
            <div class="p-6">
                <span class="inline-block px-3 py-1 bg-indigo-100 text-indigo-600 rounded-full text-xs font-semibold mb-3">Pemrograman</span>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Pemrograman Web Lanjut</h3>
                <div class="flex items-center gap-1 text-gray-600 text-sm mb-4">
                    <span>👨‍🏫</span>
                    <span>Dr. Budi Santoso</span>
                </div>
                <div class="flex gap-4 text-sm text-gray-600 mb-4 pt-4 border-t border-gray-200">
                    <div class="flex items-center gap-1">
                        <span>📄</span> 12 Materi
                    </div>
                    <div class="flex items-center gap-1">
                        <span>⏱️</span> 24 Jam
                    </div>
                    <div class="flex items-center gap-1">
                        <span>👥</span> 45
                    </div>
                </div>
                <div class="mb-4">
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-gray-600">Progress Pembelajaran</span>
                        <span class="font-semibold text-indigo-600">75%</span>
                    </div>
                    <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-indigo-600 to-purple-700 rounded-full transition-all duration-300" style="width: 75%"></div>
                    </div>
                </div>
                <div class="flex gap-2">
                    <button class="flex-1 px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-700 text-white rounded-lg font-semibold hover:-translate-y-1 hover:shadow-lg transition-all">
                        Lanjutkan
                    </button>
                    <button class="px-4 py-2 bg-gray-100 text-indigo-600 rounded-lg font-semibold hover:bg-gray-200 transition-colors">
                        Detail
                    </button>
                </div>
            </div>
        </div>

        <!-- Course Card 2 -->
        <div class="course-card bg-white rounded-2xl shadow-sm overflow-hidden hover:-translate-y-2 hover:shadow-xl transition-all cursor-pointer" data-status="active">
            <div class="h-36 bg-gradient-to-br from-pink-500 to-red-500 flex items-center justify-center text-5xl relative">
                🔢
                <span class="absolute top-4 right-4 px-3 py-1 bg-white/90 text-green-600 rounded-full text-xs font-semibold">Aktif</span>
            </div>
            <div class="p-6">
                <span class="inline-block px-3 py-1 bg-indigo-100 text-indigo-600 rounded-full text-xs font-semibold mb-3">Algoritma</span>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Struktur Data & Algoritma</h3>
                <div class="flex items-center gap-1 text-gray-600 text-sm mb-4">
                    <span>👩‍🏫</span>
                    <span>Prof. Siti Nurhaliza</span>
                </div>
                <div class="flex gap-4 text-sm text-gray-600 mb-4 pt-4 border-t border-gray-200">
                    <div class="flex items-center gap-1">
                        <span>📄</span> 15 Materi
                    </div>
                    <div class="flex items-center gap-1">
                        <span>⏱️</span> 30 Jam
                    </div>
                    <div class="flex items-center gap-1">
                        <span>👥</span> 38
                    </div>
                </div>
                <div class="mb-4">
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-gray-600">Progress Pembelajaran</span>
                        <span class="font-semibold text-indigo-600">60%</span>
                    </div>
                    <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-indigo-600 to-purple-700 rounded-full transition-all duration-300" style="width: 60%"></div>
                    </div>
                </div>
                <div class="flex gap-2">
                    <button class="flex-1 px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-700 text-white rounded-lg font-semibold hover:-translate-y-1 hover:shadow-lg transition-all">
                        Lanjutkan
                    </button>
                    <button class="px-4 py-2 bg-gray-100 text-indigo-600 rounded-lg font-semibold hover:bg-gray-200 transition-colors">
                        Detail
                    </button>
                </div>
            </div>
        </div>

        <!-- Course Card 3 -->
        <div class="course-card bg-white rounded-2xl shadow-sm overflow-hidden hover:-translate-y-2 hover:shadow-xl transition-all cursor-pointer" data-status="active">
            <div class="h-36 bg-gradient-to-br from-blue-400 to-cyan-400 flex items-center justify-center text-5xl relative">
                🎨
                <span class="absolute top-4 right-4 px-3 py-1 bg-white/90 text-green-600 rounded-full text-xs font-semibold">Aktif</span>
            </div>
            <div class="p-6">
                <span class="inline-block px-3 py-1 bg-indigo-100 text-indigo-600 rounded-full text-xs font-semibold mb-3">Design</span>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Desain Interaksi</h3>
                <div class="flex items-center gap-1 text-gray-600 text-sm mb-4">
                    <span>👨‍🏫</span>
                    <span>Andi Wijaya, M.Kom</span>
                </div>
                <div class="flex gap-4 text-sm text-gray-600 mb-4 pt-4 border-t border-gray-200">
                    <div class="flex items-center gap-1">
                        <span>📄</span> 10 Materi
                    </div>
                    <div class="flex items-center gap-1">
                        <span>⏱️</span> 20 Jam
                    </div>
                    <div class="flex items-center gap-1">
                        <span>👥</span> 52
                    </div>
                </div>
                <div class="mb-4">
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-gray-600">Progress Pembelajaran</span>
                        <span class="font-semibold text-indigo-600">45%</span>
                    </div>
                    <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-indigo-600 to-purple-700 rounded-full transition-all duration-300" style="width: 45%"></div>
                    </div>
                </div>
                <div class="flex gap-2">
                    <button class="flex-1 px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-700 text-white rounded-lg font-semibold hover:-translate-y-1 hover:shadow-lg transition-all">
                        Lanjutkan
                    </button>
                    <button class="px-4 py-2 bg-gray-100 text-indigo-600 rounded-lg font-semibold hover:bg-gray-200 transition-colors">
                        Detail
                    </button>
                </div>
            </div>
        </div>

        <!-- Course Card 4 - Completed -->
        <div class="course-card bg-white rounded-2xl shadow-sm overflow-hidden hover:-translate-y-2 hover:shadow-xl transition-all cursor-pointer" data-status="completed">
            <div class="h-36 bg-gradient-to-br from-green-400 to-cyan-400 flex items-center justify-center text-5xl relative">
                🗄️
                <span class="absolute top-4 right-4 px-3 py-1 bg-white/90 text-indigo-600 rounded-full text-xs font-semibold">Selesai</span>
            </div>
            <div class="p-6">
                <span class="inline-block px-3 py-1 bg-indigo-100 text-indigo-600 rounded-full text-xs font-semibold mb-3">Database</span>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Database Management System</h3>
                <div class="flex items-center gap-1 text-gray-600 text-sm mb-4">
                    <span>👨‍🏫</span>
                    <span>Ir. Joko Widodo, M.T</span>
                </div>
                <div class="flex gap-4 text-sm text-gray-600 mb-4 pt-4 border-t border-gray-200">
                    <div class="flex items-center gap-1">
                        <span>📄</span> 14 Materi
                    </div>
                    <div class="flex items-center gap-1">
                        <span>⏱️</span> 28 Jam
                    </div>
                    <div class="flex items-center gap-1">
                        <span>👥</span> 60
                    </div>
                </div>
                <div class="mb-4">
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-gray-600">Progress Pembelajaran</span>
                        <span class="font-semibold text-green-600">100%</span>
                    </div>
                    <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-green-500 to-emerald-500 rounded-full transition-all duration-300" style="width: 100%"></div>
                    </div>
                </div>
                <div class="flex gap-2">
                    <button class="flex-1 px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-700 text-white rounded-lg font-semibold hover:-translate-y-1 hover:shadow-lg transition-all">
                        Lihat Sertifikat
                    </button>
                    <button class="px-4 py-2 bg-gray-100 text-indigo-600 rounded-lg font-semibold hover:bg-gray-200 transition-colors">
                        Review
                    </button>
                </div>
            </div>
        </div>

        <!-- Course Card 5 -->
        <div class="course-card bg-white rounded-2xl shadow-sm overflow-hidden hover:-translate-y-2 hover:shadow-xl transition-all cursor-pointer" data-status="active">
            <div class="h-36 bg-gradient-to-br from-pink-400 to-yellow-400 flex items-center justify-center text-5xl relative">
                🤖
                <span class="absolute top-4 right-4 px-3 py-1 bg-white/90 text-green-600 rounded-full text-xs font-semibold">Aktif</span>
            </div>
            <div class="p-6">
                <span class="inline-block px-3 py-1 bg-indigo-100 text-indigo-600 rounded-full text-xs font-semibold mb-3">AI & ML</span>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Machine Learning Dasar</h3>
                <div class="flex items-center gap-1 text-gray-600 text-sm mb-4">
                    <span>👩‍🏫</span>
                    <span>Dr. Maya Sari, S.Kom</span>
                </div>
                <div class="flex gap-4 text-sm text-gray-600 mb-4 pt-4 border-t border-gray-200">
                    <div class="flex items-center gap-1">
                        <span>📄</span> 16 Materi
                    </div>
                    <div class="flex items-center gap-1">
                        <span>⏱️</span> 32 Jam
                    </div>
                    <div class="flex items-center gap-1">
                        <span>👥</span> 42
                    </div>
                </div>
                <div class="mb-4">
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-gray-600">Progress Pembelajaran</span>
                        <span class="font-semibold text-indigo-600">30%</span>
                    </div>
                    <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-indigo-600 to-purple-700 rounded-full transition-all duration-300" style="width: 30%"></div>
                    </div>
                </div>
                <div class="flex gap-2">
                    <button class="flex-1 px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-700 text-white rounded-lg font-semibold hover:-translate-y-1 hover:shadow-lg transition-all">
                        Lanjutkan
                    </button>
                    <button class="px-4 py-2 bg-gray-100 text-indigo-600 rounded-lg font-semibold hover:bg-gray-200 transition-colors">
                        Detail
                    </button>
                </div>
            </div>
        </div>

        <!-- Course Card 6 -->
        <div class="course-card bg-white rounded-2xl shadow-sm overflow-hidden hover:-translate-y-2 hover:shadow-xl transition-all cursor-pointer" data-status="active">
            <div class="h-36 bg-gradient-to-br from-cyan-500 to-indigo-900 flex items-center justify-center text-5xl relative">
                📱
                <span class="absolute top-4 right-4 px-3 py-1 bg-white/90 text-green-600 rounded-full text-xs font-semibold">Aktif</span>
            </div>
            <div class="p-6">
                <span class="inline-block px-3 py-1 bg-indigo-100 text-indigo-600 rounded-full text-xs font-semibold mb-3">Mobile Dev</span>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Pengembangan Aplikasi Mobile</h3>
                <div class="flex items-center gap-1 text-gray-600 text-sm mb-4">
                    <span>👨‍🏫</span>
                    <span>Rahmat Hidayat, M.T</span>
                </div>
                <div class="flex gap-4 text-sm text-gray-600 mb-4 pt-4 border-t border-gray-200">
                    <div class="flex items-center gap-1">
                        <span>📄</span> 13 Materi
                    </div>
                    <div class="flex items-center gap-1">
                        <span>⏱️</span> 26 Jam
                    </div>
                    <div class="flex items-center gap-1">
                        <span>👥</span> 48
                    </div>
                </div>
                <div class="mb-4">
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-gray-600">Progress Pembelajaran</span>
                        <span class="font-semibold text-indigo-600">55%</span>
                    </div>
                    <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-indigo-600 to-purple-700 rounded-full transition-all duration-300" style="width: 55%"></div>
                    </div>
                </div>
                <div class="flex gap-2">
                    <button class="flex-1 px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-700 text-white rounded-lg font-semibold hover:-translate-y-1 hover:shadow-lg transition-all">
                        Lanjutkan
                    </button>
                    <button class="px-4 py-2 bg-gray-100 text-indigo-600 rounded-lg font-semibold hover:bg-gray-200 transition-colors">
                        Detail
                    </button>
                </div>
            </div>
        </div>

        <!-- Course Card 7 - Completed -->
        <div class="course-card bg-white rounded-2xl shadow-sm overflow-hidden hover:-translate-y-2 hover:shadow-xl transition-all cursor-pointer" data-status="completed">
            <div class="h-36 bg-gradient-to-br from-teal-300 to-pink-200 flex items-center justify-center text-5xl relative">
                🔐
                <span class="absolute top-4 right-4 px-3 py-1 bg-white/90 text-indigo-600 rounded-full text-xs font-semibold">Selesai</span>
            </div>
            <div class="p-6">
                <span class="inline-block px-3 py-1 bg-indigo-100 text-indigo-600 rounded-full text-xs font-semibold mb-3">Security</span>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Keamanan Sistem Informasi</h3>
                <div class="flex items-center gap-1 text-gray-600 text-sm mb-4">
                    <span>👨‍🏫</span>
                    <span>Dr. Agus Salim</span>
                </div>
                <div class="flex gap-4 text-sm text-gray-600 mb-4 pt-4 border-t border-gray-200">
                    <div class="flex items-center gap-1">
                        <span>📄</span> 11 Materi
                    </div>
                    <div class="flex items-center gap-1">
                        <span>⏱️</span> 22 Jam
                    </div>
                    <div class="flex items-center gap-1">
                        <span>👥</span> 35
                    </div>
                </div>
                <div class="mb-4">
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-gray-600">Progress Pembelajaran</span>
                        <span class="font-semibold text-green-600">100%</span>
                    </div>
                    <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-green-500 to-emerald-500 rounded-full transition-all duration-300" style="width: 100%"></div>
                    </div>
                </div>
                <div class="flex gap-2">
                    <button class="flex-1 px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-700 text-white rounded-lg font-semibold hover:-translate-y-1 hover:shadow-lg transition-all">
                        Lihat Sertifikat
                    </button>
                    <button class="px-4 py-2 bg-gray-100 text-indigo-600 rounded-lg font-semibold hover:bg-gray-200 transition-colors">
                        Review
                    </button>
                </div>
            </div>
        </div>

        <!-- Course Card 8 - Completed -->
        <div class="course-card bg-white rounded-2xl shadow-sm overflow-hidden hover:-translate-y-2 hover:shadow-xl transition-all cursor-pointer" data-status="completed">
            <div class="h-36 bg-gradient-to-br from-pink-300 to-purple-200 flex items-center justify-center text-5xl relative">
                🌐
                <span class="absolute top-4 right-4 px-3 py-1 bg-white/90 text-indigo-600 rounded-full text-xs font-semibold">Selesai</span>
            </div>
            <div class="p-6">
                <span class="inline-block px-3 py-1 bg-indigo-100 text-indigo-600 rounded-full text-xs font-semibold mb-3">Networking</span>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Jaringan Komputer</h3>
                <div class="flex items-center gap-1 text-gray-600 text-sm mb-4">
                    <span>👨‍🏫</span>
                    <span>Drs. Herman Wijaya</span>
                </div>
                <div class="flex gap-4 text-sm text-gray-600 mb-4 pt-4 border-t border-gray-200">
                    <div class="flex items-center gap-1">
                        <span>📄</span> 12 Materi
                    </div>
                    <div class="flex items-center gap-1">
                        <span>⏱️</span> 24 Jam
                    </div>
                    <div class="flex items-center gap-1">
                        <span>👥</span> 50
                    </div>
                </div>
                <div class="mb-4">
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-gray-600">Progress Pembelajaran</span>
                        <span class="font-semibold text-green-600">100%</span>
                    </div>
                    <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-green-500 to-emerald-500 rounded-full transition-all duration-300" style="width: 100%"></div>
                    </div>
                </div>
                <div class="flex gap-2">
                    <button class="flex-1 px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-700 text-white rounded-lg font-semibold hover:-translate-y-1 hover:shadow-lg transition-all">
                        Lihat Sertifikat
                    </button>
                    <button class="px-4 py-2 bg-gray-100 text-indigo-600 rounded-lg font-semibold hover:bg-gray-200 transition-colors">
                        Review
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function filterCourses(status, button) {
        const cards = document.querySelectorAll('.course-card');
        const tabs = document.querySelectorAll('.filter-tab');
        
        // Update active state
        tabs.forEach(tab => {
            tab.classList.remove('bg-gradient-to-r', 'from-indigo-600', 'to-purple-700', 'text-white');
            tab.classList.add('border-2', 'border-gray-200', 'text-gray-600');
        });
        
        button.classList.remove('border-2', 'border-gray-200', 'text-gray-600');
        button.classList.add('bg-gradient-to-r', 'from-indigo-600', 'to-purple-700', 'text-white');
        
        // Filter courses
        cards.forEach(card => {
            if (status === 'all' || card.dataset.status === status) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }
</script>
@endpush