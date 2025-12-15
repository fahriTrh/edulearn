<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'E-Learning - Platform Modern untuk Mahasiswa Indonesia')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50 text-gray-900 selection:bg-purple-500 selection:text-white">
    <!-- Navbar -->
    <div class="fixed top-0 w-full z-50 px-6 py-6 flex justify-center">
        <nav class="w-full max-w-5xl bg-white/80 backdrop-blur-xl border border-white/20 shadow-2xl shadow-purple-500/5 rounded-full px-6 py-3 flex justify-between items-center transition-all duration-300" id="navbar">
            <!-- Logo -->
            <a href="#" class="flex items-center gap-2 group">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-purple-600 to-fuchsia-500 flex items-center justify-center text-white font-bold text-lg shadow-lg shadow-purple-500/30 group-hover:shadow-purple-500/50 transition-all">
                    E
                </div>
                <span class="text-xl font-bold bg-gradient-to-r from-purple-700 to-purple-500 bg-clip-text text-transparent">
                    EduLearn
                </span>
            </a>

            <!-- Desktop Menu -->
            <ul class="hidden md:flex gap-8 list-none">
                <li><a href="#home" class="text-sm font-medium text-gray-600 hover:text-purple-600 transition-all">Beranda</a></li>
                <li><a href="#features" class="text-sm font-medium text-gray-600 hover:text-purple-600 transition-all">Fitur</a></li>
                <li><a href="#courses" class="text-sm font-medium text-gray-600 hover:text-purple-600 transition-all">Kursus</a></li>
                <li><a href="#about" class="text-sm font-medium text-gray-600 hover:text-purple-600 transition-all">Tentang</a></li>
            </ul>

            <!-- Auth Button -->
            <a href="{{ route('login') }}" class="relative group overflow-hidden bg-purple-600 text-white px-6 py-2 rounded-full font-bold text-sm transition-all hover:bg-purple-700 hover:shadow-lg hover:shadow-purple-500/30">
                <span class="relative z-10">Masuk</span>
            </a>
        </nav>
    </div>

    <!-- Main Content -->
    <main class="relative z-10">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="border-t border-gray-200 bg-white py-12 px-6">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex flex-col items-center md:items-start gap-2">
                 <div class="flex items-center gap-2">
                    <div class="w-6 h-6 rounded bg-gradient-to-tr from-purple-600 to-fuchsia-500 flex items-center justify-center text-white font-bold text-xs">
                        E
                    </div>
                    <span class="text-lg font-bold text-gray-900">EduLearn</span>
                </div>
                <p class="text-gray-500 text-sm">Platform E-Learning Masa Depan.</p>
            </div>
            <p class="text-gray-500 text-sm">&copy; 2024 EduLearn. Dibuat dengan 💜 untuk Mahasiswa.</p>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>