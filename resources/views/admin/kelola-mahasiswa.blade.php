@extends('admin.app')

{{-- 
    SELURUH BLOK @push('styles') ... </style> @endpush TELAH DIHAPUS. 
    Semua styling sekarang ditangani oleh Tailwind.
--}}

@section('content')
{{-- Stats Grid --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm p-6 text-center hover:-translate-y-1 hover:shadow-md transition-all">
        <div class="text-3xl font-bold text-indigo-600 mb-2" id="totalUsers">0</div>
        <div class="text-gray-600 text-sm">Total Pengguna</div>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6 text-center hover:-translate-y-1 hover:shadow-md transition-all">
        <div class="text-3xl font-bold text-indigo-600 mb-2" id="activeUsers">0</div>
        <div class="text-gray-600 text-sm">Aktif</div>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6 text-center hover:-translate-y-1 hover:shadow-md transition-all">
        <div class="text-3xl font-bold text-indigo-600 mb-2" id="inactiveUsers">0</div>
        <div class="text-gray-600 text-sm">Tidak Aktif</div>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6 text-center hover:-translate-y-1 hover:shadow-md transition-all">
        {{-- Stat ini statis di HTML Anda, jadi saya biarkan --}}
        <div class="text-3xl font-bold text-indigo-600 mb-2">+127</div>
        <div class="text-gray-600 text-sm">Bulan Ini</div>
    </div>
</div>

{{-- Toolbar --}}
<div class="bg-white p-6 rounded-xl mb-8 shadow-sm flex flex-col md:flex-row gap-4 flex-wrap items-center">
    <div class="relative flex-1 min-w-[250px]">
        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">🔍</span>
        <input type="text" id="searchInput" placeholder="Cari nama, email, atau NIM..." class="w-full p-3 pl-10 border-2 border-gray-200 rounded-lg outline-none focus:border-indigo-500">
    </div>
    <select id="statusFilter" class="w-full md:w-auto p-3 border-2 border-gray-200 rounded-lg outline-none cursor-pointer bg-white focus:border-indigo-500">
        <option value="all">Semua Status</option>
        <option value="active">Aktif</option>
        <option value="inactive">Tidak Aktif</option>
        <option value="suspended">Suspended</option>
    </select>
    <button class="w-full md:w-auto p-3 bg-gradient-to-br from-purple-600 to-purple-800 text-white rounded-lg cursor-pointer font-semibold flex items-center justify-center gap-2 transition-all hover:-translate-y-0.5 hover:shadow-lg" onclick="openAddUserModal()">
        <span>➕</span>
        <span>Tambah Mahasiswa</span>
    </button>
</div>

{{-- Users Table --}}
<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full min-w-[800px] border-collapse">
            <thead class="bg-gray-50">
                <tr>
                    <th class="p-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b-2 border-gray-200">Pengguna</th>
                    <th class="p-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b-2 border-gray-200">NIM</th>
                    <th class="p-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b-2 border-gray-200">Bergabung</th>
                    <th class="p-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b-2 border-gray-200">Status</th>
                    <th class="p-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b-2 border-gray-200">Aksi</th>
                </tr>
            </thead>
            <tbody id="usersTableBody">
                {{-- Rows will be rendered here by JavaScript --}}
            </tbody>
        </table>
    </div>
</div>

{{-- Add/Edit User Modal --}}
<div class="fixed top-0 left-0 w-full h-full bg-black/50 z-[1000] items-center justify-center p-4 hidden" id="addUserModal">
    <div class="bg-white p-8 rounded-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-6">
            <h2 id="modalTitle" class="text-2xl font-semibold">Tambah Mahasiswa Baru</h2>
            <button class="text-2xl text-gray-500 hover:text-gray-800" onclick="closeModal()">✕</button>
        </div>
        <form id="userForm" action="/tambah-mahasiswa" method="POST">
            @csrf
            <div class="mb-6">
                <label class="block mb-2 font-semibold">Nama Lengkap</label>
                <input name="name" type="text" id="userName" required class="w-full p-3 border-2 border-gray-200 rounded-lg outline-none focus:border-indigo-500">
            </div>
            <div class="mb-6">
                <label class="block mb-2 font-semibold">Email</label>
                <input name="email" type="email" id="userEmail" required class="w-full p-3 border-2 border-gray-200 rounded-lg outline-none focus:border-indigo-500">
            </div>
            <div class="mb-6">
                <label class="block mb-2 font-semibold">NIM</label>
                <input name="nim" type="text" id="userNIM" required class="w-full p-3 border-2 border-gray-200 rounded-lg outline-none focus:border-indigo-500">
            </div>
            <div class="mb-6">
                <label class="block mb-2 font-semibold">Status</label>
                <select name="status" id="userStatus" class="w-full p-3 border-2 border-gray-200 rounded-lg outline-none focus:border-indigo-500 bg-white">
                    <option value="active">Aktif</option>
                    <option value="inactive">Tidak Aktif</option>
                </select>
            </div>
            <button type="submit" class="w-full p-3 bg-gradient-to-br from-purple-600 to-purple-800 text-white rounded-lg cursor-pointer font-semibold text-base hover:opacity-90 hover:-translate-y-0.5" id="submitBtn">Tambah Mahasiswa</button>
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
    let users = @json($mahasiswas);
    let editingUserId = null;

    // Helper untuk mendapatkan inisial avatar
    function getInitials(name) {
        if (!name) return '...';
        const words = name.trim().split(' ');
        let initials = '';
        if (words.length >= 2) {
            initials = words[0].charAt(0) + words[words.length - 1].charAt(0);
        } else {
            initials = name.substring(0, 2);
        }
        return initials.toUpperCase();
    }

    function renderTable(data = users) {
        const tbody = document.getElementById('usersTableBody');
        tbody.innerHTML = data.map(user => {
            // Logika untuk status badge Tailwind
            let statusClass = '';
            let statusText = '';
            switch (user.status) {
                case 'active':
                    statusClass = 'bg-green-100 text-green-700';
                    statusText = 'Aktif';
                    break;
                case 'inactive':
                    statusClass = 'bg-red-100 text-red-700';
                    statusText = 'Tidak Aktif';
                    break;
                case 'suspended':
                    statusClass = 'bg-yellow-100 text-yellow-600';
                    statusText = 'Suspended';
                    break;
                default:
                    statusClass = 'bg-gray-100 text-gray-600';
                    statusText = 'N/A';
            }

            return `
                <tr class="hover:bg-gray-50">
                    <td class="p-4 border-b border-gray-200">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-600 to-purple-800 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                                ${getInitials(user.name)}
                            </div>
                            <div>
                                <div class="font-semibold text-gray-800">${user.name}</div>
                                <div class="text-sm text-gray-500">${user.email}</div>
                            </div>
                        </div>
                    </td>
                    <td class="p-4 border-b border-gray-200 text-sm text-gray-700">${user.nim}</td>
                    <td class="p-4 border-b border-gray-200 text-sm text-gray-700">${user.joinedDate}</td>
                    <td class="p-4 border-b border-gray-200">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold ${statusClass}">
                            ${statusText}
                        </span>
                    </td>
                    <td class="p-4 border-b border-gray-200 whitespace-nowrap">
                        <button class="px-3 py-1 rounded-md font-semibold text-xs transition-all hover:-translate-y-0.5 bg-gray-100 text-gray-700 hover:bg-gray-200" onclick="viewUser(${user.id})">Lihat</button>
                        <button class="px-3 py-1 rounded-md font-semibold text-xs transition-all hover:-translate-y-0.5 bg-indigo-600 text-white hover:bg-indigo-700" onclick="editUser(${user.id})">Edit</button>
                        <button class="px-3 py-1 rounded-md font-semibold text-xs transition-all hover:-translate-y-0.5 ${user.status === 'suspended' ? 'bg-green-500' : 'bg-yellow-500'} text-white" onclick="toggleSuspend(${user.id})">
                            ${user.status === 'suspended' ? 'Aktifkan' : 'Suspend'}
                        </button>
                        <button class="px-3 py-1 rounded-md font-semibold text-xs transition-all hover:-translate-y-0.5 bg-red-500 text-white hover:bg-red-600" onclick="deleteUser(${user.id})">Hapus</button>
                    </td>
                </tr>
            `;
        }).join('');
        updateStats();
    }

    function updateStats() {
        document.getElementById('totalUsers').textContent = users.length;
        document.getElementById('activeUsers').textContent = users.filter(u => u.status === 'active').length;
        document.getElementById('inactiveUsers').textContent = users.filter(u => u.status === 'inactive').length;
    }

    function openAddUserModal() {
        editingUserId = null;
        const form = document.getElementById('userForm');
        form.reset();
        document.getElementById('modalTitle').textContent = 'Tambah Mahasiswa Baru';
        document.getElementById('submitBtn').textContent = 'Tambah Mahasiswa';
        form.action = '/tambah-mahasiswa';

        // Hapus input _method atau id jika ada
        form.querySelector('input[name="id"]')?.remove();
        form.querySelector('input[name="_method"]')?.remove();

        const modal = document.getElementById('addUserModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeModal() {
        const modal = document.getElementById('addUserModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

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
        
        const form = document.getElementById('userForm');
        form.action = '/update-mahasiswa';

        // Hapus input lama jika ada
        form.querySelector('input[name="id"]')?.remove();
        form.querySelector('input[name="_method"]')?.remove();

        // Tambahkan input hidden untuk ID
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'id';
        hiddenInput.value = editingUserId;
        form.appendChild(hiddenInput);

        openModal(); // Buka modal
    }

    function toggleSuspend(id) {
        // Ini hanya demo sisi klien. Idealnya, ini akan memanggil API.
        const user = users.find(u => u.id === id);
        if (confirm(`${user.status === 'suspended' ? 'Aktifkan' : 'Suspend'} pengguna "${user.name}"?`)) {
            user.status = user.status === 'suspended' ? 'active' : 'suspended';
            renderTable(); // Render ulang tabel untuk menunjukkan perubahan
            // showNotification('Status pengguna diperbarui!', 'success');
        }
    }

    function deleteUser(userId) {
        if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
            const form = document.getElementById('deleteForm');
            form.action = `/delete-mahasiswa/${userId}`;
            form.submit();
        }
    }

    document.getElementById('searchInput').addEventListener('input', function(e) {
        applyFilters();
    });

    document.getElementById('statusFilter').addEventListener('change', function(e) {
        applyFilters();
    });

    function applyFilters() {
        const term = document.getElementById('searchInput').value.toLowerCase();
        const status = document.getElementById('statusFilter').value;

        let filtered = users;

        if (status !== 'all') {
            filtered = filtered.filter(u => u.status === status);
        }

        if (term) {
            filtered = filtered.filter(u =>
                u.name.toLowerCase().includes(term) ||
                u.email.toLowerCase().includes(term) ||
                (u.nim && u.nim.includes(term)) // Pastikan nim ada
            );
        }
        
        renderTable(filtered);
    }

    // Render awal saat halaman dimuat
    document.addEventListener('DOMContentLoaded', () => {
        renderTable();
    });
</script>
@endpush