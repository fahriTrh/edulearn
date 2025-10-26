<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tugas - EduLearn</title>
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
        }

        .logo-section {
            padding: 0 1.5rem 2rem;
            font-size: 1.8rem;
            font-weight: bold;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .menu {
            padding: 2rem 0;
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

        .user-section {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .notification {
            width: 40px;
            height: 40px;
            background: #f5f7fa;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
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

        .page-header h1 {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .page-header p {
            color: #666;
            margin-bottom: 2rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
        }

        .stat-icon.red { background: rgba(255, 71, 87, 0.1); }
        .stat-icon.orange { background: rgba(255, 165, 2, 0.1); }
        .stat-icon.green { background: rgba(46, 213, 115, 0.1); }
        .stat-icon.blue { background: rgba(102, 126, 234, 0.1); }

        .stat-info h3 {
            font-size: 1.8rem;
            color: #667eea;
        }

        .stat-info p {
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

        .assignments-container {
            display: grid;
            gap: 1.5rem;
        }

        .assignment-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            border-left: 4px solid transparent;
        }

        .assignment-card.urgent { border-left-color: #ff4757; }
        .assignment-card.pending { border-left-color: #ffa502; }
        .assignment-card.submitted { border-left-color: #2ed573; }
        .assignment-card.graded { border-left-color: #667eea; }

        .assignment-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .assignment-title h3 {
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
        }

        .course-label {
            display: inline-block;
            padding: 0.3rem 0.8rem;
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
            border-radius: 15px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .assignment-status {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .status-urgent { background: rgba(255, 71, 87, 0.1); color: #ff4757; }
        .status-pending { background: rgba(255, 165, 2, 0.1); color: #ffa502; }
        .status-submitted { background: rgba(46, 213, 115, 0.1); color: #2ed573; }
        .status-graded { background: rgba(102, 126, 234, 0.1); color: #667eea; }

        .assignment-meta {
            display: flex;
            gap: 1.5rem;
            margin-bottom: 1rem;
            flex-wrap: wrap;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #666;
            font-size: 0.9rem;
        }

        .meta-item.urgent {
            color: #ff4757;
            font-weight: 600;
        }

        .assignment-description {
            color: #666;
            line-height: 1.6;
            margin-bottom: 1rem;
        }

        .assignment-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 1rem;
            border-top: 1px solid #e8ebf0;
        }

        .assignment-actions {
            display: flex;
            gap: 0.5rem;
        }

        .btn {
            padding: 0.6rem 1.2rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-secondary {
            background: #f5f7fa;
            color: #667eea;
        }

        .btn-success {
            background: #2ed573;
            color: white;
        }

        .grade-badge {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 1rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 25px;
            font-weight: 600;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            max-width: 500px;
            width: 90%;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }

        .close-modal {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
        }

        .upload-area {
            border: 2px dashed #667eea;
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
            margin-bottom: 1.5rem;
            cursor: pointer;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .form-group textarea {
            width: 100%;
            padding: 0.8rem;
            border: 2px solid #e8ebf0;
            border-radius: 8px;
            resize: vertical;
            min-height: 100px;
        }

        @media (max-width: 768px) {
            .sidebar { width: 0; padding: 0; }
            .main-content { margin-left: 0; }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <aside class="sidebar">
            <div class="logo-section">EduLearn</div>
            <nav class="menu">
                <div class="menu-item"><span>📊</span> Dashboard</div>
                <div class="menu-item"><span>📚</span> Kursus Saya</div>
                <div class="menu-item"><span>📅</span> Jadwal</div>
                <div class="menu-item active"><span>✍️</span> Tugas</div>
                <div class="menu-item"><span>📈</span> Nilai</div>
                <div class="menu-item"><span>💬</span> Diskusi</div>
                <div class="menu-item"><span>🏆</span> Sertifikat</div>
                <div class="menu-item"><span>⚙️</span> Pengaturan</div>
            </nav>
        </aside>

        <main class="main-content">
            <div class="top-bar">
                <div class="search-bar">
                    <span>🔍</span>
                    <input type="text" placeholder="Cari tugas...">
                </div>
                <div class="user-section">
                    <div class="notification">🔔</div>
                    <div class="user-avatar">AM</div>
                    <div>
                        <div style="font-weight: 600;">Ahmad Maulana</div>
                        <div style="font-size: 0.85rem; color: #666;">Mahasiswa</div>
                    </div>
                </div>
            </div>

            <div class="page-header">
                <h1>Tugas Kuliah</h1>
                <p>Kelola dan selesaikan tugas kuliah Anda</p>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon red">⚠️</div>
                    <div class="stat-info">
                        <h3>2</h3>
                        <p>Mendesak</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon orange">⏰</div>
                    <div class="stat-info">
                        <h3>5</h3>
                        <p>Pending</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon green">✅</div>
                    <div class="stat-info">
                        <h3>24</h3>
                        <p>Terkirim</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon blue">📊</div>
                    <div class="stat-info">
                        <h3>18</h3>
                        <p>Dinilai</p>
                    </div>
                </div>
            </div>

            <div class="filter-section">
                <button class="filter-tab active" onclick="filterAssignments('all')">Semua</button>
                <button class="filter-tab" onclick="filterAssignments('urgent')">Mendesak</button>
                <button class="filter-tab" onclick="filterAssignments('pending')">Pending</button>
                <button class="filter-tab" onclick="filterAssignments('submitted')">Terkirim</button>
                <button class="filter-tab" onclick="filterAssignments('graded')">Dinilai</button>
            </div>

            <div class="assignments-container" id="assignmentsContainer">
                <div class="assignment-card urgent" data-status="urgent">
                    <div class="assignment-header">
                        <div class="assignment-title">
                            <h3>Project Website E-Commerce</h3>
                            <span class="course-label">Pemrograman Web Lanjut</span>
                        </div>
                        <span class="assignment-status status-urgent">Mendesak</span>
                    </div>
                    <div class="assignment-meta">
                        <div class="meta-item urgent"><span>⏰</span> Deadline: Besok, 23:59</div>
                        <div class="meta-item"><span>👨‍🏫</span> Dr. Budi Santoso</div>
                        <div class="meta-item"><span>📎</span> File Upload</div>
                    </div>
                    <p class="assignment-description">
                        Buat website e-commerce lengkap dengan fitur login, catalog, shopping cart, dan payment gateway.
                    </p>
                    <div class="assignment-footer">
                        <div class="meta-item"><span>📊</span> Bobot: 30%</div>
                        <div class="assignment-actions">
                            <button class="btn btn-primary" onclick="openUploadModal('Project Website E-Commerce')">Upload Tugas</button>
                            <button class="btn btn-secondary">Detail</button>
                        </div>
                    </div>
                </div>

                <div class="assignment-card pending" data-status="pending">
                    <div class="assignment-header">
                        <div class="assignment-title">
                            <h3>Analisis Algoritma Sorting</h3>
                            <span class="course-label">Struktur Data & Algoritma</span>
                        </div>
                        <span class="assignment-status status-pending">Pending</span>
                    </div>
                    <div class="assignment-meta">
                        <div class="meta-item"><span>⏰</span> Deadline: 5 hari lagi</div>
                        <div class="meta-item"><span>👩‍🏫</span> Prof. Siti Nurhaliza</div>
                    </div>
                    <p class="assignment-description">
                        Analisis kompleksitas waktu dan ruang dari 5 algoritma sorting dengan implementasi code.
                    </p>
                    <div class="assignment-footer">
                        <div class="meta-item"><span>📊</span> Bobot: 25%</div>
                        <div class="assignment-actions">
                            <button class="btn btn-primary" onclick="openUploadModal('Analisis Algoritma')">Upload Tugas</button>
                            <button class="btn btn-secondary">Detail</button>
                        </div>
                    </div>
                </div>

                <div class="assignment-card submitted" data-status="submitted">
                    <div class="assignment-header">
                        <div class="assignment-title">
                            <h3>Prototype Aplikasi Mobile</h3>
                            <span class="course-label">Desain Interaksi</span>
                        </div>
                        <span class="assignment-status status-submitted">Terkirim</span>
                    </div>
                    <div class="assignment-meta">
                        <div class="meta-item"><span>✅</span> Dikirim: 2 hari yang lalu</div>
                        <div class="meta-item"><span>👨‍🏫</span> Andi Wijaya, M.Kom</div>
                    </div>
                    <p class="assignment-description">
                        Buat prototype high-fidelity aplikasi mobile dengan minimal 10 screen.
                    </p>
                    <div class="assignment-footer">
                        <div class="meta-item"><span>📊</span> Bobot: 20%</div>
                        <div class="assignment-actions">
                            <button class="btn btn-success">✓ Sudah Dikirim</button>
                            <button class="btn btn-secondary">Lihat Kiriman</button>
                        </div>
                    </div>
                </div>

                <div class="assignment-card graded" data-status="graded">
                    <div class="assignment-header">
                        <div class="assignment-title">
                            <h3>Quiz Database Normalisasi</h3>
                            <span class="course-label">Database Management</span>
                        </div>
                        <span class="assignment-status status-graded">Dinilai</span>
                    </div>
                    <div class="assignment-meta">
                        <div class="meta-item"><span>✅</span> Selesai: 1 minggu lalu</div>
                        <div class="meta-item"><span>👨‍🏫</span> Ir. Joko Widodo, M.T</div>
                    </div>
                    <p class="assignment-description">
                        Quiz online tentang konsep normalisasi database hingga BCNF.
                    </p>
                    <div class="assignment-footer">
                        <div class="meta-item"><span>📊</span> Bobot: 15%</div>
                        <div class="assignment-actions">
                            <div class="grade-badge">🎯 Nilai: 88/100</div>
                            <button class="btn btn-secondary">Lihat Feedback</button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <div class="modal" id="uploadModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Upload Tugas</h2>
                <button class="close-modal" onclick="closeUploadModal()">✕</button>
            </div>
            <div class="upload-area" onclick="document.getElementById('fileInput').click()">
                <div style="font-size: 3rem; margin-bottom: 1rem;">📁</div>
                <p>Klik untuk upload file atau drag & drop</p>
                <input type="file" id="fileInput" style="display: none;">
            </div>
            <div class="form-group">
                <label>Catatan (Opsional)</label>
                <textarea placeholder="Tambahkan catatan untuk dosen..."></textarea>
            </div>
            <button class="btn btn-primary" style="width: 100%;">Kirim Tugas</button>
        </div>
    </div>

    <script>
        function filterAssignments(status) {
            const cards = document.querySelectorAll('.assignment-card');
            const tabs = document.querySelectorAll('.filter-tab');
            
            tabs.forEach(tab => tab.classList.remove('active'));
            event.target.classList.add('active');
            
            cards.forEach(card => {
                if (status === 'all' || card.dataset.status === status) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        function openUploadModal(title) {
            document.getElementById('uploadModal').classList.add('active');
        }

        function closeUploadModal() {
            document.getElementById('uploadModal').classList.remove('active');
        }

        document.getElementById('fileInput').addEventListener('change', function(e) {
            if (e.target.files.length > 0) {
                alert('File terpilih: ' + e.target.files[0].name);
            }
        });
    </script>
</body>
</html>