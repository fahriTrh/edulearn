<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat - EduLearn</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
            color: #333;
        }

        .dashboard {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 260px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 100;
        }

        .logo-section {
            padding: 0 1.5rem 2rem;
            font-size: 1.8rem;
            font-weight: bold;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .menu-item {
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            cursor: pointer;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }

        .menu-item:hover {
            background: rgba(255, 255, 255, 0.1);
            border-left-color: white;
        }

        .menu-item.active {
            background: rgba(255, 255, 255, 0.15);
            border-left-color: white;
        }

        .main-content {
            flex: 1;
            margin-left: 260px;
            padding: 2rem;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .search-bar {
            display: flex;
            align-items: center;
            background: #f5f7fa;
            padding: 0.7rem 1.2rem;
            border-radius: 25px;
            flex: 1;
            max-width: 400px;
        }

        .search-bar input {
            border: none;
            background: none;
            outline: none;
            width: 100%;
            margin-left: 0.5rem;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        .page-header {
            margin-bottom: 2rem;
        }

        .page-header h1 {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .page-header p {
            color: #666;
        }

        .stats-summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-box {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            text-align: center;
            transition: transform 0.3s;
        }

        .stat-box:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: #666;
            font-size: 0.9rem;
        }

        .filter-section {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .filter-tab {
            padding: 0.6rem 1.2rem;
            border: 2px solid #e8ebf0;
            background: white;
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 500;
            color: #666;
        }

        .filter-tab.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-color: transparent;
        }

        .certificates-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 2rem;
        }

        .certificate-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: all 0.3s;
            cursor: pointer;
        }

        .certificate-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        .certificate-preview {
            position: relative;
            height: 220px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            overflow: hidden;
        }

        .certificate-preview::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .cert-badge {
            width: 80px;
            height: 80px;
            background: rgba(255,255,255,0.2);
            border: 3px solid white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            margin-bottom: 1rem;
            z-index: 1;
        }

        .cert-title {
            color: white;
            font-size: 1.1rem;
            font-weight: 600;
            text-align: center;
            z-index: 1;
        }

        .certificate-body {
            padding: 1.5rem;
        }

        .cert-course-name {
            font-size: 1.2rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .cert-meta {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .cert-meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #666;
            font-size: 0.85rem;
        }

        .cert-score {
            display: inline-block;
            padding: 0.3rem 0.8rem;
            background: rgba(46, 213, 115, 0.1);
            color: #2ed573;
            border-radius: 15px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .certificate-actions {
            display: flex;
            gap: 0.5rem;
            padding-top: 1rem;
            border-top: 1px solid #e8ebf0;
        }

        .cert-btn {
            flex: 1;
            padding: 0.7rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.3rem;
        }

        .btn-download {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-download:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-share {
            background: #f5f7fa;
            color: #667eea;
        }

        .btn-share:hover {
            background: #e8ebf0;
        }

        .btn-view {
            background: #f5f7fa;
            color: #667eea;
        }

        .btn-view:hover {
            background: #e8ebf0;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.8);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: white;
            padding: 0;
            border-radius: 15px;
            max-width: 900px;
            width: 100%;
            max-height: 90vh;
            overflow: auto;
            position: relative;
        }

        .close-modal {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: rgba(0,0,0,0.5);
            color: white;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            font-size: 1.5rem;
            cursor: pointer;
            z-index: 10;
        }

        .certificate-full {
            padding: 3rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .cert-decoration {
            position: absolute;
            width: 200px;
            height: 200px;
            border: 3px solid rgba(255,255,255,0.1);
            border-radius: 50%;
        }

        .cert-decoration.top-left {
            top: -100px;
            left: -100px;
        }

        .cert-decoration.bottom-right {
            bottom: -100px;
            right: -100px;
        }

        .cert-full-badge {
            width: 120px;
            height: 120px;
            background: rgba(255,255,255,0.2);
            border: 4px solid white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
            margin: 0 auto 2rem;
            position: relative;
            z-index: 1;
        }

        .cert-full-title {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 1rem;
            position: relative;
            z-index: 1;
        }

        .cert-full-subtitle {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
            position: relative;
            z-index: 1;
        }

        .cert-recipient {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 2rem;
            position: relative;
            z-index: 1;
        }

        .cert-details {
            background: rgba(255,255,255,0.1);
            padding: 2rem;
            border-radius: 12px;
            margin-top: 2rem;
            position: relative;
            z-index: 1;
        }

        .cert-detail-row {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: white;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .empty-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 0;
                padding: 0;
            }

            .main-content {
                margin-left: 0;
                padding: 1rem;
            }

            .certificates-grid {
                grid-template-columns: 1fr;
            }

            .cert-full-title {
                font-size: 1.8rem;
            }

            .cert-recipient {
                font-size: 1.5rem;
            }

            .certificate-full {
                padding: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <aside class="sidebar">
            <div class="logo-section">EduLearn</div>
            <div style="padding: 2rem 0;">
                <div class="menu-item"><span>📊</span> Dashboard</div>
                <div class="menu-item"><span>📚</span> Kursus Saya</div>
                <div class="menu-item"><span>📅</span> Jadwal</div>
                <div class="menu-item"><span>✍️</span> Tugas</div>
                <div class="menu-item"><span>📈</span> Nilai</div>
                <div class="menu-item"><span>💬</span> Diskusi</div>
                <div class="menu-item active"><span>🏆</span> Sertifikat</div>
                <div class="menu-item"><span>⚙️</span> Pengaturan</div>
            </div>
        </aside>

        <main class="main-content">
            <div class="top-bar">
                <div class="search-bar">
                    <span>🔍</span>
                    <input type="text" placeholder="Cari sertifikat..." id="searchInput">
                </div>
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div style="width: 40px; height: 40px; background: #f5f7fa; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer;">🔔</div>
                    <div class="user-avatar">AM</div>
                    <div>
                        <div style="font-weight: 600;">Ahmad Maulana</div>
                        <div style="font-size: 0.85rem; color: #666;">Mahasiswa</div>
                    </div>
                </div>
            </div>

            <div class="page-header">
                <h1>Sertifikat Saya</h1>
                <p>Koleksi sertifikat pencapaian dari kursus yang telah diselesaikan</p>
            </div>

            <div class="stats-summary">
                <div class="stat-box">
                    <div class="stat-icon">🏆</div>
                    <div class="stat-number">8</div>
                    <div class="stat-label">Total Sertifikat</div>
                </div>
                <div class="stat-box">
                    <div class="stat-icon">⭐</div>
                    <div class="stat-number">6</div>
                    <div class="stat-label">Dengan Predikat A</div>
                </div>
                <div class="stat-box">
                    <div class="stat-icon">📅</div>
                    <div class="stat-number">328</div>
                    <div class="stat-label">Total Jam Belajar</div>
                </div>
                <div class="stat-box">
                    <div class="stat-icon">🎓</div>
                    <div class="stat-number">2024</div>
                    <div class="stat-label">Tahun Aktif</div>
                </div>
            </div>

            <div class="filter-section">
                <button class="filter-tab active" onclick="filterCertificates('all', this)">Semua</button>
                <button class="filter-tab" onclick="filterCertificates('pemrograman', this)">Pemrograman</button>
                <button class="filter-tab" onclick="filterCertificates('design', this)">Design</button>
                <button class="filter-tab" onclick="filterCertificates('data', this)">Data Science</button>
            </div>

            <div class="certificates-grid" id="certificatesGrid">
                <!-- Certificates will be rendered here -->
            </div>
        </main>
    </div>

    <div class="modal" id="certificateModal">
        <div class="modal-content">
            <button class="close-modal" onclick="closeCertificateModal()">✕</button>
            <div id="certificateDetail"></div>
        </div>
    </div>

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
                    <div class="empty-state" style="grid-column: 1/-1;">
                        <div class="empty-icon">🏆</div>
                        <h3>Belum ada sertifikat</h3>
                        <p>Selesaikan kursus untuk mendapatkan sertifikat</p>
                    </div>
                `;
                return;
            }

            container.innerHTML = filteredCertificates.map(cert => `
                <div class="certificate-card" onclick="viewCertificate(${cert.id})">
                    <div class="certificate-preview">
                        <div class="cert-badge">🏆</div>
                        <div class="cert-title">Sertifikat Penyelesaian</div>
                    </div>
                    <div class="certificate-body">
                        <div class="cert-course-name">${cert.courseName}</div>
                        <div class="cert-meta">
                            <div class="cert-meta-item">
                                <span>📅</span>
                                <span>${cert.completedDate}</span>
                            </div>
                            <div class="cert-meta-item">
                                <span>⏱️</span>
                                <span>${cert.duration}</span>
                            </div>
                            <div class="cert-meta-item">
                                <span>👨‍🏫</span>
                                <span>${cert.instructor}</span>
                            </div>
                            <div class="cert-meta-item">
                                <span>🎯</span>
                                <span class="cert-score">Nilai: ${cert.score}</span>
                            </div>
                        </div>
                        <div class="certificate-actions">
                            <button class="cert-btn btn-download" onclick="downloadCertificate(${cert.id}, event)">
                                <span>⬇️</span>
                                <span>Download</span>
                            </button>
                            <button class="cert-btn btn-share" onclick="shareCertificate(${cert.id}, event)">
                                <span>🔗</span>
                                <span>Share</span>
                            </button>
                            <button class="cert-btn btn-view" onclick="viewCertificate(${cert.id})">
                                <span>👁️</span>
                                <span>Lihat</span>
                            </button>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        function filterCertificates(filter, button) {
            document.querySelectorAll('.filter-tab').forEach(tab => tab.classList.remove('active'));
            button.classList.add('active');
            renderCertificates(filter);
        }

        function viewCertificate(id) {
            const cert = certificates.find(c => c.id === id);
            if (!cert) return;

            const modal = document.getElementById('certificateModal');
            const detailContainer = document.getElementById('certificateDetail');

            detailContainer.innerHTML = `
                <div class="certificate-full">
                    <div class="cert-decoration top-left"></div>
                    <div class="cert-decoration bottom-right"></div>
                    
                    <div class="cert-full-badge">🏆</div>
                    <div class="cert-full-title">SERTIFIKAT PENYELESAIAN</div>
                    <div class="cert-full-subtitle">Diberikan kepada</div>
                    <div class="cert-recipient">Ahmad Maulana</div>
                    
                    <div style="margin: 2rem 0;">
                        <p style="font-size: 1.1rem; margin-bottom: 1rem;">
                            Telah berhasil menyelesaikan kursus
                        </p>
                        <h2 style="font-size: 2rem; margin-bottom: 2rem;">${cert.courseName}</h2>
                    </div>
                    
                    <div class="cert-details">
                        <div class="cert-detail-row">
                            <span>Nomor Sertifikat:</span>
                            <strong>${cert.certNumber}</strong>
                        </div>
                        <div class="cert-detail-row">
                            <span>Tanggal Selesai:</span>
                            <strong>${cert.completedDate}</strong>
                        </div>
                        <div class="cert-detail-row">
                            <span>Durasi:</span>
                            <strong>${cert.duration}</strong>
                        </div>
                        <div class="cert-detail-row">
                            <span>Nilai Akhir:</span>
                            <strong>${cert.score}/100</strong>
                        </div>
                        <div class="cert-detail-row">
                            <span>Instruktur:</span>
                            <strong>${cert.instructor}</strong>
                        </div>
                    </div>
                    
                    <div style="margin-top: 2rem;">
                        <p style="font-size: 0.9rem; opacity: 0.8;">Skill yang dikuasai:</p>
                        <div style="display: flex; flex-wrap: wrap; gap: 0.5rem; justify-content: center; margin-top: 1rem;">
                            ${cert.skills.map(skill => `
                                <span style="padding: 0.4rem 1rem; background: rgba(255,255,255,0.2); border-radius: 20px; font-size: 0.85rem;">
                                    ${skill}
                                </span>
                            `).join('')}
                        </div>
                    </div>
                </div>
            `;

            modal.classList.add('active');
        }

        function closeCertificateModal() {
            document.getElementById('certificateModal').classList.remove('active');
        }

        function downloadCertificate(id, event) {
            event.stopPropagation();
            const cert = certificates.find(c => c.id === id);
            
            // Create certificate HTML content
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
            
            // Create blob and download
            const blob = new Blob([certificateHTML], { type: 'text/html' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `Sertifikat_${cert.courseName.replace(/\s+/g, '_')}_${cert.certNumber}.html`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);
            
            // Show success message
            showNotification('✅ Sertifikat berhasil didownload!', 'success');
        }

        function shareCertificate(id, event) {
            event.stopPropagation();
            const cert = certificates.find(c => c.id === id);
            const shareUrl = `https://edulearn.com/certificate/${cert.certNumber}`;
            const shareText = `🎓 Saya telah menyelesaikan kursus "${cert.courseName}" di EduLearn dengan nilai ${cert.score}/100!\n\n${shareUrl}`;
            
            // Try native share API first (works on mobile)
            if (navigator.share) {
                navigator.share({
                    title: `Sertifikat ${cert.courseName}`,
                    text: shareText,
                    url: shareUrl
                }).then(() => {
                    showNotification('✅ Sertifikat berhasil dibagikan!', 'success');
                }).catch((err) => {
                    if (err.name !== 'AbortError') {
                        showShareModal(shareText, shareUrl, cert);
                    }
                });
            } else {
                showShareModal(shareText, shareUrl, cert);
            }
        }

        function showShareModal(text, url, cert) {
            const modal = document.createElement('div');
            modal.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.5);
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 2000;
            `;
            
            modal.innerHTML = `
                <div style="background: white; padding: 2rem; border-radius: 15px; max-width: 500px; width: 90%;">
                    <h3 style="margin-bottom: 1rem; color: #333;">Bagikan Sertifikat</h3>
                    <p style="color: #666; margin-bottom: 1.5rem; line-height: 1.6;">${text}</p>
                    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap; margin-bottom: 1.5rem;">
                        <button onclick="shareToLinkedIn('${url}', '${cert.courseName}')" style="flex: 1; padding: 0.8rem; background: #0077b5; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 600;">
                            LinkedIn
                        </button>
                        <button onclick="shareToFacebook('${url}')" style="flex: 1; padding: 0.8rem; background: #1877f2; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 600;">
                            Facebook
                        </button>
                        <button onclick="shareToTwitter('${text}', '${url}')" style="flex: 1; padding: 0.8rem; background: #1da1f2; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 600;">
                            Twitter
                        </button>
                    </div>
                    <button onclick="copyShareLink('${url}')" style="width: 100%; padding: 0.8rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; margin-bottom: 0.5rem;">
                        📋 Salin Link
                    </button>
                    <button onclick="this.closest('div').parentElement.remove()" style="width: 100%; padding: 0.8rem; background: #f5f7fa; color: #666; border: none; border-radius: 8px; cursor: pointer; font-weight: 600;">
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
            window.open(`https://twitter.com/intent/tweet?text=${encodeURIComponent(text)}`, '_blank');
            showNotification('✅ Membuka Twitter...', 'success');
        }

        function copyShareLink(url) {
            navigator.clipboard.writeText(url).then(() => {
                showNotification('✅ Link berhasil disalin ke clipboard!', 'success');
                setTimeout(() => {
                    document.querySelectorAll('div[style*="position: fixed"]').forEach(el => {
                        if (el.style.zIndex === '2000') el.remove();
                    });
                }, 1500);
            }).catch(() => {
                // Fallback for older browsers
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
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: ${type === 'success' ? '#2ed573' : '#667eea'};
                color: white;
                padding: 1rem 1.5rem;
                border-radius: 8px;
                box-shadow: 0 5px 15px rgba(0,0,0,0.3);
                z-index: 3000;
                animation: slideIn 0.3s ease;
            `;
            notification.textContent = message;
            
            const style = document.createElement('style');
            style.textContent = `
                @keyframes slideIn {
                    from { transform: translateX(400px); opacity: 0; }
                    to { transform: translateX(0); opacity: 1; }
                }
            `;
            document.head.appendChild(style);
            
            document.body.appendChild(notification);
            setTimeout(() => {
                notification.style.animation = 'slideIn 0.3s ease reverse';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const cards = document.querySelectorAll('.certificate-card');
            
            cards.forEach(card => {
                const courseName = card.querySelector('.cert-course-name').textContent.toLowerCase();
                
                if (courseName.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });

        // Close modal when clicking outside
        document.getElementById('certificateModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeCertificateModal();
            }
        });

        // Initial render
        renderCertificates();
    </script>
</body>
</html>