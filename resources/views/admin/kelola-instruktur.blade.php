@extends('admin.app')

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
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        text-align: center;
        transition: transform 0.3s;
    }

    .stat-box:hover {
        transform: translateY(-5px);
    }

    .stat-number {
        font-size: 2rem;
        font-weight: bold;
        color: #667eea;
        margin-bottom: 0.5rem;
    }

    .stat-label {
        color: #666;
        font-size: 0.9rem;
    }

    .toolbar {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        margin-bottom: 2rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
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
        transition: border-color 0.3s;
    }

    .search-box input:focus {
        border-color: #667eea;
    }

    .search-icon {
        position: absolute;
        left: 0.8rem;
        top: 50%;
        transform: translateY(-50%);
    }

    .filter-select {
        padding: 0.8rem 1rem;
        border: 2px solid #e8ebf0;
        border-radius: 8px;
        outline: none;
        cursor: pointer;
        background: white;
    }

    .btn-add {
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

    .btn-add:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }

    .instructors-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 1.5rem;
    }

    .instructor-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        transition: all 0.3s;
    }

    .instructor-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }

    .instructor-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 2rem;
        text-align: center;
        position: relative;
    }

    .instructor-avatar-large {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        margin: 0 auto;
        border: 4px solid rgba(255, 255, 255, 0.3);
    }

    .instructor-status {
        position: absolute;
        top: 1rem;
        right: 1rem;
        padding: 0.3rem 0.8rem;
        border-radius: 15px;
        font-size: 0.75rem;
        font-weight: 600;
        background: rgba(255, 255, 255, 0.9);
    }

    .status-active {
        color: #2ed573;
    }

    .status-inactive {
        color: #ff4757;
    }

    .instructor-body {
        padding: 1.5rem;
    }

    .instructor-name {
        font-size: 1.2rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 0.3rem;
        text-align: center;
    }

    .instructor-specialty {
        text-align: center;
        color: #667eea;
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }

    .instructor-info {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.85rem;
        color: #666;
    }

    .instructor-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
        padding: 1rem;
        background: #f5f7fa;
        border-radius: 8px;
        margin-bottom: 1rem;
    }

    .stat-item {
        text-align: center;
    }

    .stat-value {
        font-size: 1.2rem;
        font-weight: 600;
        color: #667eea;
    }

    .stat-label-small {
        font-size: 0.75rem;
        color: #666;
    }

    .instructor-actions {
        display: flex;
        gap: 0.5rem;
    }

    .action-btn {
        flex: 1;
        padding: 0.7rem;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s;
        font-size: 0.85rem;
    }

    .btn-edit {
        background: #667eea;
        color: white;
    }

    .btn-view {
        background: #f5f7fa;
        color: #667eea;
    }

    .btn-delete {
        background: #ff4757;
        color: white;
    }

    .action-btn:hover {
        transform: translateY(-2px);
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
        min-height: 100px;
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
        transition: all 0.3s;
    }

    .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }

    .rating-display {
        display: flex;
        align-items: center;
        gap: 0.3rem;
        justify-content: center;
        margin-bottom: 1rem;
    }

    .star {
        color: #ffa502;
    }

    @media (max-width: 768px) {
        .sidebar {
            width: 0;
            padding: 0;
        }

        .main-content {
            margin-left: 0;
            padding: 1rem;
        }

        .instructors-grid {
            grid-template-columns: 1fr;
        }

        .toolbar {
            flex-direction: column;
        }

        .search-box {
            width: 100%;
        }
    }
</style>
@endpush

@section('content')
<div class="stats-summary">
    <div class="stat-box">
        <div class="stat-number" id="totalInstructors">0</div>
        <div class="stat-label">Total Instruktur</div>
    </div>
    <div class="stat-box">
        <div class="stat-number" id="activeInstructors">0</div>
        <div class="stat-label">Aktif</div>
    </div>
    <div class="stat-box">
        <div class="stat-number" id="totalCourses">0</div>
        <div class="stat-label">Total Kursus</div>
    </div>
    <div class="stat-box">
        <div class="stat-number" id="avgRating">0</div>
        <div class="stat-label">Rata-rata Rating</div>
    </div>
</div>

<div class="toolbar">
    <div class="search-box">
        <span class="search-icon">🔍</span>
        <input type="text" id="searchInput" placeholder="Cari nama atau keahlian...">
    </div>
    <select class="filter-select" id="statusFilter">
        <option value="all">Semua Status</option>
        <option value="active">Aktif</option>
        <option value="inactive">Tidak Aktif</option>
    </select>
    <select class="filter-select" id="specialtyFilter">
        <option value="all">Semua Keahlian</option>
        <option value="Pemrograman">Pemrograman</option>
        <option value="Design">Design</option>
        <option value="Data Science">Data Science</option>
        <option value="Mobile">Mobile</option>
    </select>
    <button class="btn-add" onclick="openAddModal()">
        <span>➕</span>
        <span>Tambah Instruktur</span>
    </button>
</div>

<div class="instructors-grid" id="instructorsGrid">
    <!-- Instructor cards will be rendered here -->
</div>

<div class="modal" id="instructorModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 id="modalTitle">Tambah Instruktur Baru</h2>
            <button class="close-modal" onclick="closeModal()">✕</button>
        </div>
        <form id="instructorForm" action="/tambah-instruktur" method="POST">
            @csrf
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input name="name" type="text" id="instructorName" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input name="email" type="email" id="instructorEmail" required>
            </div>
            <div class="form-group">
                <label>Keahlian/Spesialisasi</label>
                <input name="specialization" type="text" id="instructorSpecialty" placeholder="e.g., Pemrograman Web, UI/UX" required>
            </div>
            <div class="form-group">
                <label>Bio/Deskripsi</label>
                <textarea name="description" id="instructorBio" placeholder="Pengalaman dan latar belakang instruktur..."
                    required></textarea>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="status" id="instructorStatus">
                    <option value="active">Aktif</option>
                    <option value="inactive">Tidak Aktif</option>
                </select>
            </div>
            <button type="submit" class="submit-btn" id="submitBtn">Tambah Instruktur</button>
        </form>
    </div>
</div>
<!-- form hapus -->
<form id="deleteForm" action="" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('scripts')
<script>
    let instructors = @json($instructors);


    let editingId = null;

    function renderInstructors(data = instructors) {
        const grid = document.getElementById('instructorsGrid');
        grid.innerHTML = data.map(instructor => `
                <div class="instructor-card">
                    <div class="instructor-header">
                        <div class="instructor-status status-${instructor.status}">
                            ${instructor.status === 'active' ? '● Aktif' : '● Tidak Aktif'}
                        </div>
                        <div class="instructor-avatar-large">👨‍🏫</div>
                    </div>
                    <div class="instructor-body">
                        <div class="instructor-name">${instructor.name}</div>
                        <div class="instructor-specialty">🎯 ${instructor.specialty}</div>
                        <div class="rating-display">
                            <span class="star">⭐</span>
                            <span style="font-weight: 600; color: #333;">${instructor.rating}</span>
                            <span style="color: #666; font-size: 0.85rem;">(${instructor.students} mahasiswa)</span>
                        </div>
                        <div class="instructor-info">
                            <div class="info-item">
                                <span>📧</span>
                                <span>${instructor.email}</span>
                            </div>
                            <div class="info-item">
                                <span>📝</span>
                                <span>${instructor.bio.substring(0, 50)}...</span>
                            </div>
                        </div>
                        <div class="instructor-stats">
                            <div class="stat-item">
                                <div class="stat-value">${instructor.courses}</div>
                                <div class="stat-label-small">Kursus</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value">${instructor.students}</div>
                                <div class="stat-label-small">Mahasiswa</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value">${instructor.rating}</div>
                                <div class="stat-label-small">Rating</div>
                            </div>
                        </div>
                        <div class="instructor-actions">
                            <button class="action-btn btn-view" onclick="viewInstructor(${instructor.id})">Lihat</button>
                            <button class="action-btn btn-edit" onclick="editInstructor(${instructor.id})">Edit</button>
                            <button class="action-btn btn-delete" onclick="deleteInstructor(${instructor.id})">Hapus</button>
                        </div>
                    </div>
                </div>
            `).join('');
        updateStats();
    }

    function updateStats() {
        document.getElementById('totalInstructors').textContent = instructors.length;
        document.getElementById('activeInstructors').textContent = instructors.filter(i => i.status === 'active').length;
        document.getElementById('totalCourses').textContent = instructors.reduce((sum, i) => sum + i.courses, 0);
        const avgRating = instructors.length > 0 ? (totalRating / instructors.length).toFixed(1) : '0.0';
        document.getElementById('avgRating').textContent = avgRating;
    }

    function openAddModal() {
        editingId = null;
        document.getElementById('modalTitle').textContent = 'Tambah Instruktur Baru';
        document.getElementById('submitBtn').textContent = 'Tambah Instruktur';
        document.getElementById('instructorForm').reset();
        document.getElementById('instructorModal').classList.add('active');
        document.getElementById('instructorForm').action = '/tambah-instruktur';
    }

    function closeModal() {
        document.getElementById('instructorModal').classList.remove('active');
    }

    function submitInstructor(e) {
        e.preventDefault();
        const data = {
            name: document.getElementById('instructorName').value,
            email: document.getElementById('instructorEmail').value,
            specialty: document.getElementById('instructorSpecialty').value,
            bio: document.getElementById('instructorBio').value,
            status: document.getElementById('instructorStatus').value,
            courses: 0,
            students: 0,
            rating: 0
        };

        if (editingId) {
            const index = instructors.findIndex(i => i.id === editingId);
            instructors[index] = {
                ...instructors[index],
                ...data
            };
            alert('✅ Data instruktur berhasil diupdate!');
        } else {
            instructors.unshift({
                id: instructors.length + 1,
                ...data
            });
            alert('✅ Instruktur baru berhasil ditambahkan!');
        }

        closeModal();
        renderInstructors();
    }

    function viewInstructor(id) {
        const instructor = instructors.find(i => i.id === id);
        alert(`Nama: ${instructor.name}\nKeahlian: ${instructor.specialty}\nEmail: ${instructor.email}\nRating: ${instructor.rating}\nKursus: ${instructor.courses}\nMahasiswa: ${instructor.students}\n\nBio: ${instructor.bio}`);
    }

    function editInstructor(id) {
        const instructor = instructors.find(i => i.id === id);
        editingId = id;
        document.getElementById('modalTitle').textContent = 'Edit Instruktur';
        document.getElementById('submitBtn').textContent = 'Update';
        document.getElementById('instructorName').value = instructor.name;
        document.getElementById('instructorEmail').value = instructor.email;
        document.getElementById('instructorSpecialty').value = instructor.specialty;
        document.getElementById('instructorBio').value = instructor.bio;
        document.getElementById('instructorStatus').value = instructor.status;
        document.getElementById('instructorModal').classList.add('active');

        const form = document.getElementById('instructorForm');

        // Buat input hidden baru
        let hiddenInput = form.querySelector('input[name="id"]');

        if (hiddenInput) {
            // kalau sudah ada, update valuenya
            hiddenInput.value = editingId;
        } else {
            // kalau belum ada, buat baru
            hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'id';
            hiddenInput.value = editingId;
            form.appendChild(hiddenInput);
        }
        form.action = '/update-instruktur';
    }

    function deleteInstructor(id) {
        // munculkan konfirmasi
        if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
            const form = document.getElementById('deleteForm');

            // ubah action-nya ke URL yang sesuai
            form.action = `/delete-instruktur/${id}`;

            // kirim form ke server
            form.submit();
        }
    }

    document.getElementById('searchInput').addEventListener('input', function(e) {
        const term = e.target.value.toLowerCase();
        const filtered = instructors.filter(i =>
            i.name.toLowerCase().includes(term) ||
            i.specialty.toLowerCase().includes(term)
        );
        renderInstructors(filtered);
    });

    document.getElementById('statusFilter').addEventListener('change', function(e) {
        const status = e.target.value;
        const filtered = status === 'all' ? instructors : instructors.filter(i => i.status === status);
        renderInstructors(filtered);
    });

    document.getElementById('specialtyFilter').addEventListener('change', function(e) {
        const specialty = e.target.value;
        const filtered = specialty === 'all' ? instructors : instructors.filter(i => i.specialty === specialty);
        renderInstructors(filtered);
    });

    renderInstructors();
</script>
@endpush