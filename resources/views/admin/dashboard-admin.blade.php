@extends('admin.app')

@section('content')
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon blue">👥</div>
        <div class="stat-info">
            <h3>{{ $total_mahasiswa }}</h3>
            <p>Total Mahasiswa</p>
            <!-- <div class="stat-change positive">↑ +12% bulan ini</div> -->
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">📚</div>
        <div class="stat-info">
            <h3>{{ $total_class }}</h3>
            <p>Total Kursus</p>
            <!-- <div class="stat-change positive">↑ +8 kursus baru</div> -->
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange">👨‍🏫</div>
        <div class="stat-info">
            <h3>{{ $total_instructor }}</h3>
            <p>Instruktur Aktif</p>
            <!-- <div class="stat-change positive">↑ +3 instruktur</div> -->
        </div>
    </div>
    <!-- <div class="stat-card">
        <div class="stat-icon purple">🏆</div>
        <div class="stat-info">
            <h3>1,283</h3>
            <p>Sertifikat Diterbitkan</p>
            <div class="stat-change positive">↑ +156 bulan ini</div>
        </div>
    </div> -->
</div>

<div class="card" style="margin-bottom: 2rem;">
    <div class="card-header">
        <div class="card-title">Quick Actions</div>
    </div>
    <div class="quick-actions">
        <!-- <button class="quick-action-btn"
            onclick="showNotification('Membuka form tambah kursus...', 'info')">
            <div class="quick-action-icon">➕</div>
            <div>Tambah Kursus</div>
        </button> -->
        <a href="/kelola-mahasiswa" class="quick-action-btn" style="text-decoration: none;">
            <div class="quick-action-icon">👤</div>
            <div>Tambah Mahasiswa</div>
        </a>
        <a href="/kelola-instruktur" class="quick-action-btn" style="text-decoration: none;">
            <div class="quick-action-icon">👤</div>
            <div>Tambah Instruktur/Dosen</div>
        </a>
        <!-- <a href="/" class="quick-action-btn">
            <div class="quick-action-icon">✍️</div>
            <div>Review Tugas</div>
        </a>
        <a class="quick-action-btn">
            <div class="quick-action-icon">📊</div>
            <div>Lihat Laporan</div>
        </a> -->
    </div>
</div>

<!-- <div class="content-grid">
    <div class="card">
        <div class="card-header">
            <div class="card-title">Statistik Pendaftaran Bulanan</div>
            <select
                style="padding: 0.5rem; border: 2px solid #e8ebf0; border-radius: 6px; cursor: pointer;">
                <option>2024</option>
                <option>2023</option>
            </select>
        </div>
        <div class="chart-container">
            <div class="chart-bar">
                <div class="bar" style="height: 150px;">
                    <div class="bar-value">180</div>
                </div>
                <div class="bar-label">Jan</div>
            </div>
            <div class="chart-bar">
                <div class="bar" style="height: 180px;">
                    <div class="bar-value">220</div>
                </div>
                <div class="bar-label">Feb</div>
            </div>
            <div class="chart-bar">
                <div class="bar" style="height: 200px;">
                    <div class="bar-value">250</div>
                </div>
                <div class="bar-label">Mar</div>
            </div>
            <div class="chart-bar">
                <div class="bar" style="height: 170px;">
                    <div class="bar-value">210</div>
                </div>
                <div class="bar-label">Apr</div>
            </div>
            <div class="chart-bar">
                <div class="bar" style="height: 230px;">
                    <div class="bar-value">280</div>
                </div>
                <div class="bar-label">Mei</div>
            </div>
            <div class="chart-bar">
                <div class="bar" style="height: 260px;">
                    <div class="bar-value">320</div>
                </div>
                <div class="bar-label">Jun</div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="card-title">Aktivitas Terbaru</div>
            <a href="#" class="view-all">Lihat Semua →</a>
        </div>
        <div class="activity-list">
            <div class="activity-item">
                <div class="activity-icon user">👤</div>
                <div class="activity-info">
                    <div class="activity-title">Pengguna baru terdaftar</div>
                    <div class="activity-time">5 menit yang lalu</div>
                </div>
            </div>
            <div class="activity-item">
                <div class="activity-icon course">📚</div>
                <div class="activity-info">
                    <div class="activity-title">Kursus "React Native" dipublikasi</div>
                    <div class="activity-time">1 jam yang lalu</div>
                </div>
            </div>
            <div class="activity-item">
                <div class="activity-icon cert">🏆</div>
                <div class="activity-info">
                    <div class="activity-title">25 sertifikat diterbitkan</div>
                    <div class="activity-time">2 jam yang lalu</div>
                </div>
            </div>
            <div class="activity-item">
                <div class="activity-icon user">👤</div>
                <div class="activity-info">
                    <div class="activity-title">Instruktur baru bergabung</div>
                    <div class="activity-time">3 jam yang lalu</div>
                </div>
            </div>
            <div class="activity-item">
                <div class="activity-icon course">📚</div>
                <div class="activity-info">
                    <div class="activity-title">Kursus diperbarui</div>
                    <div class="activity-time">5 jam yang lalu</div>
                </div>
            </div>
        </div>
    </div>
</div> -->

<!-- <div class="card">
    <div class="card-header">
        <div class="card-title">Kursus Terbaru</div>
    </div>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Nama Kursus</th>
                    <th>Instruktur</th>
                    <th>Peserta</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="coursesTable">
            </tbody>
        </table>
    </div>
</div> -->
@endsection

@push('scripts')
<script>
    const coursesData = [{
            name: "Pemrograman Web Lanjut",
            instructor: "Dr. Budi Santoso",
            students: 245,
            rating: 4.8,
            status: "active"
        },
        {
            name: "Machine Learning Dasar",
            instructor: "Dr. Maya Sari",
            students: 198,
            rating: 4.7,
            status: "active"
        },
        {
            name: "Desain Interaksi",
            instructor: "Andi Wijaya, M.Kom",
            students: 167,
            rating: 4.9,
            status: "active"
        },
        {
            name: "Database Management",
            instructor: "Ir. Joko Widodo",
            students: 152,
            rating: 4.6,
            status: "active"
        },
        {
            name: "Mobile Development",
            instructor: "Rahmat Hidayat, M.T",
            students: 134,
            rating: 4.7,
            status: "pending"
        }
    ];

    function renderCoursesTable() {
        const tbody = document.getElementById('coursesTable');
        tbody.innerHTML = coursesData.map(course => `
                <tr>
                    <td><strong>${course.name}</strong></td>
                    <td>${course.instructor}</td>
                    <td>${course.students} mahasiswa</td>
                    <td>
                        <span class="status-badge badge-${course.status}">
                            ${course.status === 'active' ? 'Aktif' : 'Pending'}
                        </span>
                    </td>
                    <td>
                        <button class="action-btn btn-view" onclick="viewCourse('${course.name}')">Lihat</button>
                        <button class="action-btn btn-edit" onclick="editCourse('${course.name}')">Edit</button>
                        <button class="action-btn btn-delete" onclick="deleteCourse('${course.name}')">Hapus</button>
                    </td>
                </tr>
            `).join('');
    }

    function viewCourse(name) {
        showNotification(`📖 Membuka detail kursus: ${name}`, 'info');
    }

    function editCourse(name) {
        showNotification(`✏️ Membuka form edit kursus: ${name}`, 'info');
    }

    function deleteCourse(name) {
        if (confirm(`Apakah Anda yakin ingin menghapus kursus "${name}"?`)) {
            showNotification(`🗑️ Kursus "${name}" berhasil dihapus!`, 'success');
        }
    }

    // Initialize
    renderCoursesTable();
</script>
@endpush