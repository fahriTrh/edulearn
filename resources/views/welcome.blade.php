<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Learning - Platform Modern untuk Mahasiswa Indonesia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-white shadow-sm fixed w-full top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold text-indigo-600">E-Learning</h1>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#" class="text-gray-700 hover:text-indigo-600 transition">Beranda</a>
                    <a href="#fitur" class="text-gray-700 hover:text-indigo-600 transition">Fitur</a>
                    <a href="#" class="text-gray-700 hover:text-indigo-600 transition">Kursus</a>
                    <a href="#" class="text-gray-700 hover:text-indigo-600 transition">Tentang</a>
                    <a href="/login" class="bg-indigo-600 text-white px-6 py-2 rounded-full hover:bg-indigo-700 transition">
                        Masuk
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-24 pb-20 px-4 bg-gradient-to-br from-indigo-500 via-purple-500 to-purple-600 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-purple-700 rounded-full opacity-30 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-indigo-700 rounded-full opacity-30 blur-3xl"></div>
        
        <div class="max-w-7xl mx-auto relative z-10">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="text-white">
                    <h2 class="text-5xl font-bold mb-6 leading-tight">Belajar Tanpa Batas</h2>
                    <p class="text-lg mb-8 text-indigo-100">
                        Platform e-learning modern untuk mahasiswa Indonesia. Akses ribuan materi kuliah, video pembelajaran, dan ujian online kapan saja, di mana saja.
                    </p>
                    <div class="flex gap-4">
                        <a href="/login" class="bg-white text-indigo-600 px-8 py-3 rounded-full font-semibold hover:bg-gray-100 transition">
                            Mulai Belajar
                        </a>
                    </div>
                </div>
                <div class="hidden md:block">
                    <div class="bg-white bg-opacity-20 backdrop-blur-lg rounded-3xl p-8 shadow-2xl">
                        <div class="space-y-4">
                            <div class="flex gap-4">
                                <div class="bg-indigo-200 rounded-2xl h-24 flex-1"></div>
                                <div class="bg-purple-200 rounded-2xl h-24 w-32"></div>
                            </div>
                            <div class="bg-white bg-opacity-40 rounded-2xl h-16"></div>
                            <div class="flex gap-4 justify-center pt-4">
                                <div class="bg-indigo-400 rounded-full w-20 h-20"></div>
                                <div class="bg-purple-400 rounded-full w-20 h-20"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Fitur Unggulan Section -->
    <section id="fitur" class="py-20 px-4 bg-white">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-4xl font-bold text-center mb-16 text-gray-800">Fitur Unggulan</h2>
            
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white border border-gray-200 rounded-2xl p-8 hover:shadow-xl transition">
                    <div class="bg-indigo-100 w-16 h-16 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800">Materi Lengkap</h3>
                    <p class="text-gray-600">Akses ribuan materi kuliah dari berbagai jurusan dan mata kuliah yang terupdate 24/7.</p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white border border-gray-200 rounded-2xl p-8 hover:shadow-xl transition">
                    <div class="bg-indigo-100 w-16 h-16 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800">Video Pembelajaran</h3>
                    <p class="text-gray-600">Pembelajaran interaktif dengan video berkualitas tinggi dari dosen berpengalaman.</p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white border border-gray-200 rounded-2xl p-8 hover:shadow-xl transition">
                    <div class="bg-indigo-100 w-16 h-16 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800">Ujian Online</h3>
                    <p class="text-gray-600">Sistem ujian online yang terintegrasi dengan penilaian otomatis dan feedback langsung.</p>
                </div>

                <!-- Feature 4 -->
                <div class="bg-white border border-gray-200 rounded-2xl p-8 hover:shadow-xl transition">
                    <div class="bg-indigo-100 w-16 h-16 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800">Forum Diskusi</h3>
                    <p class="text-gray-600">Berkolaborasi dengan mahasiswa lain dan berdiskusi dengan dosen kapan saja.</p>
                </div>

                <!-- Feature 5 -->
                <div class="bg-white border border-gray-200 rounded-2xl p-8 hover:shadow-xl transition">
                    <div class="bg-indigo-100 w-16 h-16 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800">Tracking Progress</h3>
                    <p class="text-gray-600">Pantau perkembangan belajar Anda dengan dashboard analitik yang komprehensif.</p>
                </div>

                <!-- Feature 6 -->
                <div class="bg-white border border-gray-200 rounded-2xl p-8 hover:shadow-xl transition">
                    <div class="bg-indigo-100 w-16 h-16 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800">Sertifikat</h3>
                    <p class="text-gray-600">Dapatkan sertifikat digital untuk setiap kursus yang berhasil diselesaikan.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-20 px-4 bg-gradient-to-br from-indigo-500 via-purple-500 to-purple-600">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-4 gap-8 text-center text-white">
                <div>
                    <div class="text-5xl font-bold mb-2">50K+</div>
                    <div class="text-indigo-100 text-lg">Mahasiswa Aktif</div>
                </div>
                <div>
                    <div class="text-5xl font-bold mb-2">500+</div>
                    <div class="text-indigo-100 text-lg">Mata Kuliah</div>
                </div>
                <div>
                    <div class="text-5xl font-bold mb-2">100+</div>
                    <div class="text-indigo-100 text-lg">Dosen Expert</div>
                </div>
                <div>
                    <div class="text-5xl font-bold mb-2">95%</div>
                    <div class="text-indigo-100 text-lg">Tingkat Kepuasan</div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 px-4 bg-white">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-4xl font-bold mb-6 text-gray-800">Siap Memulai Perjalanan Belajar?</h2>
            <p class="text-xl text-gray-600 mb-8">
                Bergabunglah dengan ribuan mahasiswa yang sudah merasakan kemudahan belajar dengan EduLearn
            </p>
            <button class="bg-indigo-600 text-white px-10 py-4 rounded-full text-lg font-semibold hover:bg-indigo-700 transition shadow-lg hover:shadow-xl">
                Daftar Sekarang Gratis
            </button>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-gray-300 py-8 px-4">
        <div class="max-w-7xl mx-auto text-center">
            <p>&copy; 2024 EduLearn. Platform E-Learning untuk Mahasiswa Indonesia.</p>
        </div>
    </footer>
</body>
</html>