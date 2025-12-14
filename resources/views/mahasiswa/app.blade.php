<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - EduLearn</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900 antialiased">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-linear-to-br from-purple-600 to-purple-800 text-white fixed h-screen overflow-y-auto transition-all duration-300 z-30 -translate-x-full lg:translate-x-0" id="sidebar">
            <!-- Logo Section -->
            <div class="px-6 py-8 border-b border-white/20">
                <h1 class="text-3xl font-bold">EduLearn</h1>
                <span class="inline-flex items-center gap-2 mt-2 px-3 py-1 bg-white/20 rounded-full text-xs font-semibold">
                    <x-heroicon-s-academic-cap class="w-4 h-4" />
                    Mahasiswa
                </span>
            </div>
        
            <!-- Enroll Class Button -->
            <div class="px-6 py-4 border-b border-white/20">
                <button onclick="window.dispatchEvent(new CustomEvent('open-enroll-modal'))" 
                        class="w-full flex items-center justify-center gap-3 px-4 py-3 bg-white/20 hover:bg-white/30 rounded-lg font-semibold transition-all duration-300 border-2 border-white/30 hover:border-white/50">
                    <x-heroicon-s-plus-circle class="w-6 h-6" />
                    <span>Daftar Kelas</span>
                </button>
            </div>
        
            <!-- Navigation Menu -->
            <nav class="py-8">
                <a href="{{ route('mahasiswa.dashboard') }}" wire:navigate class="flex items-center gap-4 px-6 py-4 border-l-4 transition-all duration-300 {{ request()->routeIs('mahasiswa.dashboard') ? 'bg-white/15 border-white' : 'border-transparent hover:bg-white/10 hover:border-white' }}">
                    <x-heroicon-s-squares-2x2 class="w-6 h-6" />
                    <span class="font-medium">Dashboard</span>
                </a>
        
                <a href="{{ route('mahasiswa.kelas') }}" wire:navigate class="flex items-center gap-4 px-6 py-4 border-l-4 transition-all duration-300 {{ request()->routeIs('mahasiswa.kelas') ? 'bg-white/15 border-white' : 'border-transparent hover:bg-white/10 hover:border-white' }}">
                    <x-heroicon-s-academic-cap class="w-6 h-6" />
                    <span class="font-medium">Kursus Saya</span>
                </a>
        
                <a href="{{ route('mahasiswa.tugas') }}" wire:navigate class="flex items-center gap-4 px-6 py-4 border-l-4 transition-all duration-300 {{ request()->routeIs('mahasiswa.tugas') ? 'bg-white/15 border-white' : 'border-transparent hover:bg-white/10 hover:border-white' }}">
                    <x-heroicon-s-document-text class="w-6 h-6" />
                    <span class="font-medium">Tugas</span>
                </a>
        
                <a href="{{ route('mahasiswa.nilai') }}" wire:navigate class="flex items-center gap-4 px-6 py-4 border-l-4 transition-all duration-300 {{ request()->routeIs('mahasiswa.nilai') ? 'bg-white/15 border-white' : 'border-transparent hover:bg-white/10 hover:border-white' }}">
                    <x-heroicon-s-chart-bar class="w-6 h-6" />
                    <span class="font-medium">Nilai</span>
                </a>
        
                <form action="{{ route('logout') }}" method="POST" class="w-full">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-4 px-6 py-4 border-l-4 transition-all duration-300 border-transparent hover:bg-white/10 hover:border-white">
                        <x-heroicon-s-arrow-right-on-rectangle class="w-6 h-6" />
                        <span class="font-medium">Logout</span>
                    </button>
                </form>
            </nav>
        </aside>
        
        <!-- Mobile Sidebar Overlay -->
        <div class="fixed inset-0 bg-black/50 z-20 lg:hidden hidden" id="sidebar-overlay"></div>

        <!-- Main Content Wrapper -->
        <div class="flex-1 ml-0 lg:ml-64 transition-all duration-300">
            <!-- Navbar -->
            <header class="bg-white shadow-sm sticky top-0 z-10">
                <div class="flex items-center justify-between px-4 py-4 lg:px-8">
                    <!-- Mobile Menu Button & Search -->
                    <div class="flex items-center gap-4 flex-1">
                        <!-- Hamburger Menu (Mobile) -->
                        <button class="lg:hidden text-gray-600 hover:text-gray-900" id="mobile-menu-btn">
                            <x-heroicon-s-bars-3 class="w-6 h-6" />
                        </button>
                    </div>
            
                    <!-- User Section -->
                    <div class="flex items-center gap-3 lg:gap-4">
                        <!-- Notification Bell -->
                        <div class="relative">
                            <button class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center hover:bg-gray-200 transition-colors">
                                <x-heroicon-s-bell class="w-5 h-5 text-gray-600" />
                            </button>
                            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                        </div>
            
                        <!-- User Info -->
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-linear-to-br from-purple-600 to-purple-800 rounded-full flex items-center justify-center text-white font-bold">
                                {{ strtoupper(substr(Auth::user()->name ?? 'AM', 0, 2)) }}
                            </div>
                            <div class="hidden md:block">
                                <div class="font-semibold text-sm">{{ Auth::user()->name ?? 'Ahmad Maulana' }}</div>
                                <div class="text-xs text-gray-600">Mahasiswa</div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            
            @push('scripts')
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
            </script>
            @endpush

            <!-- Page Content -->
            <main class="p-4 lg:p-8">
                @hasSection('content')
                    @yield('content')
                @else
                    {{ $slot ?? '' }}
                @endif
            </main>
        </div>
    </div>

    <!-- Enrollment Modal (rendered in main content area) -->
    @livewire('student.enroll-class-modal', key('enroll-modal'))

    @push('scripts')
    <script>
        // Listen for custom event to open modal
        window.addEventListener('open-enroll-modal', function() {
            // Find the Livewire component by its container ID
            const componentElement = document.getElementById('enroll-class-modal-component');
            if (componentElement) {
                const wireId = componentElement.getAttribute('wire:id');
                if (wireId) {
                    const component = Livewire.find(wireId);
                    if (component) {
                        component.openModal();
                    }
                }
            }
        });

    </script>
    @endpush

    @stack('scripts')
    @livewireScripts
</body>
</html>