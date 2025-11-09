@extends('dosen.app')

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
                <h3 class="text-2xl font-bold text-gray-900">{{ count($instructor_class) }}</h3>
                <p class="text-gray-600 text-sm">Kelas Aktif</p>
            </div>
        </div>
    </div>

    <!-- Stat Card 2 -->
    <div class="bg-white rounded-xl shadow-sm p-6 hover:-translate-y-1 hover:shadow-md transition-all">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center text-2xl">
                👥
            </div>
            <div>
                <h3 class="text-2xl font-bold text-gray-900">{{ $total_mahasiswa }}</h3>
                <p class="text-gray-600 text-sm">Total Mahasiswa</p>
            </div>
        </div>
    </div>

    <!-- Stat Card 3 -->
    <div class="bg-white rounded-xl shadow-sm p-6 hover:-translate-y-1 hover:shadow-md transition-all">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 bg-orange-100 rounded-xl flex items-center justify-center text-2xl">
                ✍️
            </div>
            <div>
                <h3 class="text-2xl font-bold text-gray-900">{{ count($assignments) }}</h3>
                <p class="text-gray-600 text-sm">Tugas</p>
            </div>
        </div>
    </div>

    <!-- Stat Card 4 -->
    <div class="bg-white rounded-xl shadow-sm p-6 hover:-translate-y-1 hover:shadow-md transition-all">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center text-2xl">
                📄
            </div>
            <div>
                <h3 class="text-2xl font-bold text-gray-900">{{ count($materials) }}</h3>
                <p class="text-gray-600 text-sm">Materi Diunggah</p>
            </div>
        </div>
    </div>
</div>

<!-- Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Classes List -->
    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-900">Kelas yang Saya Ajar</h2>
            <a href="{{ route('dosen.kelas') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-purple-600 to-purple-800 text-white rounded-lg font-semibold hover:opacity-90 transition-opacity text-sm">
                <span>➕</span>
                <span>Tambah Kelas</span>
            </a>
        </div>

        <div class="space-y-4">
            @forelse($instructor_class as $class)
            <!-- Class Card -->
            <div class="flex gap-4 p-4 border border-gray-200 rounded-xl hover:border-purple-600 hover:shadow-md transition-all cursor-pointer">
                <div class="w-20 h-20 bg-gradient-to-br from-purple-600 to-purple-800 rounded-lg flex items-center justify-center text-3xl flex-shrink-0">
                    📚
                </div>
                <div class="flex-1">
                    <h3 class="font-semibold text-gray-900 mb-1">{{ $class->title }}</h3>
                    <p class="text-gray-600 text-sm mb-3">{{ $class->code }}</p>
                    <div class="flex flex-wrap gap-4 text-sm text-gray-600">
                        <span class="flex items-center gap-1">
                            <span>👥</span>
                            <span>{{ count($class->students) }} mahasiswa</span>
                        </span>
                        <span class="flex items-center gap-1">
                            <span>📄</span>
                            <span>{{ count($class->materials) }} materi</span>
                        </span>
                        <span class="flex items-center gap-1">
                            <span>✍️</span>
                            <span>{{ count($class->assignments) }} tugas</span>
                        </span>
                    </div>
                </div>
                <div class="flex items-center">
                    <a href="{{ route('dosen.detail-kelas', $class->id) }}" class="px-4 py-2 bg-purple-600 text-white rounded-lg font-semibold hover:bg-purple-700 transition-colors text-sm">
                        Kelola
                    </a>
                </div>
            </div>
            @empty
            <!-- Empty State -->
            <div class="text-center py-12">
                <div class="text-6xl mb-4">📚</div>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Belum Ada Kelas</h3>
                <p class="text-gray-600 mb-4">Mulai dengan menambahkan kelas pertama Anda</p>
                <a href="{{ route('dosen.kelas') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-purple-600 to-purple-800 text-white rounded-lg font-semibold hover:opacity-90 transition-opacity">
                    <span>➕</span>
                    <span>Tambah Kelas</span>
                </a>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Assignments & Quick Stats -->
    <div class="space-y-6">
        <!-- Recent Assignments -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-900">Tugas Terbaru</h2>
                <a href="{{ route('dosen.kelas') }}" class="text-purple-600 text-sm font-semibold hover:underline">Lihat Semua →</a>
            </div>

            <div class="space-y-4">
                @forelse($instructor_class as $class)
                    @foreach($class->assignments->take(3) as $assignment)
                    <div class="p-4 border border-gray-200 rounded-lg hover:border-purple-600 transition-colors">
                        <h4 class="font-semibold text-gray-900 mb-2">{{ $assignment->title }}</h4>
                        <p class="text-gray-600 text-sm mb-2">{{ $class->title }}</p>
                        <div class="flex items-center justify-between">
                            <p class="text-purple-600 text-sm font-semibold">
                                📅 {{ \Carbon\Carbon::parse($assignment->deadline)->format('d M Y H:i') }}
                            </p>
                            <a href="{{ route('dosen.kelas.detail', $class->id) }}" class="px-3 py-1 bg-purple-100 text-purple-600 rounded-lg text-xs font-semibold hover:bg-purple-200 transition-colors">
                                Kelola
                            </a>
                        </div>
                    </div>
                    @endforeach
                @empty
                <div class="text-center py-8">
                    <div class="text-4xl mb-2">✍️</div>
                    <p class="text-gray-600 text-sm">Belum ada tugas</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Aksi Cepat</h2>

            <div class="space-y-3">
                <a href="{{ route('dosen.kelas') }}" class="flex items-center gap-3 p-3 bg-gradient-to-r from-purple-50 to-purple-100 rounded-lg hover:shadow-md transition-all group">
                    <div class="w-10 h-10 bg-purple-600 rounded-lg flex items-center justify-center text-white group-hover:scale-110 transition-transform">
                        ➕
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 text-sm">Tambah Kelas</h4>
                        <p class="text-gray-600 text-xs">Buat kelas baru</p>
                    </div>
                </a>

                <a href="{{ route('dosen.kelas') }}" class="flex items-center gap-3 p-3 bg-gradient-to-r from-blue-50 to-blue-100 rounded-lg hover:shadow-md transition-all group">
                    <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center text-white group-hover:scale-110 transition-transform">
                        📄
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 text-sm">Upload Materi</h4>
                        <p class="text-gray-600 text-xs">Tambah materi baru</p>
                    </div>
                </a>

                <a href="{{ route('dosen.kelas') }}" class="flex items-center gap-3 p-3 bg-gradient-to-r from-green-50 to-green-100 rounded-lg hover:shadow-md transition-all group">
                    <div class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center text-white group-hover:scale-110 transition-transform">
                        ✍️
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 text-sm">Buat Tugas</h4>
                        <p class="text-gray-600 text-xs">Tambah tugas baru</p>
                    </div>
                </a>

                <a href="{{ route('dosen.kelas') }}" class="flex items-center gap-3 p-3 bg-gradient-to-r from-orange-50 to-orange-100 rounded-lg hover:shadow-md transition-all group">
                    <div class="w-10 h-10 bg-orange-600 rounded-lg flex items-center justify-center text-white group-hover:scale-110 transition-transform">
                        📊
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 text-sm">Lihat Nilai</h4>
                        <p class="text-gray-600 text-xs">Kelola penilaian</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Tips Section -->
        <div class="bg-gradient-to-br from-purple-600 to-purple-800 rounded-xl shadow-sm p-6 text-white">
            <div class="flex items-start gap-3 mb-4">
                <div class="text-3xl">💡</div>
                <div>
                    <h3 class="font-bold mb-2">Tips Pengajaran</h3>
                    <p class="text-white/90 text-sm leading-relaxed">
                        Gunakan fitur diskusi untuk meningkatkan interaksi dengan mahasiswa dan berikan feedback konstruktif pada setiap tugas.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Optional: Add any interactive functionality here
    document.addEventListener('DOMContentLoaded', function() {
        // Animation for stats on page load
        const stats = document.querySelectorAll('.stat-card h3');
        stats.forEach((stat, index) => {
            setTimeout(() => {
                stat.style.opacity = '0';
                stat.style.transform = 'translateY(20px)';
                stat.style.transition = 'all 0.5s ease';
                
                setTimeout(() => {
                    stat.style.opacity = '1';
                    stat.style.transform = 'translateY(0)';
                }, 50);
            }, index * 100);
        });
    });
</script>
@endpush