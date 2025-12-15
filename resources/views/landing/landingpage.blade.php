@extends('landing.app')

@section('title', 'EduLearn - Media Pembelajaran Daring')

@section('content')

<!-- Hero Section -->
<section class="min-h-screen flex items-center justify-center relative overflow-hidden pt-32 pb-20 px-6" id="home">
    <!-- Background Effects (Light Mode) -->
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[1000px] h-[600px] bg-purple-200/50 rounded-full blur-[120px] -z-10 animate-pulse-slow"></div>
    <div class="absolute bottom-0 right-0 w-[800px] h-[600px] bg-fuchsia-200/40 rounded-full blur-[100px] -z-10"></div>
    
    <div class="max-w-4xl mx-auto text-center z-10">
        <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight text-gray-900 animate-fade-in-up">
            Media Pembelajaran Daring <br>
            <span class="text-purple-600">
                EduLearn
            </span>
        </h1>
        
        <p class="text-xl text-gray-600 mb-10 max-w-2xl mx-auto leading-relaxed animate-fade-in-up delay-200">
            Platform e-learning untuk mendukung kegiatan belajar mengajar yang efektif, efisien, dan terstruktur.
        </p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center animate-fade-in-up delay-300">
            <a href="{{ route('login') }}" class="px-8 py-4 rounded-full bg-purple-600 text-white font-bold hover:bg-purple-700 transition-all hover:scale-105 active:scale-95 shadow-xl shadow-purple-600/20">
                Masuk ke Portal
            </a>
        </div>
    </div>
</section>

<!-- Features Grid -->
<section class="py-24 px-6 relative" id="features">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold mb-4 text-gray-900">Fitur Utama</h2>
            <p class="text-gray-500 max-w-2xl mx-auto">Mendukung aktivitas akademik dosen dan mahasiswa.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Feature 1 -->
            <div class="rounded-3xl p-8 bg-white border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-lg transition-all group">
                <div class="w-12 h-12 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center text-2xl mb-6">
                    📚
                </div>
                <h3 class="text-xl font-bold mb-2 text-gray-900">Manajemen Kelas</h3>
                <p class="text-gray-500 leading-relaxed">Pengelolaan data kelas, materi, dan peserta didik yang terintegrasi dalam satu sistem.</p>
            </div>

            <!-- Feature 2 -->
            <div class="rounded-3xl p-8 bg-white border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-lg transition-all group">
                 <div class="w-12 h-12 rounded-xl bg-pink-100 text-pink-600 flex items-center justify-center text-2xl mb-6">
                    📝
                </div>
                <h3 class="text-xl font-bold mb-2 text-gray-900">Tugas & Evaluasi</h3>
                <p class="text-gray-500 text-sm">Distribusi tugas dan pelaksanaan evaluasi pembelajaran secara daring dan terstruktur.</p>
            </div>

            <!-- Feature 3 -->
            <div class="rounded-3xl p-8 bg-white border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-lg transition-all group">
                <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center text-2xl mb-6">
                    📊
                </div>
                <h3 class="text-xl font-bold mb-2 text-gray-900">Monitoring Aktivitas</h3>
                <p class="text-gray-500 text-sm">Pemantauan keaktifan dan perkembangan belajar mahasiswa melalui dashboard.</p>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<section class="py-12 border-t border-gray-200 bg-gray-50/50">
    <div class="max-w-7xl mx-auto px-6 text-center">
        <p class="text-gray-500">&copy; {{ date('Y') }} EduLearn. All rights reserved.</p>
    </div>
</section>

@endsection

@push('styles')
<style>
    @keyframes fade-in-up {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .animate-fade-in-up { animation: fade-in-up 1s ease forwards; }
    .animate-pulse-slow { animation: pulse 8s cubic-bezier(0.4, 0, 0.6, 1) infinite; }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Navbar scroll effect
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 20) {
                navbar.classList.add('bg-white/90', 'shadow-md', 'backdrop-blur-xl');
                navbar.classList.remove('bg-white/80', 'border-white/20');
            } else {
                navbar.classList.remove('bg-white/90', 'shadow-md', 'backdrop-blur-xl');
                navbar.classList.add('bg-white/80', 'border-white/20');
            }
        });
    });
</script>
@endpush
