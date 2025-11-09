@extends('landing.app')

@section('title', 'EduLearn - Platform E-Learning Mahasiswa')

@section('content')


<!-- Hero Section -->
<section class="mt-20 min-h-screen bg-gradient-to-br from-purple-600 to-purple-800 flex items-center justify-between px-6 lg:px-12 py-8 relative overflow-hidden" id="home">
    <!-- Floating Background Circle -->
    <div class="absolute w-[500px] h-[500px] bg-white/10 rounded-full -top-64 -right-24 animate-float"></div>
    
    <div class="flex-1 text-white z-10 animate-fade-in-up">
        <h1 class="text-5xl md:text-6xl font-bold mb-4">Belajar Tanpa Batas</h1>
        <p class="text-xl md:text-2xl mb-8 opacity-90">
            Platform e-learning modern untuk mahasiswa Indonesia. Akses ribuan materi kuliah, video pembelajaran, dan ujian online kapan saja, di mana saja.
        </p>
        <div class="flex gap-4 flex-wrap">
            <button class="bg-white text-purple-600 px-8 py-4 rounded-full font-semibold hover:-translate-y-1 hover:shadow-xl transition-all duration-300">
                Mulai Belajar
            </button>
            <button class="bg-gradient-to-r from-purple-600 to-purple-800 text-white px-8 py-4 rounded-full font-semibold border-2 border-white hover:-translate-y-1 hover:shadow-xl transition-all duration-300">
                Lihat Demo
            </button>
        </div>
    </div>
    
    <div class="flex-1 hidden lg:flex justify-center items-center animate-fade-in-right">
        <svg class="w-full max-w-lg animate-float" viewBox="0 0 500 400" xmlns="http://www.w3.org/2000/svg">
            <rect x="50" y="50" width="400" height="300" rx="20" fill="white" opacity="0.9"/>
            <rect x="70" y="70" width="150" height="120" rx="10" fill="#667eea" opacity="0.3"/>
            <rect x="240" y="70" width="190" height="60" rx="10" fill="#764ba2" opacity="0.3"/>
            <rect x="240" y="145" width="190" height="45" rx="10" fill="#667eea" opacity="0.2"/>
            <circle cx="250" cy="280" r="40" fill="#667eea" opacity="0.5"/>
            <circle cx="350" cy="280" r="40" fill="#764ba2" opacity="0.5"/>
            <path d="M 100 250 Q 250 200 400 250" stroke="#667eea" stroke-width="3" fill="none" opacity="0.5"/>
        </svg>
    </div>
</section>

<!-- Features Section -->
<section class="py-20 px-6 lg:px-12 bg-gray-50" id="features">
    <h2 class="text-4xl md:text-5xl font-bold text-center mb-12 text-gray-800">Fitur Unggulan</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto">
        <!-- Feature Card 1 -->
        <div class="bg-white p-8 rounded-2xl shadow-md hover:-translate-y-3 hover:shadow-xl transition-all duration-300 cursor-pointer feature-card">
            <div class="w-16 h-16 bg-gradient-to-br from-purple-600 to-purple-800 rounded-xl flex items-center justify-center text-3xl mb-4">
                📚
            </div>
            <h3 class="text-xl font-semibold mb-2 text-gray-800">Materi Lengkap</h3>
            <p class="text-gray-600 leading-relaxed">Akses ribuan materi kuliah dari berbagai jurusan dan mata kuliah yang tersedia 24/7.</p>
        </div>
        
        <!-- Feature Card 2 -->
        <div class="bg-white p-8 rounded-2xl shadow-md hover:-translate-y-3 hover:shadow-xl transition-all duration-300 cursor-pointer feature-card">
            <div class="w-16 h-16 bg-gradient-to-br from-purple-600 to-purple-800 rounded-xl flex items-center justify-center text-3xl mb-4">
                🎥
            </div>
            <h3 class="text-xl font-semibold mb-2 text-gray-800">Video Pembelajaran</h3>
            <p class="text-gray-600 leading-relaxed">Pembelajaran interaktif dengan video berkualitas tinggi dari dosen berpengalaman.</p>
        </div>
        
        <!-- Feature Card 3 -->
        <div class="bg-white p-8 rounded-2xl shadow-md hover:-translate-y-3 hover:shadow-xl transition-all duration-300 cursor-pointer feature-card">
            <div class="w-16 h-16 bg-gradient-to-br from-purple-600 to-purple-800 rounded-xl flex items-center justify-center text-3xl mb-4">
                ✍️
            </div>
            <h3 class="text-xl font-semibold mb-2 text-gray-800">Ujian Online</h3>
            <p class="text-gray-600 leading-relaxed">Sistem ujian online yang terintegrasi dengan penilaian otomatis dan feedback langsung.</p>
        </div>
        
        <!-- Feature Card 4 -->
        <div class="bg-white p-8 rounded-2xl shadow-md hover:-translate-y-3 hover:shadow-xl transition-all duration-300 cursor-pointer feature-card">
            <div class="w-16 h-16 bg-gradient-to-br from-purple-600 to-purple-800 rounded-xl flex items-center justify-center text-3xl mb-4">
                💬
            </div>
            <h3 class="text-xl font-semibold mb-2 text-gray-800">Forum Diskusi</h3>
            <p class="text-gray-600 leading-relaxed">Berkolaborasi dengan mahasiswa lain dan berdiskusi dengan dosen kapan saja.</p>
        </div>
        
        <!-- Feature Card 5 -->
        <div class="bg-white p-8 rounded-2xl shadow-md hover:-translate-y-3 hover:shadow-xl transition-all duration-300 cursor-pointer feature-card">
            <div class="w-16 h-16 bg-gradient-to-br from-purple-600 to-purple-800 rounded-xl flex items-center justify-center text-3xl mb-4">
                📊
            </div>
            <h3 class="text-xl font-semibold mb-2 text-gray-800">Tracking Progress</h3>
            <p class="text-gray-600 leading-relaxed">Pantau perkembangan belajar Anda dengan dashboard analitik yang komprehensif.</p>
        </div>
        
        <!-- Feature Card 6 -->
        <div class="bg-white p-8 rounded-2xl shadow-md hover:-translate-y-3 hover:shadow-xl transition-all duration-300 cursor-pointer feature-card">
            <div class="w-16 h-16 bg-gradient-to-br from-purple-600 to-purple-800 rounded-xl flex items-center justify-center text-3xl mb-4">
                🏆
            </div>
            <h3 class="text-xl font-semibold mb-2 text-gray-800">Sertifikat</h3>
            <p class="text-gray-600 leading-relaxed">Dapatkan sertifikat digital untuk setiap kursus yang berhasil diselesaikan.</p>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-16 px-6 lg:px-12 bg-gradient-to-br from-purple-600 to-purple-800 text-white">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 max-w-7xl mx-auto text-center">
        <div class="stat-item">
            <h2 class="text-5xl md:text-6xl font-bold mb-2">50K+</h2>
            <p class="text-lg md:text-xl opacity-90">Mahasiswa Aktif</p>
        </div>
        <div class="stat-item">
            <h2 class="text-5xl md:text-6xl font-bold mb-2">500+</h2>
            <p class="text-lg md:text-xl opacity-90">Mata Kuliah</p>
        </div>
        <div class="stat-item">
            <h2 class="text-5xl md:text-6xl font-bold mb-2">100+</h2>
            <p class="text-lg md:text-xl opacity-90">Dosen Expert</p>
        </div>
        <div class="stat-item">
            <h2 class="text-5xl md:text-6xl font-bold mb-2">95%</h2>
            <p class="text-lg md:text-xl opacity-90">Tingkat Kepuasan</p>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 px-6 lg:px-12 text-center bg-white">
    <h2 class="text-4xl md:text-5xl font-bold mb-4 text-gray-800">Siap Memulai Perjalanan Belajar?</h2>
    <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
        Bergabunglah dengan ribuan mahasiswa yang sudah merasakan kemudahan belajar dengan EduLearn
    </p>
    <button class="bg-gradient-to-r from-purple-600 to-purple-800 text-white px-12 py-5 rounded-full font-semibold text-lg hover:-translate-y-1 hover:shadow-lg hover:shadow-purple-400/40 transition-all duration-300">
        Daftar Sekarang Gratis
    </button>
</section>

@endsection

@push('styles')
<style>
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }
    
    @keyframes fade-in-up {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes fade-in-right {
        from {
            opacity: 0;
            transform: translateX(50px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    .animate-float {
        animation: float 6s ease-in-out infinite;
    }
    
    .animate-fade-in-up {
        animation: fade-in-up 1s ease;
    }
    
    .animate-fade-in-right {
        animation: fade-in-right 1s ease;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });

        // Navbar scroll effect
        window.addEventListener('scroll', () => {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('shadow-lg');
            } else {
                navbar.classList.remove('shadow-lg');
            }
        });

        // Feature cards animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.feature-card').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(card);
        });
    });
</script>
@endpush