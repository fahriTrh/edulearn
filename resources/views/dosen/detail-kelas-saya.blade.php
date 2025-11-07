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
    .student-item:hover {
        border-color: #667eea;
        background: #f5f7fa;
    }

    /* Assignment Item Styles */
    .assignment-wrapper {
        margin-bottom: 1.5rem;
        border: 1px solid #e8ebf0;
        border-radius: 8px;
        overflow: hidden;
        transition: all 0.3s;
    }

    .assignment-wrapper:hover {
        border-color: #667eea;
        box-shadow: 0 2px 8px rgba(102, 126, 234, 0.1);
    }

    .assignment-header {
        padding: 1rem;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: white;
        transition: all 0.3s;
    }

    .assignment-header:hover {
        background: #f5f7fa;
    }

    .assignment-header.active {
        background: #f5f7fa;
        border-bottom: 1px solid #e8ebf0;
    }

    .assignment-main-info {
        flex: 1;
    }

    .assignment-title-row {
        display: flex;
        align-items: center;
        gap: 0.8rem;
        margin-bottom: 0.5rem;
    }

    .assignment-title {
        font-weight: 600;
        font-size: 1.1rem;
    }

    .assignment-meta {
        font-size: 0.85rem;
        color: #666;
        margin-bottom: 0.5rem;
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

    .assignment-actions {
        display: flex;
        gap: 0.5rem;
    }

    /* Accordion Content */
    .assignment-detail {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease;
        background: #f8f9fa;
    }

    .assignment-detail.active {
        max-height: 2000px;
        border-top: 1px solid #e8ebf0;
    }

    .assignment-detail-content {
        padding: 1.5rem;
    }

    .detail-section-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: #333;
    }

    /* Submission List */
    .submission-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .submission-item {
        background: white;
        padding: 1.5rem;
        border-radius: 8px;
        border: 1px solid #e8ebf0;
        transition: all 0.3s;
    }

    .submission-item:hover {
        border-color: #667eea;
        box-shadow: 0 2px 8px rgba(102, 126, 234, 0.1);
    }

    .submission-header-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #f5f7fa;
    }

    .student-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .student-avatar {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 1rem;
    }

    .student-details {
        flex: 1;
    }

    .student-name {
        font-weight: 600;
        font-size: 1rem;
        margin-bottom: 0.2rem;
    }

    .student-nim {
        font-size: 0.85rem;
        color: #666;
    }

    .submission-status {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 0.3rem;
    }

    .submission-time {
        font-size: 0.85rem;
        color: #666;
    }

    .late-badge {
        background: rgba(255, 82, 82, 0.1);
        color: #ff5252;
        padding: 0.3rem 0.8rem;
        border-radius: 15px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .submission-content-area {
        margin-bottom: 1rem;
    }

    .submission-file-link {
        display: inline-flex;
        align-items: center;
        gap: 0.8rem;
        padding: 0.8rem 1.2rem;
        background: #f5f7fa;
        border: 1px solid #e8ebf0;
        border-radius: 8px;
        text-decoration: none;
        color: #667eea;
        font-weight: 500;
        transition: all 0.3s;
    }

    .submission-file-link:hover {
        background: #e8ebf0;
        border-color: #667eea;
        transform: translateY(-2px);
    }

    .file-icon {
        font-size: 1.5rem;
    }

    .submission-text-content {
        padding: 1rem;
        background: #f5f7fa;
        border-radius: 8px;
        border: 1px solid #e8ebf0;
        line-height: 1.6;
        font-size: 0.95rem;
        color: #333;
    }

    /* Grading Section */
    .grading-section {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: #f5f7fa;
        border-radius: 8px;
    }

    .grade-label {
        font-weight: 600;
        color: #333;
        min-width: 80px;
    }

    .grade-input {
        width: 120px;
        padding: 0.6rem;
        border: 2px solid #e8ebf0;
        border-radius: 6px;
        outline: none;
        font-size: 1rem;
        font-weight: 600;
        text-align: center;
    }

    .grade-input:focus {
        border-color: #667eea;
    }

    .btn-grade {
        padding: 0.6rem 1.5rem;
        background: #667eea;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s;
    }

    .btn-grade:hover {
        background: #5568d3;
        transform: translateY(-2px);
    }

    .grade-display {
        padding: 0.6rem 1.2rem;
        background: rgba(46, 213, 115, 0.1);
        color: #2ed573;
        border-radius: 6px;
        font-weight: 600;
        font-size: 1.1rem;
    }

    .no-submissions {
        text-align: center;
        padding: 3rem 1rem;
        color: #666;
    }

    .no-submissions-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
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

    .item-icon.document {
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

    .form-group small {
        display: block;
        margin-top: 0.5rem;
        color: #666;
        font-size: 0.85rem;
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

    .submit-btn:hover {
        opacity: 0.9;
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

    .loading {
        text-align: center;
        padding: 2rem;
        color: #666;
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

        .grading-section {
            flex-direction: column;
            align-items: stretch;
        }

        .grade-input {
            width: 100%;
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
            <div class="class-code-badge" id="classCodeHeader">{{ $class->code }}</div>
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
    </div>
</div>

<div class="tabs-container">
    <div class="tabs">
        <div class="tab active" onclick="switchTab('overview')">📊 Ringkasan</div>
        <div class="tab" onclick="switchTab('materials')">📝 Materi</div>
        <div class="tab" onclick="switchTab('assignments')">✍️ Tugas</div>
        <div class="tab" onclick="switchTab('students')">👥 Mahasiswa</div>
        <div class="tab" onclick="switchTab('grades')">📈 Nilai</div>
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
        </div>

        <div class="content-card">
            <div class="card-header">
                <div class="card-title">Aktivitas Terkini</div>
            </div>
            <div class="card-body" id="recentActivities">
                <!-- Activities will be rendered here -->
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
                <button class="btn-add" onclick="exportGradesToExcel()">
                    <span>📥</span>
                    <span>Export Excel</span>
                </button>
            </div>
            <div class="card-body" id="gradesContent">
                <!-- Grades will be rendered here -->
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
        <form action="/tambah-materi" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="class_id" value="{{ $class->id }}">

            <div class="form-group">
                <label>Judul Materi</label>
                <input type="text" name="title" placeholder="e.g., Pengenalan React Hooks" required>
            </div>

            <div class="form-group">
                <label>Tipe Materi</label>
                <select name="type" id="materialType" required onchange="toggleFileInput(this.value)">
                    <option value="pdf">PDF Document</option>
                    <option value="document">Word/Other Document</option>
                    <option value="link">Link/URL</option>
                </select>
            </div>

            <div class="form-group" id="fileInputGroup">
                <label>Upload File</label>
                <input type="file" name="file" accept=".pdf,.doc,.docx">
            </div>

            <div class="form-group" id="linkInputGroup" style="display: none;">
                <label>Link / URL</label>
                <input type="url" name="link" placeholder="https://contoh.com/materi">
            </div>

            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="description" placeholder="Deskripsi materi..."></textarea>
            </div>

            <button type="submit" class="submit-btn">Tambah Materi</button>
        </form>
    </div>
</div>

<!-- Modal Edit Material -->
<div class="modal" id="editMaterialModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Edit Materi</h2>
            <button class="close-modal" onclick="closeModal('editMaterialModal')">✕</button>
        </div>
        <form action="/update-materi" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="material_id" id="editMaterialId">
            <input type="hidden" name="class_id" value="{{ $class->id }}">

            <div class="form-group">
                <label>Judul Materi</label>
                <input type="text" name="title" id="editMaterialTitle" required>
            </div>

            <div class="form-group">
                <label>Tipe Materi</label>
                <select name="type" id="editMaterialType" required onchange="toggleEditFileInput(this.value)">
                    <option value="pdf">PDF Document</option>
                    <option value="document">Word/Other Document</option>
                    <option value="link">Link/URL</option>
                </select>
            </div>

            <div class="form-group" id="editFileInputGroup">
                <label>Upload File Baru (Opsional)</label>
                <input type="file" name="file" id="editMaterialFile" accept=".pdf,.doc,.docx">
                <small>Kosongkan jika tidak ingin mengubah file</small>
            </div>

            <div class="form-group" id="editLinkInputGroup" style="display: none;">
                <label>Link / URL</label>
                <input type="url" name="link" id="editMaterialLink" placeholder="https://contoh.com/materi">
            </div>

            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="description" id="editMaterialDesc" placeholder="Deskripsi materi..."></textarea>
            </div>

            <button type="submit" class="submit-btn">Update Materi</button>
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
        <form action="/tambah-tugas" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="class_id" value="{{ $class->id }}">

            <div class="form-group">
                <label>Judul Tugas</label>
                <input type="text" name="title" placeholder="e.g., Project Website E-Commerce" required>
            </div>

            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="description" placeholder="Deskripsi tugas..." required></textarea>
            </div>

            <div class="form-group">
                <label>Tipe Instruksi</label>
                <select name="instruction_type" id="assignmentInstructionType" required onchange="toggleAssignmentInput(this.value)">
                    <option value="file">Upload File Instruksi</option>
                    <option value="text">Deskripsi Teks Saja</option>
                    <option value="link">Link/URL</option>
                </select>
            </div>

            <div class="form-group" id="assignmentFileInputGroup">
                <label>Upload File Instruksi (Opsional)</label>
                <input type="file" name="instruction_file" accept=".pdf,.doc,.docx,.ppt,.pptx">
                <small>Format: PDF, Word, PowerPoint (Max 10MB)</small>
            </div>

            <div class="form-group" id="assignmentLinkInputGroup" style="display: none;">
                <label>Link / URL Instruksi</label>
                <input type="url" name="instruction_link" placeholder="https://contoh.com/instruksi-tugas">
            </div>

            <div class="form-group">
                <label>Deadline</label>
                <input type="datetime-local" name="deadline" required>
            </div>

            <div class="form-group">
                <label>Bobot Nilai (%)</label>
                <input type="number" name="weight" min="0" max="100" placeholder="20" required>
                <small>Total bobot semua tugas harus 100%</small>
            </div>

            <button type="submit" class="submit-btn">Buat Tugas</button>
        </form>
    </div>
</div>

<!-- Modal Edit Assignment -->
<div class="modal" id="editAssignmentModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Edit Tugas</h2>
            <button class="close-modal" onclick="closeModal('editAssignmentModal')">✕</button>
        </div>
        <form action="/update-tugas" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="assignment_id" id="editAssignmentId">
            <input type="hidden" name="class_id" value="{{ $class->id }}">

            <div class="form-group">
                <label>Judul Tugas</label>
                <input type="text" name="title" id="editAssignmentTitle" required>
            </div>

            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="description" id="editAssignmentDesc" required></textarea>
            </div>

            <div class="form-group">
                <label>Tipe Instruksi</label>
                <select name="instruction_type" id="editAssignmentInstructionType" required onchange="toggleEditAssignmentInput(this.value)">
                    <option value="file">Upload File Instruksi</option>
                    <option value="text">Deskripsi Teks Saja</option>
                    <option value="link">Link/URL</option>
                </select>
            </div>

            <div class="form-group" id="editAssignmentFileInputGroup">
                <label>Upload File Instruksi Baru (Opsional)</label>
                <input type="file" name="instruction_file" accept=".pdf,.doc,.docx,.ppt,.pptx">
                <small>Kosongkan jika tidak ingin mengubah file</small>
            </div>

            <div class="form-group" id="editAssignmentLinkInputGroup" style="display: none;">
                <label>Link / URL Instruksi</label>
                <input type="url" name="instruction_link" id="editAssignmentLink" placeholder="https://contoh.com/instruksi-tugas">
            </div>

            <div class="form-group">
                <label>Deadline</label>
                <input type="datetime-local" name="deadline" id="editAssignmentDeadline" required>
            </div>

            <div class="form-group">
                <label>Bobot Nilai (%)</label>
                <input type="number" name="weight" id="editAssignmentWeight" min="0" max="100" required>
            </div>

            <button type="submit" class="submit-btn">Update Tugas</button>
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
        <form action="/tambah-mahasiswa-kelas" method="POST">
            @csrf
            <div class="form-group">
                <label>NIM/Email</label>
                <input type="text" name="identifier" required>
                <input type="hidden" name="class_id" value="{{ $class->id }}">
            </div>
            <button type="submit" class="submit-btn">Tambah Mahasiswa</button>
        </form>
    </div>
</div>

<!-- Form hapus -->
<form id="deleteFormMaterial" action="" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('scripts')
<script>
    let materials = @json($materials);
    let assignments = @json($formatted_assignments);
    let students = @json($mahasiswa);

    // Tab Switching
    function switchTab(tabName) {
        document.querySelectorAll('.tab').forEach(tab => tab.classList.remove('active'));
        document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));

        event.target.classList.add('active');
        document.getElementById(tabName).classList.add('active');

        if (tabName === 'materials') renderMaterials();
        if (tabName === 'assignments') renderAssignments();
        if (tabName === 'students') renderStudents();
    }

    // Toggle file input for material
    function toggleFileInput(type) {
        const fileGroup = document.getElementById('fileInputGroup');
        const linkGroup = document.getElementById('linkInputGroup');

        if (type === 'link') {
            fileGroup.style.display = 'none';
            linkGroup.style.display = 'block';
        } else {
            fileGroup.style.display = 'block';
            linkGroup.style.display = 'none';
        }
    }

    function toggleEditFileInput(type) {
        const fileGroup = document.getElementById('editFileInputGroup');
        const linkGroup = document.getElementById('editLinkInputGroup');

        if (type === 'link') {
            fileGroup.style.display = 'none';
            linkGroup.style.display = 'block';
        } else {
            fileGroup.style.display = 'block';
            linkGroup.style.display = 'none';
        }
    }

    // Toggle assignment input
    function toggleAssignmentInput(type) {
        const fileGroup = document.getElementById('assignmentFileInputGroup');
        const linkGroup = document.getElementById('assignmentLinkInputGroup');

        if (type === 'link') {
            fileGroup.style.display = 'none';
            linkGroup.style.display = 'block';
        } else if (type === 'text') {
            fileGroup.style.display = 'none';
            linkGroup.style.display = 'none';
        } else {
            fileGroup.style.display = 'block';
            linkGroup.style.display = 'none';
        }
    }

    function toggleEditAssignmentInput(type) {
        const fileGroup = document.getElementById('editAssignmentFileInputGroup');
        const linkGroup = document.getElementById('editAssignmentLinkInputGroup');

        if (type === 'link') {
            fileGroup.style.display = 'none';
            linkGroup.style.display = 'block';
        } else if (type === 'text') {
            fileGroup.style.display = 'none';
            linkGroup.style.display = 'none';
        } else {
            fileGroup.style.display = 'block';
            linkGroup.style.display = 'none';
        }
    }

    // Render Recent Activities
    function renderRecentActivities() {
        const container = document.getElementById('recentActivities');

        const activities = [
            ...materials.map(m => ({
                type: 'material',
                title: m.title,
                date: m.created_at || m.uploadDate,
                icon: '📚',
                bgColor: 'rgba(102, 126, 234, 0.1)',
            })),
            ...assignments.map(a => ({
                type: 'assignment',
                title: a.title,
                date: a.created_at || a.deadline,
                icon: '✍️',
                bgColor: 'rgba(255, 177, 66, 0.1)',
            }))
        ];

        activities.sort((a, b) => new Date(b.date) - new Date(a.date));
        const recentActivities = activities.slice(0, 5);

        if (recentActivities.length === 0) {
            container.innerHTML = `
                <div class="empty-state">
                    <div class="empty-icon">📋</div>
                    <h3>Belum Ada Aktivitas</h3>
                    <p>Aktivitas akan muncul setelah Anda menambahkan materi atau tugas</p>
                </div>
            `;
            return;
        }

        container.innerHTML = `
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                ${recentActivities.map(activity => {
                    const timeAgo = getTimeAgo(activity.date);
                    const typeLabel = activity.type === 'material' ? 'Materi ditambahkan' : 'Tugas dibuat';
                    
                    return `
                        <div style="padding: 1rem; background: #f5f7fa; border-radius: 8px; display: flex; align-items: center; gap: 1rem;">
                            <div style="width: 40px; height: 40px; background: ${activity.bgColor}; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                ${activity.icon}
                            </div>
                            <div style="flex: 1;">
                                <div style="font-weight: 600; margin-bottom: 0.2rem;">${typeLabel}: ${activity.title}</div>
                                <div style="font-size: 0.85rem; color: #666;">${timeAgo}</div>
                            </div>
                        </div>
                    `;
                }).join('')}
            </div>
        `;
    }

    function getTimeAgo(dateString) {
        const date = new Date(dateString);
        const now = new Date();
        const diffInSeconds = Math.floor((now - date) / 1000);

        if (diffInSeconds < 60) return 'Baru saja';
        if (diffInSeconds < 3600) return `${Math.floor(diffInSeconds / 60)} menit yang lalu`;
        if (diffInSeconds < 86400) return `${Math.floor(diffInSeconds / 3600)} jam yang lalu`;
        if (diffInSeconds < 2592000) return `${Math.floor(diffInSeconds / 86400)} hari yang lalu`;
        return `${Math.floor(diffInSeconds / 2592000)} bulan yang lalu`;
    }

    // Render Materials
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
            document: '📄',
            video: '🎥',
            link: '🔗'
        };

        container.innerHTML = materials.map(material => `
            <div class="material-item" onclick="handleMaterialClick(${material.id})">
                <div style="display: flex; align-items: center; flex: 1;">
                    <div class="item-icon ${material.type}">
                        ${typeIcons[material.type]}
                    </div>
                    <div class="item-content">
                        <div class="item-title">${material.title}</div>
                        <div class="item-meta">Diunggah: ${material.uploadDate}</div>
                        <div style="font-size: 14px; margin-top: 5px;">${material.description || '-'}</div>
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

    function handleMaterialClick(id) {
        const material = materials.find(m => m.id === id);
        if (!material) return;

        if (material.type === 'link') {
            if (material.link) {
                window.open(material.link, '_blank');
            }
        } else {
            if (material.fileUrl) {
                window.open(material.fileUrl, '_blank');
            }
        }
    }

    function downloadMaterial(id, event) {
        event.stopPropagation();
        handleMaterialClick(id);
    }

    function editMaterial(id, event) {
        event.stopPropagation();
        const material = materials.find(m => m.id === id);
        if (!material) return;

        document.getElementById('editMaterialId').value = material.id;
        document.getElementById('editMaterialTitle').value = material.title;
        document.getElementById('editMaterialType').value = material.type;
        document.getElementById('editMaterialDesc').value = material.description || '';

        if (material.type === 'link') {
            document.getElementById('editMaterialLink').value = material.link || '';
            toggleEditFileInput('link');
        } else {
            toggleEditFileInput(material.type);
        }

        document.getElementById('editMaterialModal').classList.add('active');
    }

    function deleteMaterial(id, event) {
        event.stopPropagation();
        if (confirm('Yakin ingin menghapus materi ini?')) {
            const form = document.getElementById('deleteFormMaterial');
            form.action = `/delete-materi/${id}`;
            form.submit();
        }
    }

    // Render Assignments with Accordion
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
                <div class="assignment-wrapper" id="assignment-${assignment.id}">
                    <div class="assignment-header" onclick="toggleAssignmentDetail(${assignment.id})">
                        <div class="assignment-main-info">
                            <div class="assignment-title-row">
                                <div class="assignment-title">${assignment.title}</div>
                            </div>
                            <div class="assignment-meta">
                                Deadline: ${assignment.deadline} • ${assignment.submissions}/${assignment.total} mahasiswa mengumpulkan
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: ${percentage}%"></div>
                            </div>
                        </div>
                        <div class="assignment-actions" onclick="event.stopPropagation()">
                            <button class="btn-icon" onclick="editAssignment(${assignment.id}, event)" title="Edit">✏️</button>
                            <button class="btn-icon" onclick="deleteAssignment(${assignment.id}, event)" title="Hapus">🗑️</button>
                        </div>
                    </div>
                    
                    <div class="assignment-detail" id="detail-${assignment.id}">
                        <div class="assignment-detail-content">
                            <div class="detail-section-title">📝 Submission Mahasiswa</div>
                            <div id="submissions-${assignment.id}" class="submission-list">
                                <div class="loading">Memuat data...</div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }).join('');
    }

    // Toggle Assignment Detail (Accordion)
    function toggleAssignmentDetail(assignmentId) {
        const detailElement = document.getElementById(`detail-${assignmentId}`);
        const headerElement = document.querySelector(`#assignment-${assignmentId} .assignment-header`);
        const isActive = detailElement.classList.contains('active');

        // Close all other accordions
        document.querySelectorAll('.assignment-detail').forEach(detail => {
            detail.classList.remove('active');
        });
        document.querySelectorAll('.assignment-header').forEach(header => {
            header.classList.remove('active');
        });

        // Toggle current accordion
        if (!isActive) {
            detailElement.classList.add('active');
            headerElement.classList.add('active');
            loadSubmissions(assignmentId);
        }
    }

    // Load Submissions from Backend (data sudah ada dari server)
    function loadSubmissions(assignmentId) {
        const container = document.getElementById(`submissions-${assignmentId}`);
        const assignment = assignments.find(a => a.id === assignmentId);

        if (!assignment || !assignment.submissions_data) {
            container.innerHTML = `
                <div class="no-submissions">
                    <div class="no-submissions-icon">⚠️</div>
                    <h3>Gagal Memuat Data</h3>
                    <p>Data submission tidak ditemukan.</p>
                </div>
            `;
            return;
        }

        const submissions = assignment.submissions_data;

        if (submissions.length === 0) {
            container.innerHTML = `
                <div class="no-submissions">
                    <div class="no-submissions-icon">📝</div>
                    <h3>Belum Ada Submission</h3>
                    <p>Belum ada mahasiswa yang mengumpulkan tugas ini</p>
                </div>
            `;
            return;
        }

        container.innerHTML = submissions.map(submission => {
            const initials = submission.student_name
                .split(' ')
                .map(n => n[0])
                .join('')
                .substring(0, 2)
                .toUpperCase();

            return `
                <div class="submission-item">
                    <div class="submission-header-info">
                        <div class="student-info">
                            <div class="student-avatar">${initials}</div>
                            <div class="student-details">
                                <div class="student-name">${submission.student_name}</div>
                                <div class="student-nim">${submission.student_nim}</div>
                            </div>
                        </div>
                        <div class="submission-status">
                            <div class="submission-time">📅 ${submission.submitted_at}</div>
                            ${submission.is_late ? '<div class="late-badge">⏰ Terlambat</div>' : ''}
                        </div>
                    </div>
                    
                    <div class="submission-content-area">
                        ${submission.submission_type === 'file' ? `
                            <p style="margin-bottom: 10px; color: grey;">${submission.submission_text || ''}</p>
                            <a href="${submission.file_url}" target="_blank" class="submission-file-link">
                                <span class="file-icon">📄</span>
                                <span>${submission.file_name || 'Download File Jawaban'}</span>
                            </a>
                        ` : `
                            <div class="submission-text-content">
                                ${submission.submission_text || 'Tidak ada teks jawaban'}
                            </div>
                        `}
                    </div>
                    
                    <form action="/submissions/${submission.id}/grade" method="POST" class="grading-section">
                        @csrf
                        <div class="grade-label">Nilai:</div>
                        ${submission.grade !== null ? `
                            <div class="grade-display">${Math.round(submission.grade)}/100</div>
                        ` : ''}
                        <input 
                            type="number" 
                            class="grade-input" 
                            name="grade"
                            value="${submission.grade !== null ? Math.round(submission.grade) : ''}"
                            placeholder="0-100"
                            min="0" 
                            max="100"
                            required
                        >
                        <button type="submit" class="btn-grade">
                            ${submission.grade !== null ? 'Update Nilai' : 'Beri Nilai'}
                        </button>
                    </form>

                </div>
            `;
        }).join('');
    }

    // Submit Grade
    async function submitGrade(submissionId, assignmentId) {
        const gradeInput = document.getElementById(`grade-${submissionId}`);
        const grade = parseFloat(gradeInput.value);

        if (isNaN(grade) || grade < 0 || grade > 100) {
            alert('Nilai harus antara 0-100');
            return;
        }

        try {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const response = await fetch(`/submissions/${submissionId}/grade`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    grade
                })
            });

            if (!response.ok) {
                throw new Error('Failed to submit grade');
            }

            showNotification('✅ Nilai berhasil disimpan!', 'success');
            loadSubmissions(assignmentId);

        } catch (error) {
            console.error('Error submitting grade:', error);
            alert('Gagal menyimpan nilai. Silakan coba lagi.');
        }
    }

    function editAssignment(id, event) {
        event.stopPropagation();
        const assignment = assignments.find(a => a.id === id);
        if (!assignment) return;

        document.getElementById('editAssignmentId').value = assignment.id;
        document.getElementById('editAssignmentTitle').value = assignment.title;
        document.getElementById('editAssignmentDesc').value = assignment.description || '';
        document.getElementById('editAssignmentWeight').value = assignment.weight || '';

        // Format deadline
        let deadlineValue = '';
        if (assignment.deadline_raw) {
            deadlineValue = assignment.deadline_raw;
        } else if (assignment.deadline) {
            try {
                const date = new Date(assignment.deadline);
                if (!isNaN(date.getTime())) {
                    const year = date.getFullYear();
                    const month = String(date.getMonth() + 1).padStart(2, '0');
                    const day = String(date.getDate()).padStart(2, '0');
                    const hours = String(date.getHours()).padStart(2, '0');
                    const minutes = String(date.getMinutes()).padStart(2, '0');
                    deadlineValue = `${year}-${month}-${day}T${hours}:${minutes}`;
                }
            } catch (e) {
                console.error('Error parsing deadline:', e);
            }
        }
        document.getElementById('editAssignmentDeadline').value = deadlineValue;

        const instructionType = assignment.instruction_type || 'text';
        document.getElementById('editAssignmentInstructionType').value = instructionType;

        if (instructionType === 'link') {
            document.getElementById('editAssignmentLink').value = assignment.instruction_link || '';
        }

        toggleEditAssignmentInput(instructionType);
        document.getElementById('editAssignmentModal').classList.add('active');
    }

    function deleteAssignment(id, event) {
        event.stopPropagation();
        if (confirm('Yakin ingin menghapus tugas ini?')) {
            // Implement delete logic
            showNotification('Tugas berhasil dihapus', 'success');
        }
    }

    // Render Students
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
            <div class="student-item">
                <div style="display: flex; align-items: center; flex: 1;">
                    <div style="width: 50px; height: 50px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; margin-right: 1rem;">
                        ${student.name.split(' ').map(n => n[0]).join('').substring(0, 2)}
                    </div>
                    <div class="item-content">
                        <div class="item-title">${student.name}</div>
                        <div class="item-meta">${student.nim} • ${student.email}</div>
                    </div>
                </div>
                <div class="item-actions">
                    <button class="btn-icon" onclick="removeStudent(${student.id}, ${student.class_id}, event)" title="Hapus">🗑️</button>
                </div>
            </div>
        `).join('');
    }

    async function removeStudent(id, class_id, event) {
        event.stopPropagation();
        if (confirm('Yakin ingin mengeluarkan mahasiswa dari kelas ini?')) {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            await fetch('/hapus-mahasiswa-kelas', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    class_id: class_id,
                    user_id: id
                })
            });

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

    function closeModal(modalId) {
        document.getElementById(modalId).classList.remove('active');
    }

    function exportGrades() {
        showNotification('Mengexport nilai ke Excel...', 'success');
    }

    function goBack() {
        window.history.back();
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

    // COPY SEMUA KODE INI DAN TAMBAHKAN KE BAGIAN <script> DI FILE ANDA
    // LETAKKAN SEBELUM BAGIAN "// Initialize" DI AKHIR

    // Fungsi untuk menghitung nilai mahasiswa
    function calculateStudentGrades() {
        const gradesMap = new Map();

        console.log('=== DEBUG: Calculate Student Grades ===');
        console.log('Students:', students);
        console.log('Assignments:', assignments);

        // Inisialisasi data mahasiswa
        students.forEach(student => {
            gradesMap.set(student.id, {
                id: student.id,
                name: student.name,
                nim: student.nim,
                assignments: [],
                totalWeightedScore: 0,
                totalWeight: 0,
                finalGrade: 0,
                gradeStatus: 'incomplete'
            });
        });

        // Hitung total bobot semua assignment
        const totalAssignmentWeight = assignments.reduce((sum, assignment) => {
            return sum + (parseFloat(assignment.weight) || 0);
        }, 0);

        console.log('Total Assignment Weight:', totalAssignmentWeight);

        // Proses setiap assignment dan submission
        assignments.forEach(assignment => {
            const assignmentWeight = parseFloat(assignment.weight) || 0;
            const submissions = assignment.submissions_data || [];

            console.log('Processing Assignment:', assignment.title, 'Weight:', assignmentWeight);
            console.log('Submissions for this assignment:', submissions);

            // Tandai mahasiswa yang sudah submit
            const submittedStudentIds = new Set();

            submissions.forEach(submission => {
                const studentId = submission.student_id;
                submittedStudentIds.add(studentId);

                console.log('Processing submission from student_id:', studentId, 'Grade:', submission.grade);

                if (gradesMap.has(studentId)) {
                    const studentData = gradesMap.get(studentId);
                    const grade = parseFloat(submission.grade);

                    // Hitung kontribusi nilai ke total (grade * bobot / 100)
                    if (!isNaN(grade) && grade !== null) {
                        const weightedScore = (grade * assignmentWeight) / 100;

                        console.log('Student:', studentData.name, 'Grade:', grade, 'Weighted Score:', weightedScore);

                        studentData.assignments.push({
                            id: assignment.id,
                            title: assignment.title,
                            weight: assignmentWeight,
                            grade: grade,
                            weightedScore: weightedScore,
                            isLate: submission.is_late,
                            submittedAt: submission.submitted_at
                        });

                        studentData.totalWeightedScore += weightedScore;
                        studentData.totalWeight += assignmentWeight;
                    } else {
                        // Submitted tapi belum dinilai
                        studentData.assignments.push({
                            id: assignment.id,
                            title: assignment.title,
                            weight: assignmentWeight,
                            grade: null,
                            weightedScore: 0,
                            isLate: submission.is_late,
                            submittedAt: submission.submitted_at,
                            status: 'not_graded'
                        });
                    }
                }
            });

            // Tambahkan assignment yang belum disubmit
            students.forEach(student => {
                if (!submittedStudentIds.has(student.id) && gradesMap.has(student.id)) {
                    const studentData = gradesMap.get(student.id);
                    studentData.assignments.push({
                        id: assignment.id,
                        title: assignment.title,
                        weight: assignmentWeight,
                        grade: null,
                        weightedScore: 0,
                        isLate: false,
                        submittedAt: null,
                        status: 'not_submitted'
                    });
                }
            });
        });

        console.log(students);
        

        // Hitung nilai akhir setiap mahasiswa
        gradesMap.forEach((studentData, studentId) => {
            if (studentData.totalWeight > 0) {
                // Nilai akhir = (Total Skor Berbobot / Total Bobot yang Sudah Dinilai) * 100
                studentData.finalGrade = (studentData.totalWeightedScore / studentData.totalWeight) * 100;

                // Tentukan status kelulusan
                if (studentData.totalWeight === totalAssignmentWeight) {
                    studentData.gradeStatus = 'complete';

                    // Tentukan grade letter
                    if (studentData.finalGrade >= 85) {
                        studentData.gradeLetter = 'A';
                    } else if (studentData.finalGrade >= 70) {
                        studentData.gradeLetter = 'B';
                    } else if (studentData.finalGrade >= 55) {
                        studentData.gradeLetter = 'C';
                    } else if (studentData.finalGrade >= 40) {
                        studentData.gradeLetter = 'D';
                    } else {
                        studentData.gradeLetter = 'E';
                    }
                } else {
                    studentData.gradeStatus = 'partial';
                    studentData.gradeLetter = '-';
                }
            } else {
                studentData.gradeStatus = 'incomplete';
                studentData.finalGrade = 0;
                studentData.gradeLetter = '-';
            }

            console.log('Final data for', studentData.name, ':', studentData);
        });

        return Array.from(gradesMap.values());
    }

    // Fungsi helper untuk membuat HTML assignment columns
    function buildAssignmentColumns(student, assignments) {
        let html = '';
        assignments.forEach(assignment => {
            const assignmentData = student.assignments.find(a => a.id === assignment.id);
            if (!assignmentData || assignmentData.grade === null) {
                html += '<td style="padding: 0.8rem; text-align: center; color: #999; font-size: 0.9rem;">';
                if (assignmentData && assignmentData.status === 'not_submitted') {
                    html += '-';
                } else if (assignmentData && assignmentData.status === 'not_graded') {
                    html += '<span style="color: #ffa502;">Belum Dinilai</span>';
                } else {
                    html += '-';
                }
                html += '</td>';
            } else {
                const cellColor = assignmentData.grade >= 85 ? '#2ed573' :
                    assignmentData.grade >= 70 ? '#ffa502' :
                    assignmentData.grade >= 55 ? '#ff7675' : '#d63031';
                html += '<td style="padding: 0.8rem; text-align: center;">';
                html += '<div style="display: inline-block; padding: 0.3rem 0.6rem; background: rgba(102, 126, 234, 0.1); color: ' + cellColor + '; border-radius: 6px; font-weight: 600; font-size: 0.95rem;">';
                html += Math.round(assignmentData.grade);
                if (assignmentData.isLate) {
                    html += '<span style="font-size: 0.7rem; margin-left: 2px;">⏰</span>';
                }
                html += '</div>';
                html += '<div style="font-size: 0.7rem; color: #999; margin-top: 0.2rem;">';
                html += assignmentData.weightedScore.toFixed(1);
                html += '</div>';
                html += '</td>';
            }
        });
        return html;
    }

    // Render Tab Grades
    function renderGrades() {
        const container = document.getElementById('gradesContent');

        if (assignments.length === 0) {
            container.innerHTML = '<div class="empty-state"><div class="empty-icon">📊</div><h3>Belum Ada Tugas</h3><p>Buat tugas terlebih dahulu untuk melihat rekapitulasi nilai</p></div>';
            return;
        }

        const studentGrades = calculateStudentGrades();

        if (studentGrades.length === 0) {
            container.innerHTML = '<div class="empty-state"><div class="empty-icon">👥</div><h3>Belum Ada Mahasiswa</h3><p>Tambahkan mahasiswa untuk melihat rekapitulasi nilai</p></div>';
            return;
        }

        // Sort by final grade descending
        studentGrades.sort((a, b) => b.finalGrade - a.finalGrade);

        // Calculate statistics
        const completedGrades = studentGrades.filter(s => s.gradeStatus === 'complete');
        const avgGrade = completedGrades.length > 0 ?
            completedGrades.reduce((sum, s) => sum + s.finalGrade, 0) / completedGrades.length :
            0;
        const maxGrade = studentGrades.length > 0 ?
            Math.max(...studentGrades.map(s => s.finalGrade)) :
            0;
        const minGrade = studentGrades.length > 0 ?
            Math.min(...studentGrades.filter(s => s.finalGrade > 0).map(s => s.finalGrade)) :
            0;

        // Build statistics HTML
        let html = '<div class="stats-grid" style="margin-bottom: 2rem;">';
        // html += '<div class="stat-card"><div class="stat-icon">📊</div><div class="stat-value">' + avgGrade.toFixed(1) + '</div><div class="stat-label">Rata-rata Kelas</div></div>';
        // html += '<div class="stat-card"><div class="stat-icon">⭐</div><div class="stat-value">' + maxGrade.toFixed(1) + '</div><div class="stat-label">Nilai Tertinggi</div></div>';
        // html += '<div class="stat-card"><div class="stat-icon">📉</div><div class="stat-value">' + (minGrade > 0 ? minGrade.toFixed(1) : '-') + '</div><div class="stat-label">Nilai Terendah</div></div>';
        // html += '<div class="stat-card"><div class="stat-icon">✅</div><div class="stat-value">' + completedGrades.length + '/' + studentGrades.length + '</div><div class="stat-label">Selesai Dinilai</div></div>';
        // html += '</div>';

        // Build table with responsive design
        html += '<div style="overflow-x: auto; -webkit-overflow-scrolling: touch;">';
        html += '<table style="width: 100%; min-width: 800px; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; font-size: 0.9rem;">';
        html += '<thead><tr style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">';
        html += '<th style="padding: 0.8rem; text-align: center; font-weight: 600; min-width: 50px;">#</th>';
        html += '<th style="padding: 0.8rem; text-align: left; font-weight: 600; min-width: 100px;">NIM</th>';
        html += '<th style="padding: 0.8rem; text-align: left; font-weight: 600; min-width: 150px;">Nama</th>';

        assignments.forEach(a => {
            html += '<th style="padding: 0.8rem; text-align: center; font-weight: 600; min-width: 80px;">';
            html += '<div style="font-size: 0.85rem;">' + (a.title.length > 15 ? a.title.substring(0, 15) + '...' : a.title) + '</div>';
            html += '<div style="font-size: 0.75rem; opacity: 0.9; margin-top: 2px;">(' + a.weight + '%)</div>';
            html += '</th>';
        });

        html += '<th style="padding: 0.8rem; text-align: center; font-weight: 600; min-width: 100px;">Total Skor</th>';
        html += '<th style="padding: 0.8rem; text-align: center; font-weight: 600; min-width: 90px;">Nilai</th>';
        html += '<th style="padding: 0.8rem; text-align: center; font-weight: 600; min-width: 60px;">Grade</th>';
        html += '<th style="padding: 0.8rem; text-align: center; font-weight: 600; min-width: 80px;">Status</th>';
        html += '</tr></thead><tbody>';

        // Build table rows
        studentGrades.forEach((student, index) => {
            const statusColor = student.gradeStatus === 'complete' ? '#2ed573' :
                student.gradeStatus === 'partial' ? '#ffa502' : '#666';
            const statusText = student.gradeStatus === 'complete' ? 'Selesai' :
                student.gradeStatus === 'partial' ? 'Sebagian' : 'Belum';
            const rgbaColor = statusColor === '#2ed573' ? '46, 213, 115' :
                statusColor === '#ffa502' ? '255, 165, 2' : '102, 102, 102';

            html += '<tr style="border-bottom: 1px solid #f5f7fa;">';
            html += '<td style="padding: 0.8rem; text-align: center; font-weight: 600; color: #667eea;">' + (index + 1) + '</td>';
            html += '<td style="padding: 0.8rem; font-size: 0.85rem;">' + student.nim + '</td>';
            html += '<td style="padding: 0.8rem; font-weight: 600; font-size: 0.9rem;">' + student.name + '</td>';

            html += buildAssignmentColumns(student, assignments);

            html += '<td style="padding: 0.8rem; text-align: center; font-weight: 600; color: #667eea; font-size: 0.95rem;">' + student.totalWeightedScore.toFixed(1) + '</td>';
            html += '<td style="padding: 0.8rem; text-align: center;"><div style="font-size: 1.3rem; font-weight: bold; color: #667eea;">' + student.finalGrade.toFixed(1) + '</div></td>';
            html += '<td style="padding: 0.8rem; text-align: center;"><div style="display: inline-block; padding: 0.4rem 0.8rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 6px; font-weight: bold; font-size: 1rem;">' + student.gradeLetter + '</div></td>';
            html += '<td style="padding: 0.8rem; text-align: center;"><span style="padding: 0.3rem 0.6rem; background: rgba(' + rgbaColor + ', 0.1); color: ' + statusColor + '; border-radius: 12px; font-size: 0.8rem; font-weight: 600;">' + statusText + '</span></td>';
            html += '</tr>';
        });

        html += '</tbody></table></div>';

        // Legend - More compact
        // html += '<div style="margin-top: 1.5rem; padding: 1rem; background: #f5f7fa; border-radius: 8px; font-size: 0.85rem;">';
        // html += '<h4 style="margin-bottom: 0.8rem; color: #333; font-size: 1rem;">Keterangan:</h4>';
        // html += '<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 0.8rem;">';
        // html += '<div><strong>Grade:</strong> A: 85-100 | B: 70-84 | C: 55-69 | D: 40-54 | E: 0-39</div>';
        // html += '<div><strong>Total Skor:</strong> Σ(Nilai × Bobot ÷ 100)</div>';
        // html += '<div><strong>Nilai Akhir:</strong> (Total Skor ÷ Total Bobot) × 100</div>';
        // html += '<div><strong>Status:</strong> <span style="color: #2ed573;">●</span> Selesai | <span style="color: #ffa502;">●</span> Sebagian | <span style="color: #666;">●</span> Belum</div>';
        html += '</div></div>';

        container.innerHTML = html;
    }

    // Export to Excel
    function exportGradesToExcel() {
        const studentGrades = calculateStudentGrades();

        if (studentGrades.length === 0) {
            alert('Tidak ada data untuk di-export');
            return;
        }

        let csv = 'Peringkat,NIM,Nama,';
        csv += assignments.map(a => '"' + a.title + ' (' + a.weight + '%)"').join(',');
        csv += ',Total Skor Berbobot,Nilai Akhir,Grade,Status\n';

        studentGrades.forEach((student, index) => {
            csv += (index + 1) + ',' + student.nim + ',"' + student.name + '",';

            assignments.forEach(assignment => {
                const assignmentData = student.assignments.find(a => a.id === assignment.id);
                if (assignmentData && assignmentData.grade !== null) {
                    csv += assignmentData.grade.toFixed(0);
                } else {
                    csv += '-';
                }
                csv += ',';
            });

            csv += student.totalWeightedScore.toFixed(1) + ',';
            csv += student.finalGrade.toFixed(1) + ',';
            csv += student.gradeLetter + ',';

            const statusText = student.gradeStatus === 'complete' ? 'Selesai' :
                student.gradeStatus === 'partial' ? 'Sebagian' : 'Belum';
            csv += statusText + '\n';
        });

        const blob = new Blob(['\uFEFF' + csv], {
            type: 'text/csv;charset=utf-8;'
        });
        const link = document.createElement('a');
        const url = URL.createObjectURL(blob);

        link.setAttribute('href', url);
        link.setAttribute('download', 'nilai_kelas_' + Date.now() + '.csv');
        link.style.visibility = 'hidden';

        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);

        showNotification('✅ Data nilai berhasil di-export!', 'success');
    }

    // ============================================
    // UPDATE FUNGSI switchTab YANG SUDAH ADA
    // Ganti fungsi switchTab dengan yang ini:
    // ============================================

    function switchTab(tabName) {
        document.querySelectorAll('.tab').forEach(tab => tab.classList.remove('active'));
        document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));

        event.target.classList.add('active');
        document.getElementById(tabName).classList.add('active');

        if (tabName === 'materials') renderMaterials();
        if (tabName === 'assignments') renderAssignments();
        if (tabName === 'students') renderStudents();
        if (tabName === 'grades') renderGrades(); // <- TAMBAHKAN BARIS INI
    }

    // Initialize
    renderMaterials();
    renderAssignments();
    renderStudents();
    renderRecentActivities();
</script>
@endpush