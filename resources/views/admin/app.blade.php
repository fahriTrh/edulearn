<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - EduLearn</title>
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

        .admin-badge {
            background: rgba(255, 255, 255, 0.2);
            padding: 0.3rem 0.8rem;
            border-radius: 15px;
            font-size: 0.75rem;
            margin-top: 0.5rem;
            display: inline-block;
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
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 600;
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

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: transform 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
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

        .stat-icon.blue {
            background: rgba(102, 126, 234, 0.1);
        }

        .stat-icon.green {
            background: rgba(46, 213, 115, 0.1);
        }

        .stat-icon.orange {
            background: rgba(255, 165, 2, 0.1);
        }

        .stat-icon.purple {
            background: rgba(118, 75, 162, 0.1);
        }

        .stat-info h3 {
            font-size: 1.8rem;
            color: #667eea;
            margin-bottom: 0.2rem;
        }

        .stat-info p {
            color: #666;
            font-size: 0.9rem;
        }

        .stat-change {
            font-size: 0.85rem;
            margin-top: 0.3rem;
        }

        .stat-change.positive {
            color: #2ed573;
        }

        .stat-change.negative {
            color: #ff4757;
        }

        .content-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .card {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .card-title {
            font-size: 1.2rem;
            font-weight: 600;
        }

        .view-all {
            color: #667eea;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .chart-container {
            height: 300px;
            display: flex;
            align-items: flex-end;
            justify-content: space-around;
            gap: 0.5rem;
        }

        .chart-bar {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
        }

        .bar {
            width: 100%;
            background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
            border-radius: 8px 8px 0 0;
            transition: all 0.3s;
            position: relative;
        }

        .bar:hover {
            opacity: 0.8;
        }

        .bar-value {
            position: absolute;
            top: -25px;
            left: 50%;
            transform: translateX(-50%);
            font-weight: 600;
            color: #667eea;
            font-size: 0.85rem;
        }

        .bar-label {
            font-size: 0.85rem;
            color: #666;
        }

        .activity-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .activity-item {
            display: flex;
            gap: 1rem;
            padding: 1rem;
            background: #f5f7fa;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .activity-item:hover {
            background: #e8ebf0;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .activity-icon.user {
            background: rgba(102, 126, 234, 0.1);
        }

        .activity-icon.course {
            background: rgba(46, 213, 115, 0.1);
        }

        .activity-icon.cert {
            background: rgba(255, 165, 2, 0.1);
        }

        .activity-info {
            flex: 1;
        }

        .activity-title {
            font-weight: 600;
            margin-bottom: 0.2rem;
        }

        .activity-time {
            color: #666;
            font-size: 0.85rem;
        }

        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #f5f7fa;
        }

        th {
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: #333;
            border-bottom: 2px solid #e8ebf0;
        }

        td {
            padding: 1rem;
            border-bottom: 1px solid #e8ebf0;
        }

        tr:hover {
            background: #f5f7fa;
        }

        .status-badge {
            padding: 0.3rem 0.8rem;
            border-radius: 15px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-active {
            background: rgba(46, 213, 115, 0.1);
            color: #2ed573;
        }

        .badge-pending {
            background: rgba(255, 165, 2, 0.1);
            color: #ffa502;
        }

        .badge-inactive {
            background: rgba(255, 71, 87, 0.1);
            color: #ff4757;
        }

        .action-btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
            margin: 0 0.2rem;
        }

        .btn-edit {
            background: #667eea;
            color: white;
        }

        .btn-delete {
            background: #ff4757;
            color: white;
        }

        .btn-view {
            background: #f5f7fa;
            color: #667eea;
        }

        .action-btn:hover {
            transform: translateY(-2px);
        }

        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
        }

        .quick-action-btn {
            padding: 1rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            font-weight: 600;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s;
        }

        .quick-action-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .quick-action-icon {
            font-size: 2rem;
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
                transform: translateX(-100%);
            }

            .main-content {
                margin-left: 0;
                padding: 1rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .quick-actions {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>

    @stack('styles')
</head>

<body>
    <div class="dashboard">
        <aside class="sidebar">
            <div class="logo-section">
                EduLearn
                <div class="admin-badge">🔐 Admin Panel</div>
            </div>
            <div style="padding: 2rem 0;">
                <a href="/dashboard-admin"
                    class="menu-item {{ Request::is('dashboard-admin') ? 'active' : '' }}"
                    style="text-decoration: none; color: inherit;">
                    <span>📊</span>Dashboard
                </a>
                <a href="/kelola-mahasiswa"
                    class="menu-item {{ Request::is('kelola-mahasiswa') ? 'active' : '' }}"
                    style="text-decoration: none; color: inherit;">
                    <span>👥</span>Kelola Mahasiswa
                </a>
                <a href="/kelola-instruktur"
                    class="menu-item {{ Request::is('kelola-instruktur') ? 'active' : '' }}"
                    style="text-decoration: none; color: inherit;">
                    <span>👨‍🏫</span> Kelola Instruktur
                </a>

                <!-- <a class="menu-item" style="text-decoration: none; color: inherit;"><span>📚</span> Kelola Kursus</a> -->
                <a class="menu-item" style="text-decoration: none; color: inherit;"><span>🚪</span> Logout</a>
                <!-- <div class="menu-item"><span>📝</span> Kelola Konten</div>
                <div class="menu-item"><span>✍️</span> Review Tugas</div>
                <div class="menu-item"><span>📈</span> Laporan & Analitik</div>
                <div class="menu-item"><span>🏆</span> Sertifikat</div>
                <div class="menu-item"><span>💬</span> Moderasi Forum</div>
                <div class="menu-item"><span>⚙️</span> Pengaturan</div> -->
            </div>
        </aside>

        <main class="main-content">
            <div class="top-bar">
                <div>
                    <div class="page-title">{{ $title }}</div>
                    <div style="color: #666; font-size: 0.9rem; margin-top: 0.3rem;">
                        {{ $sub_title }}
                    </div>
                </div>
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div style="width: 40px; height: 40px; background: #f5f7fa; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                        🔔
                    </div>
                    <div class="user-avatar" id="adminAvatar" data-name="{{ $admin_name }}">AD</div>
                    <div>
                        <div style="font-weight: 600;">{{ $admin_name }}</div>
                        <div style="font-size: 0.85rem; color: #666;">Administrator</div>
                    </div>
                </div>
            </div>

            <!-- main -->
            @yield('content')

        </main>

        <form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display:none;">
            @csrf
        </form>
    </div>

    <script>
        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: ${type === 'success' ? '#2ed573' : type === 'error' ? '#ff4757' : '#667eea'};
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
            if (!document.querySelector('style[data-notification]')) {
                style.setAttribute('data-notification', 'true');
                document.head.appendChild(style);
            }

            document.body.appendChild(notification);
            setTimeout(() => {
                notification.style.animation = 'slideIn 0.3s ease reverse';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }

        // Menu interaction
        document.querySelectorAll('.menu-item').forEach(item => {
            item.addEventListener('click', function() {
                if (this.textContent.includes('Logout')) {
                    if (confirm('Apakah Anda yakin ingin logout?')) {
                        // showNotification('👋 Logout berhasil! Sampai jumpa lagi.', 'success');
                        document.getElementById('logoutForm').submit();
                    }
                } else {
                    document.querySelectorAll('.menu-item').forEach(i => i.classList.remove('active'));
                    this.classList.add('active');
                    showNotification(`Navigasi ke: ${this.textContent.trim()}`, 'info');
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const avatarElement = document.getElementById('adminAvatar');
            const adminName = avatarElement.getAttribute('data-name');

            function generateInitials(name) {
                if (!name || name.trim() === '') return 'AD';

                const words = name.trim().split(/\s+/);
                let initials = '';

                if (words.length >= 2) {
                    initials = words[0].charAt(0) + words[words.length - 1].charAt(0);
                } else {
                    initials = name.substring(0, 2);
                }

                return initials.toUpperCase();
            }

            avatarElement.textContent = generateInitials(adminName);
        });
    </script>
    @stack('scripts')
</body>

</html>