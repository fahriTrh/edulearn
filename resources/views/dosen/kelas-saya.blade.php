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

    .main-content {
        flex: 1;
        padding: 2rem;
    }

    .filter-section {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        margin-bottom: 2rem;
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        align-items: center;
    }

    .search-box {
        flex: 1;
        min-width: 250px;
        position: relative;
    }

    .search-box input {
        width: 100%;
        padding: 0.8rem 1rem 0.8rem 2.5rem;
        border: 2px solid #e8ebf0;
        border-radius: 8px;
        outline: none;
        font-family: inherit;
    }

    .search-box input:focus {
        border-color: #667eea;
    }

    .search-icon {
        position: absolute;
        left: 0.8rem;
        top: 50%;
        transform: translateY(-50%);
        font-size: 1.2rem;
    }

    .filter-select {
        padding: 0.8rem 1rem;
        border: 2px solid #e8ebf0;
        border-radius: 8px;
        outline: none;
        font-family: inherit;
        cursor: pointer;
        background: white;
    }

    .filter-select:focus {
        border-color: #667eea;
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

    .view-toggle {
        display: flex;
        background: #f5f7fa;
        border-radius: 8px;
        padding: 0.3rem;
        gap: 0.3rem;
    }

    .view-btn {
        padding: 0.6rem 1rem;
        border: none;
        background: transparent;
        cursor: pointer;
        border-radius: 6px;
        transition: all 0.3s;
        font-size: 1.2rem;
    }

    .view-btn.active {
        background: white;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .classes-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 1.5rem;
        margin-top: 1.5rem;
    }

    .class-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        transition: all 0.3s;
        cursor: pointer;
        position: relative;
    }

    .class-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }

    .class-header {
        height: 140px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        position: relative;
        background-size: cover;
        background-position: center;
    }

    .class-header.has-image {
        background-blend-mode: overlay;
    }

    .class-header.blue {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .class-header.green {
        background: linear-gradient(135deg, #2ed573 0%, #16a085 100%);
    }

    .class-header.orange {
        background: linear-gradient(135deg, #ffa502 0%, #ff6348 100%);
    }

    .class-header.purple {
        background: linear-gradient(135deg, #a29bfe 0%, #6c5ce7 100%);
    }

    .class-status {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: rgba(255, 255, 255, 0.9);
        padding: 0.3rem 0.8rem;
        border-radius: 15px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .status-active {
        color: #2ed573;
    }

    .status-inactive {
        color: #ffa502;
    }

    .class-body {
        padding: 1.5rem;
    }

    .class-code {
        background: #f5f7fa;
        padding: 0.3rem 0.8rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
        color: #667eea;
        display: inline-block;
        margin-bottom: 0.8rem;
    }

    .class-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #333;
    }

    .class-desc {
        font-size: 0.85rem;
        color: #666;
        margin-bottom: 1rem;
        line-height: 1.5;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .class-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.8rem;
        margin: 1rem 0;
        padding-top: 1rem;
        border-top: 1px solid #e8ebf0;
    }

    .stat-item {
        text-align: center;
    }

    .stat-value {
        font-size: 1.3rem;
        font-weight: 600;
        color: #667eea;
    }

    .stat-label {
        font-size: 0.75rem;
        color: #666;
        margin-top: 0.2rem;
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

    .btn-manage:hover {
        background: #5568d3;
    }

    .btn-students {
        background: #f5f7fa;
        color: #667eea;
    }

    .btn-students:hover {
        background: #e8ebf0;
    }

    .btn-more {
        background: #f5f7fa;
        color: #666;
        padding: 0.6rem;
        min-width: 40px;
        position: relative;
    }

    .btn-more:hover {
        background: #e8ebf0;
    }

    .classes-list {
        display: none;
        flex-direction: column;
        gap: 1rem;
        margin-top: 1.5rem;
    }

    .class-list-item {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        display: flex;
        gap: 1.5rem;
        align-items: center;
        transition: all 0.3s;
        cursor: pointer;
    }

    .class-list-item:hover {
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    }

    .list-icon {
        width: 80px;
        height: 80px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        flex-shrink: 0;
        background-size: cover;
        background-position: center;
    }

    .list-content {
        flex: 1;
    }

    .list-actions {
        display: flex;
        gap: 0.5rem;
    }

    .context-menu {
        position: fixed;
        background: white;
        border-radius: 8px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
        min-width: 180px;
        overflow: hidden;
        z-index: 10000;
        display: none;
    }

    .dropdown-item {
        padding: 0.8rem 1rem;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9rem;
        border-bottom: 1px solid #f5f7fa;
    }

    .dropdown-item:last-child {
        border-bottom: none;
    }

    .dropdown-item:hover {
        background: #f5f7fa;
    }

    .dropdown-item.danger {
        color: #ff5252;
    }

    .dropdown-item.danger:hover {
        background: #fff5f5;
    }

    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 9999;
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

    .image-preview-container {
        margin-top: 0.5rem;
        position: relative;
    }

    .image-preview {
        width: 100%;
        height: 200px;
        border-radius: 8px;
        object-fit: cover;
        border: 2px solid #e8ebf0;
        display: none;
    }

    .image-preview.show {
        display: block;
    }

    .remove-image-btn {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        background: rgba(255, 82, 82, 0.9);
        color: white;
        border: none;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        cursor: pointer;
        font-size: 1rem;
        display: none;
    }

    .remove-image-btn.show {
        display: block;
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

    .btn-danger {
        width: 100%;
        padding: 0.8rem;
        background: #ff5252;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        font-size: 1rem;
        margin-top: 1rem;
    }

    .btn-danger:hover {
        background: #ff3838;
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #666;
    }

    .empty-state-icon {
        font-size: 5rem;
        margin-bottom: 1rem;
    }

    @media (max-width: 768px) {
        .main-content {
            padding: 1rem;
        }

        .classes-grid {
            grid-template-columns: 1fr;
        }

        .filter-section {
            flex-direction: column;
        }

        .search-box {
            width: 100%;
        }

        .class-list-item {
            flex-direction: column;
            text-align: center;
        }

        .list-actions {
            width: 100%;
            flex-direction: column;
        }
    }
</style>
@endpush

@section('content')
<div class="filter-section">
    <div class="search-box">
        <span class="search-icon">🔍</span>
        <input type="text" id="searchInput" placeholder="Cari kelas...">
    </div>
    <select class="filter-select" id="semesterFilter">
        <option value="all">Semua Semester</option>
        <option value="ganjil">Ganjil 2024/2025</option>
        <option value="genap">Genap 2024/2025</option>
    </select>
    <select class="filter-select" id="statusFilter">
        <option value="all">Semua Status</option>
        <option value="active">Aktif</option>
        <option value="inactive">Tidak Aktif</option>
    </select>
    <div class="view-toggle">
        <button class="view-btn active" id="gridView">🔲</button>
        <button class="view-btn" id="listView">☰</button>
    </div>
    <button class="btn-primary" id="addClassBtn">
        <span>➕</span>
        <span>Tambah Kelas</span>
    </button>
</div>

<div class="classes-grid" id="classesGrid"></div>
<div class="classes-list" id="classesList"></div>

<!-- Context Menu -->
<div class="context-menu" id="contextMenu"></div>

<!-- Modal Add/Edit Class -->
<div class="modal" id="classModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 id="modalTitle">Tambah Kelas Baru</h2>
            <button class="close-modal" id="closeModalBtn">✕</button>
        </div>
        <form id="classForm" action="/tambah-kelas" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="classId">

            <div class="form-group">
                <label>Nama Kelas</label>
                <input name="title" type="text" id="className" placeholder="e.g., Pemrograman Web Lanjut" required>
            </div>

            <div class="form-group">
                <label>Kode Kelas</label>
                <input name="code" type="text" id="classCode" placeholder="e.g., CS301" required>
            </div>

            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="description" id="classDesc" placeholder="Deskripsi kelas..." required></textarea>
            </div>

            <div class="form-group">
                <label>Semester</label>
                <select name="semester" id="classSemester" required>
                    <option>Ganjil 2024/2025</option>
                    <option>Genap 2024/2025</option>
                </select>
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="status" id="classStatus" required>
                    <option value="active">Aktif</option>
                    <option value="inactive">Tidak Aktif</option>
                </select>
            </div>

            <div class="form-group">
                <label>Cover Image (Opsional)</label>
                <input name="cover_image" type="file" id="coverImage" accept="image/*">
                <div class="image-preview-container">
                    <img id="imagePreview" class="image-preview" alt="Preview">
                    <button type="button" class="remove-image-btn" id="removeImageBtn">✕</button>
                </div>
            </div>

            <button type="submit" class="submit-btn" id="submitBtn">Buat Kelas</button>
            <button type="button" class="btn-danger" id="deleteBtn" style="display: none;">
                🗑️ Hapus Kelas
            </button>
        </form>
    </div>
</div>

<form id="deleteForm" action="" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('scripts')
<script>
    // Data kelas
    let classes = @json($classes);

    let currentView = 'grid';
    let filteredClasses = [...classes];
    let editingClassId = null;
    let currentImageData = null;

    // Render grid view
    function renderClasses() {
        const grid = document.getElementById('classesGrid');
        if (filteredClasses.length === 0) {
            grid.innerHTML = '<div class="empty-state" style="grid-column: 1/-1;"><div class="empty-state-icon">🔍</div><h3>Tidak ada kelas ditemukan</h3><p>Coba ubah filter pencarian Anda</p></div>';
            return;
        }

        grid.innerHTML = filteredClasses.map(cls => {
            const headerStyle = cls.coverImage ? `background-image: url(${cls.coverImage}); background-blend-mode: overlay;` : '';
            const headerClass = cls.coverImage ? 'has-image' : '';

            return `
                <div class="class-card" data-id="${cls.id}">
                    <a href="/kelas-saya/detail-kelas/${cls.id}" class="class-header ${cls.color} ${headerClass}" style="${headerStyle}">
                        ${!cls.coverImage ? cls.icon : ''}
                        <span class="class-status status-${cls.status}">
                            ${cls.status === 'active' ? '● Aktif' : '○ Tidak Aktif'}
                        </span>
                    </a>
                    <div class="class-body">
                        <div class="class-code">${cls.code}</div>
                        <div class="class-title">${cls.name}</div>
                        <div class="class-desc">${cls.desc}</div>
                        <div class="class-stats">
                            <div class="stat-item"><div class="stat-value">${cls.students}</div><div class="stat-label">Mahasiswa</div></div>
                            <div class="stat-item"><div class="stat-value">${cls.materials}</div><div class="stat-label">Materi</div></div>
                            <div class="stat-item"><div class="stat-value">${cls.assignments}</div><div class="stat-label">Tugas</div></div>
                        </div>
                        <div class="class-actions">
                            <button class="btn-action btn-manage" data-action="manage" data-id="${cls.id}">Kelola</button>
                            <button class="btn-action btn-students" data-action="students" data-id="${cls.id}">Mahasiswa</button>
                            <button class="btn-action btn-more" data-action="more" data-id="${cls.id}">⋮</button>
                        </div>
                    </div>
                </div>
            `;
        }).join('');
    }

    // Render list view
    function renderListView() {
        const list = document.getElementById('classesList');
        if (filteredClasses.length === 0) {
            list.innerHTML = `
            <div class="empty-state">
                <div class="empty-state-icon">🔍</div>
                <h3>Tidak ada kelas ditemukan</h3>
                <p>Coba ubah filter pencarian Anda</p>
            </div>
        `;
            return;
        }

        list.innerHTML = filteredClasses.map(cls => {
            // kalau ada cover image, pakai cover dari public/covers
            const hasCover = cls.coverImage && cls.coverImage !== "";
            const gradient = getColorGradient(cls.color);
            const iconBackground = hasCover ?
                `background-image: url('${cls.coverImage}'); background-size: cover; background-position: center;` :
                `background: ${gradient};`;

            return `
            <div class="class-list-item" data-id="${cls.id}">
                <a href="/kelas-saya/detail-kelas/${cls.id}" class="list-icon ${cls.color}" style="${iconBackground}">
                    ${!hasCover ? cls.icon : ""}
                </a>
                <div class="list-content">
                    <div style="display: flex; align-items: center; gap: 0.8rem; margin-bottom: 0.5rem;">
                        <div class="class-code">${cls.code}</div>
                        <span class="class-status status-${cls.status}">
                            ${cls.status === 'active' ? '● Aktif' : '○ Tidak Aktif'}
                        </span>
                    </div>
                    <div class="class-title">${cls.name}</div>
                    <div class="class-desc" style="-webkit-line-clamp: 1;">${cls.desc}</div>
                    <div style="display: flex; gap: 1rem; margin-top: 0.8rem; font-size: 0.85rem; color: #666;">
                        <span>👥 ${cls.students} mahasiswa</span>
                        <span>📄 ${cls.materials} materi</span>
                        <span>✍️ ${cls.assignments} tugas</span>
                    </div>
                </div>
                <div class="list-actions">
                    <button class="btn-action btn-manage" data-action="manage" data-id="${cls.id}">Kelola</button>
                    <button class="btn-action btn-students" data-action="students" data-id="${cls.id}">Mahasiswa</button>
                    <button class="btn-action btn-more" data-action="more" data-id="${cls.id}">⋮</button>
                </div>
            </div>
        `;
        }).join('');
    }


    function getColorGradient(color) {
        const gradients = {
            blue: 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
            green: 'linear-gradient(135deg, #2ed573 0%, #16a085 100%)',
            orange: 'linear-gradient(135deg, #ffa502 0%, #ff6348 100%)',
            purple: 'linear-gradient(135deg, #a29bfe 0%, #6c5ce7 100%)'
        };
        return gradients[color] || gradients.blue;
    }

    // Filter classes
    function filterClasses() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const semesterFilter = document.getElementById('semesterFilter').value;
        const statusFilter = document.getElementById('statusFilter').value;

        filteredClasses = classes.filter(cls => {
            const matchSearch = cls.name.toLowerCase().includes(searchTerm) ||
                cls.code.toLowerCase().includes(searchTerm) ||
                cls.desc.toLowerCase().includes(searchTerm);
            const matchSemester = semesterFilter === 'all' || cls.semester === semesterFilter;
            const matchStatus = statusFilter === 'all' || cls.status === statusFilter;
            return matchSearch && matchSemester && matchStatus;
        });

        currentView === 'grid' ? renderClasses() : renderListView();
    }

    // Toggle view
    function toggleView(view) {
        currentView = view;
        const gridView = document.getElementById('gridView');
        const listView = document.getElementById('listView');
        const classesGrid = document.getElementById('classesGrid');
        const classesList = document.getElementById('classesList');

        if (view === 'grid') {
            gridView.classList.add('active');
            listView.classList.remove('active');
            classesGrid.style.display = 'grid';
            classesList.style.display = 'none';
            renderClasses();
        } else {
            listView.classList.add('active');
            gridView.classList.remove('active');
            classesGrid.style.display = 'none';
            classesList.style.display = 'flex';
            renderListView();
        }
    }

    // Show context menu
    function showContextMenu(id, event) {
        event.preventDefault();
        event.stopPropagation();

        const cls = classes.find(c => c.id === id);
        const menu = document.getElementById('contextMenu');

        menu.innerHTML = `
            <div class="dropdown-item" data-action="edit" data-id="${id}">
                ✏️ Edit Kelas
            </div>
            <div class="dropdown-item" data-action="archive" data-id="${id}">
                📦 ${cls.status === 'active' ? 'Arsipkan' : 'Aktifkan'} Kelas
            </div>
            <div class="dropdown-item danger" data-action="delete" data-id="${id}">
                🗑️ Hapus Kelas
            </div>
        `;

        menu.style.left = event.clientX + 'px';
        menu.style.top = (event.clientY - 100) + 'px';
        menu.style.display = 'block';
    }

    // Close context menu
    function closeContextMenu() {
        const menu = document.getElementById('contextMenu');
        menu.style.display = 'none';
        menu.innerHTML = '';
    }

    // Open add class modal
    function openAddClassModal() {
        editingClassId = null;
        currentImageData = null;
        document.getElementById('modalTitle').textContent = 'Tambah Kelas Baru';
        document.getElementById('submitBtn').textContent = 'Buat Kelas';
        document.getElementById('deleteBtn').style.display = 'none';
        document.getElementById('classForm').reset();
        document.getElementById('imagePreview').classList.remove('show');
        document.getElementById('removeImageBtn').classList.remove('show');
        document.getElementById('classModal').classList.add('active');
        document.getElementById('classForm').action = '/tambah-kelas';

    }

    // Edit class modal
    function editClassModal(id) {
        const cls = classes.find(c => c.id === id);
        if (!cls) return;

        editingClassId = id;
        currentImageData = cls.coverImage;

        document.getElementById('modalTitle').textContent = 'Edit Kelas';
        document.getElementById('submitBtn').textContent = 'Simpan Perubahan';
        document.getElementById('deleteBtn').style.display = 'block';
        document.getElementById('classId').value = cls.id;
        document.getElementById('className').value = cls.name;
        document.getElementById('classCode').value = cls.code;
        document.getElementById('classDesc').value = cls.desc;
        document.getElementById('classSemester').value = cls.semester === 'ganjil' ? 'Ganjil 2024/2025' : 'Genap 2024/2025';
        document.getElementById('classStatus').value = cls.status;
        document.getElementById('coverImage').value = '';

        if (cls.coverImage) {
            document.getElementById('imagePreview').src = cls.coverImage;
            document.getElementById('imagePreview').classList.add('show');
            document.getElementById('removeImageBtn').classList.add('show');
        } else {
            document.getElementById('imagePreview').classList.remove('show');
            document.getElementById('removeImageBtn').classList.remove('show');
        }

        document.getElementById('classModal').classList.add('active');

        const form = document.getElementById('classForm');

        // Buat input hidden baru
        let hiddenInput = form.querySelector('input[name="id"]');

        if (hiddenInput) {
            // kalau sudah ada, update valuenya
            hiddenInput.value = editingClassId;
        } else {
            // kalau belum ada, buat baru
            hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'id';
            hiddenInput.value = editingClassId;
            form.appendChild(hiddenInput);
        }

        form.action = '/update-kelas';
    }

    // Close modal
    function closeClassModal() {
        document.getElementById('classModal').classList.remove('active');
        editingClassId = null;
        currentImageData = null;
    }

    // Preview image
    function previewImage(file) {
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                currentImageData = e.target.result;
                document.getElementById('imagePreview').src = e.target.result;
                document.getElementById('imagePreview').classList.add('show');
                document.getElementById('removeImageBtn').classList.add('show');
            };
            reader.readAsDataURL(file);
        }
    }

    // Remove image
    function removeImage() {
        currentImageData = null;
        document.getElementById('coverImage').value = '';
        document.getElementById('imagePreview').src = '';
        document.getElementById('imagePreview').classList.remove('show');
        document.getElementById('removeImageBtn').classList.remove('show');
    }

    // Submit class form
    function submitClass(e) {
        e.preventDefault();

        const icons = ['💻', '🔢', '🗄️', '📱', '🤖', '☁️', '🎨', '📊', '🔬', '📚'];
        const colors = ['blue', 'green', 'orange', 'purple'];
        const randomColor = colors[Math.floor(Math.random() * colors.length)];

        const classData = {
            name: document.getElementById('className').value,
            code: document.getElementById('classCode').value,
            desc: document.getElementById('classDesc').value,
            semester: document.getElementById('classSemester').value.toLowerCase().includes('ganjil') ? 'ganjil' : 'genap',
            status: document.getElementById('classStatus').value,
            coverImage: currentImageData
        };

        if (editingClassId) {
            const index = classes.findIndex(c => c.id === editingClassId);
            if (index !== -1) {
                classes[index] = {
                    ...classes[index],
                    ...classData
                };
                showNotification('✅ Kelas berhasil diperbarui!', 'success');
            }
        } else {
            const randomIcon = icons[Math.floor(Math.random() * icons.length)];
            const newClass = {
                id: classes.length + 1,
                ...classData,
                students: 0,
                materials: 0,
                assignments: 0,
                icon: randomIcon,
                color: randomColor
            };
            classes.unshift(newClass);
            showNotification('✅ Kelas berhasil dibuat!', 'success');
        }

        filteredClasses = [...classes];
        currentView === 'grid' ? renderClasses() : renderListView();
        closeClassModal();
    }

    // Delete class
    function deleteClass() {
        if (editingClassId) {
            const cls = classes.find(c => c.id === editingClassId);
            if (confirm(`Apakah Anda yakin ingin menghapus kelas "${cls.name}"?\n\nTindakan ini tidak dapat dibatalkan!`)) {
                deleteClassById(editingClassId);
            }
        }
    }

    function deleteClassById(id) {
        classes = classes.filter(c => c.id !== id);
        filteredClasses = [...classes];
        currentView === 'grid' ? renderClasses() : renderListView();
        closeClassModal();

        const form = document.getElementById('deleteForm');

        // ubah action-nya ke URL yang sesuai
        form.action = `/delete-kelas/${id}`;

        // kirim form ke server
        form.submit();

        showNotification('✅ Kelas berhasil dihapus!', 'success');
    }

    // Archive class
    function archiveClass(id) {
        const cls = classes.find(c => c.id === id);
        if (cls) {
            cls.status = cls.status === 'active' ? 'inactive' : 'active';
            filteredClasses = [...classes];
            currentView === 'grid' ? renderClasses() : renderListView();
            showNotification(`✅ Kelas berhasil ${cls.status === 'inactive' ? 'diarsipkan' : 'diaktifkan'}!`, 'success');
        }
    }

    // Show notification
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
            z-index: 10001;
            animation: slideIn 0.3s ease;
        `;
        notification.textContent = message;
        document.body.appendChild(notification);
        setTimeout(() => {
            notification.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    // Event Listeners
    document.getElementById('searchInput').addEventListener('keyup', filterClasses);
    document.getElementById('semesterFilter').addEventListener('change', filterClasses);
    document.getElementById('statusFilter').addEventListener('change', filterClasses);

    document.getElementById('gridView').addEventListener('click', () => toggleView('grid'));
    document.getElementById('listView').addEventListener('click', () => toggleView('list'));

    document.getElementById('addClassBtn').addEventListener('click', openAddClassModal);
    document.getElementById('closeModalBtn').addEventListener('click', closeClassModal);
    // document.getElementById('classForm').addEventListener('submit', submitClass);
    document.getElementById('deleteBtn').addEventListener('click', deleteClass);

    document.getElementById('coverImage').addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (file) previewImage(file);
    });

    document.getElementById('removeImageBtn').addEventListener('click', removeImage);

    // Close modal when clicking outside
    document.getElementById('classModal').addEventListener('click', function(e) {
        if (e.target === this) closeClassModal();
    });

    // Event delegation for dynamic buttons
    document.addEventListener('click', function(e) {
        const target = e.target;

        // Handle button actions
        if (target.classList.contains('btn-action') || target.closest('.btn-action')) {
            const btn = target.classList.contains('btn-action') ? target : target.closest('.btn-action');
            const action = btn.getAttribute('data-action');
            const id = parseInt(btn.getAttribute('data-id'));

            e.stopPropagation();

            if (action === 'manage') {
                showNotification(`Mengelola kelas: ${classes.find(c => c.id === id).name}`, 'info');
            } else if (action === 'students') {
                showNotification(`Melihat daftar mahasiswa di: ${classes.find(c => c.id === id).name}`, 'info');
            } else if (action === 'more') {
                showContextMenu(id, e);
            }
        }

        // Handle context menu items
        if (target.classList.contains('dropdown-item')) {
            const action = target.getAttribute('data-action');
            const id = parseInt(target.getAttribute('data-id'));

            closeContextMenu();

            if (action === 'edit') {
                editClassModal(id);
            } else if (action === 'archive') {
                archiveClass(id);
            } else if (action === 'delete') {
                const cls = classes.find(c => c.id === id);
                if (confirm(`Apakah Anda yakin ingin menghapus kelas "${cls.name}"?\n\nTindakan ini tidak dapat dibatalkan!`)) {
                    deleteClassById(id);
                }
            }
        }

        // Handle class card click
        if (target.closest('.class-card') && !target.classList.contains('btn-action')) {
            const card = target.closest('.class-card');
            const id = parseInt(card.getAttribute('data-id'));
            if (!target.closest('.class-actions')) {
                showNotification(`Membuka kelas: ${classes.find(c => c.id === id).name}`, 'info');
            }
        }

        // Handle list item click
        if (target.closest('.class-list-item') && !target.classList.contains('btn-action')) {
            const item = target.closest('.class-list-item');
            const id = parseInt(item.getAttribute('data-id'));
            if (!target.closest('.list-actions')) {
                showNotification(`Membuka kelas: ${classes.find(c => c.id === id).name}`, 'info');
            }
        }

        // Close context menu when clicking outside
        if (!target.closest('.context-menu') && !target.classList.contains('btn-more')) {
            closeContextMenu();
        }
    });

    // Initial render
    renderClasses();
</script>
@endpush