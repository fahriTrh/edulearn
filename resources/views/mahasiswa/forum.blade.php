<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diskusi - EduLearn</title>
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
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .search-bar {
            display: flex;
            align-items: center;
            background: #f5f7fa;
            padding: 0.7rem 1.2rem;
            border-radius: 25px;
            flex: 1;
            max-width: 400px;
        }

        .search-bar input {
            border: none;
            background: none;
            outline: none;
            width: 100%;
            margin-left: 0.5rem;
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

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .page-header h1 {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .page-header p {
            color: #666;
        }

        .new-thread-btn {
            padding: 0.8rem 1.5rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .new-thread-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .filter-section {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .filter-tab {
            padding: 0.6rem 1.2rem;
            border: 2px solid #e8ebf0;
            background: white;
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 500;
            color: #666;
        }

        .filter-tab.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-color: transparent;
        }

        .discussions-container {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .discussion-card {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: all 0.3s;
            cursor: pointer;
        }

        .discussion-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }

        .discussion-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .discussion-info {
            flex: 1;
        }

        .discussion-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .discussion-meta {
            display: flex;
            gap: 1rem;
            align-items: center;
            color: #666;
            font-size: 0.85rem;
            flex-wrap: wrap;
        }

        .course-tag {
            display: inline-block;
            padding: 0.3rem 0.8rem;
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
            border-radius: 15px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .discussion-preview {
            color: #666;
            line-height: 1.6;
            margin-bottom: 1rem;
        }

        .discussion-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 1rem;
            border-top: 1px solid #e8ebf0;
        }

        .discussion-stats {
            display: flex;
            gap: 1.5rem;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #666;
            font-size: 0.9rem;
        }

        .author-info {
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .author-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 0.85rem;
        }

        .author-name {
            font-weight: 600;
            color: #333;
            font-size: 0.9rem;
        }

        .author-time {
            color: #666;
            font-size: 0.75rem;
        }

        .status-badge {
            padding: 0.3rem 0.8rem;
            border-radius: 15px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-solved {
            background: rgba(46, 213, 115, 0.1);
            color: #2ed573;
        }

        .badge-active {
            background: rgba(255, 165, 2, 0.1);
            color: #ffa502;
        }

        .badge-new {
            background: rgba(79, 172, 254, 0.1);
            color: #4facfe;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
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

        .modal-header h2 {
            color: #333;
        }

        .close-modal {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #666;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #333;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 0.8rem;
            border: 2px solid #e8ebf0;
            border-radius: 8px;
            font-family: inherit;
            transition: border-color 0.3s;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: #667eea;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 150px;
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

        .comments-section {
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 2px solid #e8ebf0;
            display: none;
        }

        .comments-section.active {
            display: block;
        }

        .comment {
            padding: 1rem;
            background: #f5f7fa;
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .comment-header {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            margin-bottom: 0.5rem;
        }

        .comment-text {
            color: #333;
            line-height: 1.6;
        }

        .comment-form {
            display: flex;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .comment-input {
            flex: 1;
            padding: 0.8rem;
            border: 2px solid #e8ebf0;
            border-radius: 8px;
            outline: none;
        }

        .comment-input:focus {
            border-color: #667eea;
        }

        .comment-btn {
            padding: 0.8rem 1.5rem;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
        }

        .like-btn {
            cursor: pointer;
            transition: all 0.3s;
        }

        .like-btn:hover {
            transform: scale(1.2);
        }

        .like-btn.liked {
            color: #ff4757;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 0;
                padding: 0;
                transform: translateX(-100%);
            }

            .main-content {
                margin-left: 0;
                padding: 1rem;
            }

            .top-bar {
                flex-direction: column;
                gap: 1rem;
            }

            .search-bar {
                max-width: 100%;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .discussion-header {
                flex-direction: column;
                gap: 0.5rem;
            }

            .discussion-footer {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .new-thread-btn {
                width: 100%;
                justify-content: center;
            }

            .comment-form {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <aside class="sidebar">
            <div class="logo-section">EduLearn</div>
            <div style="padding: 2rem 0;">
                <div class="menu-item"><span>📊</span> Dashboard</div>
                <div class="menu-item"><span>📚</span> Kursus Saya</div>
                <div class="menu-item"><span>📅</span> Jadwal</div>
                <div class="menu-item"><span>✍️</span> Tugas</div>
                <div class="menu-item"><span>📈</span> Nilai</div>
                <div class="menu-item active"><span>💬</span> Diskusi</div>
                <div class="menu-item"><span>🏆</span> Sertifikat</div>
                <div class="menu-item"><span>⚙️</span> Pengaturan</div>
            </div>
        </aside>

        <main class="main-content">
            <div class="top-bar">
                <div class="search-bar">
                    <span>🔍</span>
                    <input type="text" placeholder="Cari diskusi..." id="searchInput">
                </div>
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div style="width: 40px; height: 40px; background: #f5f7fa; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer;">🔔</div>
                    <div class="user-avatar">AM</div>
                    <div>
                        <div style="font-weight: 600;">Ahmad Maulana</div>
                        <div style="font-size: 0.85rem; color: #666;">Mahasiswa</div>
                    </div>
                </div>
            </div>

            <div class="page-header">
                <div>
                    <h1>Forum Diskusi</h1>
                    <p>Diskusikan materi, tanyakan pertanyaan, dan berbagi pengetahuan</p>
                </div>
                <button class="new-thread-btn" onclick="openNewThreadModal()">
                    <span>➕</span>
                    <span>Buat Diskusi Baru</span>
                </button>
            </div>

            <div class="filter-section">
                <button class="filter-tab active" onclick="filterDiscussions('all', this)">Semua</button>
                <button class="filter-tab" onclick="filterDiscussions('new', this)">Terbaru</button>
                <button class="filter-tab" onclick="filterDiscussions('active', this)">Aktif</button>
                <button class="filter-tab" onclick="filterDiscussions('solved', this)">Terjawab</button>
            </div>

            <div class="discussions-container" id="discussionsContainer">
                <!-- Discussions will be rendered here -->
            </div>
        </main>
    </div>

    <div class="modal" id="newThreadModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Buat Diskusi Baru</h2>
                <button class="close-modal" onclick="closeNewThreadModal()">✕</button>
            </div>
            <form id="newThreadForm" onsubmit="submitThread(event)">
                <div class="form-group">
                    <label>Kursus</label>
                    <select id="courseSelect" required>
                        <option value="">Pilih Kursus</option>
                        <option>💻 Pemrograman Web Lanjut</option>
                        <option>🔢 Struktur Data & Algoritma</option>
                        <option>🎨 Desain Interaksi</option>
                        <option>🤖 Machine Learning Dasar</option>
                        <option>🗄️ Database Management System</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Kategori</label>
                    <select id="categorySelect" required>
                        <option value="">Pilih Kategori</option>
                        <option>Pertanyaan</option>
                        <option>Diskusi</option>
                        <option>Bug/Error</option>
                        <option>Tools & Resources</option>
                        <option>Konsep</option>
                        <option>Tutorial</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Judul Diskusi</label>
                    <input type="text" id="titleInput" placeholder="Masukkan judul diskusi yang jelas..." required>
                </div>
                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea id="descriptionInput" placeholder="Jelaskan pertanyaan atau topik diskusi Anda secara detail..." required></textarea>
                </div>
                <button type="submit" class="submit-btn">Posting Diskusi</button>
            </form>
        </div>
    </div>

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
                comments: []
            }
        ];

        function renderDiscussions(filter = 'all') {
            const container = document.getElementById('discussionsContainer');
            let filteredDiscussions = discussions;

            if (filter !== 'all') {
                filteredDiscussions = discussions.filter(d => d.status === filter);
            }

            container.innerHTML = filteredDiscussions.map(d => `
                <div class="discussion-card" data-status="${d.status}">
                    <div class="discussion-header">
                        <div class="discussion-info">
                            <div class="discussion-title">${d.title}</div>
                            <div class="discussion-meta">
                                <span class="course-tag">${d.course}</span>
                                <div style="display: flex; align-items: center; gap: 0.3rem;">
                                    <span>📁</span>
                                    <span>${d.category}</span>
                                </div>
                            </div>
                        </div>
                        <span class="status-badge badge-${d.status}">${d.status === 'new' ? 'Baru' : d.status === 'active' ? 'Aktif' : 'Terjawab'}</span>
                    </div>
                    <p class="discussion-preview">${d.preview}</p>
                    <div class="discussion-footer">
                        <div class="discussion-stats">
                            <div class="stat-item" onclick="toggleComments(${d.id})">
                                <span>💬</span>
                                <span>${d.replies} balasan</span>
                            </div>
                            <div class="stat-item">
                                <span>👁️</span>
                                <span>${d.views} views</span>
                            </div>
                            <div class="stat-item">
                                <span class="like-btn" onclick="likeDiscussion(${d.id}, event)">👍</span>
                                <span id="likes-${d.id}">${d.likes} likes</span>
                            </div>
                        </div>
                        <div class="author-info">
                            <div class="author-avatar">${d.authorInitials}</div>
                            <div>
                                <div class="author-name">${d.author}</div>
                                <div class="author-time">${d.time}</div>
                            </div>
                        </div>
                    </div>
                    <div class="comments-section" id="comments-${d.id}">
                        <div id="comments-list-${d.id}">
                            ${d.comments.map(c => `
                                <div class="comment">
                                    <div class="comment-header">
                                        <div class="author-avatar">${c.authorInitials}</div>
                                        <div>
                                            <div class="author-name">${c.author}</div>
                                            <div class="author-time">${c.time}</div>
                                        </div>
                                    </div>
                                    <div class="comment-text">${c.text}</div>
                                </div>
                            `).join('')}
                        </div>
                        <div class="comment-form">
                            <input type="text" class="comment-input" id="comment-input-${d.id}" placeholder="Tulis komentar...">
                            <button class="comment-btn" onclick="addComment(${d.id})">Kirim</button>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        function filterDiscussions(filter, button) {
            document.querySelectorAll('.filter-tab').forEach(tab => tab.classList.remove('active'));
            button.classList.add('active');
            renderDiscussions(filter);
        }

        function openNewThreadModal() {
            document.getElementById('newThreadModal').classList.add('active');
        }

        function closeNewThreadModal() {
            document.getElementById('newThreadModal').classList.remove('active');
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
                comments: []
            };

            discussions.unshift(newDiscussion);
            renderDiscussions();
            closeNewThreadModal();
            
            alert('✅ Diskusi berhasil dibuat!');
        }

        function toggleComments(id) {
            const commentsSection = document.getElementById(`comments-${id}`);
            commentsSection.classList.toggle('active');
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
                toggleComments(discussionId);
                
                setTimeout(() => toggleComments(discussionId), 100);
            }

            input.value = '';
        }

        function likeDiscussion(id, event) {
            event.stopPropagation();
            const discussion = discussions.find(d => d.id === id);
            const likeBtn = event.target;
            
            if (discussion) {
                if (likeBtn.classList.contains('liked')) {
                    discussion.likes--;
                    likeBtn.classList.remove('liked');
                } else {
                    discussion.likes++;
                    likeBtn.classList.add('liked');
                }
                
                document.getElementById(`likes-${id}`).textContent = `${discussion.likes} likes`;
            }
        }

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const cards = document.querySelectorAll('.discussion-card');
            
            cards.forEach(card => {
                const title = card.querySelector('.discussion-title').textContent.toLowerCase();
                const preview = card.querySelector('.discussion-preview').textContent.toLowerCase();
                
                if (title.includes(searchTerm) || preview.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });

        // Initial render
        renderDiscussions();
    </script>
</body>
</html>