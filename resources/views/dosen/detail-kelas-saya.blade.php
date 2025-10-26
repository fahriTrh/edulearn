@extends('dosen.app')

@push('styles')
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

    .breadcrumb {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
        color: #666;
        font-size: 0.9rem;
    }

    .breadcrumb a {
        color: #667eea;
        text-decoration: none;
        cursor: pointer;
    }

    .breadcrumb a:hover {
        text-decoration: underline;
    }

    .class-header-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        border-radius: 12px;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }

    .class-header-content {
        display: flex;
        justify-content: space-between;
        align-items: start;
        gap: 2rem;
        flex-wrap: wrap;
    }

    .class-info {
        flex: 1;
        min-width: 300px;
    }

    .class-code-badge {
        background: rgba(255, 255, 255, 0.2);
        padding: 0.4rem 1rem;
        border-radius: 20px;
        font-size: 0.85rem;
        display: inline-block;
        margin-bottom: 1rem;
    }

    .class-title-large {
        font-size: 2rem;
        margin-bottom: 0.8rem;
        font-weight: 600;
    }

    .class-desc-large {
        opacity: 0.9;
        line-height: 1.6;
        margin-bottom: 1.5rem;
    }

    .class-meta-large {
        display: flex;
        gap: 2rem;
        flex-wrap: wrap;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.95rem;
    }

    .header-actions {
        display: flex;
        gap: 0.8rem;
        flex-wrap: wrap;
    }

    .btn-header {
        padding: 0.8rem 1.5rem;
        border: 2px solid white;
        background: transparent;
        color: white;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-header:hover {
        background: white;
        color: #667eea;
    }

    .btn-header.primary {
        background: white;
        color: #667eea;
    }

    .btn-header.primary:hover {
        background: rgba(255, 255, 255, 0.9);
    }

    .tabs-container {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        margin-bottom: 2rem;
        overflow: hidden;
    }

    .tabs {
        display: flex;
        border-bottom: 2px solid #f5f7fa;
        overflow-x: auto;
    }

    .tab {
        padding: 1rem 1.5rem;
        cursor: pointer;
        transition: all 0.3s;
        border-bottom: 3px solid transparent;
        white-space: nowrap;
        font-weight: 600;
        color: #666;
    }

    .tab:hover {
        background: #f5f7fa;
    }

    .tab.active {
        color: #667eea;
        border-bottom-color: #667eea;
        background: #f5f7fa;
    }

    .tab-content {
        display: none;
        padding: 2rem;
    }

    .tab-content.active {
        display: block;
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
        text-align: center;
    }

    .stat-icon {
        font-size: 2.5rem;
        margin-bottom: 0.5rem;
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 600;
        color: #667eea;
        margin-bottom: 0.3rem;
    }

    .stat-label {
        color: #666;
        font-size: 0.9rem;
    }

    .content-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        margin-bottom: 1.5rem;
    }

    .card-header {
        padding: 1.5rem;
        border-bottom: 1px solid #f5f7fa;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-title {
        font-size: 1.2rem;
        font-weight: 600;
    }

    .card-body {
        padding: 1.5rem;
    }

    .btn-add {
        padding: 0.6rem 1.2rem;
        background: #667eea;
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

    .btn-add:hover {
        background: #5568d3;
        transform: translateY(-2px);
    }

    .material-item,
    .assignment-item,
    .student-item {
        padding: 1rem;
        border: 1px solid #e8ebf0;
        border-radius: 8px;
        margin-bottom: 1rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.3s;
        cursor: pointer;
    }

    .material-item:hover,
    .assignment-item:hover,
    .student-item:hover {
        border-color: #667eea;
        background: #f5f7fa;
    }

    .item-icon {
        width: 50px;
        height: 50px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-right: 1rem;
    }

    .item-icon.pdf {
        background: rgba(255, 82, 82, 0.1);
    }

    .item-icon.video {
        background: rgba(255, 177, 66, 0.1);
    }

    .item-icon.link {
        background: rgba(46, 213, 115, 0.1);
    }

    .item-content {
        flex: 1;
    }

    .item-title {
        font-weight: 600;
        margin-bottom: 0.3rem;
    }

    .item-meta {
        font-size: 0.85rem;
        color: #666;
    }

    .item-actions {
        display: flex;
        gap: 0.5rem;
    }

    .btn-icon {
        width: 35px;
        height: 35px;
        border: none;
        background: #f5f7fa;
        border-radius: 6px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
    }

    .btn-icon:hover {
        background: #e8ebf0;
    }

    .badge {
        padding: 0.3rem 0.8rem;
        border-radius: 15px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .badge.pending {
        background: rgba(255, 165, 2, 0.1);
        color: #ffa502;
    }

    .badge.completed {
        background: rgba(46, 213, 115, 0.1);
        color: #2ed573;
    }

    .badge.active {
        background: rgba(46, 213, 115, 0.1);
        color: #2ed573;
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

    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: #666;
    }

    .empty-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
    }

    .progress-bar {
        width: 100%;
        height: 8px;
        background: #f5f7fa;
        border-radius: 10px;
        overflow: hidden;
        margin-top: 0.5rem;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        transition: width 0.3s;
    }

    @media (max-width: 768px) {
        .sidebar {
            transform: translateX(-100%);
        }

        .main-content {
            margin-left: 0;
            padding: 1rem;
        }

        .class-header-content {
            flex-direction: column;
        }

        .tabs {
            justify-content: start;
        }

        .tab {
            font-size: 0.9rem;
            padding: 0.8rem 1rem;
        }
    }
</style>
@endpush

@section('content')
<div class="breadcrumb">
    <a onclick="goBack()">← Kelas Saya</a>
    <span>/</span>
    <span id="breadcrumbTitle">{{ $class->title }}</span>
</div>

<div class="class-header-section">
    <div class="class-header-content">
        <div class="class-info">
            <div class="class-code-badge" id="classCodeHeader">CS301</div>
            <h1 class="class-title-large" id="classTitleHeader">{{ $class->title }}</h1>
            <p class="class-desc-large" id="classDescHeader">{{ $class->description }}</p>
            <div class="class-meta-large">
                <div class="meta-item">
                    <span>📅</span>
                    <span>{{ $class->semester }}</span>
                </div>
                <div class="meta-item">
                    <span>👥</span>
                    <span id="studentCountHeader">{{ $class->students->count() }} Mahasiswa</span>
                </div>
                <div class="meta-item">
                    <span>✅</span>
                    <span>Aktif</span>
                </div>
            </div>
        </div>
        <div class="header-actions">
            <button class="btn-header primary" onclick="openShareModal()">
                <span>📤</span>
                <span>Bagikan</span>
            </button>
            <button class="btn-header" onclick="openEditModal()">
                <span>✏️</span>
                <span>Edit</span>
            </button>
            <button class="btn-header" onclick="openSettingsModal()">
                <span>⚙️</span>
                <span>Pengaturan</span>
            </button>
        </div>
    </div>
</div>

<div class="tabs-container">
    <div class="tabs">
        <div class="tab active" onclick="switchTab('overview')">📊 Ringkasan</div>
        <div class="tab" onclick="switchTab('materials')">📝 Materi</div>
        <div class="tab" onclick="switchTab('assignments')">✍️ Tugas</div>
        <div class="tab" onclick="switchTab('students')">👥 Mahasiswa</div>
        <div class="tab" onclick="switchTab('grades')">📈 Nilai</div>
        <div class="tab" onclick="switchTab('announcements')">📢 Pengumuman</div>
    </div>

    <!-- Tab Overview -->
    <div class="tab-content active" id="overview">
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">📚</div>
                <div class="stat-value">{{ $class->materials->count() }}</div>
                <div class="stat-label">Total Materi</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">✍️</div>
                <div class="stat-value">{{ $class->assignments->count() }}</div>
                <div class="stat-label">Total Tugas</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">👥</div>
                <div class="stat-value">{{ $class->students->count() }}</div>
                <div class="stat-label">Mahasiswa Aktif</div>
            </div>
            <!-- <div class="stat-card">
                <div class="stat-icon">📊</div>
                <div class="stat-value">85%</div>
                <div class="stat-label">Rata-rata Nilai</div>
            </div> -->
        </div>

        <div class="content-card">
            <div class="card-header">
                <div class="card-title">Aktivitas Terkini</div>
            </div>
            <div class="card-body">
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    <div
                        style="padding: 1rem; background: #f5f7fa; border-radius: 8px; display: flex; align-items: center; gap: 1rem;">
                        <div
                            style="width: 40px; height: 40px; background: rgba(102, 126, 234, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            📝</div>
                        <div style="flex: 1;">
                            <div style="font-weight: 600; margin-bottom: 0.2rem;">5 mahasiswa mengumpulkan
                                tugas</div>
                            <div style="font-size: 0.85rem; color: #666;">Project Website E-Commerce • 2 jam
                                yang lalu</div>
                        </div>
                    </div>
                    <div
                        style="padding: 1rem; background: #f5f7fa; border-radius: 8px; display: flex; align-items: center; gap: 1rem;">
                        <div
                            style="width: 40px; height: 40px; background: rgba(46, 213, 115, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            💬</div>
                        <div style="flex: 1;">
                            <div style="font-weight: 600; margin-bottom: 0.2rem;">12 diskusi baru di forum
                            </div>
                            <div style="font-size: 0.85rem; color: #666;">Berbagai topik • 5 jam yang lalu
                            </div>
                        </div>
                    </div>
                    <div
                        style="padding: 1rem; background: #f5f7fa; border-radius: 8px; display: flex; align-items: center; gap: 1rem;">
                        <div
                            style="width: 40px; height: 40px; background: rgba(255, 165, 2, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            ⏰</div>
                        <div style="flex: 1;">
                            <div style="font-weight: 600; margin-bottom: 0.2rem;">Deadline tugas mendekat
                            </div>
                            <div style="font-size: 0.85rem; color: #666;">Project Website E-Commerce • 2
                                hari lagi</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab Materials -->
    <div class="tab-content" id="materials">
        <div class="content-card">
            <div class="card-header">
                <div class="card-title">Daftar Materi</div>
                <button class="btn-add" onclick="openAddMaterialModal()">
                    <span>➕</span>
                    <span>Tambah Materi</span>
                </button>
            </div>
            <div class="card-body" id="materialsList">
                <!-- Materials will be rendered here -->
            </div>
        </div>
    </div>

    <!-- Tab Assignments -->
    <div class="tab-content" id="assignments">
        <div class="content-card">
            <div class="card-header">
                <div class="card-title">Daftar Tugas</div>
                <button class="btn-add" onclick="openAddAssignmentModal()">
                    <span>➕</span>
                    <span>Tambah Tugas</span>
                </button>
            </div>
            <div class="card-body" id="assignmentsList">
                <!-- Assignments will be rendered here -->
            </div>
        </div>
    </div>

    <!-- Tab Students -->
    <div class="tab-content" id="students">
        <div class="content-card">
            <div class="card-header">
                <div class="card-title">Daftar Mahasiswa</div>
                <button class="btn-add" onclick="openAddStudentModal()">
                    <span>➕</span>
                    <span>Tambah Mahasiswa</span>
                </button>
            </div>
            <div class="card-body" id="studentsList">
                <!-- Students will be rendered here -->
            </div>
        </div>
    </div>

    <!-- Tab Grades -->
    <div class="tab-content" id="grades">
        <div class="content-card">
            <div class="card-header">
                <div class="card-title">Rekapitulasi Nilai</div>
                <button class="btn-add" onclick="exportGrades()">
                    <span>📥</span>
                    <span>Export</span>
                </button>
            </div>
            <div class="card-body">
                <div class="empty-state">
                    <div class="empty-icon">📊</div>
                    <h3>Rekapitulasi Nilai</h3>
                    <p>Nilai akan ditampilkan setelah ada tugas yang dinilai</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab Announcements -->
    <div class="tab-content" id="announcements">
        <div class="content-card">
            <div class="card-header">
                <div class="card-title">Pengumuman Kelas</div>
                <button class="btn-add" onclick="openAddAnnouncementModal()">
                    <span>➕</span>
                    <span>Buat Pengumuman</span>
                </button>
            </div>
            <div class="card-body">
                <div class="empty-state">
                    <div class="empty-icon">📢</div>
                    <h3>Belum Ada Pengumuman</h3>
                    <p>Buat pengumuman pertama untuk kelas ini</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add Material -->
<div class="modal" id="addMaterialModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Tambah Materi Baru</h2>
            <button class="close-modal" onclick="closeModal('addMaterialModal')">✕</button>
        </div>
        <form onsubmit="submitMaterial(event)">
            <div class="form-group">
                <label>Judul Materi</label>
                <input type="text" id="materialTitle" placeholder="e.g., Pengenalan React Hooks" required>
            </div>
            <div class="form-group">
                <label>Tipe Materi</label>
                <select id="materialType" required>
                    <option value="pdf">PDF Document</option>
                    <option value="video">Video</option>
                    <option value="link">Link/URL</option>
                </select>
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <textarea id="materialDesc" placeholder="Deskripsi materi..."></textarea>
            </div>
            <button type="submit" class="submit-btn">Tambah Materi</button>
        </form>
    </div>
</div>

<!-- Modal Add Assignment -->
<div class="modal" id="addAssignmentModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Buat Tugas Baru</h2>
            <button class="close-modal" onclick="closeModal('addAssignmentModal')">✕</button>
        </div>
        <form onsubmit="submitAssignment(event)">
            <div class="form-group">
                <label>Judul Tugas</label>
                <input type="text" id="assignmentTitle" placeholder="e.g., Project Website E-Commerce" required>
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <textarea id="assignmentDesc" placeholder="Deskripsi tugas..." required></textarea>
            </div>
            <div class="form-group">
                <label>Deadline</label>
                <input type="datetime-local" id="assignmentDeadline" required>
            </div>
            <div class="form-group">
                <label>Bobot Nilai (%)</label>
                <input type="number" id="assignmentWeight" min="0" max="100" placeholder="20" required>
            </div>
            <button type="submit" class="submit-btn">Buat Tugas</button>
        </form>
    </div>
</div>

<!-- Modal Add Student -->
<div class="modal" id="addStudentModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Tambah Mahasiswa</h2>
            <button class="close-modal" onclick="closeModal('addStudentModal')">✕</button>
        </div>
        <form onsubmit="submitStudent(event)">
            <div class="form-group">
                <label>NIM</label>
                <input type="text" id="studentNIM" placeholder="e.g., 11220001" required>
            </div>
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" id="studentName" placeholder="e.g., Ahmad Rizki" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" id="studentEmail" placeholder="e.g., ahmad@email.com" required>
            </div>
            <button type="submit" class="submit-btn">Tambah Mahasiswa</button>
        </form>
    </div>
</div>
@endsection
@push('scripts')
<script>
    let materials = [{
            id: 1,
            title: "Pengenalan React Hooks",
            type: "pdf",
            uploadDate: "2024-10-20",
            downloads: 42
        },
        {
            id: 2,
            title: "Video Tutorial: useState & useEffect",
            type: "video",
            uploadDate: "2024-10-18",
            downloads: 38
        },
        {
            id: 3,
            title: "Dokumentasi React Official",
            type: "link",
            uploadDate: "2024-10-15",
            downloads: 35
        }
    ];

    let assignments = [{
            id: 1,
            title: "Project Website E-Commerce",
            deadline: "2024-10-27",
            submissions: 12,
            total: 45,
            status: "pending"
        },
        {
            id: 2,
            title: "Quiz React Fundamentals",
            deadline: "2024-10-25",
            submissions: 45,
            total: 45,
            status: "completed"
        },
        {
            id: 3,
            title: "Latihan Component State",
            deadline: "2024-10-30",
            submissions: 0,
            total: 45,
            status: "pending"
        }
    ];

    let students = [{
            id: 1,
            nim: "11220001",
            name: "Ahmad Rizki",
            email: "ahmad@email.com",
            attendance: 95
        },
        {
            id: 2,
            nim: "11220002",
            name: "Siti Nurhaliza",
            email: "siti@email.com",
            attendance: 90
        },
        {
            id: 3,
            nim: "11220003",
            name: "Budi Santoso",
            email: "budi@email.com",
            attendance: 88
        },
        {
            id: 4,
            nim: "11220004",
            name: "Dewi Lestari",
            email: "dewi@email.com",
            attendance: 92
        }
    ];

    function switchTab(tabName) {
        document.querySelectorAll('.tab').forEach(tab => tab.classList.remove('active'));
        document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));

        event.target.classList.add('active');
        document.getElementById(tabName).classList.add('active');

        if (tabName === 'materials') renderMaterials();
        if (tabName === 'assignments') renderAssignments();
        if (tabName === 'students') renderStudents();
    }

    function renderMaterials() {
        const container = document.getElementById('materialsList');
        if (materials.length === 0) {
            container.innerHTML = `
                    <div class="empty-state">
                        <div class="empty-icon">📚</div>
                        <h3>Belum Ada Materi</h3>
                        <p>Tambahkan materi pertama untuk kelas ini</p>
                    </div>
                `;
            return;
        }

        const typeIcons = {
            pdf: '📄',
            video: '🎥',
            link: '🔗'
        };

        container.innerHTML = materials.map(material => `
                <div class="material-item" onclick="viewMaterial(${material.id})">
                    <div style="display: flex; align-items: center; flex: 1;">
                        <div class="item-icon ${material.type}">
                            ${typeIcons[material.type]}
                        </div>
                        <div class="item-content">
                            <div class="item-title">${material.title}</div>
                            <div class="item-meta">
                                Diunggah: ${material.uploadDate} • ${material.downloads} downloads
                            </div>
                        </div>
                    </div>
                    <div class="item-actions">
                        <button class="btn-icon" onclick="editMaterial(${material.id}, event)" title="Edit">✏️</button>
                        <button class="btn-icon" onclick="downloadMaterial(${material.id}, event)" title="Download">📥</button>
                        <button class="btn-icon" onclick="deleteMaterial(${material.id}, event)" title="Hapus">🗑️</button>
                    </div>
                </div>
            `).join('');
    }

    function renderAssignments() {
        const container = document.getElementById('assignmentsList');
        if (assignments.length === 0) {
            container.innerHTML = `
                    <div class="empty-state">
                        <div class="empty-icon">✍️</div>
                        <h3>Belum Ada Tugas</h3>
                        <p>Buat tugas pertama untuk kelas ini</p>
                    </div>
                `;
            return;
        }

        container.innerHTML = assignments.map(assignment => {
            const percentage = Math.round((assignment.submissions / assignment.total) * 100);
            return `
                    <div class="assignment-item" onclick="viewAssignment(${assignment.id})">
                        <div style="flex: 1;">
                            <div style="display: flex; align-items: center; gap: 0.8rem; margin-bottom: 0.5rem;">
                                <div class="item-title">${assignment.title}</div>
                                <span class="badge ${assignment.status}">${assignment.status === 'completed' ? '✓ Selesai' : 'Pending'}</span>
                            </div>
                            <div class="item-meta">
                                Deadline: ${assignment.deadline} • ${assignment.submissions}/${assignment.total} mahasiswa mengumpulkan
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: ${percentage}%"></div>
                            </div>
                        </div>
                        <div class="item-actions">
                            <button class="btn-icon" onclick="gradeAssignment(${assignment.id}, event)" title="Nilai">📊</button>
                            <button class="btn-icon" onclick="editAssignment(${assignment.id}, event)" title="Edit">✏️</button>
                            <button class="btn-icon" onclick="deleteAssignment(${assignment.id}, event)" title="Hapus">🗑️</button>
                        </div>
                    </div>
                `;
        }).join('');
    }

    function renderStudents() {
        const container = document.getElementById('studentsList');
        if (students.length === 0) {
            container.innerHTML = `
                    <div class="empty-state">
                        <div class="empty-icon">👥</div>
                        <h3>Belum Ada Mahasiswa</h3>
                        <p>Tambahkan mahasiswa ke kelas ini</p>
                    </div>
                `;
            return;
        }

        container.innerHTML = students.map(student => `
                <div class="student-item" onclick="viewStudent(${student.id})">
                    <div style="display: flex; align-items: center; flex: 1;">
                        <div style="width: 50px; height: 50px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; margin-right: 1rem;">
                            ${student.name.split(' ').map(n => n[0]).join('').substring(0, 2)}
                        </div>
                        <div class="item-content">
                            <div class="item-title">${student.name}</div>
                            <div class="item-meta">
                                ${student.nim} • ${student.email} • Kehadiran: ${student.attendance}%
                            </div>
                        </div>
                    </div>
                    <div class="item-actions">
                        <button class="btn-icon" onclick="viewStudentProgress(${student.id}, event)" title="Progress">📊</button>
                        <button class="btn-icon" onclick="sendMessage(${student.id}, event)" title="Pesan">💬</button>
                        <button class="btn-icon" onclick="removeStudent(${student.id}, event)" title="Hapus">🗑️</button>
                    </div>
                </div>
            `).join('');
    }

    // Material Functions
    function viewMaterial(id) {
        const material = materials.find(m => m.id === id);
        showNotification(`Membuka materi: ${material.title}`, 'info');
    }

    function editMaterial(id, event) {
        event.stopPropagation();
        const material = materials.find(m => m.id === id);
        showNotification(`Mengedit materi: ${material.title}`, 'info');
    }

    function downloadMaterial(id, event) {
        event.stopPropagation();
        const material = materials.find(m => m.id === id);
        showNotification(`Mengunduh materi: ${material.title}`, 'success');
    }

    function deleteMaterial(id, event) {
        event.stopPropagation();
        if (confirm('Yakin ingin menghapus materi ini?')) {
            materials = materials.filter(m => m.id !== id);
            renderMaterials();
            showNotification('Materi berhasil dihapus', 'success');
        }
    }

    // Assignment Functions
    function viewAssignment(id) {
        const assignment = assignments.find(a => a.id === id);
        showNotification(`Membuka tugas: ${assignment.title}`, 'info');
    }

    function gradeAssignment(id, event) {
        event.stopPropagation();
        const assignment = assignments.find(a => a.id === id);
        showNotification(`Menilai tugas: ${assignment.title}`, 'info');
    }

    function editAssignment(id, event) {
        event.stopPropagation();
        const assignment = assignments.find(a => a.id === id);
        showNotification(`Mengedit tugas: ${assignment.title}`, 'info');
    }

    function deleteAssignment(id, event) {
        event.stopPropagation();
        if (confirm('Yakin ingin menghapus tugas ini?')) {
            assignments = assignments.filter(a => a.id !== id);
            renderAssignments();
            showNotification('Tugas berhasil dihapus', 'success');
        }
    }

    // Student Functions
    function viewStudent(id) {
        const student = students.find(s => s.id === id);
        showNotification(`Membuka profil: ${student.name}`, 'info');
    }

    function viewStudentProgress(id, event) {
        event.stopPropagation();
        const student = students.find(s => s.id === id);
        showNotification(`Melihat progress: ${student.name}`, 'info');
    }

    function sendMessage(id, event) {
        event.stopPropagation();
        const student = students.find(s => s.id === id);
        showNotification(`Mengirim pesan ke: ${student.name}`, 'info');
    }

    function removeStudent(id, event) {
        event.stopPropagation();
        if (confirm('Yakin ingin mengeluarkan mahasiswa dari kelas ini?')) {
            students = students.filter(s => s.id !== id);
            renderStudents();
            showNotification('Mahasiswa berhasil dikeluarkan', 'success');
        }
    }

    // Modal Functions
    function openAddMaterialModal() {
        document.getElementById('addMaterialModal').classList.add('active');
    }

    function openAddAssignmentModal() {
        document.getElementById('addAssignmentModal').classList.add('active');
    }

    function openAddStudentModal() {
        document.getElementById('addStudentModal').classList.add('active');
    }

    function openShareModal() {
        showNotification('Kode kelas: CS301-2024 (salin untuk dibagikan)', 'info');
    }

    function openEditModal() {
        showNotification('Membuka form edit kelas...', 'info');
    }

    function openSettingsModal() {
        showNotification('Membuka pengaturan kelas...', 'info');
    }

    function openAddAnnouncementModal() {
        showNotification('Membuka form pengumuman...', 'info');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.remove('active');
    }

    function exportGrades() {
        showNotification('Mengexport nilai ke Excel...', 'success');
    }

    // Form Submissions
    function submitMaterial(e) {
        e.preventDefault();
        const newMaterial = {
            id: materials.length + 1,
            title: document.getElementById('materialTitle').value,
            type: document.getElementById('materialType').value,
            uploadDate: new Date().toISOString().split('T')[0],
            downloads: 0
        };
        materials.unshift(newMaterial);
        renderMaterials();
        closeModal('addMaterialModal');
        showNotification('✅ Materi berhasil ditambahkan!', 'success');
        e.target.reset();
    }

    function submitAssignment(e) {
        e.preventDefault();
        const newAssignment = {
            id: assignments.length + 1,
            title: document.getElementById('assignmentTitle').value,
            deadline: document.getElementById('assignmentDeadline').value.split('T')[0],
            submissions: 0,
            total: 45,
            status: 'pending'
        };
        assignments.unshift(newAssignment);
        renderAssignments();
        closeModal('addAssignmentModal');
        showNotification('✅ Tugas berhasil dibuat!', 'success');
        e.target.reset();
    }

    function submitStudent(e) {
        e.preventDefault();
        const newStudent = {
            id: students.length + 1,
            nim: document.getElementById('studentNIM').value,
            name: document.getElementById('studentName').value,
            email: document.getElementById('studentEmail').value,
            attendance: 100
        };
        students.push(newStudent);
        renderStudents();
        closeModal('addStudentModal');
        showNotification('✅ Mahasiswa berhasil ditambahkan!', 'success');
        e.target.reset();
    }

    function goBack() {
        showNotification('Kembali ke halaman Kelas Saya...', 'info');
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
        document.body.appendChild(notification);
        setTimeout(() => {
            notification.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    // Close modals when clicking outside
    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.remove('active');
            }
        });
    });

    // Menu navigation
    document.querySelectorAll('.menu-item').forEach(item => {
        item.addEventListener('click', function() {
            document.querySelectorAll('.menu-item').forEach(i => i.classList.remove('active'));
            this.classList.add('active');
            showNotification(`Navigasi ke: ${this.textContent.trim()}`, 'info');
        });
    });

    // Initialize
    renderMaterials();
    renderAssignments();
    renderStudents();
</script>
@endpush