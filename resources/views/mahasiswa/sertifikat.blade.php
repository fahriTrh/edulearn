@extends('mahasiswa.app')

@section('title', 'Sertifikat - EduLearn')

@section('content')
<div class="min-h-screen bg-gray-50 p-4 md:p-8">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Sertifikat Saya</h1>
        <p class="text-gray-600 text-lg">Koleksi sertifikat pencapaian dari kursus yang telah diselesaikan</p>
    </div>

    <!-- Stats Summary -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 md:p-8 rounded-xl shadow-sm text-center hover:-translate-y-1 transition-transform">
            <div class="text-5xl mb-4">🏆</div>
            <div class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-purple-600 to-purple-800 bg-clip-text text-transparent mb-2">8</div>
            <div class="text-gray-600 text-sm">Total Sertifikat</div>
        </div>
        <div class="bg-white p-6 md:p-8 rounded-xl shadow-sm text-center hover:-translate-y-1 transition-transform">
            <div class="text-5xl mb-4">⭐</div>
            <div class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-purple-600 to-purple-800 bg-clip-text text-transparent mb-2">6</div>
            <div class="text-gray-600 text-sm">Dengan Predikat A</div>
        </div>
        <div class="bg-white p-6 md:p-8 rounded-xl shadow-sm text-center hover:-translate-y-1 transition-transform">
            <div class="text-5xl mb-4">📅</div>
            <div class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-purple-600 to-purple-800 bg-clip-text text-transparent mb-2">328</div>
            <div class="text-gray-600 text-sm">Total Jam Belajar</div>
        </div>
        <div class="bg-white p-6 md:p-8 rounded-xl shadow-sm text-center hover:-translate-y-1 transition-transform">
            <div class="text-5xl mb-4">🎓</div>
            <div class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-purple-600 to-purple-800 bg-clip-text text-transparent mb-2">2024</div>
            <div class="text-gray-600 text-sm">Tahun Aktif</div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white p-6 rounded-xl shadow-sm mb-8 flex flex-wrap gap-3">
        <button onclick="filterCertificates('all', this)" class="filter-tab px-5 py-2 rounded-full font-medium transition-all bg-gradient-to-r from-purple-600 to-purple-800 text-white">
            Semua
        </button>
        <button onclick="filterCertificates('pemrograman', this)" class="filter-tab px-5 py-2 border-2 border-gray-200 rounded-full font-medium text-gray-600 hover:border-purple-600 hover:text-purple-600 transition-all">
            Pemrograman
        </button>
        <button onclick="filterCertificates('design', this)" class="filter-tab px-5 py-2 border-2 border-gray-200 rounded-full font-medium text-gray-600 hover:border-purple-600 hover:text-purple-600 transition-all">
            Design
        </button>
        <button onclick="filterCertificates('data', this)" class="filter-tab px-5 py-2 border-2 border-gray-200 rounded-full font-medium text-gray-600 hover:border-purple-600 hover:text-purple-600 transition-all">
            Data Science
        </button>
    </div>

    <!-- Certificates Grid -->
    <div id="certificatesGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Certificates will be rendered by JavaScript -->
    </div>
</div>

<!-- Certificate Modal -->
<div id="certificateModal" class="hidden fixed inset-0 bg-black/80 z-50 p-4 items-center justify-center">
    <div class="bg-white rounded-2xl max-w-4xl w-full max-h-[90vh] overflow-auto relative">
        <button onclick="closeCertificateModal()" class="absolute top-4 right-4 w-10 h-10 bg-black/50 text-white rounded-full text-2xl hover:bg-black/70 transition-colors z-10">
            ✕
        </button>
        <div id="certificateDetail"></div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const certificates = [
        {
            id: 1,
            courseName: "Pemrograman Web Lanjut",
            category: "pemrograman",
            completedDate: "15 September 2024",
            duration: "24 Jam",
            score: 88,
            instructor: "Dr. Budi Santoso",
            certNumber: "CERT-2024-001",
            skills: ["HTML5", "CSS3", "JavaScript", "React", "Node.js"]
        },
        {
            id: 2,
            courseName: "Struktur Data & Algoritma",
            category: "pemrograman",
            completedDate: "20 Agustus 2024",
            duration: "30 Jam",
            score: 85,
            instructor: "Prof. Siti Nurhaliza",
            certNumber: "CERT-2024-002",
            skills: ["Data Structures", "Algorithms", "Big O Notation", "Problem Solving"]
        },
        {
            id: 3,
            courseName: "Desain Interaksi",
            category: "design",
            completedDate: "10 Oktober 2024",
            duration: "20 Jam",
            score: 90,
            instructor: "Andi Wijaya, M.Kom",
            certNumber: "CERT-2024-003",
            skills: ["UI/UX Design", "Figma", "Prototyping", "User Research"]
        },
        {
            id: 4,
            courseName: "Machine Learning Dasar",
            category: "data",
            completedDate: "5 Juli 2024",
            duration: "32 Jam",
            score: 82,
            instructor: "Dr. Maya Sari, S.Kom",
            certNumber: "CERT-2024-004",
            skills: ["Python", "Machine Learning", "TensorFlow", "Data Analysis"]
        },
        {
            id: 5,
            courseName: "Database Management System",
            category: "pemrograman",
            completedDate: "25 Juni 2024",
            duration: "28 Jam",
            score: 87,
            instructor: "Ir. Joko Widodo, M.T",
            certNumber: "CERT-2024-005",
            skills: ["SQL", "Database Design", "Normalization", "Query Optimization"]
        },
        {
            id: 6,
            courseName: "Pengembangan Aplikasi Mobile",
            category: "pemrograman",
            completedDate: "18 Mei 2024",
            duration: "26 Jam",
            score: 86,
            instructor: "Rahmat Hidayat, M.T",
            certNumber: "CERT-2024-006",
            skills: ["React Native", "Flutter", "Mobile UI", "API Integration"]
        },
        {
            id: 7,
            courseName: "Keamanan Sistem Informasi",
            category: "pemrograman",
            completedDate: "12 April 2024",
            duration: "22 Jam",
            score: 84,
            instructor: "Dr. Agus Salim",
            certNumber: "CERT-2024-007",
            skills: ["Cybersecurity", "Encryption", "Network Security", "Ethical Hacking"]
        },
        {
            id: 8,
            courseName: "Data Visualization",
            category: "data",
            completedDate: "8 Maret 2024",
            duration: "18 Jam",
            score: 89,
            instructor: "Linda Wijaya, M.Sc",
            certNumber: "CERT-2024-008",
            skills: ["D3.js", "Tableau", "Data Storytelling", "Python Visualization"]
        }
    ];

    function renderCertificates(filter = 'all') {
        const container = document.getElementById('certificatesGrid');
        let filteredCertificates = certificates;

        if (filter !== 'all') {
            filteredCertificates = certificates.filter(c => c.category === filter);
        }

        if (filteredCertificates.length === 0) {
            container.innerHTML = `
                <div class="col-span-full text-center bg-white p-16 rounded-2xl shadow-sm">
                    <div class="text-6xl mb-4">🏆</div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Belum ada sertifikat</h3>
                    <p class="text-gray-600">Selesaikan kursus untuk mendapatkan sertifikat</p>
                </div>
            `;
            return;
        }

        container.innerHTML = filteredCertificates.map(cert => `
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden hover:-translate-y-2 hover:shadow-xl transition-all cursor-pointer" onclick="viewCertificate(${cert.id})">
                <div class="relative h-56 bg-gradient-to-br from-purple-600 to-purple-800 flex flex-col items-center justify-center p-8 overflow-hidden">
                    <div class="absolute inset-0 opacity-20">
                        <div class="absolute top-0 left-0 w-64 h-64 bg-white rounded-full -translate-x-1/2 -translate-y-1/2 animate-pulse"></div>
                        <div class="absolute bottom-0 right-0 w-64 h-64 bg-white rounded-full translate-x-1/2 translate-y-1/2 animate-pulse" style="animation-delay: 1s;"></div>
                    </div>
                    <div class="w-20 h-20 bg-white/20 border-4 border-white rounded-full flex items-center justify-center text-4xl mb-4 relative z-10">
                        🏆
                    </div>
                    <div class="text-white text-lg font-semibold text-center relative z-10">Sertifikat Penyelesaian</div>
                </div>
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">${cert.courseName}</h3>
                    <div class="space-y-2 mb-4">
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <span>📅</span>
                            <span>${cert.completedDate}</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <span>⏱️</span>
                            <span>${cert.duration}</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <span>👨‍🏫</span>
                            <span>${cert.instructor}</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm">
                            <span>🎯</span>
                            <span class="inline-block px-3 py-1 bg-green-100 text-green-600 rounded-full font-semibold text-xs">Nilai: ${cert.score}</span>
                        </div>
                    </div>
                    <div class="flex gap-2 pt-4 border-t border-gray-200">
                        <button onclick="downloadCertificate(${cert.id}, event)" class="flex-1 flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-purple-600 to-purple-800 text-white rounded-lg font-semibold hover:-translate-y-1 hover:shadow-lg transition-all">
                            <span>⬇️</span>
                            <span>Download</span>
                        </button>
                        <button onclick="shareCertificate(${cert.id}, event)" class="flex-1 flex items-center justify-center gap-2 px-4 py-3 bg-gray-100 text-purple-600 rounded-lg font-semibold hover:bg-gray-200 transition-colors">
                            <span>🔗</span>
                            <span>Share</span>
                        </button>
                    </div>
                </div>
            </div>
        `).join('');
    }

    function filterCertificates(filter, button) {
        document.querySelectorAll('.filter-tab').forEach(tab => {
            tab.className = 'filter-tab px-5 py-2 border-2 border-gray-200 rounded-full font-medium text-gray-600 hover:border-purple-600 hover:text-purple-600 transition-all';
        });
        button.className = 'filter-tab px-5 py-2 rounded-full font-medium transition-all bg-gradient-to-r from-purple-600 to-purple-800 text-white';
        renderCertificates(filter);
    }

    function viewCertificate(id) {
        const cert = certificates.find(c => c.id === id);
        if (!cert) return;

        const modal = document.getElementById('certificateModal');
        const detailContainer = document.getElementById('certificateDetail');

        detailContainer.innerHTML = `
            <div class="relative bg-gradient-to-br from-purple-600 to-purple-800 text-white p-8 md:p-12 overflow-hidden">
                <div class="absolute top-0 left-0 w-48 h-48 border-4 border-white/10 rounded-full -translate-x-1/2 -translate-y-1/2"></div>
                <div class="absolute bottom-0 right-0 w-48 h-48 border-4 border-white/10 rounded-full translate-x-1/2 translate-y-1/2"></div>
                
                <div class="relative z-10 text-center">
                    <div class="w-32 h-32 bg-white/20 border-4 border-white rounded-full flex items-center justify-center text-6xl mx-auto mb-6">
                        🏆
                    </div>
                    <h1 class="text-3xl md:text-4xl font-bold mb-4">SERTIFIKAT PENYELESAIAN</h1>
                    <p class="text-xl mb-4 opacity-90">Diberikan kepada</p>
                    <div class="text-3xl md:text-4xl font-bold mb-8">Ahmad Maulana</div>
                    
                    <div class="my-8">
                        <p class="text-lg mb-4">Telah berhasil menyelesaikan kursus</p>
                        <h2 class="text-2xl md:text-3xl font-bold mb-8">${cert.courseName}</h2>
                    </div>
                    
                    <div class="bg-white/10 backdrop-blur-sm p-6 rounded-xl max-w-2xl mx-auto">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-left">
                            <div class="flex justify-between py-2">
                                <span class="opacity-90">Nomor Sertifikat:</span>
                                <strong>${cert.certNumber}</strong>
                            </div>
                            <div class="flex justify-between py-2">
                                <span class="opacity-90">Tanggal Selesai:</span>
                                <strong>${cert.completedDate}</strong>
                            </div>
                            <div class="flex justify-between py-2">
                                <span class="opacity-90">Durasi:</span>
                                <strong>${cert.duration}</strong>
                            </div>
                            <div class="flex justify-between py-2">
                                <span class="opacity-90">Nilai Akhir:</span>
                                <strong>${cert.score}/100</strong>
                            </div>
                        </div>
                        <div class="flex justify-between py-2 border-t border-white/20 mt-4 pt-4">
                            <span class="opacity-90">Instruktur:</span>
                            <strong>${cert.instructor}</strong>
                        </div>
                    </div>
                    
                    <div class="mt-8">
                        <p class="text-sm opacity-80 mb-4">Skill yang dikuasai:</p>
                        <div class="flex flex-wrap gap-2 justify-center">
                            ${cert.skills.map(skill => `
                                <span class="px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full text-sm">
                                    ${skill}
                                </span>
                            `).join('')}
                        </div>
                    </div>
                </div>
            </div>
        `;

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeCertificateModal() {
        const modal = document.getElementById('certificateModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    function downloadCertificate(id, event) {
        event.stopPropagation();
        const cert = certificates.find(c => c.id === id);
        
        const certificateHTML = `
            <html>
            <head>
                <style>
                    body { 
                        font-family: Arial, sans-serif; 
                        display: flex; 
                        justify-content: center; 
                        align-items: center; 
                        min-height: 100vh; 
                        margin: 0;
                        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                    }
                    .certificate { 
                        background: white; 
                        padding: 60px; 
                        text-align: center; 
                        border: 10px solid gold;
                        max-width: 800px;
                        box-shadow: 0 0 50px rgba(0,0,0,0.3);
                    }
                    h1 { color: #667eea; font-size: 48px; margin-bottom: 20px; }
                    h2 { color: #333; font-size: 36px; margin: 30px 0; }
                    .recipient { font-size: 42px; color: #764ba2; font-weight: bold; margin: 30px 0; }
                    .details { margin: 30px 0; line-height: 2; }
                    .badge { font-size: 80px; }
                </style>
            </head>
            <body>
                <div class="certificate">
                    <div class="badge">🏆</div>
                    <h1>SERTIFIKAT PENYELESAIAN</h1>
                    <p>Diberikan kepada</p>
                    <div class="recipient">Ahmad Maulana</div>
                    <p>Telah berhasil menyelesaikan kursus</p>
                    <h2>${cert.courseName}</h2>
                    <div class="details">
                        <p>Nomor Sertifikat: ${cert.certNumber}</p>
                        <p>Tanggal: ${cert.completedDate}</p>
                        <p>Durasi: ${cert.duration}</p>
                        <p>Nilai: ${cert.score}/100</p>
                        <p>Instruktur: ${cert.instructor}</p>
                    </div>
                    <p style="margin-top: 40px; color: #666;">Skills: ${cert.skills.join(', ')}</p>
                </div>
            </body>
            </html>
        `;
        
        const blob = new Blob([certificateHTML], { type: 'text/html' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `Sertifikat_${cert.courseName.replace(/\s+/g, '_')}_${cert.certNumber}.html`;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        window.URL.revokeObjectURL(url);
        
        showNotification('✅ Sertifikat berhasil didownload!', 'success');
    }

    function shareCertificate(id, event) {
        event.stopPropagation();
        const cert = certificates.find(c => c.id === id);
        const shareUrl = `https://edulearn.com/certificate/${cert.certNumber}`;
        const shareText = `🎓 Saya telah menyelesaikan kursus "${cert.courseName}" di EduLearn dengan nilai ${cert.score}/100!

${shareUrl}`;
        
        if (navigator.share) {
            navigator.share({
                title: `Sertifikat ${cert.courseName}`,
                text: shareText,
                url: shareUrl
            }).then(() => {
                showNotification('✅ Sertifikat berhasil dibagikan!', 'success');
            }).catch(() => {});
        } else {
            showShareModal(shareText, shareUrl, cert);
        }
    }

    function showShareModal(text, url, cert) {
        const modal = document.createElement('div');
        modal.className = 'fixed inset-0 bg-black/50 flex items-center justify-center z-[2000] p-4';
        
        modal.innerHTML = `
            <div class="bg-white p-8 rounded-2xl max-w-lg w-full">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Bagikan Sertifikat</h3>
                <p class="text-gray-600 mb-6 leading-relaxed">${text}</p>
                <div class="grid grid-cols-3 gap-3 mb-4">
                    <button onclick="shareToLinkedIn('${url}', '${cert.courseName}')" class="px-4 py-3 bg-[#0077b5] text-white rounded-lg font-semibold hover:opacity-90 transition-opacity">
                        LinkedIn
                    </button>
                    <button onclick="shareToFacebook('${url}')" class="px-4 py-3 bg-[#1877f2] text-white rounded-lg font-semibold hover:opacity-90 transition-opacity">
                        Facebook
                    </button>
                    <button onclick="shareToTwitter('${encodeURIComponent(text)}', '${url}')" class="px-4 py-3 bg-[#1da1f2] text-white rounded-lg font-semibold hover:opacity-90 transition-opacity">
                        Twitter
                    </button>
                </div>
                <button onclick="copyShareLink('${url}')" class="w-full px-4 py-3 bg-gradient-to-r from-purple-600 to-purple-800 text-white rounded-lg font-semibold hover:opacity-90 transition-opacity mb-2">
                    📋 Salin Link
                </button>
                <button onclick="this.closest('.fixed').remove()" class="w-full px-4 py-3 bg-gray-100 text-gray-700 rounded-lg font-semibold hover:bg-gray-200 transition-colors">
                    Tutup
                </button>
            </div>
        `;
        
        document.body.appendChild(modal);
        modal.addEventListener('click', (e) => {
            if (e.target === modal) modal.remove();
        });
    }

    function shareToLinkedIn(url, courseName) {
        window.open(`https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(url)}`, '_blank');
        showNotification('✅ Membuka LinkedIn...', 'success');
    }

    function shareToFacebook(url) {
        window.open(`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`, '_blank');
        showNotification('✅ Membuka Facebook...', 'success');
    }

    function shareToTwitter(text, url) {
        window.open(`https://twitter.com/intent/tweet?text=${text}`, '_blank');
        showNotification('✅ Membuka Twitter...', 'success');
    }

    function copyShareLink(url) {
        navigator.clipboard.writeText(url).then(() => {
            showNotification('✅ Link berhasil disalin ke clipboard!', 'success');
            setTimeout(() => {
                document.querySelectorAll('.fixed.z-\\[2000\\]').forEach(el => el.remove());
            }, 1500);
        }).catch(() => {
            const textarea = document.createElement('textarea');
            textarea.value = url;
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand('copy');
            document.body.removeChild(textarea);
            showNotification('✅ Link berhasil disalin!', 'success');
        });
    }

    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `fixed top-5 right-5 ${type === 'success' ? 'bg-green-500' : 'bg-purple-600'} text-white px-6 py-4 rounded-lg shadow-lg z-[3000] animate-slide-in`;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        setTimeout(() => {
            notification.style.animation = 'slide-out 0.3s ease';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    // Close modal on click outside
    document.getElementById('certificateModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeCertificateModal();
        }
    });

    // Initial render
    renderCertificates();
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