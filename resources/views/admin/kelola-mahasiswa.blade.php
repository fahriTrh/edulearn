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

    .users-table {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        overflow: hidden;
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

    tbody tr:hover {
        background: #f5f7fa;
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }

    .user-avatar-small {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 0.9rem;
    }

    .user-name {
        font-weight: 600;
        color: #333;
    }

    .user-email {
        font-size: 0.85rem;
        color: #666;
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

    .badge-inactive {
        background: rgba(255, 71, 87, 0.1);
        color: #ff4757;
    }

    .badge-suspended {
        background: rgba(255, 165, 2, 0.1);
        color: #ffa502;
    }

    .action-btn {
        padding: 0.5rem 0.8rem;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s;
        margin: 0 0.2rem;
        font-size: 0.85rem;
    }

    .btn-edit {
        background: #667eea;
        color: white;
    }

    .btn-suspend {
        background: #ffa502;
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
    .form-group select {
        width: 100%;
        padding: 0.8rem;
        border: 2px solid #e8ebf0;
        border-radius: 8px;
        outline: none;
    }

    .form-group input:focus,
    .form-group select:focus {
        border-color: #667eea;
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
    }
</style>
@endpush

@section('content')
<div class="stats-summary">
    <div class="stat-box">
        <div class="stat-number" id="totalUsers">0</div>
        <div class="stat-label">Total Pengguna</div>
    </div>
    <div class="stat-box">
        <div class="stat-number" id="activeUsers">0</div>
        <div class="stat-label">Aktif</div>
    </div>
    <div class="stat-box">
        <div class="stat-number" id="inactiveUsers">0</div>
        <div class="stat-label">Tidak Aktif</div>
    </div>
    <div class="stat-box">
        <div class="stat-number">+127</div>
        <div class="stat-label">Bulan Ini</div>
    </div>
</div>

<div class="toolbar">
    <div class="search-box">
        <span class="search-icon">🔍</span>
        <input type="text" id="searchInput" placeholder="Cari nama, email, atau NIM...">
    </div>
    <select class="filter-select" id="statusFilter">
        <option value="all">Semua Status</option>
        <option value="active">Aktif</option>
        <option value="inactive">Tidak Aktif</option>
        <option value="suspended">Suspended</option>
    </select>
    <button class="btn-add" onclick="openAddUserModal()">
        <span>➕</span>
        <span>Tambah Mahasiswa</span>
    </button>
</div>

<div class="users-table">
    <table>
        <thead>
            <tr>
                <th>Pengguna</th>
                <th>NIM</th>
                <th>Bergabung</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="usersTableBody"></tbody>
    </table>
</div>

<div class="modal" id="addUserModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 id="modalTitle">Tambah Mahasiswa Baru</h2>
            <button class="close-modal" onclick="closeModal()">✕</button>
        </div>
        <form id="userForm" action="/tambah-mahasiswa" method="POST">
            @csrf
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input name="name" type="text" id="userName" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input name="email" type="email" id="userEmail" required>
            </div>
            <div class="form-group">
                <label>NIM</label>
                <input name="nim" type="text" id="userNIM" required>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="status" id="userStatus">
                    <option value="active">Aktif</option>
                    <option value="inactive">Tidak Aktif</option>
                </select>
            </div>
            <button type="submit" class="submit-btn" id="submitBtn">Tambah Mahasiswa</button>
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
    let users = @json($mahasiswas);

    let editingUserId = null;

    function renderTable(data = users) {
        const tbody = document.getElementById('usersTableBody');
        tbody.innerHTML = data.map(user => `
                <tr>
                    <td>
                        <div class="user-info">
                            <div class="user-avatar-small">${user.name.split(' ').map(n => n[0]).join('')}</div>
                            <div>
                                <div class="user-name">${user.name}</div>
                                <div class="user-email">${user.email}</div>
                            </div>
                        </div>
                    </td>
                    <td>${user.nim}</td>
                    <td>${user.joinedDate}</td>
                    <td><span class="status-badge badge-${user.status}">${user.status === 'active' ? 'Aktif' : user.status === 'inactive' ? 'Tidak Aktif' : 'Suspended'}</span></td>
                    <td>
                        <button class="action-btn btn-view" onclick="viewUser(${user.id})">Lihat</button>
                        <button class="action-btn btn-edit" onclick="editUser(${user.id})">Edit</button>
                        <button class="action-btn btn-suspend" onclick="toggleSuspend(${user.id})">${user.status === 'suspended' ? 'Aktifkan' : 'Suspend'}</button>
                        <button class="action-btn btn-delete" onclick="deleteUser(${user.id})">Hapus</button>
                    </td>
                </tr>
            `).join('');
        updateStats();
    }

    function updateStats() {
        document.getElementById('totalUsers').textContent = users.length;
        document.getElementById('activeUsers').textContent = users.filter(u => u.status === 'active').length;
        document.getElementById('inactiveUsers').textContent = users.filter(u => u.status === 'inactive').length;
    }

    function openAddUserModal() {
        editingUserId = null;
        document.getElementById('modalTitle').textContent = 'Tambah Mahasiswa Baru';
        document.getElementById('submitBtn').textContent = 'Tambah Mahasiswa';
        document.getElementById('userForm').reset();
        document.getElementById('addUserModal').classList.add('active');
        document.getElementById('userForm').action = '/tambah-mahasiswa';
    }

    function closeModal() {
        document.getElementById('addUserModal').classList.remove('active');
    }

    // function submitUser(e) {
    //     e.preventDefault();
    //     const userData = {
    //         name: document.getElementById('userName').value,
    //         email: document.getElementById('userEmail').value,
    //         nim: document.getElementById('userNIM').value,
    //         status: document.getElementById('userStatus').value,
    //         joinedDate: new Date().toLocaleDateString('id-ID', {
    //             month: 'short',
    //             year: 'numeric'
    //         })
    //     };

    //     if (editingUserId) {
    //         const index = users.findIndex(u => u.id === editingUserId);
    //         users[index] = {
    //             ...users[index],
    //             ...userData
    //         };
    //         alert('✅ Data pengguna berhasil diupdate!');
    //     } else {
    //         users.unshift({
    //             id: users.length + 1,
    //             ...userData
    //         });
    //         alert('✅ Pengguna baru berhasil ditambahkan!');
    //     }

    //     closeModal();
    //     renderTable();
    // }

    function viewUser(id) {
        const user = users.find(u => u.id === id);
        alert(`Nama: ${user.name}\nEmail: ${user.email}\nNIM: ${user.nim}\nStatus: ${user.status}`);
    }

    function editUser(id) {
        const user = users.find(u => u.id === id);
        editingUserId = id;
        document.getElementById('modalTitle').textContent = 'Edit Pengguna';
        document.getElementById('submitBtn').textContent = 'Update';
        document.getElementById('userName').value = user.name;
        document.getElementById('userEmail').value = user.email;
        document.getElementById('userNIM').value = user.nim;
        document.getElementById('userStatus').value = user.status;
        document.getElementById('addUserModal').classList.add('active');
        const form = document.getElementById('userForm');

        // Buat input hidden baru
        let hiddenInput = form.querySelector('input[name="id"]');

        if (hiddenInput) {
            // kalau sudah ada, update valuenya
            hiddenInput.value = editingUserId;
        } else {
            // kalau belum ada, buat baru
            hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'id';
            hiddenInput.value = editingUserId;
            form.appendChild(hiddenInput);
        }
        form.action = '/update-mahasiswa';
    }

    function toggleSuspend(id) {
        const user = users.find(u => u.id === id);
        if (confirm(`${user.status === 'suspended' ? 'Aktifkan' : 'Suspend'} pengguna "${user.name}"?`)) {
            user.status = user.status === 'suspended' ? 'active' : 'suspended';
            renderTable();
        }
    }

    function deleteUser(userId) {
        // munculkan konfirmasi
        if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
            const form = document.getElementById('deleteForm');

            // ubah action-nya ke URL yang sesuai
            form.action = `/delete-mahasiswa/${userId}`;

            // kirim form ke server
            form.submit();
        }
    }

    document.getElementById('searchInput').addEventListener('input', function(e) {
        const term = e.target.value.toLowerCase();
        const filtered = users.filter(u =>
            u.name.toLowerCase().includes(term) ||
            u.email.toLowerCase().includes(term) ||
            u.nim.includes(term)
        );
        renderTable(filtered);
    });

    document.getElementById('statusFilter').addEventListener('change', function(e) {
        const status = e.target.value;
        const filtered = status === 'all' ? users : users.filter(u => u.status === status);
        renderTable(filtered);
    });

    renderTable();
</script>
@endpush