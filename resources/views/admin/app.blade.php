<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Admin Panel' }} - EduLearn</title>
    
    {{-- Memuat aset yang di-compile oleh Vite, sama seperti dosen.app --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- Stack untuk style spesifik halaman --}}
    @stack('styles')
</head>
<body class="bg-gray-50 text-gray-900 antialiased">
    <div class="flex min-h-screen">
        
        <aside class="w-64 bg-gradient-to-br from-purple-600 to-purple-800 text-white fixed h-screen overflow-y-auto transition-all duration-300 z-30 -translate-x-full lg:translate-x-0" id="sidebar">
            <div class="px-6 py-8 border-b border-white/20">
                <h1 class="text-3xl font-bold">EduLearn</h1>
                <span class="inline-block mt-2 px-3 py-1 bg-white/20 rounded-full text-xs font-semibold">
                    🔐 Admin Panel
                </span>
            </div>
        
            <nav class="py-8">
                <a href="/dashboard-admin" 
                   class="flex items-center gap-4 px-6 py-4 border-l-4 transition-all duration-300 {{ Request::is('dashboard-admin') ? 'bg-white/15 border-white' : 'border-transparent hover:bg-white/10 hover:border-white' }}">
                    <span class="text-2xl">📊</span>
                    <span class="font-medium">Dashboard</span>
                </a>
        
                <a href="/kelola-mahasiswa" 
                   class="flex items-center gap-4 px-6 py-4 border-l-4 transition-all duration-300 {{ Request::is('kelola-mahasiswa') ? 'bg-white/15 border-white' : 'border-transparent hover:bg-white/10 hover:border-white' }}">
                    <span class="text-2xl">👥</span>
                    <span class="font-medium">Kelola Mahasiswa</span>
                </a>
        
                <a href="/kelola-instruktur" 
                   class="flex items-center gap-4 px-6 py-4 border-l-4 transition-all duration-300 {{ Request::is('kelola-instruktur') ? 'bg-white/15 border-white' : 'border-transparent hover:bg-white/10 hover:border-white' }}">
                    <span class="text-2xl">👨‍🏫</span>
                    <span class="font-medium">Kelola Instruktur</span>
                </a>
        
                <button onclick="handleLogout()" class="w-full flex items-center gap-4 px-6 py-4 border-l-4 border-transparent hover:bg-white/10 hover:border-white transition-all duration-300">
                    <span class="text-2xl">🚪</span>
                    <span class="font-medium">Logout</span>
                </button>
            </nav>
        </aside>
        
        <div class="fixed inset-0 bg-black/50 z-20 lg:hidden hidden" id="sidebar-overlay"></div>

        <div class="flex-1 ml-0 lg:ml-64 transition-all duration-300">
            
            <header class="bg-white shadow-sm sticky top-0 z-10">
                <div class="flex items-center justify-between px-4 py-4 lg:px-8 flex-wrap gap-4">
                    <div class="flex items-center gap-4 flex-1">
                        <button class="lg:hidden text-gray-600 hover:text-gray-900" id="mobile-menu-btn">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>

                        <div>
                            <h2 class="text-xl md:text-2xl font-bold text-gray-800">{{ $title ?? 'Admin Panel' }}</h2>
                            <p class="text-sm text-gray-600 mt-1">{{ $sub_title ?? 'Selamat datang, Admin!' }}</p>
                        </div>
                    </div>
            
                    <div class="flex items-center gap-3 lg:gap-4">
                        <div class="relative">
                            <button class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center hover:bg-gray-200 transition-colors">
                                <span>🔔</span>
                            </button>
                            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                        </div>
            
                        <div class="flex items-center gap-3">
                            <div id="userAvatar" class="w-10 h-10 bg-gradient-to-br from-purple-600 to-purple-800 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                AD
                            </div>
                            <div class="hidden md:block">
                                <div class="font-semibold text-sm">{{ $admin_name ?? 'Admin' }}</div>
                                <div class="text-xs text-gray-600">Administrator</div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <main class="p-4 lg:p-8">
                @yield('content')
            </main>
        </div>
    </div>

    <form id="logoutForm" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>

    <div id="toast-container" class="fixed top-5 right-5 z-50 space-y-3"></div>

    {{-- Script konsisten yang diambil dari dosen.app --}}
    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-btn')?.addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        });

        // Close sidebar when clicking overlay
        document.getElementById('sidebar-overlay')?.addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.add('-translate-x-full');
            this.classList.add('hidden');
        });

        // Handle logout
        function handleLogout() {
            if (confirm('Apakah Anda yakin ingin logout?')) {
                document.getElementById('logoutForm').submit();
            }
        }

        // Generate user initials
        document.addEventListener('DOMContentLoaded', function() {
            // Menggunakan variabel $admin_name
            const userName = "{{ $admin_name ?? 'Admin' }}"; 
            const avatarElement = document.getElementById('userAvatar');

            function getInitials(name) {
                if (!name) return 'AD';

                const words = name.trim().split(' ');
                let initials = '';

                if (words.length >= 2) {
                    initials = words[0].charAt(0) + words[words.length - 1].charAt(0);
                } else {
                    initials = name.substring(0, 2);
                }

                return initials.toUpperCase();
            }

            if (avatarElement) {
                avatarElement.textContent = getInitials(userName);
            }
        });

        // Toast notification function
        function showNotification(message, type = 'info') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            
            const bgColors = {
                success: 'bg-green-500',
                error: 'bg-red-500',
                warning: 'bg-orange-500',
                info: 'bg-purple-600'
            };

            const icons = {
                success: '✓',
                error: '✕',
                warning: '⚠',
                info: 'ℹ'
            };

            toast.className = `${bgColors[type]} text-white px-6 py-4 rounded-lg shadow-lg flex items-center gap-3 animate-slide-in max-w-md`;
            toast.innerHTML = `
                <span class="text-xl font-bold">${icons[type]}</span>
                <span class="flex-1">${message}</span>
                <button onclick="this.parentElement.remove()" class="text-white/80 hover:text-white text-xl font-bold">×</button>
            `;
            
            container.appendChild(toast);
            
            setTimeout(() => {
                toast.style.animation = 'slide-out 0.3s ease';
                setTimeout(() => toast.remove(), 300);
            }, 5000);
        }

        // Make showNotification globally available
        window.showNotification = showNotification;
    </script>

    @stack('scripts')

    {{-- Style untuk animasi toast (Identik dengan dosen.app) --}}
    <style>
        @keyframes slide-in {
            from {
                transform: translateX(400px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        @keyframes slide-out {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(400px);
                opacity: 0;
            }
        }
        
        .animate-slide-in {
            animation: slide-in 0.3s ease;
        }
    </style>
</body>
</html>