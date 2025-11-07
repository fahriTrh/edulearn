<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

        .instructor-badge {
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
            flex-wrap: wrap;
            gap: 1rem;
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

        .welcome-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
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

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .section-title {
            font-size: 1.3rem;
            font-weight: 600;
        }

        .btn-primary {
            padding: 0.8rem 1.5rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .card {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 2rem;
        }

        .classes-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .class-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
            cursor: pointer;
        }

        .class-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .class-header {
            height: 120px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
        }

        .class-body {
            padding: 1.5rem;
        }

        .class-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .class-meta {
            display: flex;
            gap: 1rem;
            margin: 1rem 0;
            font-size: 0.85rem;
            color: #666;
        }

        .class-actions {
            display: flex;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .btn-action {
            flex: 1;
            padding: 0.6rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
            font-size: 0.85rem;
        }

        .btn-manage {
            background: #667eea;
            color: white;
        }

        .btn-students {
            background: #f5f7fa;
            color: #667eea;
        }

        .assignments-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .assignment-item {
            padding: 1rem;
            border: 1px solid #e8ebf0;
            border-radius: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s;
        }

        .assignment-item:hover {
            border-color: #667eea;
            background: #f5f7fa;
        }

        .assignment-info h4 {
            margin-bottom: 0.3rem;
        }

        .assignment-meta {
            font-size: 0.85rem;
            color: #666;
        }

        .pending-badge {
            background: rgba(255, 165, 2, 0.1);
            color: #ffa502;
            padding: 0.3rem 0.8rem;
            border-radius: 15px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
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
            padding: 2rem;
            border-radius: 15px;
            max-width: 600px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .close-modal {
            background: none;
            border: none;
            font-size: 1.5rem;
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

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 0.8rem;
            border: 2px solid #e8ebf0;
            border-radius: 8px;
            outline: none;
            font-family: inherit;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: #667eea;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 120px;
        }

        .file-upload {
            border: 2px dashed #667eea;
            border-radius: 8px;
            padding: 2rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }

        .file-upload:hover {
            background: rgba(102, 126, 234, 0.05);
        }

        .submit-btn {
            width: 100%;
            padding: 0.8rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 1rem;
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

            .classes-grid {
                grid-template-columns: 1fr;
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
                <div class="instructor-badge">👨‍🏫 Instruktur</div>
            </div>
            <div style="padding: 2rem 0;">
                <a href="/dashboard-dosen"
                    class="menu-item {{ Request::is('dashboard-dosen') ? 'active' : '' }}"
                    style="text-decoration: none; color: inherit;">
                    <span>📊</span>Dashboard
                </a>
                <a href="/kelas-saya"
                    class="menu-item {{ Request::is('kelas-saya*') ? 'active' : '' }}"
                    style="text-decoration: none; color: inherit;">
                    <span>📚</span> Kelas Saya
                </a>
                <a href="/ubah-password"
                    class="menu-item {{ Request::is('ubah-password*') ? 'active' : '' }}"
                    style="text-decoration: none; color: inherit;">
                    <span>🔒</span> Ubah Password
                </a>
                <a class="menu-item" style="text-decoration: none; color: inherit;"><span>🚪</span> Logout</a>
                <!-- <div class="menu-item"><span>📝</span> Materi</div>
                <div class="menu-item"><span>✍️</span> Tugas</div>
                <div class="menu-item"><span>👥</span> Mahasiswa</div>
                <div class="menu-item"><span>📈</span> Nilai</div>
                <div class="menu-item"><span>💬</span> Diskusi</div>
                <div class="menu-item"><span>⚙️</span> Pengaturan</div> -->
            </div>
        </aside>

        <main class="main-content">
            @unless (Request::is('kelas-saya/detail-kelas*') || Request::is('ubah-password'))
            <div class="top-bar">
                <div>
                    <div class="page-title">Dashboard Instruktur</div>
                    <div style="color: #666; font-size: 0.9rem; margin-top: 0.3rem;">Selamat datang kembali!</div>
                </div>
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div style="width: 40px; height: 40px; background: #f5f7fa; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer;">🔔</div>
                    <div class="user-avatar" id="userAvatar">US</div>
                    <div>
                        <div style="font-weight: 600;">{{ $instructor_name }}</div>
                        <div style="font-size: 0.85rem; color: #666;">Instruktur</div>
                    </div>
                </div>
            </div>

            <div class="welcome-section">
                <div>
                    <h2 style="margin-bottom: 0.5rem;">Selamat Datang, {{ $instructor_name }}! 👋</h2>
                    <p style="opacity: 0.9;">{{ $sub_title }}</p>
                </div>
                <a href="/kelas-saya" class="btn-primary" style="background: white; color: #667eea; text-decoration: none;" onclick="showNotification('Membuka daftar tugas pending...', 'info')">
                    <span>📋</span>
                    <span>Lihat Tugas</span>
                </a>
            </div>
            @endunless

            @yield('content')


        </main>

        <form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display:none;">
            @csrf
        </form>
    </div>

    <script>
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

        document.addEventListener('DOMContentLoaded', function() {
            const instructorName = "{{ $instructor_name }}";
            const avatarElement = document.getElementById('userAvatar');

            function getInitials(name) {
                if (!name) return 'US';

                const words = name.split(' ');
                let initials = '';

                if (words.length >= 2) {
                    // Ambil huruf pertama dari kata pertama dan terakhir
                    initials = words[0].charAt(0) + words[words.length - 1].charAt(0);
                } else {
                    // Ambil 2 huruf pertama dari nama
                    initials = name.substring(0, 2);
                }

                return initials.toUpperCase();
            }

            avatarElement.textContent = getInitials(instructorName);
        });
    </script>

    @stack('scripts')
</body>

</html>