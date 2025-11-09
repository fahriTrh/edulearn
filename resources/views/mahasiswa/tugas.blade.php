@extends('mahasiswa.app')

@section('title', 'Tugas - EduLearn')

@section('content')
<div class="min-h-screen bg-gray-50 p-4 md:p-8">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Tugas Kuliah</h1>
        <p class="text-gray-600 text-lg">Kelola dan selesaikan tugas kuliah Anda</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-8">
        <div class="bg-white p-4 md:p-6 rounded-xl shadow-sm flex items-center gap-4">
            <div class="w-14 h-14 md:w-16 md:h-16 bg-red-100 rounded-xl flex items-center justify-center text-2xl md:text-3xl">
                ⚠️
            </div>
            <div>
                <h3 class="text-2xl md:text-3xl font-bold text-purple-600">2</h3>
                <p class="text-gray-600 text-sm">Mendesak</p>
            </div>
        </div>
        <div class="bg-white p-4 md:p-6 rounded-xl shadow-sm flex items-center gap-4">
            <div class="w-14 h-14 md:w-16 md:h-16 bg-orange-100 rounded-xl flex items-center justify-center text-2xl md:text-3xl">
                ⏰
            </div>
            <div>
                <h3 class="text-2xl md:text-3xl font-bold text-purple-600">5</h3>
                <p class="text-gray-600 text-sm">Pending</p>
            </div>
        </div>
        <div class="bg-white p-4 md:p-6 rounded-xl shadow-sm flex items-center gap-4">
            <div class="w-14 h-14 md:w-16 md:h-16 bg-green-100 rounded-xl flex items-center justify-center text-2xl md:text-3xl">
                ✅
            </div>
            <div>
                <h3 class="text-2xl md:text-3xl font-bold text-purple-600">24</h3>
                <p class="text-gray-600 text-sm">Terkirim</p>
            </div>
        </div>
        <div class="bg-white p-4 md:p-6 rounded-xl shadow-sm flex items-center gap-4">
            <div class="w-14 h-14 md:w-16 md:h-16 bg-blue-100 rounded-xl flex items-center justify-center text-2xl md:text-3xl">
                📊
            </div>
            <div>
                <h3 class="text-2xl md:text-3xl font-bold text-purple-600">18</h3>
                <p class="text-gray-600 text-sm">Dinilai</p>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white p-4 md:p-6 rounded-xl shadow-sm mb-8 flex flex-wrap gap-3">
        <button onclick="filterAssignments('all', this)" class="filter-tab px-5 py-2 rounded-full font-medium transition-all bg-gradient-to-r from-purple-600 to-purple-800 text-white">
            Semua
        </button>
        <button onclick="filterAssignments('urgent', this)" class="filter-tab px-5 py-2 border-2 border-gray-200 rounded-full font-medium text-gray-600 hover:border-purple-600 hover:text-purple-600 transition-all">
            Mendesak
        </button>
        <button onclick="filterAssignments('pending', this)" class="filter-tab px-5 py-2 border-2 border-gray-200 rounded-full font-medium text-gray-600 hover:border-purple-600 hover:text-purple-600 transition-all">
            Pending
        </button>
        <button onclick="filterAssignments('submitted', this)" class="filter-tab px-5 py-2 border-2 border-gray-200 rounded-full font-medium text-gray-600 hover:border-purple-600 hover:text-purple-600 transition-all">
            Terkirim
        </button>
        <button onclick="filterAssignments('graded', this)" class="filter-tab px-5 py-2 border-2 border-gray-200 rounded-full font-medium text-gray-600 hover:border-purple-600 hover:text-purple-600 transition-all">
            Dinilai
        </button>
    </div>

    <!-- Assignments Container -->
    <div class="space-y-6" id="assignmentsContainer">
        <!-- Assignment Card 1 - Urgent -->
        <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border-l-4 border-red-500 assignment-card" data-status="urgent">
            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4 mb-4">
                <div class="flex-1">
                    <h3 class="text-lg md:text-xl font-semibold text-gray-800 mb-2">Project Website E-Commerce</h3>
                    <span class="inline-block px-3 py-1 bg-purple-100 text-purple-600 rounded-full text-xs font-semibold">
                        Pemrograman Web Lanjut
                    </span>
                </div>
                <span class="inline-block px-4 py-2 bg-red-100 text-red-600 rounded-full text-sm font-semibold whitespace-nowrap">
                    Mendesak
                </span>
            </div>
            
            <div class="flex flex-wrap gap-4 mb-4 text-sm">
                <div class="flex items-center gap-2 text-red-600 font-semibold">
                    <span>⏰</span>
                    <span>Deadline: Besok, 23:59</span>
                </div>
                <div class="flex items-center gap-2 text-gray-600">
                    <span>👨‍🏫</span>
                    <span>Dr. Budi Santoso</span>
                </div>
                <div class="flex items-center gap-2 text-gray-600">
                    <span>📎</span>
                    <span>File Upload</span>
                </div>
            </div>
            
            <p class="text-gray-600 mb-4 leading-relaxed">
                Buat website e-commerce lengkap dengan fitur login, catalog, shopping cart, dan payment gateway.
            </p>
            
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pt-4 border-t border-gray-200">
                <div class="flex items-center gap-2 text-gray-600 text-sm">
                    <span>📊</span>
                    <span>Bobot: 30%</span>
                </div>
                <div class="flex gap-2">
                    <button onclick="openUploadModal('Project Website E-Commerce')" class="flex-1 sm:flex-initial px-4 py-2 bg-gradient-to-r from-purple-600 to-purple-800 text-white rounded-lg font-semibold hover:opacity-90 transition-opacity">
                        Upload Tugas
                    </button>
                    <button class="flex-1 sm:flex-initial px-4 py-2 bg-gray-100 text-purple-600 rounded-lg font-semibold hover:bg-gray-200 transition-colors">
                        Detail
                    </button>
                </div>
            </div>
        </div>

        <!-- Assignment Card 2 - Pending -->
        <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border-l-4 border-orange-500 assignment-card" data-status="pending">
            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4 mb-4">
                <div class="flex-1">
                    <h3 class="text-lg md:text-xl font-semibold text-gray-800 mb-2">Analisis Algoritma Sorting</h3>
                    <span class="inline-block px-3 py-1 bg-purple-100 text-purple-600 rounded-full text-xs font-semibold">
                        Struktur Data & Algoritma
                    </span>
                </div>
                <span class="inline-block px-4 py-2 bg-orange-100 text-orange-600 rounded-full text-sm font-semibold whitespace-nowrap">
                    Pending
                </span>
            </div>
            
            <div class="flex flex-wrap gap-4 mb-4 text-sm">
                <div class="flex items-center gap-2 text-gray-600">
                    <span>⏰</span>
                    <span>Deadline: 5 hari lagi</span>
                </div>
                <div class="flex items-center gap-2 text-gray-600">
                    <span>👩‍🏫</span>
                    <span>Prof. Siti Nurhaliza</span>
                </div>
            </div>
            
            <p class="text-gray-600 mb-4 leading-relaxed">
                Analisis kompleksitas waktu dan ruang dari 5 algoritma sorting dengan implementasi code.
            </p>
            
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pt-4 border-t border-gray-200">
                <div class="flex items-center gap-2 text-gray-600 text-sm">
                    <span>📊</span>
                    <span>Bobot: 25%</span>
                </div>
                <div class="flex gap-2">
                    <button onclick="openUploadModal('Analisis Algoritma')" class="flex-1 sm:flex-initial px-4 py-2 bg-gradient-to-r from-purple-600 to-purple-800 text-white rounded-lg font-semibold hover:opacity-90 transition-opacity">
                        Upload Tugas
                    </button>
                    <button class="flex-1 sm:flex-initial px-4 py-2 bg-gray-100 text-purple-600 rounded-lg font-semibold hover:bg-gray-200 transition-colors">
                        Detail
                    </button>
                </div>
            </div>
        </div>

        <!-- Assignment Card 3 - Submitted -->
        <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border-l-4 border-green-500 assignment-card" data-status="submitted">
            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4 mb-4">
                <div class="flex-1">
                    <h3 class="text-lg md:text-xl font-semibold text-gray-800 mb-2">Prototype Aplikasi Mobile</h3>
                    <span class="inline-block px-3 py-1 bg-purple-100 text-purple-600 rounded-full text-xs font-semibold">
                        Desain Interaksi
                    </span>
                </div>
                <span class="inline-block px-4 py-2 bg-green-100 text-green-600 rounded-full text-sm font-semibold whitespace-nowrap">
                    Terkirim
                </span>
            </div>
            
            <div class="flex flex-wrap gap-4 mb-4 text-sm">
                <div class="flex items-center gap-2 text-gray-600">
                    <span>✅</span>
                    <span>Dikirim: 2 hari yang lalu</span>
                </div>
                <div class="flex items-center gap-2 text-gray-600">
                    <span>👨‍🏫</span>
                    <span>Andi Wijaya, M.Kom</span>
                </div>
            </div>
            
            <p class="text-gray-600 mb-4 leading-relaxed">
                Buat prototype high-fidelity aplikasi mobile dengan minimal 10 screen.
            </p>
            
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pt-4 border-t border-gray-200">
                <div class="flex items-center gap-2 text-gray-600 text-sm">
                    <span>📊</span>
                    <span>Bobot: 20%</span>
                </div>
                <div class="flex gap-2">
                    <button class="flex-1 sm:flex-initial px-4 py-2 bg-green-500 text-white rounded-lg font-semibold">
                        ✓ Sudah Dikirim
                    </button>
                    <button class="flex-1 sm:flex-initial px-4 py-2 bg-gray-100 text-purple-600 rounded-lg font-semibold hover:bg-gray-200 transition-colors">
                        Lihat Kiriman
                    </button>
                </div>
            </div>
        </div>

        <!-- Assignment Card 4 - Graded -->
        <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border-l-4 border-purple-600 assignment-card" data-status="graded">
            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4 mb-4">
                <div class="flex-1">
                    <h3 class="text-lg md:text-xl font-semibold text-gray-800 mb-2">Quiz Database Normalisasi</h3>
                    <span class="inline-block px-3 py-1 bg-purple-100 text-purple-600 rounded-full text-xs font-semibold">
                        Database Management
                    </span>
                </div>
                <span class="inline-block px-4 py-2 bg-purple-100 text-purple-600 rounded-full text-sm font-semibold whitespace-nowrap">
                    Dinilai
                </span>
            </div>
            
            <div class="flex flex-wrap gap-4 mb-4 text-sm">
                <div class="flex items-center gap-2 text-gray-600">
                    <span>✅</span>
                    <span>Selesai: 1 minggu lalu</span>
                </div>
                <div class="flex items-center gap-2 text-gray-600">
                    <span>👨‍🏫</span>
                    <span>Ir. Joko Widodo, M.T</span>
                </div>
            </div>
            
            <p class="text-gray-600 mb-4 leading-relaxed">
                Quiz online tentang konsep normalisasi database hingga BCNF.
            </p>
            
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pt-4 border-t border-gray-200">
                <div class="flex items-center gap-2 text-gray-600 text-sm">
                    <span>📊</span>
                    <span>Bobot: 15%</span>
                </div>
                <div class="flex gap-2">
                    <div class="flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-purple-600 to-purple-800 text-white rounded-full font-semibold">
                        <span>🎯</span>
                        <span>Nilai: 88/100</span>
                    </div>
                    <button class="px-4 py-2 bg-gray-100 text-purple-600 rounded-lg font-semibold hover:bg-gray-200 transition-colors">
                        Lihat Feedback
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Upload Modal -->
<div id="uploadModal" class="hidden fixed inset-0 bg-black/50 z-50 items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 md:p-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Upload Tugas</h2>
            <button onclick="closeUploadModal()" class="text-3xl text-gray-400 hover:text-gray-600 transition-colors">
                ✕
            </button>
        </div>
        
        <div onclick="document.getElementById('fileInput').click()" class="border-2 border-dashed border-purple-600 rounded-xl p-8 text-center cursor-pointer hover:bg-purple-50 transition-colors mb-6">
            <div class="text-6xl mb-4">📁</div>
            <p class="text-gray-600">Klik untuk upload file atau drag & drop</p>
            <input type="file" id="fileInput" class="hidden">
        </div>
        
        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Catatan (Opsional)</label>
            <textarea class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-600 focus:outline-none resize-none" rows="4" placeholder="Tambahkan catatan untuk dosen..."></textarea>
        </div>
        
        <button class="w-full px-6 py-3 bg-gradient-to-r from-purple-600 to-purple-800 text-white rounded-xl font-semibold hover:opacity-90 transition-opacity">
            Kirim Tugas
        </button>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function filterAssignments(status, button) {
        const cards = document.querySelectorAll('.assignment-card');
        const tabs = document.querySelectorAll('.filter-tab');
        
        tabs.forEach(tab => {
            tab.className = 'filter-tab px-5 py-2 border-2 border-gray-200 rounded-full font-medium text-gray-600 hover:border-purple-600 hover:text-purple-600 transition-all';
        });
        button.className = 'filter-tab px-5 py-2 rounded-full font-medium transition-all bg-gradient-to-r from-purple-600 to-purple-800 text-white';
        
        cards.forEach(card => {
            if (status === 'all' || card.dataset.status === status) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }

    function openUploadModal(title) {
        const modal = document.getElementById('uploadModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeUploadModal() {
        const modal = document.getElementById('uploadModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    document.getElementById('fileInput').addEventListener('change', function(e) {
        if (e.target.files.length > 0) {
            const fileName = e.target.files[0].name;
            showNotification(`File terpilih: ${fileName}`, 'success');
        }
    });

    // Close modal when clicking outside
    document.getElementById('uploadModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeUploadModal();
        }
    });

    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `fixed top-5 right-5 ${type === 'success' ? 'bg-green-500' : 'bg-purple-600'} text-white px-6 py-4 rounded-lg shadow-lg z-[60] animate-slide-in`;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        setTimeout(() => {
            notification.style.animation = 'slide-out 0.3s ease';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }
</script>
@endpush

@push('styles')
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
@endpush