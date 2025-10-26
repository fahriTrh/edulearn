@extends('dosen.app')

@section('content')
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon blue">📚</div>
        <div class="stat-info">
            <h3 id="totalClasses">8</h3>
            <p>Kelas Aktif</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">👥</div>
        <div class="stat-info">
            <h3 id="totalStudents">245</h3>
            <p>Total Mahasiswa</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange">✍️</div>
        <div class="stat-info">
            <h3 id="pendingAssignments">5</h3>
            <p>Tugas Pending</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon purple">📄</div>
        <div class="stat-info">
            <h3 id="totalMaterials">48</h3>
            <p>Materi Diunggah</p>
        </div>
    </div>
</div>

<div class="card">
    <div class="section-header">
        <h2 class="section-title">Kelas yang Saya Ajar</h2>
        <button class="btn-primary" onclick="openAddClassModal()">
            <span>➕</span>
            <span>Tambah Kelas</span>
        </button>
    </div>
    <div class="classes-grid" id="classesGrid">
        <!-- Classes will be rendered here -->
    </div>
</div>

<div class="card">
    <div class="section-header">
        <h2 class="section-title">Tugas Perlu Dinilai</h2>
        <a href="#" style="color: #667eea; text-decoration: none; font-weight: 600;">Lihat Semua →</a>
    </div>
    <div class="assignments-list" id="assignmentsList">
        <!-- Assignments will be rendered here -->
    </div>
</div>

<!-- Modal Add Class -->
<div class="modal" id="addClassModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Tambah Kelas Baru</h2>
            <button class="close-modal" onclick="closeAddClassModal()">✕</button>
        </div>
        <form onsubmit="submitClass(event)">
            <div class="form-group">
                <label>Nama Kelas</label>
                <input type="text" id="className" placeholder="e.g., Pemrograman Web Lanjut" required>
            </div>
            <div class="form-group">
                <label>Kode Kelas</label>
                <input type="text" id="classCode" placeholder="e.g., CS301" required>
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <textarea id="classDesc" placeholder="Deskripsi kelas..." required></textarea>
            </div>
            <div class="form-group">
                <label>Semester</label>
                <select id="classSemester" required>
                    <option>Ganjil 2024/2025</option>
                    <option>Genap 2024/2025</option>
                </select>
            </div>
            <button type="submit" class="submit-btn">Buat Kelas</button>
        </form>
    </div>
</div>

<!-- Modal Add Material -->
<div class="modal" id="addMaterialModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Upload Materi Baru</h2>
            <button class="close-modal" onclick="closeAddMaterialModal()">✕</button>
        </div>
        <form onsubmit="submitMaterial(event)">
            <div class="form-group">
                <label>Judul Materi</label>
                <input type="text" id="materialTitle" required>
            </div>
            <div class="form-group">
                <label>Tipe Materi</label>
                <select id="materialType" required>
                    <option>PDF</option>
                    <option>Video</option>
                    <option>Teks</option>
                    <option>Link</option>
                </select>
            </div>
            <div class="form-group">
                <label>Upload File</label>
                <div class="file-upload" onclick="document.getElementById('fileInput').click()">
                    <div style="font-size: 3rem; margin-bottom: 0.5rem;">📁</div>
                    <p>Klik untuk upload file</p>
                    <input type="file" id="fileInput" style="display: none;">
                </div>
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <textarea id="materialDesc"></textarea>
            </div>
            <button type="submit" class="submit-btn">Upload Materi</button>
        </form>
    </div>
</div>

<!-- Modal Add Assignment -->
<div class="modal" id="addAssignmentModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Buat Tugas Baru</h2>
            <button class="close-modal" onclick="closeAddAssignmentModal()">✕</button>
        </div>
        <form onsubmit="submitAssignment(event)">
            <div class="form-group">
                <label>Judul Tugas</label>
                <input type="text" id="assignmentTitle" required>
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <textarea id="assignmentDesc" required></textarea>
            </div>
            <div class="form-group">
                <label>Deadline</label>
                <input type="datetime-local" id="assignmentDeadline" required>
            </div>
            <div class="form-group">
                <label>Bobot Nilai (%)</label>
                <input type="number" id="assignmentWeight" min="0" max="100" required>
            </div>
            <button type="submit" class="submit-btn">Buat Tugas</button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let classes = [{
            id: 1,
            name: "Pemrograman Web Lanjut",
            code: "CS301",
            students: 45,
            materials: 12,
            assignments: 8
        },
        {
            id: 2,
            name: "Struktur Data & Algoritma",
            code: "CS302",
            students: 38,
            materials: 15,
            assignments: 10
        },
        {
            id: 3,
            name: "Database Management",
            code: "CS303",
            students: 42,
            materials: 10,
            assignments: 6
        },
        {
            id: 4,
            name: "Mobile Development",
            code: "CS304",
            students: 35,
            materials: 11,
            assignments: 7
        }
    ];

    let pendingAssignments = [{
            id: 1,
            title: "Project Website E-Commerce",
            class: "Pemrograman Web Lanjut",
            submissions: 12,
            total: 45,
            deadline: "2024-10-25"
        },
        {
            id: 2,
            title: "Analisis Algoritma Sorting",
            class: "Struktur Data & Algoritma",
            submissions: 8,
            total: 38,
            deadline: "2024-10-26"
        },
        {
            id: 3,
            title: "Design Database ERD",
            class: "Database Management",
            submissions: 15,
            total: 42,
            deadline: "2024-10-27"
        }
    ];

    function renderClasses() {
        const grid = document.getElementById('classesGrid');
        grid.innerHTML = classes.map(cls => `
                <div class="class-card" onclick="viewClass(${cls.id})">
                    <div class="class-header">📚</div>
                    <div class="class-body">
                        <div class="class-title">${cls.name}</div>
                        <div style="font-size: 0.85rem; color: #666; margin-bottom: 0.5rem;">${cls.code}</div>
                        <div class="class-meta">
                            <span>👥 ${cls.students} mahasiswa</span>
                        </div>
                        <div class="class-meta">
                            <span>📄 ${cls.materials} materi</span>
                            <span>✍️ ${cls.assignments} tugas</span>
                        </div>
                        <div class="class-actions">
                            <button class="btn-action btn-manage" onclick="manageClass(${cls.id}, event)">Kelola</button>
                            <button class="btn-action btn-students" onclick="viewStudents(${cls.id}, event)">Mahasiswa</button>
                        </div>
                    </div>
                </div>
            `).join('');
    }

    function renderAssignments() {
        const list = document.getElementById('assignmentsList');
        list.innerHTML = pendingAssignments.map(assignment => `
                <div class="assignment-item">
                    <div class="assignment-info">
                        <h4>${assignment.title}</h4>
                        <div class="assignment-meta">
                            ${assignment.class} • Deadline: ${assignment.deadline}
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <span class="pending-badge">${assignment.submissions}/${assignment.total} dinilai</span>
                        <button class="btn-action btn-manage" onclick="gradeAssignments(${assignment.id})">Nilai</button>
                    </div>
                </div>
            `).join('');
    }

    function viewClass(id) {
        const cls = classes.find(c => c.id === id);
        showNotification(`Membuka kelas: ${cls.name}`, 'info');
    }

    function manageClass(id, event) {
        event.stopPropagation();
        const cls = classes.find(c => c.id === id);
        showNotification(`Mengelola kelas: ${cls.name}`, 'info');
    }

    function viewStudents(id, event) {
        event.stopPropagation();
        const cls = classes.find(c => c.id === id);
        showNotification(`Melihat daftar mahasiswa di: ${cls.name}`, 'info');
    }

    function gradeAssignments(id) {
        const assignment = pendingAssignments.find(a => a.id === id);
        showNotification(`Membuka penilaian: ${assignment.title}`, 'info');
    }

    function openAddClassModal() {
        document.getElementById('addClassModal').classList.add('active');
    }

    function closeAddClassModal() {
        document.getElementById('addClassModal').classList.remove('active');
    }

    function openAddMaterialModal() {
        document.getElementById('addMaterialModal').classList.add('active');
    }

    function closeAddMaterialModal() {
        document.getElementById('addMaterialModal').classList.remove('active');
    }

    function openAddAssignmentModal() {
        document.getElementById('addAssignmentModal').classList.add('active');
    }

    function closeAddAssignmentModal() {
        document.getElementById('addAssignmentModal').classList.remove('active');
    }

    function submitClass(e) {
        e.preventDefault();
        const newClass = {
            id: classes.length + 1,
            name: document.getElementById('className').value,
            code: document.getElementById('classCode').value,
            students: 0,
            materials: 0,
            assignments: 0
        };
        classes.unshift(newClass);
        renderClasses();
        closeAddClassModal();
        showNotification('✅ Kelas berhasil dibuat!', 'success');
    }

    function submitMaterial(e) {
        e.preventDefault();
        const file = document.getElementById('fileInput').files[0];
        showNotification(`✅ Materi "${document.getElementById('materialTitle').value}" berhasil diupload!`, 'success');
        closeAddMaterialModal();
    }

    function submitAssignment(e) {
        e.preventDefault();
        showNotification(`✅ Tugas "${document.getElementById('assignmentTitle').value}" berhasil dibuat!`, 'success');
        closeAddAssignmentModal();
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
            `;
        notification.textContent = message;
        document.body.appendChild(notification);
        setTimeout(() => notification.remove(), 3000);
    }

    document.querySelectorAll('.menu-item').forEach(item => {
        item.addEventListener('click', function() {
            document.querySelectorAll('.menu-item').forEach(i => i.classList.remove('active'));
            this.classList.add('active');
            showNotification(`Navigasi ke: ${this.textContent.trim()}`, 'info');
        });
    });

    renderClasses();
    renderAssignments();
</script>
@endpush