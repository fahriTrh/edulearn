<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nilai - EduLearn</title>
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

        .page-header h1 {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .page-header p {
            color: #666;
            margin-bottom: 2rem;
        }

        .summary-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .summary-card {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            border-left: 4px solid #667eea;
        }

        .summary-label {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .summary-value {
            font-size: 2.5rem;
            font-weight: bold;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .summary-note {
            color: #2ed573;
            font-size: 0.85rem;
            margin-top: 0.5rem;
        }

        .chart-section {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 2rem;
        }

        .chart-title {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .grades-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .grades-table thead {
            background: #f5f7fa;
        }

        .grades-table th {
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            border-bottom: 2px solid #e8ebf0;
        }

        .grades-table td {
            padding: 1rem;
            border-bottom: 1px solid #e8ebf0;
        }

        .course-name {
            font-weight: 600;
            color: #333;
        }

        .course-category {
            font-size: 0.85rem;
            color: #667eea;
            margin-top: 0.3rem;
        }

        .grade-badge {
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-weight: 600;
        }

        .grade-excellent {
            background: rgba(46, 213, 115, 0.1);
            color: #2ed573;
        }

        .grade-good {
            background: rgba(79, 172, 254, 0.1);
            color: #4facfe;
        }

        .grade-progress {
            background: rgba(255, 165, 2, 0.1);
            color: #ffa502;
        }

        .certificate-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            padding: 0.3rem 0.6rem;
            background: #ffd700;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-left: 0.5rem;
        }

        .score-cell {
            font-weight: 600;
            font-size: 1.1rem;
            color: #667eea;
        }

        .detail-btn {
            padding: 0.5rem 1rem;
            border: 2px solid #667eea;
            background: white;
            color: #667eea;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
        }

        .detail-btn:hover {
            background: #667eea;
            color: white;
        }

        .breakdown-section {
            padding: 1rem;
            background: #f5f7fa;
            border-radius: 8px;
            display: none;
        }

        .breakdown-section.active {
            display: block;
        }

        .breakdown-item {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            border-bottom: 1px solid #e8ebf0;
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
            <div style="padding: 2rem 0;">
                <div class="menu-item"><span>📊</span> Dashboard</div>
                <div class="menu-item"><span>📚</span> Kursus Saya</div>
                <div class="menu-item"><span>📅</span> Jadwal</div>
                <div class="menu-item"><span>✍️</span> Tugas</div>
                <div class="menu-item active"><span>📈</span> Nilai</div>
                <div class="menu-item"><span>💬</span> Diskusi</div>
                <div class="menu-item"><span>🏆</span> Sertifikat</div>
                <div class="menu-item"><span>⚙️</span> Pengaturan</div>
            </div>
        </aside>

        <main class="main-content">
            <div class="top-bar">
                <div class="search-bar">
                    <span>🔍</span>
                    <input type="text" placeholder="Cari kursus...">
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
                <h1>Nilai & Sertifikat</h1>
                <p>Pantau pencapaian dan progres belajar Anda di setiap kursus</p>
            </div>

            <div class="summary-cards">
                <div class="summary-card">
                    <div class="summary-label">Rata-rata Nilai</div>
                    <div class="summary-value">85.5</div>
                    <div class="summary-note">📊 Dari 8 kursus selesai</div>
                </div>
                <div class="summary-card">
                    <div class="summary-label">Kursus Selesai</div>
                    <div class="summary-value">8</div>
                    <div class="summary-note">✅ Dengan sertifikat</div>
                </div>
                <div class="summary-card">
                    <div class="summary-label">Kursus Aktif</div>
                    <div class="summary-value">5</div>
                    <div class="summary-note">🎯 Sedang berjalan</div>
                </div>
                <div class="summary-card">
                    <div class="summary-label">Total Jam Belajar</div>
                    <div class="summary-value">328</div>
                    <div class="summary-note">⏱️ Jam pembelajaran</div>
                </div>
            </div>

            <div class="chart-section">
                <h2 class="chart-title">Daftar Nilai Kursus</h2>
                <table class="grades-table">
                    <thead>
                        <tr>
                            <th>Nama Kursus</th>
                            <th>Durasi</th>
                            <th>Nilai</th>
                            <th>Status</th>
                            <th>Instruktur</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="course-name">Pemrograman Web Lanjut</div>
                                <div class="course-category">💻 Pemrograman</div>
                            </td>
                            <td>24 Jam</td>
                            <td class="score-cell">88</td>
                            <td>
                                <span class="grade-badge grade-excellent">Lulus</span>
                                <span class="certificate-badge">🏆 Sertifikat</span>
                            </td>
                            <td>Dr. Budi Santoso</td>
                            <td><button class="detail-btn" onclick="toggleBreakdown(1)">Detail</button></td>
                        </tr>
                        <tr>
                            <td colspan="6">
                                <div class="breakdown-section" id="breakdown-1">
                                    <div class="breakdown-item">
                                        <span>📝 Quiz & Latihan (30%)</span>
                                        <span style="font-weight: 600;">85/100</span>
                                    </div>
                                    <div class="breakdown-item">
                                        <span>📋 Tugas & Project (40%)</span>
                                        <span style="font-weight: 600;">90/100</span>
                                    </div>
                                    <div class="breakdown-item">
                                        <span>🎯 Ujian Akhir (30%)</span>
                                        <span style="font-weight: 600;">88/100</span>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div class="course-name">Struktur Data & Algoritma</div>
                                <div class="course-category">🔢 Algoritma</div>
                            </td>
                            <td>30 Jam</td>
                            <td class="score-cell">85</td>
                            <td>
                                <span class="grade-badge grade-excellent">Lulus</span>
                                <span class="certificate-badge">🏆 Sertifikat</span>
                            </td>
                            <td>Prof. Siti Nurhaliza</td>
                            <td><button class="detail-btn" onclick="toggleBreakdown(2)">Detail</button></td>
                        </tr>
                        <tr>
                            <td colspan="6">
                                <div class="breakdown-section" id="breakdown-2">
                                    <div class="breakdown-item">
                                        <span>📝 Quiz & Latihan (30%)</span>
                                        <span style="font-weight: 600;">82/100</span>
                                    </div>
                                    <div class="breakdown-item">
                                        <span>📋 Tugas & Project (40%)</span>
                                        <span style="font-weight: 600;">88/100</span>
                                    </div>
                                    <div class="breakdown-item">
                                        <span>🎯 Ujian Akhir (30%)</span>
                                        <span style="font-weight: 600;">85/100</span>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div class="course-name">Desain Interaksi</div>
                                <div class="course-category">🎨 Design</div>
                            </td>
                            <td>20 Jam</td>
                            <td class="score-cell">90</td>
                            <td>
                                <span class="grade-badge grade-excellent">Lulus</span>
                                <span class="certificate-badge">🏆 Sertifikat</span>
                            </td>
                            <td>Andi Wijaya, M.Kom</td>
                            <td><button class="detail-btn" onclick="toggleBreakdown(3)">Detail</button></td>
                        </tr>
                        <tr>
                            <td colspan="6">
                                <div class="breakdown-section" id="breakdown-3">
                                    <div class="breakdown-item">
                                        <span>📝 Quiz & Latihan (25%)</span>
                                        <span style="font-weight: 600;">88/100</span>
                                    </div>
                                    <div class="breakdown-item">
                                        <span>🎨 Project Design (45%)</span>
                                        <span style="font-weight: 600;">92/100</span>
                                    </div>
                                    <div class="breakdown-item">
                                        <span>🎯 Ujian Akhir (30%)</span>
                                        <span style="font-weight: 600;">90/100</span>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div class="course-name">Machine Learning Dasar</div>
                                <div class="course-category">🤖 AI & ML</div>
                            </td>
                            <td>32 Jam</td>
                            <td class="score-cell">82</td>
                            <td>
                                <span class="grade-badge grade-good">Lulus</span>
                                <span class="certificate-badge">🏆 Sertifikat</span>
                            </td>
                            <td>Dr. Maya Sari</td>
                            <td><button class="detail-btn" onclick="toggleBreakdown(4)">Detail</button></td>
                        </tr>
                        <tr>
                            <td colspan="6">
                                <div class="breakdown-section" id="breakdown-4">
                                    <div class="breakdown-item">
                                        <span>📝 Quiz & Latihan (30%)</span>
                                        <span style="font-weight: 600;">80/100</span>
                                    </div>
                                    <div class="breakdown-item">
                                        <span>📋 Tugas & Project (40%)</span>
                                        <span style="font-weight: 600;">85/100</span>
                                    </div>
                                    <div class="breakdown-item">
                                        <span>🎯 Ujian Akhir (30%)</span>
                                        <span style="font-weight: 600;">80/100</span>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div class="course-name">Database Management System</div>
                                <div class="course-category">🗄️ Database</div>
                            </td>
                            <td>28 Jam</td>
                            <td class="score-cell">-</td>
                            <td>
                                <span class="grade-badge grade-progress">Berlangsung</span>
                            </td>
                            <td>Ir. Joko Widodo</td>
                            <td><button class="detail-btn" onclick="toggleBreakdown(5)">Detail</button></td>
                        </tr>
                        <tr>
                            <td colspan="6">
                                <div class="breakdown-section" id="breakdown-5">
                                    <div class="breakdown-item">
                                        <span>📝 Quiz & Latihan (30%)</span>
                                        <span style="font-weight: 600;">75/100</span>
                                    </div>
                                    <div class="breakdown-item">
                                        <span>📋 Tugas (40%)</span>
                                        <span style="font-weight: 600;">Belum selesai</span>
                                    </div>
                                    <div class="breakdown-item">
                                        <span>🎯 Ujian Akhir (30%)</span>
                                        <span style="font-weight: 600;">Belum tersedia</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <script>
        function toggleBreakdown(id) {
            const breakdown = document.getElementById(`breakdown-${id}`);
            breakdown.classList.toggle('active');
        }
    </script>
</body>
</html>