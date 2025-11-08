<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kursus Saya - EduLearn</title>
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

        .page-header {
            margin-bottom: 2rem;
        }

        .page-header h1 {
            font-size: 2rem;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .page-header p {
            color: #666;
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

        .filter-tabs {
            display: flex;
            gap: 0.5rem;
            flex: 1;
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

        .filter-tab:hover {
            border-color: #667eea;
            color: #667eea;
        }

        .filter-tab.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-color: transparent;
        }

        .stats-summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-box {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            text-align: center;
            transition: transform 0.3s;
        }

        .stat-box:hover {
            transform: translateY(-5px);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: #666;
            font-size: 0.9rem;
        }

        .courses-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 1.5rem;
        }

        .course-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: all 0.3s;
            cursor: pointer;
        }

        .course-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        .course-header {
            height: 150px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            position: relative;
        }

        .course-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            background: rgba(255, 255, 255, 0.9);
        }

        .badge-active {
            color: #2ed573;
        }

        .badge-completed {
            color: #667eea;
        }

        .course-body {
            padding: 1.5rem;
        }

        .course-category {
            display: inline-block;
            padding: 0.3rem 0.8rem;
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
            border-radius: 15px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-bottom: 0.8rem;
        }

        .course-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #333;
        }

        .course-instructor {
            color: #666;
            font-size: 0.85rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .course-stats {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #e8ebf0;
        }

        .course-stat-item {
            display: flex;
            align-items: center;
            gap: 0.3rem;
            font-size: 0.85rem;
            color: #666;
        }

        .progress-section {
            margin-top: 1rem;
        }

        .progress-label {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
            font-size: 0.85rem;
            color: #666;
        }

        .progress-percentage {
            font-weight: 600;
            color: #667eea;
        }

        .progress-bar {
            width: 100%;
            height: 8px;
            background: #e8ebf0;
            border-radius: 4px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            border-radius: 4px;
            transition: width 0.3s;
        }

        .course-actions {
            display: flex;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .btn {
            flex: 1;
            padding: 0.7rem;
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

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            background: #f5f7fa;
            color: #667eea;
        }

        .btn-secondary:hover {
            background: #e8ebf0;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 0;
                padding: 0;
            }

            .main-content {
                margin-left: 0;
            }

            .courses-grid {
                grid-template-columns: 1fr;
            }

            .filter-section {
                flex-direction: column;
            }

            .filter-tabs {
                width: 100%;
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <aside class="sidebar">
            <div class="logo-section">EduLearn</div>
            <nav class="menu">
                <div class="menu-item"><span>📊</span> <a href="/dashboard-mahasiswa">Dashboard</a></div>
                <div class="menu-item active"><span>📚</span> Kursus Saya</div>
                <div class="menu-item"><span>📅</span> Jadwal</div>
                <div class="menu-item"><span>✍️</span> Tugas</div>
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
                    <input type="text" placeholder="Cari kursus..." id="searchInput">
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
                <h1>Kursus Saya</h1>
                <p>Kelola dan pantau progres pembelajaran Anda</p>
            </div>

            <div class="stats-summary">
                <div class="stat-box">
                    <div class="stat-number">8</div>
                    <div class="stat-label">Total Kursus</div>
                </div>
                <div class="stat-box">
                    <div class="stat-number">5</div>
                    <div class="stat-label">Sedang Berjalan</div>
                </div>
                <div class="stat-box">
                    <div class="stat-number">3</div>
                    <div class="stat-label">Selesai</div>
                </div>
                <div class="stat-box">
                    <div class="stat-number">65%</div>
                    <div class="stat-label">Rata-rata Progress</div>
                </div>
            </div>

            <div class="filter-section">
                <div class="filter-tabs">
                    <button class="filter-tab active" onclick="filterCourses('all')">Semua</button>
                    <button class="filter-tab" onclick="filterCourses('active')">Sedang Berjalan</button>
                    <button class="filter-tab" onclick="filterCourses('completed')">Selesai</button>
                </div>
            </div>

            <div class="courses-grid" id="coursesGrid">
                
                <div class="course-card" data-status="active">
                    <div class="course-header">
                        💻
                        <span class="course-badge badge-active">Aktif</span>
                    </div>
                    <div class="course-body">
                        <span class="course-category">Pemrograman</span>
                        <h3 class="course-title">Pemrograman Web Lanjut</h3>
                        <div class="course-instructor">
                            <span>👨‍🏫</span>
                            Dr. Budi Santoso
                        </div>
                        <div class="course-stats">
                            <div class="course-stat-item">
                                <span>📄</span> 12 Materi
                            </div>
                            <div class="course-stat-item">
                                <span>⏱️</span> 24 Jam
                            </div>
                            <div class="course-stat-item">
                                <span>👥</span> 45 Mahasiswa
                            </div>
                        </div>
                        <div class="progress-section">
                            <div class="progress-label">
                                <span>Progress Pembelajaran</span>
                                <span class="progress-percentage">75%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 75%"></div>
                            </div>
                        </div>
                        <div class="course-actions">
                            <button class="btn btn-primary">Lanjutkan Belajar</button>
                            <button class="btn btn-secondary">Detail</button>
                        </div>
                    </div>
                </div>

                <div class="course-card" data-status="active">
                    <div class="course-header" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                        🔢
                        <span class="course-badge badge-active">Aktif</span>
                    </div>
                    <div class="course-body">
                        <span class="course-category">Algoritma</span>
                        <h3 class="course-title">Struktur Data & Algoritma</h3>
                        <div class="course-instructor">
                            <span>👩‍🏫</span>
                            Prof. Siti Nurhaliza
                        </div>
                        <div class="course-stats">
                            <div class="course-stat-item">
                                <span>📄</span> 15 Materi
                            </div>
                            <div class="course-stat-item">
                                <span>⏱️</span> 30 Jam
                            </div>
                            <div class="course-stat-item">
                                <span>👥</span> 38 Mahasiswa
                            </div>
                        </div>
                        <div class="progress-section">
                            <div class="progress-label">
                                <span>Progress Pembelajaran</span>
                                <span class="progress-percentage">60%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 60%"></div>
                            </div>
                        </div>
                        <div class="course-actions">
                            <button class="btn btn-primary">Lanjutkan Belajar</button>
                            <button class="btn btn-secondary">Detail</button>
                        </div>
                    </div>
                </div>

                <div class="course-card" data-status="active">
                    <div class="course-header" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                        🎨
                        <span class="course-badge badge-active">Aktif</span>
                    </div>
                    <div class="course-body">
                        <span class="course-category">Design</span>
                        <h3 class="course-title">Desain Interaksi</h3>
                        <div class="course-instructor">
                            <span>👨‍🏫</span>
                            Andi Wijaya, M.Kom
                        </div>
                        <div class="course-stats">
                            <div class="course-stat-item">
                                <span>📄</span> 10 Materi
                            </div>
                            <div class="course-stat-item">
                                <span>⏱️</span> 20 Jam
                            </div>
                            <div class="course-stat-item">
                                <span>👥</span> 52 Mahasiswa
                            </div>
                        </div>
                        <div class="progress-section">
                            <div class="progress-label">
                                <span>Progress Pembelajaran</span>
                                <span class="progress-percentage">45%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 45%"></div>
                            </div>
                        </div>
                        <div class="course-actions">
                            <button class="btn btn-primary">Lanjutkan Belajar</button>
                            <button class="btn btn-secondary">Detail</button>
                        </div>
                    </div>
                </div>

                <div class="course-card" data-status="completed">
                    <div class="course-header" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                        🗄️
                        <span class="course-badge badge-completed">Selesai</span>
                    </div>
                    <div class="course-body">
                        <span class="course-category">Database</span>
                        <h3 class="course-title">Database Management System</h3>
                        <div class="course-instructor">
                            <span>👨‍🏫</span>
                            Ir. Joko Widodo, M.T
                        </div>
                        <div class="course-stats">
                            <div class="course-stat-item">
                                <span>📄</span> 14 Materi
                            </div>
                            <div class="course-stat-item">
                                <span>⏱️</span> 28 Jam
                            </div>
                            <div class="course-stat-item">
                                <span>👥</span> 60 Mahasiswa
                            </div>
                        </div>
                        <div class="progress-section">
                            <div class="progress-label">
                                <span>Progress Pembelajaran</span>
                                <span class="progress-percentage">100%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 100%"></div>
                            </div>
                        </div>
                        <div class="course-actions">
                            <button class="btn btn-primary">Lihat Sertifikat</button>
                            <button class="btn btn-secondary">Review</button>
                        </div>
                    </div>
                </div>

                <div class="course-card" data-status="active">
                    <div class="course-header" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                        🤖
                        <span class="course-badge badge-active">Aktif</span>
                    </div>
                    <div class="course-body">
                        <span class="course-category">AI & ML</span>
                        <h3 class="course-title">Machine Learning Dasar</h3>
                        <div class="course-instructor">
                            <span>👩‍🏫</span>
                            Dr. Maya Sari, S.Kom
                        </div>
                        <div class="course-stats">
                            <div class="course-stat-item">
                                <span>📄</span> 16 Materi
                            </div>
                            <div class="course-stat-item">
                                <span>⏱️</span> 32 Jam
                            </div>
                            <div class="course-stat-item">
                                <span>👥</span> 42 Mahasiswa
                            </div>
                        </div>
                        <div class="progress-section">
                            <div class="progress-label">
                                <span>Progress Pembelajaran</span>
                                <span class="progress-percentage">30%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 30%"></div>
                            </div>
                        </div>
                        <div class="course-actions">
                            <button class="btn btn-primary">Lanjutkan Belajar</button>
                            <button class="btn btn-secondary">Detail</button>
                        </div>
                    </div>
                </div>

                <div class="course-card" data-status="active">
                    <div class="course-header" style="background: linear-gradient(135deg, #30cfd0 0%, #330867 100%);">
                        📱
                        <span class="course-badge badge-active">Aktif</span>
                    </div>
                    <div class="course-body">
                        <span class="course-category">Mobile Dev</span>
                        <h3 class="course-title">Pengembangan Aplikasi Mobile</h3>
                        <div class="course-instructor">
                            <span>👨‍🏫</span>
                            Rahmat Hidayat, M.T
                        </div>
                        <div class="course-stats">
                            <div class="course-stat-item">
                                <span>📄</span> 13 Materi
                            </div>
                            <div class="course-stat-item">
                                <span>⏱️</span> 26 Jam
                            </div>
                            <div class="course-stat-item">
                                <span>👥</span> 48 Mahasiswa
                            </div>
                        </div>
                        <div class="progress-section">
                            <div class="progress-label">
                                <span>Progress Pembelajaran</span>
                                <span class="progress-percentage">55%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 55%"></div>
                            </div>
                        </div>
                        <div class="course-actions">
                            <button class="btn btn-primary">Lanjutkan Belajar</button>
                            <button class="btn btn-secondary">Detail</button>
                        </div>
                    </div>
                </div>

                <div class="course-card" data-status="completed">
                    <div class="course-header" style="background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);">
                        🔐
                        <span class="course-badge badge-completed">Selesai</span>
                    </div>
                    <div class="course-body">
                        <span class="course-category">Security</span>
                        <h3 class="course-title">Keamanan Sistem Informasi</h3>
                        <div class="course-instructor">
                            <span>👨‍🏫</span>
                            Dr. Agus Salim
                        </div>
                        <div class="course-stats">
                            <div class="course-stat-item">
                                <span>📄</span> 11 Materi
                            </div>
                            <div class="course-stat-item">
                                <span>⏱️</span> 22 Jam
                            </div>
                            <div class="course-stat-item">
                                <span>👥</span> 35 Mahasiswa
                            </div>
                        </div>
                        <div class="progress-section">
                            <div class="progress-label">
                                <span>Progress Pembelajaran</span>
                                <span class="progress-percentage">100%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 100%"></div>
                            </div>
                        </div>
                        <div class="course-actions">
                            <button class="btn btn-primary">Lihat Sertifikat</button>
                            <button class="btn btn-secondary">Review</button>
                        </div>
                    </div>
                </div>

                <div class="course-card" data-status="completed">
                    <div class="course-header" style="background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%);">
                        🌐
                        <span class="course-badge badge-completed">Selesai</span>
                    </div>
                    <div class="course-body">
                        <span class="course-category">Networking</span>
                        <h3 class="course-title">Jaringan Komputer</h3>
                        <div class="course-instructor">
                            <span>👨‍🏫</span>
                            Drs. Herman Wijaya
                        </div>
                        <div class="course-stats">
                            <div class="course-stat-item">
                                <span>📄</span> 12 Materi
                            </div>
                            <div class="course-stat-item">
                                <span>⏱️</span> 24 Jam
                            </div>
                            <div class="course-stat-item">
                                <span>👥</span> 50 Mahasiswa
                            </div>
                        </div>
                        <div class="progress-section">
                            <div class="progress-label">
                                <span>Progress Pembelajaran</span>
                                <span class="progress-percentage">100%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 100%"></div>
                            </div>
                        </div>
                        <div class="course-actions">
                            <button class="btn btn-primary">Lihat Sertifikat</button>
                            <button class="btn btn-secondary">Review</button>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <script>
        function filterCourses(status) {
            const cards = document.querySelectorAll('.course-card');
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

        document.getElementById('searchInput').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const cards = document.querySelectorAll('.course-card');
            
            cards.forEach(card => {
                const title = card.querySelector('.course-title').textContent.toLowerCase();
                const category = card.querySelector('.course-category').textContent.toLowerCase();
                const instructor = card.querySelector('.course-instructor').textContent.toLowerCase();
                
                if (title.includes(searchTerm) || category.includes(searchTerm) || instructor.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });

        document.querySelectorAll('.menu-item').forEach(item => {
            item.addEventListener('click', function() {
                document.querySelectorAll('.menu-item').forEach(i => i.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>
</body>
</html>