@extends('admin.app')

{{-- 
    SELURUH BLOK @push('styles') ... </style> @endpush TELAH DIHAPUS. 
    Semua styling sekarang ditangani oleh Tailwind.
--}}

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm p-6 text-center hover:-translate-y-1 hover:shadow-md transition-all">
        <div class="text-3xl font-bold text-indigo-600 mb-2" id="totalInstructors">0</div>
        <div class="text-gray-600 text-sm">Total Instruktur</div>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6 text-center hover:-translate-y-1 hover:shadow-md transition-all">
        <div class="text-3xl font-bold text-indigo-600 mb-2" id="activeInstructors">0</div>
        <div class="text-gray-600 text-sm">Aktif</div>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6 text-center hover:-translate-y-1 hover:shadow-md transition-all">
        <div class="text-3xl font-bold text-indigo-600 mb-2" id="totalCourses">0</div>
        <div class="text-gray-600 text-sm">Total Kursus</div>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6 text-center hover:-translate-y-1 hover:shadow-md transition-all">
        <div class="text-3xl font-bold text-indigo-600 mb-2" id="avgRating">0.0</div>
        <div class="text-gray-600 text-sm">Rata-rata Rating</div>
    </div>
</div>

<div class="bg-white p-6 rounded-xl mb-8 shadow-sm flex flex-col md:flex-row gap-4 flex-wrap items-center">
    <div class="relative flex-1 min-w-[250px]">
        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">🔍</span>
        <input type="text" id="searchInput" placeholder="Cari nama atau keahlian..." class="w-full p-3 pl-10 border-2 border-gray-200 rounded-lg outline-none focus:border-indigo-500">
    </div>
    <select id="statusFilter" class="w-full md:w-auto p-3 border-2 border-gray-200 rounded-lg outline-none cursor-pointer bg-white focus:border-indigo-500">
        <option value="all">Semua Status</option>
        <option value="active">Aktif</option>
        <option value="inactive">Tidak Aktif</option>
    </select>
    <select id="specialtyFilter" class="w-full md:w-auto p-3 border-2 border-gray-200 rounded-lg outline-none cursor-pointer bg-white focus:border-indigo-500">
        <option value="all">Semua Keahlian</option>
        <option value="Pemrograman">Pemrograman</option>
        <option value="Design">Design</option>
        <option value="Data Science">Data Science</option>
        <option value="Mobile">Mobile</option>
    </select>
    <button class="w-full md:w-auto p-3 bg-gradient-to-br from-purple-600 to-purple-800 text-white rounded-lg cursor-pointer font-semibold flex items-center justify-center gap-2 transition-all hover:-translate-y-0.5 hover:shadow-lg" onclick="openAddModal()">
        <span>➕</span>
        <span>Tambah Instruktur</span>
    </button>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="instructorsGrid">
    {{-- Cards dirender oleh JS --}}
</div>

{{-- Modal (Struktur HTML diperbarui agar konsisten dengan 'kelola mahasiswa') --}}
<div class="fixed top-0 left-0 w-full h-full bg-black/50 z-[1000] items-center justify-center p-4 hidden" id="instructorModal">
    <div class="bg-white p-8 rounded-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-6">
            <h2 id="modalTitle" class="text-2xl font-semibold">Tambah Instruktur Baru</h2>
            <button class="text-2xl text-gray-500 hover:text-gray-800" onclick="closeModal()">✕</button>
        </div>
        <form id="instructorForm" action="/tambah-instruktur" method="POST">
            @csrf
            <div class="mb-6">
                <label class="block mb-2 font-semibold">Nama Lengkap</label>
                <input name="name" type="text" id="instructorName" required class="w-full p-3 border-2 border-gray-200 rounded-lg outline-none focus:border-indigo-500">
            </div>
            <div class="mb-6">
                <label class="block mb-2 font-semibold">Email</label>
                <input name="email" type="email" id="instructorEmail" required class="w-full p-3 border-2 border-gray-200 rounded-lg outline-none focus:border-indigo-500">
            </div>
            <div class="mb-6">
                <label class="block mb-2 font-semibold">Keahlian/Spesialisasi</label>
                <input name="specialization" type="text" id="instructorSpecialty" placeholder="e.g., Pemrograman Web, UI/UX" required class="w-full p-3 border-2 border-gray-200 rounded-lg outline-none focus:border-indigo-500">
            </div>
            <div class="mb-6">
                <label class="block mb-2 font-semibold">Bio/Deskripsi</label>
                <textarea name="description" id="instructorBio" placeholder="Pengalaman dan latar belakang instruktur..." required class="w-full p-3 border-2 border-gray-200 rounded-lg outline-none focus:border-indigo-500 min-h-[120px] resize-y"></textarea>
            </div>
            <div class="mb-6">
                <label class="block mb-2 font-semibold">Status</label>
                <select name="status" id="instructorStatus" class="w-full p-3 border-2 border-gray-200 rounded-lg outline-none focus:border-indigo-500 bg-white">
                    <option value="active">Aktif</option>
                    <option value="inactive">Tidak Aktif</option>
                </select>
            </div>
            <button type="submit" class="w-full p-3 bg-gradient-to-br from-purple-600 to-purple-800 text-white rounded-lg cursor-pointer font-semibold text-base hover:opacity-90 hover:-translate-y-0.5" id="submitBtn">Tambah Instruktur</button>
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
    let instructors = @json($instructors);
    let editingId = null;

    function renderInstructors(data = instructors) {
        const grid = document.getElementById('instructorsGrid');
        grid.innerHTML = data.map(instructor => {
            const statusClass = instructor.status === 'active' ? 'text-green-600' : 'text-red-600';
            const statusText = instructor.status === 'active' ? '● Aktif' : '● Tidak Aktif';
            
            // Generate initials for avatar
            const words = (instructor.name || 'I').trim().split(' ');
            const initials = (words.length >= 2 ? words[0].charAt(0) + words[words.length - 1].charAt(0) : instructor.name.substring(0, 2)).toUpperCase();

            return `
                <div class="bg-white rounded-xl overflow-hidden shadow-sm transition-all hover:-translate-y-1 hover:shadow-lg">
                    <div class="bg-gradient-to-br from-purple-600 to-purple-800 p-6 text-center relative">
                        <div class="absolute top-4 right-4 px-3 py-1 rounded-full text-xs font-semibold bg-white/90 ${statusClass}">
                            ${statusText}
                        </div>
                        <div class="w-24 h-24 rounded-full bg-white text-purple-700 flex items-center justify-center text-4xl font-bold mx-auto border-4 border-white/30">
                            ${initials}
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="text-xl font-bold text-gray-900 text-center mb-1">${instructor.name}</div>
                        <div class="text-center text-indigo-600 text-sm font-medium mb-4">🎯 ${instructor.specialty}</div>
                        
                        <div class="flex items-center gap-2 justify-center mb-4">
                            <span class="text-yellow-500">⭐</span>
                            <span class="font-bold text-gray-800">${instructor.rating}</span>
                            <span class="text-gray-500 text-sm">(${instructor.students} mahasiswa)</span>
                        </div>
                        
                        <div class="space-y-2 mb-4">
                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                <span class="w-5 text-center">📧</span>
                                <span>${instructor.email}</span>
                            </div>
                            <div class="flex items-start gap-2 text-sm text-gray-600">
                                <span class="w-5 text-center pt-1">📝</span>
                                <span class="flex-1">${instructor.bio.substring(0, 50)}...</span>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-3 gap-4 p-4 bg-gray-50 rounded-lg mb-6">
                            <div class="text-center">
                                <div class="text-lg font-bold text-indigo-600">${instructor.courses}</div>
                                <div class="text-xs text-gray-500">Kursus</div>
                            </div>
                            <div class="text-center">
                                <div class="text-lg font-bold text-indigo-600">${instructor.students}</div>
                                <div class="text-xs text-gray-500">Mahasiswa</div>
                            </div>
                            <div class="text-center">
                                <div class="text-lg font-bold text-indigo-600">${instructor.rating}</div>
                                <div class="text-xs text-gray-500">Rating</div>
                            </div>
                        </div>
                        
                        <div class="flex gap-2">
                            <button class="flex-1 p-3 rounded-lg font-semibold text-sm transition-all hover:-translate-y-0.5 text-center bg-gray-100 text-gray-800 hover:bg-gray-200" onclick="viewInstructor(${instructor.id})">Lihat</button>
                            <button class="flex-1 p-3 rounded-lg font-semibold text-sm transition-all hover:-translate-y-0.5 text-center bg-indigo-600 text-white hover:bg-indigo-700" onclick="editInstructor(${instructor.id})">Edit</button>
                            <button class="flex-1 p-3 rounded-lg font-semibold text-sm transition-all hover:-translate-y-0.5 text-center bg-red-500 text-white hover:bg-red-600" onclick="deleteInstructor(${instructor.id})">Hapus</button>
                        </div>
                    </div>
                </div>
            `;
        }).join('');
        updateStats();
    }

    function updateStats() {
        document.getElementById('totalInstructors').textContent = instructors.length;
        document.getElementById('activeInstructors').textContent = instructors.filter(i => i.status === 'active').length;
        document.getElementById('totalCourses').textContent = instructors.reduce((sum, i) => sum + (i.courses || 0), 0);
        
        const totalRatingSum = instructors.reduce((sum, i) => sum + (i.rating || 0), 0);
        const avgRating = instructors.length > 0 ? (totalRatingSum / instructors.length).toFixed(1) : '0.0';
        document.getElementById('avgRating').textContent = avgRating;
    }

    function openAddModal() {
        editingId = null;
        const form = document.getElementById('instructorForm');
        form.reset();
        document.getElementById('modalTitle').textContent = 'Tambah Instruktur Baru';
        document.getElementById('submitBtn').textContent = 'Tambah Instruktur';
        form.action = '/tambah-instruktur';
        
        // Pastikan tidak ada input hidden 'id' atau '_method'
        form.querySelector('input[name="id"]')?.remove();
        form.querySelector('input[name="_method"]')?.remove();
        
        // **PERUBAHAN JAVASCRIPT:** Menggunakan 'hidden' dan 'flex'
        const modal = document.getElementById('instructorModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeModal() {
        // **PERUBAHAN JAVASCRIPT:** Menggunakan 'hidden' dan 'flex'
        const modal = document.getElementById('instructorModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    // Submit form (Create or Update)
    document.getElementById('instructorForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = e.target;
        const formData = new FormData(form);
        const url = form.action;

        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (editingId) {
                    const index = instructors.findIndex(i => i.id === editingId);
                    if (index !== -1) {
                        instructors[index] = data.instructor;
                    }
                } else {
                    instructors.unshift(data.instructor);
                }
                showNotification(data.message, 'success'); // Asumsi 'showNotification' ada di global (dari admin.app)
                closeModal();
                renderInstructors();
            } else {
                showNotification(data.message || 'Terjadi kesalahan', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Gagal terhubung ke server.', 'error');
        });
    });

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
        
        const form = document.getElementById('instructorForm');
        form.action = `/update-instruktur/${id}`; 

        form.querySelector('input[name="id"]')?.remove();
        form.querySelector('input[name="_method"]')?.remove();

        const idInput = document.createElement('input');
        idInput.type = 'hidden';
        idInput.name = 'id';
        idInput.value = id;
        form.appendChild(idInput);

        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'PUT';
        form.appendChild(methodInput);

        // **PERUBAHAN JAVASCRIPT:** Menggunakan 'hidden' dan 'flex'
        const modal = document.getElementById('instructorModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function deleteInstructor(id) {
        if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
            const form = document.getElementById('deleteForm');
            form.action = `/delete-instruktur/${id}`;
            form.submit();
        }
    }

    // --- Event Listeners untuk Filter ---
    document.getElementById('searchInput').addEventListener('input', function(e) {
        applyFilters();
    });

    document.getElementById('statusFilter').addEventListener('change', function(e) {
        applyFilters();
    });

    document.getElementById('specialtyFilter').addEventListener('change', function(e) {
        applyFilters();
    });

    function applyFilters() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const status = document.getElementById('statusFilter').value;
        const specialty = document.getElementById('specialtyFilter').value;

        let filtered = instructors;

        if (status !== 'all') {
            filtered = filtered.filter(i => i.status === status);
        }
        if (specialty !== 'all') {
            filtered = filtered.filter(i => i.specialty === specialty);
        }
        if (searchTerm) {
            filtered = filtered.filter(i =>
                i.name.toLowerCase().includes(searchTerm) ||
                i.specialty.toLowerCase().includes(searchTerm)
            );
        }
        renderInstructors(filtered);
    }

    // Render awal saat halaman dimuat
    document.addEventListener('DOMContentLoaded', () => {
        renderInstructors();
    });
</script>
@endpush