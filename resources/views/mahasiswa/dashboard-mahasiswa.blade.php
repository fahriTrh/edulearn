<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - EduLearn</title>
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

        /* Sidebar */
        .sidebar {
            width: 260px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            transition: all 0.3s ease;
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

        .menu-icon {
            font-size: 1.3rem;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 260px;
            padding: 2rem;
        }

        /* Top Bar */
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
            position: relative;
            width: 40px;
            height: 40px;
            background: #f5f7fa;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
        }

        .notification:hover {
            background: #e8ebf0;
        }

        .notification-badge {
            position: absolute;
            top: 5px;
            right: 5px;
            width: 8px;
            height: 8px;
            background: #ff4757;
            border-radius: 50%;
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

        /* Welcome Section */
        .welcome-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            border-radius: 15px;
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .welcome-text h1 {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .welcome-text p {
            opacity: 0.9;
        }

        .welcome-btn {
            background: white;
            color: #667eea;
            padding: 0.8rem 1.5rem;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-weight: 600;
            transition: transform 0.3s;
        }

        .welcome-btn:hover {
            transform: translateY(-2px);
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
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
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
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

        .stat-icon.blue { background: rgba(102, 126, 234, 0.1); }
        .stat-icon.green { background: rgba(46, 213, 115, 0.1); }
        .stat-icon.orange { background: rgba(255, 165, 2, 0.1); }
        .stat-icon.red { background: rgba(255, 71, 87, 0.1); }

        .stat-info h3 {
            font-size: 1.8rem;
            margin-bottom: 0.2rem;
            color: #667eea;
        }

        .stat-info p {
            color: #666;
            font-size: 0.9rem;
        }

        /* Content Grid */
        .content-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        /* Course Section */
        .section-card {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .section-header h2 {
            font-size: 1.3rem;
            color: #333;
        }

        .view-all {
            color: #667eea;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .course-card {
            display: flex;
            gap: 1rem;
            padding: 1rem;
            border: 1px solid #e8ebf0;
            border-radius: 10px;
            margin-bottom: 1rem;
            cursor: pointer;
            transition: all 0.3s;
        }

        .course-card:hover {
            border-color: #667eea;
            box-shadow: 0 3px 10px rgba(102, 126, 234, 0.1);
        }

        .course-thumbnail {
            width: 80px;
            height: 80px;
            border-radius: 8px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
        }

        .course-info {
            flex: 1;
        }

        .course-title {
            font-weight: 600;
            margin-bottom: 0.3rem;
            color: #333;
        }

        .course-meta {
            color: #666;
            font-size: 0.85rem;
            margin-bottom: 0.5rem;
        }

        .progress-bar {
            width: 100%;
            height: 6px;
            background: #e8ebf0;
            border-radius: 3px;
            overflow: hidden;
            margin-top: 0.5rem;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            border-radius: 3px;
            transition: width 0.3s;
        }

        /* Schedule */
        .schedule-item {
            padding: 1rem;
            border-left: 3px solid #667eea;
            background: #f8f9fa;
            border-radius: 5px;
            margin-bottom: 1rem;
        }

        .schedule-time {
            color: #667eea;
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 0.3rem;
        }

        .schedule-title {
            font-weight: 600;
            color: #333;
            margin-bottom: 0.2rem;
        }

        .schedule-desc {
            color: #666;
            font-size: 0.85rem;
        }

        /* Assignments */
        .assignment-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            border: 1px solid #e8ebf0;
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .assignment-info h4 {
            color: #333;
            margin-bottom: 0.3rem;
        }

        .assignment-deadline {
            color: #ff4757;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .assignment-status {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .status-pending {
            background: rgba(255, 165, 2, 0.1);
            color: #ffa502;
        }

        .status-submitted {
            background: rgba(46, 213, 115, 0.1);
            color: #2ed573;
        }

        @media (max-width: 1024px) {
            .content-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 0;
                padding: 0;
            }

            .main-content {
                margin-left: 0;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .welcome-section {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="logo-section">
                EduLearn
            </div>
            <nav class="menu">
                <div class="menu-item active">
                    <span class="menu-icon">📊</span>
                    <span>Dashboard</span>
                </div>
                <div class="menu-item">
                    <span class="menu-icon">📚</span>
                    <span>Kursus Saya</span>
                </div>
                <div class="menu-item">
                    <span class="menu-icon">📅</span>
                    <span>Jadwal</span>
                </div>
                <div class="menu-item">
                    <span class="menu-icon">✍️</span>
                    <span>Tugas</span>
                </div>
                <div class="menu-item">
                    <span class="menu-icon">📈</span>
                    <span>Nilai</span>
                </div>
                <div class="menu-item">
                    <span class="menu-icon">💬</span>
                    <span>Diskusi</span>
                </div>
                <div class="menu-item">
                    <span class="menu-icon">🏆</span>
                    <span>Sertifikat</span>
                </div>
                <div class="menu-item">
                    <span class="menu-icon">⚙️</span>
                    <span>Pengaturan</span>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Bar -->
            <div class="top-bar">
                <div class="search-bar">
                    <span>🔍</span>
                    <input type="text" placeholder="Cari kursus, materi, atau tugas...">
                </div>
                <div class="user-section">
                    <div class="notification">
                        <span>🔔</span>
                        <div class="notification-badge"></div>
                    </div>
                    <div class="user-avatar">AM</div>
                    <div>
                        <div style="font-weight: 600;">Ahmad Maulana</div>
                        <div style="font-size: 0.85rem; color: #666;">Mahasiswa</div>
                    </div>
                </div>
            </div>

            <!-- Welcome Section -->
            <div class="welcome-section">
                <div class="welcome-text">
                    <h1>Selamat Datang Kembali! 👋</h1>
                    <p>Anda memiliki 3 tugas yang harus diselesaikan minggu ini</p>
                </div>
                <button class="welcome-btn">Lihat Tugas</button>
            </div>

            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon blue">📚</div>
                    <div class="stat-info">
                        <h3>8</h3>
                        <p>Kursus Aktif</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon green">✅</div>
                    <div class="stat-info">
                        <h3>24</h3>
                        <p>Tugas Selesai</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon orange">⏰</div>
                    <div class="stat-info">
                        <h3>3</h3>
                        <p>Tugas Pending</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon red">🎯</div>
                    <div class="stat-info">
                        <h3>85.5</h3>
                        <p>Rata-rata Nilai</p>
                    </div>
                </div>
            </div>

            <!-- Content Grid -->
            <div class="content-grid">
                <!-- Courses in Progress -->
                <div class="section-card">
                    <div class="section-header">
                        <h2>Kursus Sedang Berjalan</h2>
                        <a href="#" class="view-all">Lihat Semua →</a>
                    </div>

                    <div class="course-card">
                        <div class="course-thumbnail">💻</div>
                        <div class="course-info">
                            <div class="course-title">Pemrograman Web Lanjut</div>
                            <div class="course-meta">Dosen: Dr. Budi Santoso • 12 Materi</div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 75%"></div>
                            </div>
                            <div style="font-size: 0.85rem; color: #667eea; margin-top: 0.3rem;">75% selesai</div>
                        </div>
                    </div>

                    <div class="course-card">
                        <div class="course-thumbnail">🔢</div>
                        <div class="course-info">
                            <div class="course-title">Struktur Data & Algoritma</div>
                            <div class="course-meta">Dosen: Prof. Siti Nurhaliza • 15 Materi</div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 60%"></div>
                            </div>
                            <div style="font-size: 0.85rem; color: #667eea; margin-top: 0.3rem;">60% selesai</div>
                        </div>
                    </div>

                    <div class="course-card">
                        <div class="course-thumbnail">🎨</div>
                        <div class="course-info">
                            <div class="course-title">Desain Interaksi</div>
                            <div class="course-meta">Dosen: Andi Wijaya, M.Kom • 10 Materi</div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 45%"></div>
                            </div>
                            <div style="font-size: 0.85rem; color: #667eea; margin-top: 0.3rem;">45% selesai</div>
                        </div>
                    </div>
                </div>

                <!-- Schedule & Assignments -->
                <div>
                    <!-- Schedule -->
                    <div class="section-card" style="margin-bottom: 2rem;">
                        <div class="section-header">
                            <h2>Jadwal Hari Ini</h2>
                        </div>

                        <div class="schedule-item">
                            <div class="schedule-time">08:00 - 10:00</div>
                            <div class="schedule-title">Pemrograman Web Lanjut</div>
                            <div class="schedule-desc">Ruang: Lab Komputer 3 • Online</div>
                        </div>

                        <div class="schedule-item">
                            <div class="schedule-time">10:30 - 12:00</div>
                            <div class="schedule-title">Struktur Data</div>
                            <div class="schedule-desc">Ruang: A301 • Offline</div>
                        </div>

                        <div class="schedule-item">
                            <div class="schedule-time">13:00 - 15:00</div>
                            <div class="schedule-title">Desain Interaksi</div>
                            <div class="schedule-desc">Ruang: Studio Design • Hybrid</div>
                        </div>
                    </div>

                    <!-- Assignments -->
                    <div class="section-card">
                        <div class="section-header">
                            <h2>Tugas Mendatang</h2>
                        </div>

                        <div class="assignment-item">
                            <div class="assignment-info">
                                <h4>Project Website E-Commerce</h4>
                                <div class="assignment-deadline">⏰ Deadline: 2 hari lagi</div>
                            </div>
                            <div class="assignment-status status-pending">Pending</div>
                        </div>

                        <div class="assignment-item">
                            <div class="assignment-info">
                                <h4>Analisis Algoritma Sorting</h4>
                                <div class="assignment-deadline">⏰ Deadline: 5 hari lagi</div>
                            </div>
                            <div class="assignment-status status-pending">Pending</div>
                        </div>

                        <div class="assignment-item">
                            <div class="assignment-info">
                                <h4>Quiz Database Management</h4>
                                <div style="color: #2ed573; font-size: 0.85rem; font-weight: 600;">✓ Diserahkan</div>
                            </div>
                            <div class="assignment-status status-submitted">Selesai</div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Menu interaction
        document.querySelectorAll('.menu-item').forEach(item => {
            item.addEventListener('click', function() {
                document.querySelectorAll('.menu-item').forEach(i => i.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Course card animation
        document.querySelectorAll('.course-card').forEach(card => {
            card.addEventListener('click', function() {
                this.style.transform = 'scale(0.98)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 100);
            });
        });

        // Notification click
        document.querySelector('.notification').addEventListener('click', function() {
            alert('Anda memiliki 3 notifikasi baru!');
        });
    </script>
</body>
</html>