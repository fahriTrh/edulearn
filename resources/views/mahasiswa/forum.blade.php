@extends('mahasiswa.app')

@section('title', 'Forum Diskusi')

@section('content')
    <!-- Page Header -->
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Forum Diskusi</h1>
            <p class="text-gray-600">Diskusikan materi, tanyakan pertanyaan, dan berbagi pengetahuan</p>
        </div>
        <button onclick="openModal()" class="flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-700 text-white rounded-full font-semibold hover:-translate-y-1 hover:shadow-lg transition-all whitespace-nowrap">
            <span>➕</span>
            <span>Buat Diskusi Baru</span>
        </button>
    </div>

    <!-- Filter Tabs -->
    <div class="bg-white rounded-xl shadow-sm p-4 mb-6 flex flex-wrap gap-2">
        <button onclick="filterDiscussions('all', this)" class="filter-tab px-4 py-2 rounded-full font-medium transition-all bg-gradient-to-r from-indigo-600 to-purple-700 text-white">
            Semua
        </button>
        <button onclick="filterDiscussions('new', this)" class="filter-tab px-4 py-2 rounded-full font-medium transition-all border-2 border-gray-200 text-gray-600 hover:border-indigo-600">
            Terbaru
        </button>
        <button onclick="filterDiscussions('active', this)" class="filter-tab px-4 py-2 rounded-full font-medium transition-all border-2 border-gray-200 text-gray-600 hover:border-indigo-600">
            Aktif
        </button>
        <button onclick="filterDiscussions('solved', this)" class="filter-tab px-4 py-2 rounded-full font-medium transition-all border-2 border-gray-200 text-gray-600 hover:border-indigo-600">
            Terjawab
        </button>
    </div>

    <!-- Discussions Container -->
    <div id="discussionsContainer" class="space-y-4">
        <!-- Discussions will be rendered here by JavaScript -->
    </div>

    <!-- Modal for New Thread -->
    <div id="newThreadModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Buat Diskusi Baru</h2>
                <button onclick="closeModal()" class="text-gray-600 hover:text-gray-900 text-2xl">✕</button>
            </div>

            <form id="newThreadForm" onsubmit="submitThread(event)" class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Kursus</label>
                    <select id="courseSelect" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-indigo-600 focus:outline-none transition-colors">
                        <option value="">Pilih Kursus</option>
                        <option>💻 Pemrograman Web Lanjut</option>
                        <option>🔢 Struktur Data & Algoritma</option>
                        <option>🎨 Desain Interaksi</option>
                        <option>🤖 Machine Learning Dasar</option>
                        <option>🗄️ Database Management System</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Kategori</label>
                    <select id="categorySelect" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-indigo-600 focus:outline-none transition-colors">
                        <option value="">Pilih Kategori</option>
                        <option>Pertanyaan</option>
                        <option>Diskusi</option>
                        <option>Bug/Error</option>
                        <option>Tools & Resources</option>
                        <option>Konsep</option>
                        <option>Tutorial</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Judul Diskusi</label>
                    <input type="text" id="titleInput" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-indigo-600 focus:outline-none transition-colors" placeholder="Masukkan judul diskusi yang jelas...">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Deskripsi</label>
                    <textarea id="descriptionInput" required rows="6" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-indigo-600 focus:outline-none transition-colors resize-y" placeholder="Jelaskan pertanyaan atau topik diskusi Anda secara detail..."></textarea>
                </div>

                <button type="submit" class="w-full py-3 bg-gradient-to-r from-indigo-600 to-purple-700 text-white rounded-lg font-semibold hover:-translate-y-1 hover:shadow-lg transition-all">
                    Posting Diskusi
                </button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    let discussions = [
        {
            id: 1,
            title: "Cara implementasi authentication JWT di Node.js?",
            course: "💻 Pemrograman Web Lanjut",
            category: "Pertanyaan",
            preview: "Halo teman-teman, saya sedang belajar membuat REST API dengan Express.js. Ada yang bisa bantu jelaskan cara implementasi JWT untuk authentication?",
            author: "Rizki Ananda",
            authorInitials: "RA",
            time: "2 jam yang lalu",
            replies: 5,
            views: 127,
            likes: 12,
            status: "new",
            liked: false,
            comments: []
        },
        {
            id: 2,
            title: "Tips optimasi query database untuk aplikasi besar?",
            course: "🗄️ Database Management",
            category: "Diskusi",
            preview: "Mau sharing dan diskusi tentang best practices untuk optimasi query database. Aplikasi saya mulai lambat ketika data sudah banyak.",
            author: "Dina Sari",
            authorInitials: "DS",
            time: "5 jam yang lalu",
            replies: 18,
            views: 342,
            likes: 28,
            status: "active",
            liked: false,
            comments: []
        },
        {
            id: 3,
            title: "Penjelasan tentang Big O Notation dalam analisis algoritma",
            course: "🔢 Struktur Data & Algoritma",
            category: "Konsep",
            preview: "Bisa minta tolong dijelaskan tentang konsep Big O Notation? Masih bingung cara menentukan kompleksitas waktu suatu algoritma.",
            author: "Budi Hartono",
            authorInitials: "BH",
            time: "1 hari yang lalu",
            replies: 12,
            views: 256,
            likes: 35,
            status: "solved",
            liked: false,
            comments: []
        }
    ];

    function renderDiscussions(filter = 'all') {
        const container = document.getElementById('discussionsContainer');
        let filteredDiscussions = discussions;

        if (filter !== 'all') {
            filteredDiscussions = discussions.filter(d => d.status === filter);
        }

        container.innerHTML = filteredDiscussions.map(d => {
            const statusColors = {
                new: 'bg-blue-100 text-blue-600',
                active: 'bg-orange-100 text-orange-600',
                solved: 'bg-green-100 text-green-600'
            };

            const statusText = {
                new: 'Baru',
                active: 'Aktif',
                solved: 'Terjawab'
            };

            return `
                <div class="bg-white rounded-xl shadow-sm p-6 hover:-translate-y-1 hover:shadow-md transition-all cursor-pointer" data-status="${d.status}">
                    <div class="flex flex-col lg:flex-row justify-between items-start gap-4 mb-4">
                        <div class="flex-1">
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">${d.title}</h3>
                            <div class="flex flex-wrap gap-2 items-center text-sm text-gray-600">
                                <span class="px-3 py-1 bg-indigo-100 text-indigo-600 rounded-full font-semibold text-xs">${d.course}</span>
                                <span class="flex items-center gap-1">
                                    <span>📁</span>
                                    <span>${d.category}</span>
                                </span>
                            </div>
                        </div>
                        <span class="px-3 py-1 ${statusColors[d.status]} rounded-full text-xs font-semibold whitespace-nowrap">
                            ${statusText[d.status]}
                        </span>
                    </div>

                    <p class="text-gray-600 leading-relaxed mb-4">${d.preview}</p>

                    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 pt-4 border-t border-gray-200">
                        <div class="flex gap-6">
                            <button onclick="toggleComments(${d.id}, event)" class="flex items-center gap-2 text-gray-600 hover:text-indigo-600 transition-colors">
                                <span>💬</span>
                                <span class="text-sm">${d.replies} balasan</span>
                            </button>
                            <div class="flex items-center gap-2 text-gray-600">
                                <span>👁️</span>
                                <span class="text-sm">${d.views} views</span>
                            </div>
                            <button onclick="likeDiscussion(${d.id}, event)" class="flex items-center gap-2 text-gray-600 hover:text-red-500 transition-colors">
                                <span class="text-lg ${d.liked ? 'text-red-500' : ''}">👍</span>
                                <span class="text-sm" id="likes-${d.id}">${d.likes} likes</span>
                            </button>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 bg-gradient-to-br from-indigo-600 to-purple-700 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                ${d.authorInitials}
                            </div>
                            <div>
                                <div class="font-semibold text-gray-900 text-sm">${d.author}</div>
                                <div class="text-xs text-gray-500">${d.time}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Comments Section -->
                    <div id="comments-${d.id}" class="hidden mt-6 pt-6 border-t-2 border-gray-200">
                        <div id="comments-list-${d.id}" class="space-y-3 mb-4">
                            ${d.comments.map(c => `
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex items-center gap-3 mb-2">
                                        <div class="w-8 h-8 bg-gradient-to-br from-indigo-600 to-purple-700 rounded-full flex items-center justify-center text-white font-bold text-xs">
                                            ${c.authorInitials}
                                        </div>
                                        <div>
                                            <div class="font-semibold text-gray-900 text-sm">${c.author}</div>
                                            <div class="text-xs text-gray-500">${c.time}</div>
                                        </div>
                                    </div>
                                    <p class="text-gray-700 leading-relaxed">${c.text}</p>
                                </div>
                            `).join('')}
                        </div>
                        <div class="flex gap-2">
                            <input type="text" id="comment-input-${d.id}" placeholder="Tulis komentar..." class="flex-1 px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-indigo-600 focus:outline-none transition-colors">
                            <button onclick="addComment(${d.id})" class="px-6 py-3 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700 transition-colors">
                                Kirim
                            </button>
                        </div>
                    </div>
                </div>
            `;
        }).join('');
    }

    function filterDiscussions(filter, button) {
        // Update active state
        document.querySelectorAll('.filter-tab').forEach(tab => {
            tab.classList.remove('bg-gradient-to-r', 'from-indigo-600', 'to-purple-700', 'text-white');
            tab.classList.add('border-2', 'border-gray-200', 'text-gray-600');
        });
        
        button.classList.remove('border-2', 'border-gray-200', 'text-gray-600');
        button.classList.add('bg-gradient-to-r', 'from-indigo-600', 'to-purple-700', 'text-white');
        
        renderDiscussions(filter);
    }

    function openModal() {
        document.getElementById('newThreadModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('newThreadModal').classList.add('hidden');
        document.getElementById('newThreadForm').reset();
    }

    function submitThread(e) {
        e.preventDefault();
        
        const course = document.getElementById('courseSelect').value;
        const category = document.getElementById('categorySelect').value;
        const title = document.getElementById('titleInput').value;
        const description = document.getElementById('descriptionInput').value;

        const newDiscussion = {
            id: discussions.length + 1,
            title: title,
            course: course,
            category: category,
            preview: description,
            author: "Ahmad Maulana",
            authorInitials: "AM",
            time: "Baru saja",
            replies: 0,
            views: 1,
            likes: 0,
            status: "new",
            liked: false,
            comments: []
        };

        discussions.unshift(newDiscussion);
        renderDiscussions();
        closeModal();
        
        alert('✅ Diskusi berhasil dibuat!');
    }

    function toggleComments(id, event) {
        event.stopPropagation();
        const commentsSection = document.getElementById(`comments-${id}`);
        commentsSection.classList.toggle('hidden');
    }

    function addComment(discussionId) {
        const input = document.getElementById(`comment-input-${discussionId}`);
        const commentText = input.value.trim();

        if (!commentText) {
            alert('Komentar tidak boleh kosong!');
            return;
        }

        const discussion = discussions.find(d => d.id === discussionId);
        if (discussion) {
            const newComment = {
                author: "Ahmad Maulana",
                authorInitials: "AM",
                time: "Baru saja",
                text: commentText
            };

            discussion.comments.push(newComment);
            discussion.replies++;
            
            renderDiscussions();
            
            // Reopen comments section
            setTimeout(() => {
                document.getElementById(`comments-${discussionId}`).classList.remove('hidden');
            }, 100);
        }

        input.value = '';
    }

    function likeDiscussion(id, event) {
        event.stopPropagation();
        const discussion = discussions.find(d => d.id === id);
        
        if (discussion) {
            if (discussion.liked) {
                discussion.likes--;
                discussion.liked = false;
            } else {
                discussion.likes++;
                discussion.liked = true;
            }
            
            renderDiscussions();
        }
    }

    // Initial render
    renderDiscussions();

    // Close modal when clicking outside
    document.getElementById('newThreadModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });
</script>
@endpush