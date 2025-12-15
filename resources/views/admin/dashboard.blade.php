@extends('admin.app')

@section('content')
{{-- Stat Grid --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    {{-- Stat Card 1 --}}
    <div class="bg-white rounded-xl shadow-sm p-6 hover:-translate-y-1 hover:shadow-md transition-all">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 bg-indigo-100 rounded-xl flex items-center justify-center text-2xl">
                👥
            </div>
            <div>
                <h3 class="text-3xl font-bold text-indigo-600">{{ $total_mahasiswa }}</h3>
                <p class="text-gray-600 text-sm">Total Mahasiswa</p>
                </div>
        </div>
    </div>
    
    {{-- Stat Card 2 --}}
    <div class="bg-white rounded-xl shadow-sm p-6 hover:-translate-y-1 hover:shadow-md transition-all">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center text-2xl">
                📚
            </div>
            <div>
                <h3 class="text-3xl font-bold text-indigo-600">{{ $total_class }}</h3>
                <p class="text-gray-600 text-sm">Total Kursus</p>
                </div>
        </div>
    </div>
    
    {{-- Stat Card 3 --}}
    <div class="bg-white rounded-xl shadow-sm p-6 hover:-translate-y-1 hover:shadow-md transition-all">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 bg-orange-100 rounded-xl flex items-center justify-center text-2xl">
                👨‍🏫
            </div>
            <div>
                <h3 class="text-3xl font-bold text-indigo-600">{{ $total_instructor }}</h3>
                <p class="text-gray-600 text-sm">Instruktur Aktif</p>
                </div>
        </div>
    </div>
</div>



{{-- Quick Actions --}}
<div class="bg-white rounded-xl shadow-sm p-6 mb-8">
    <div class="mb-6">
        <h2 class="text-xl font-bold text-gray-900">Quick Actions</h2>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <a href="/kelola-mahasiswa" class="p-4 bg-gradient-to-br from-purple-600 to-purple-800 text-white rounded-xl font-semibold flex flex-col items-center gap-2 transition-all hover:-translate-y-1 hover:shadow-lg no-underline">
            <div class="text-3xl">👤</div>
            <div>Tambah Mahasiswa</div>
        </a>
        <a href="/kelola-instruktur" class="p-4 bg-gradient-to-br from-purple-600 to-purple-800 text-white rounded-xl font-semibold flex flex-col items-center gap-2 transition-all hover:-translate-y-1 hover:shadow-lg no-underline">
            <div class="text-3xl">👨‍🏫</div>
            <div>Tambah Instruktur</div>
        </a>
        
        </div>
</div>

@endsection

@push('scripts')
<script>
    // Data dummy Anda
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
        
        // Cek jika tbody ada (karena HTML-nya di-comment)
        if (!tbody) {
            return;
        }

        tbody.innerHTML = coursesData.map(course => {
            // Logika untuk status badge Tailwind
            const statusClass = course.status === 'active' 
                ? 'bg-green-100 text-green-700' 
                : 'bg-yellow-100 text-yellow-600';
            const statusText = course.status === 'active' ? 'Aktif' : 'Pending';

            return `
                <tr class="hover:bg-gray-50">
                    <td class="p-4 border-b border-gray-200 font-semibold text-gray-800">${course.name}</td>
                    <td class="p-4 border-b border-gray-200">${course.instructor}</td>
                    <td class="p-4 border-b border-gray-200">${course.students} mahasiswa</td>
                    <td class="p-4 border-b border-gray-200">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold ${statusClass}">
                            ${statusText}
                        </span>
                    </td>
                    <td class="p-4 border-b border-gray-200 space-x-2">
                        <button class="px-4 py-2 rounded-md font-semibold text-sm transition-all hover:-translate-y-0.5 bg-gray-100 text-gray-700 hover:bg-gray-200" onclick="viewCourse('${course.name}')">Lihat</button>
                        <button class="px-4 py-2 rounded-md font-semibold text-sm transition-all hover:-translate-y-0.5 bg-indigo-600 text-white hover:bg-indigo-700" onclick="editCourse('${course.name}')">Edit</button>
                        <button class="px-4 py-2 rounded-md font-semibold text-sm transition-all hover:-translate-y-0.5 bg-red-500 text-white hover:bg-red-600" onclick="deleteCourse('${course.name}')">Hapus</button>
                    </td>
                </tr>
            `;
        }).join('');
    }

    // Fungsi notifikasi Anda (diasumsikan sudah global dari admin.app)
    function viewCourse(name) {
        showNotification(`📖 Membuka detail kursus: ${name}`, 'info');
    }

    function editCourse(name) {
        showNotification(`✏️ Membuka form edit kursus: ${name}`, 'info');
    }

    function deleteCourse(name) {
        if (confirm(`Apakah Anda yakin ingin menghapus kursus "${name}"?`)) {
            showNotification(`🗑️ Kursus "${name}" berhasil dihapus!`, 'success');
            // Tambahkan logika penghapusan data di sini
        }
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', renderCoursesTable);
</script>
@endpush