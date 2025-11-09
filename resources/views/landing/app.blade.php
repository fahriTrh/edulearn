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
<body class="bg-gray-50">
    <!-- Navbar -->
<nav class="fixed top-0 w-full bg-white/95 backdrop-blur-md shadow-md z-50 transition-all duration-300" id="navbar">
    <div class="container mx-auto px-6 lg:px-12 py-4 flex justify-between items-center">
        <div class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-purple-800 bg-clip-text text-transparent">
            EduLearn
        </div>
        <ul class="hidden md:flex gap-8 list-none">
            <li><a href="#home" class="text-gray-700 font-medium hover:text-purple-600 transition-colors">Beranda</a></li>
            <li><a href="#features" class="text-gray-700 font-medium hover:text-purple-600 transition-colors">Fitur</a></li>
            <li><a href="#courses" class="text-gray-700 font-medium hover:text-purple-600 transition-colors">Kursus</a></li>
            <li><a href="#about" class="text-gray-700 font-medium hover:text-purple-600 transition-colors">Tentang</a></li>
        </ul>
        <a href="{{ route('login') }}" class="bg-gradient-to-r from-purple-600 to-purple-800 text-white px-6 py-3 rounded-full font-semibold hover:-translate-y-1 hover:shadow-lg hover:shadow-purple-400/40 transition-all duration-300">
            Masuk
        </a>
    </div>
</nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-gray-300 py-8 px-4">
        <div class="max-w-7xl mx-auto text-center">
            <p>&copy; 2024 EduLearn. Platform E-Learning untuk Mahasiswa Indonesia.</p>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>