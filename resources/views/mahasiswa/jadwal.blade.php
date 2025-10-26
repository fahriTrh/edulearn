<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal - EduLearn</title>
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

        .view-toggle {
            background: white;
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            display: flex;
            gap: 1rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .view-btn {
            padding: 0.6rem 1.5rem;
            border: 2px solid #e8ebf0;
            background: white;
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 500;
            color: #666;
        }

        .view-btn.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-color: transparent;
        }

        .calendar-header {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .calendar-nav {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .nav-btn {
            width: 40px;
            height: 40px;
            border: none;
            background: #f5f7fa;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }

        .nav-btn:hover {
            background: #667eea;
            color: white;
        }

        .current-date {
            font-size: 1.3rem;
            font-weight: 600;
        }

        .today-btn {
            padding: 0.6rem 1.2rem;
            border: none;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 25px;
            cursor: pointer;
            font-weight: 600;
        }

        .calendar-view {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 0.5rem;
        }

        .day-header {
            text-align: center;
            padding: 1rem;
            font-weight: 600;
            color: #667eea;
            border-bottom: 2px solid #e8ebf0;
        }

        .calendar-day {
            min-height: 120px;
            border: 1px solid #e8ebf0;
            border-radius: 8px;
            padding: 0.5rem;
            cursor: pointer;
            transition: all 0.3s;
        }

        .calendar-day:hover {
            background: #f5f7fa;
            border-color: #667eea;
        }

        .calendar-day.today {
            background: rgba(102, 126, 234, 0.1);
            border-color: #667eea;
        }

        .calendar-day.other-month {
            opacity: 0.3;
        }

        .day-number {
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .day-event {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.3rem 0.5rem;
            border-radius: 4px;
            font-size: 0.75rem;
            margin-bottom: 0.3rem;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .day-event.live {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        .day-event.webinar {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }

        .day-event.deadline {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        }

        .list-view {
            display: none;
        }

        .list-view.active {
            display: block;
        }

        .schedule-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .day-section {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .day-section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #e8ebf0;
        }

        .day-section-title {
            font-size: 1.2rem;
            font-weight: 600;
        }

        .schedule-card {
            background: white;
            border-left: 4px solid #667eea;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: all 0.3s;
            cursor: pointer;
        }

        .schedule-card:hover {
            transform: translateX(5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }

        .schedule-card.live {
            border-left-color: #4facfe;
        }

        .schedule-card.webinar {
            border-left-color: #43e97b;
        }

        .schedule-card.deadline {
            border-left-color: #fa709a;
        }

        .schedule-time {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #667eea;
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .schedule-title {
            font-weight: 600;
            color: #333;
            margin-bottom: 0.3rem;
        }

        .schedule-meta {
            display: flex;
            gap: 1rem;
            font-size: 0.85rem;
            color: #666;
            flex-wrap: wrap;
        }

        .schedule-meta-item {
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .schedule-badge {
            display: inline-block;
            padding: 0.2rem 0.6rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-top: 0.5rem;
        }

        .badge-live {
            background: rgba(79, 172, 254, 0.1);
            color: #4facfe;
        }

        .badge-webinar {
            background: rgba(67, 233, 123, 0.1);
            color: #43e97b;
        }

        .badge-recorded {
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
        }

        .badge-deadline {
            background: rgba(250, 112, 154, 0.1);
            color: #fa709a;
        }

        .join-btn {
            padding: 0.5rem 1rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            margin-top: 0.5rem;
        }

        @media (max-width: 768px) {
            .sidebar { width: 0; padding: 0; }
            .main-content { margin-left: 0; }
            .calendar-grid { grid-template-columns: repeat(7, 1fr); gap: 0.2rem; }
            .calendar-day { min-height: 80px; padding: 0.3rem; }
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
                <div class="menu-item active"><span>📅</span> Jadwal</div>
                <div class="menu-item"><span>✍️</span> Tugas</div>
                <div class="menu-item"><span>📈</span> Nilai</div>
                <div class="menu-item"><span>💬</span> Diskusi</div>
                <div class="menu-item"><span>🏆</span> Sertifikat</div>
                <div class="menu-item"><span>⚙️</span> Pengaturan</div>
            </div>
        </aside>

        <main class="main-content">
            <div class="top-bar">
                <div class="search-bar">
                    <span>🔍</span>
                    <input type="text" placeholder="Cari jadwal...">
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
                <h1>Jadwal Pembelajaran</h1>
                <p>Kelola jadwal sesi live, webinar, dan deadline tugas Anda</p>
            </div>

            <div class="view-toggle">
                <button class="view-btn active" onclick="changeView('calendar')">📅 Kalender</button>
                <button class="view-btn" onclick="changeView('list')">📋 Daftar</button>
            </div>

            <div class="calendar-header">
                <div class="calendar-nav">
                    <button class="nav-btn">◀</button>
                    <div class="current-date">Oktober 2024</div>
                    <button class="nav-btn">▶</button>
                </div>
                <button class="today-btn">Hari Ini</button>
            </div>

            <div class="calendar-view active" id="calendarView">
                <div class="calendar-grid">
                    <div class="day-header">Min</div>
                    <div class="day-header">Sen</div>
                    <div class="day-header">Sel</div>
                    <div class="day-header">Rab</div>
                    <div class="day-header">Kam</div>
                    <div class="day-header">Jum</div>
                    <div class="day-header">Sab</div>

                    <div class="calendar-day other-month"><div class="day-number">29</div></div>
                    <div class="calendar-day other-month"><div class="day-number">30</div></div>
                    <div class="calendar-day"><div class="day-number">1</div></div>
                    <div class="calendar-day">
                        <div class="day-number">2</div>
                        <div class="day-event live">Live: Web Dev</div>
                        <div class="day-event webinar">Webinar AI</div>
                    </div>
                    <div class="calendar-day">
                        <div class="day-number">3</div>
                        <div class="day-event live">Live: ML Dasar</div>
                    </div>
                    <div class="calendar-day"><div class="day-number">4</div></div>
                    <div class="calendar-day"><div class="day-number">5</div></div>

                    <div class="calendar-day"><div class="day-number">6</div></div>
                    <div class="calendar-day">
                        <div class="day-number">7</div>
                        <div class="day-event live">Live: UI/UX</div>
                    </div>
                    <div class="calendar-day">
                        <div class="day-number">8</div>
                        <div class="day-event live">Live: Web Dev</div>
                    </div>
                    <div class="calendar-day">
                        <div class="day-number">9</div>
                        <div class="day-event webinar">Workshop Database</div>
                    </div>
                    <div class="calendar-day">
                        <div class="day-number">10</div>
                        <div class="day-event deadline">Deadline: Tugas ML</div>
                    </div>
                    <div class="calendar-day"><div class="day-number">11</div></div>
                    <div class="calendar-day"><div class="day-number">12</div></div>

                    <div class="calendar-day"><div class="day-number">13</div></div>
                    <div class="calendar-day">
                        <div class="day-number">14</div>
                        <div class="day-event live">Live: UI/UX</div>
                    </div>
                    <div class="calendar-day">
                        <div class="day-number">15</div>
                        <div class="day-event live">Live: Web Dev</div>
                    </div>
                    <div class="calendar-day">
                        <div class="day-number">16</div>
                        <div class="day-event webinar">Webinar DevOps</div>
                    </div>
                    <div class="calendar-day">
                        <div class="day-number">17</div>
                        <div class="day-event live">Live: ML Dasar</div>
                    </div>
                    <div class="calendar-day"><div class="day-number">18</div></div>
                    <div class="calendar-day"><div class="day-number">19</div></div>

                    <div class="calendar-day"><div class="day-number">20</div></div>
                    <div class="calendar-day">
                        <div class="day-number">21</div>
                        <div class="day-event live">Live: UI/UX</div>
                    </div>
                    <div class="calendar-day today">
                        <div class="day-number">22</div>
                        <div class="day-event live">Live: Web Dev</div>
                        <div class="day-event deadline">Deadline: Project</div>
                    </div>
                    <div class="calendar-day">
                        <div class="day-number">23</div>
                        <div class="day-event webinar">Webinar Security</div>
                    </div>
                    <div class="calendar-day">
                        <div class="day-number">24</div>
                        <div class="day-event live">Live: ML Dasar</div>
                    </div>
                    <div class="calendar-day">
                        <div class="day-number">25</div>
                        <div class="day-event deadline">Deadline: Quiz</div>
                    </div>
                    <div class="calendar-day"><div class="day-number">26</div></div>

                    <div class="calendar-day"><div class="day-number">27</div></div>
                    <div class="calendar-day">
                        <div class="day-number">28</div>
                        <div class="day-event live">Live: UI/UX</div>
                    </div>
                    <div class="calendar-day">
                        <div class="day-number">29</div>
                        <div class="day-event live">Live: Web Dev</div>
                    </div>
                    <div class="calendar-day">
                        <div class="day-number">30</div>
                        <div class="day-event webinar">Webinar Cloud</div>
                    </div>
                    <div class="calendar-day"><div class="day-number">31</div></div>
                    <div class="calendar-day other-month"><div class="day-number">1</div></div>
                    <div class="calendar-day other-month"><div class="day-number">2</div></div>
                </div>
            </div>

            <div class="list-view" id="listView">
                <div class="schedule-list">
                    <div class="day-section">
                        <div class="day-section-header">
                            <div class="day-section-title">Senin, 21 Oktober 2024</div>
                        </div>
                        <div class="schedule-card live">
                            <div class="schedule-time">
                                <span>🕐</span>
                                <span>08:00 - 10:00 WIB</span>
                            </div>
                            <div class="schedule-title">Sesi Live: Pemrograman Web Lanjut</div>
                            <div class="schedule-meta">
                                <div class="schedule-meta-item">
                                    <span>👨‍🏫</span>
                                    <span>Dr. Budi Santoso</span>
                                </div>
                                <div class="schedule-meta-item">
                                    <span>📹</span>
                                    <span>Zoom Meeting</span>
                                </div>
                            </div>
                            <span class="schedule-badge badge-live">Live Session</span>
                            <button class="join-btn">Gabung Sekarang</button>
                        </div>

                        <div class="schedule-card webinar">
                            <div class="schedule-time">
                                <span>🕐</span>
                                <span>13:00 - 15:00 WIB</span>
                            </div>
                            <div class="schedule-title">Webinar: Tips Desain UI/UX Modern</div>
                            <div class="schedule-meta">
                                <div class="schedule-meta-item">
                                    <span>👨‍🏫</span>
                                    <span>Andi Wijaya, M.Kom</span>
                                </div>
                                <div class="schedule-meta-item">
                                    <span>🌐</span>
                                    <span>Google Meet</span>
                                </div>
                            </div>
                            <span class="schedule-badge badge-webinar">Webinar</span>
                            <button class="join-btn">Daftar Webinar</button>
                        </div>
                    </div>

                    <div class="day-section">
                        <div class="day-section-header">
                            <div class="day-section-title">Selasa, 22 Oktober 2024 • Hari Ini</div>
                        </div>
                        <div class="schedule-card live">
                            <div class="schedule-time">
                                <span>🕐</span>
                                <span>08:00 - 10:00 WIB</span>
                            </div>
                            <div class="schedule-title">Sesi Live: Pemrograman Web Lanjut</div>
                            <div class="schedule-meta">
                                <div class="schedule-meta-item">
                                    <span>👨‍🏫</span>
                                    <span>Dr. Budi Santoso</span>
                                </div>
                                <div class="schedule-meta-item">
                                    <span>📹</span>
                                    <span>Zoom Meeting</span>
                                </div>
                            </div>
                            <span class="schedule-badge badge-live">Live Session</span>
                            <button class="join-btn">Gabung Sekarang</button>
                        </div>

                        <div class="schedule-card deadline">
                            <div class="schedule-time">
                                <span>⏰</span>
                                <span>Deadline: 23:59 WIB</span>
                            </div>
                            <div class="schedule-title">Deadline: Project Website E-Commerce</div>
                            <div class="schedule-meta">
                                <div class="schedule-meta-item">
                                    <span>📋</span>
                                    <span>Tugas Akhir</span>
                                </div>
                                <div class="schedule-meta-item">
                                    <span>💻</span>
                                    <span>Pemrograman Web Lanjut</span>
                                </div>
                            </div>
                            <span class="schedule-badge badge-deadline">Deadline Hari Ini</span>
                        </div>
                    </div>

                    <div class="day-section">
                        <div class="day-section-header">
                            <div class="day-section-title">Rabu, 23 Oktober 2024</div>
                        </div>
                        <div class="schedule-card webinar">
                            <div class="schedule-time">
                                <span>🕐</span>
                                <span>14:00 - 16:00 WIB</span>
                            </div>
                            <div class="schedule-title">Workshop: Database Design Best Practices</div>
                            <div class="schedule-meta">
                                <div class="schedule-meta-item">
                                    <span>👨‍🏫</span>
                                    <span>Ir. Joko Widodo, M.T</span>
                                </div>
                                <div class="schedule-meta-item">
                                    <span>🌐</span>
                                    <span>Microsoft Teams</span>
                                </div>
                            </div>
                            <span class="schedule-badge badge-webinar">Workshop</span>
                            <button class="join-btn">Daftar Workshop</button>
                        </div>
                    </div>

                    <div class="day-section">
                        <div class="day-section-header">
                            <div class="day-section-title">Kamis, 24 Oktober 2024</div>
                        </div>
                        <div class="schedule-card live">
                            <div class="schedule-time">
                                <span>🕐</span>
                                <span>09:00 - 11:00 WIB</span>
                            </div>
                            <div class="schedule-title">Sesi Live: Machine Learning Dasar</div>
                            <div class="schedule-meta">
                                <div class="schedule-meta-item">
                                    <span>👩‍🏫</span>
                                    <span>Dr. Maya Sari, S.Kom</span>
                                </div>
                                <div class="schedule-meta-item">
                                    <span>📹</span>
                                    <span>Zoom Meeting</span>
                                </div>
                            </div>
                            <span class="schedule-badge badge-live">Live Session</span>
                            <button class="join-btn">Set Reminder</button>
                        </div>
                    </div>

                    <div class="day-section">
                        <div class="day-section-header">
                            <div class="day-section-title">Jumat, 25 Oktober 2024</div>
                        </div>
                        <div class="schedule-card deadline">
                            <div class="schedule-time">
                                <span>⏰</span>
                                <span>Deadline: 23:59 WIB</span>
                            </div>
                            <div class="schedule-title">Deadline: Quiz Algoritma Sorting</div>
                            <div class="schedule-meta">
                                <div class="schedule-meta-item">
                                    <span>📝</span>
                                    <span>Quiz Online</span>
                                </div>
                                <div class="schedule-meta-item">
                                    <span>🔢</span>
                                    <span>Struktur Data & Algoritma</span>
                                </div>
                            </div>
                            <span class="schedule-badge badge-deadline">Deadline</span>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        function changeView(view) {
            const calendarView = document.getElementById('calendarView');
            const listView = document.getElementById('listView');
            const btns = document.querySelectorAll('.view-btn');
            
            btns.forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            
            if (view === 'calendar') {
                calendarView.classList.add('active');
                listView.classList.remove('active');
            } else {
                calendarView.classList.remove('active');
                listView.classList.add('active');
            }
        }
    </script>
</body>
</html>