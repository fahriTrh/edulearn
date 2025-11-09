<div>
    @if (session()->has('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <!-- Course Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-900 mb-1">{{ $class->title ?? 'Kelas' }}</h1>
        <p class="text-sm text-gray-600">{{ $class->code ?? '' }} @if($class->description) • {{ Str::limit($class->description, 60) }} @endif</p>
    </div>

    <!-- Tabs Navigation -->
    <div class="bg-white border-b border-gray-200 mb-6">
        <div class="flex gap-8">
            <button wire:click="switchTab('stream')" 
                    class="px-4 py-3 border-b-2 {{ $activeTab === 'stream' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-600 hover:text-gray-900' }} font-medium text-sm transition-colors">
                Stream
            </button>
            <button wire:click="switchTab('classwork')" 
                    class="px-4 py-3 border-b-2 {{ $activeTab === 'classwork' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-600 hover:text-gray-900' }} font-medium text-sm transition-colors">
                Classwork
            </button>
            <button wire:click="switchTab('people')" 
                    class="px-4 py-3 border-b-2 {{ $activeTab === 'people' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-600 hover:text-gray-900' }} font-medium text-sm transition-colors">
                People
            </button>
        </div>
    </div>

    <!-- Stream Tab -->
    @if($activeTab === 'stream')
    <div class="space-y-4">
        <!-- Post Composer -->
        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-semibold">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="flex-1">
                    <input type="text" 
                           wire:click="openPostModal('announcement')"
                           placeholder="Share an announcement with your class..." 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer"
                           readonly>
                </div>
            </div>
            <div class="flex gap-2">
                <button wire:click="openPostModal('announcement')" 
                        class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium">
                    📢 Announcement
                </button>
                <button wire:click="openPostModal('discussion')" 
                        class="flex-1 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium">
                    💬 Discussion
                </button>
            </div>
        </div>

        <!-- Posts List -->
        <div class="space-y-4">
            @forelse($posts as $post)
            <div class="bg-white rounded-lg border border-gray-200 p-4 {{ $post['is_pinned'] ? 'border-blue-300 bg-blue-50' : '' }}">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 {{ $post['type'] === 'announcement' ? 'bg-blue-600' : 'bg-green-600' }} rounded-full flex items-center justify-center text-white font-semibold">
                            {{ $post['user']['initial'] }}
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h4 class="font-semibold text-gray-900">{{ $post['user']['name'] }}</h4>
                                @if($post['is_pinned'])
                                    <span class="px-2 py-0.5 bg-blue-100 text-blue-600 rounded text-xs font-medium">📌 Pinned</span>
                                @endif
                                @if($post['type'] === 'announcement')
                                    <span class="px-2 py-0.5 bg-blue-100 text-blue-600 rounded text-xs font-medium">📢 Announcement</span>
                                @else
                                    <span class="px-2 py-0.5 bg-green-100 text-green-600 rounded text-xs font-medium">💬 Discussion</span>
                                @endif
                            </div>
                            <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($post['created_at'])->diffForHumans() }}</p>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <button wire:click="togglePinPost({{ $post['id'] }})" 
                                class="p-1.5 text-gray-600 hover:bg-gray-100 rounded" 
                                title="{{ $post['is_pinned'] ? 'Unpin' : 'Pin' }}">
                            {{ $post['is_pinned'] ? '📌' : '📍' }}
                        </button>
                        <button wire:click="deletePost({{ $post['id'] }})" 
                                wire:confirm="Hapus post ini?"
                                class="p-1.5 text-red-600 hover:bg-red-50 rounded" 
                                title="Hapus">
                            🗑️
                        </button>
                    </div>
                </div>
                
                @if($post['title'])
                    <h5 class="font-semibold text-gray-900 mb-2">{{ $post['title'] }}</h5>
                @endif
                <p class="text-gray-700 mb-3 whitespace-pre-wrap">{{ $post['content'] }}</p>

                <!-- Replies Section -->
                @if(count($post['replies']) > 0)
                <div class="ml-12 mt-3 space-y-2 border-t border-gray-200 pt-3">
                    @foreach($post['replies'] as $reply)
                    <div class="flex items-start gap-2">
                        <div class="w-8 h-8 bg-gray-400 rounded-full flex items-center justify-center text-white text-xs font-semibold">
                            {{ $reply['user']['initial'] }}
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-sm font-medium text-gray-900">{{ $reply['user']['name'] }}</span>
                                <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($reply['created_at'])->diffForHumans() }}</span>
                            </div>
                            <p class="text-sm text-gray-700">{{ $reply['content'] }}</p>
                        </div>
                        <button wire:click="deleteReply({{ $reply['id'] }})" 
                                wire:confirm="Hapus balasan ini?"
                                class="p-1 text-red-600 hover:bg-red-50 rounded text-xs">
                            🗑️
                        </button>
                    </div>
                    @endforeach
                </div>
                @endif

                <!-- Reply Input -->
                <div class="mt-3 ml-12 flex gap-2">
                    <input type="text" 
                           wire:model="reply_content.{{ $post['id'] }}"
                           wire:keydown.enter="addReply({{ $post['id'] }})"
                           placeholder="Add a comment..." 
                           class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button wire:click="addReply({{ $post['id'] }})" 
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium">
                        Reply
                    </button>
                </div>
            </div>
            @empty
            <div class="bg-white rounded-lg border border-gray-200 p-6 text-center text-gray-500">
                <p>No posts yet. Share something with your class!</p>
            </div>
            @endforelse
        </div>
    </div>
    @endif

    <!-- Classwork Tab -->
    @if($activeTab === 'classwork')
    <div class="space-y-4">
        <!-- Action Buttons -->
        <div class="flex gap-4 mb-4">
            <button wire:click="openMaterialModal" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium">
                + Create Material
            </button>
            <button wire:click="openAssignmentModal" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium">
                + Create Assignment
            </button>
        </div>

        <!-- Materials Section -->
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <h3 class="text-sm font-medium text-gray-700 mb-3">Materials</h3>
            <div class="space-y-2">
                @forelse($materials as $material)
                <div class="flex items-center gap-3 p-3 hover:bg-gray-50 rounded-lg group">
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                        📄
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="text-sm font-medium text-gray-900 truncate">{{ $material['title'] }}</h4>
                        <p class="text-xs text-gray-500">{{ $material['type'] }}</p>
                    </div>
                    <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                        <button wire:click="editMaterial({{ $material['id'] }})" 
                                class="p-1.5 text-gray-600 hover:bg-gray-200 rounded" title="Edit">
                            ✏️
                        </button>
                        <button wire:click="deleteMaterial({{ $material['id'] }})" 
                                wire:confirm="Hapus materi ini?"
                                class="p-1.5 text-red-600 hover:bg-red-50 rounded" title="Hapus">
                            🗑️
                        </button>
                    </div>
                </div>
                @empty
                <p class="text-sm text-gray-500 py-4">No materials yet</p>
                @endforelse
            </div>
        </div>

        <!-- Assignments Section -->
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <h3 class="text-sm font-medium text-gray-700 mb-3">Assignments</h3>
            <div class="space-y-2">
                @forelse($formatted_assignments as $assignment)
                <div class="flex items-center gap-3 p-3 hover:bg-gray-50 rounded-lg group">
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                        📝
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="text-sm font-medium text-gray-900 truncate">{{ $assignment['title'] }}</h4>
                        <p class="text-xs text-gray-500">
                            Due: {{ $assignment['deadline'] }} • 
                            {{ $assignment['submissions'] }}/{{ $assignment['total'] }} turned in
                        </p>
                    </div>
                </div>
                @empty
                <p class="text-sm text-gray-500 py-4">No assignments yet</p>
                @endforelse
            </div>
        </div>
    </div>
    @endif

    <!-- People Tab -->
    @if($activeTab === 'people')
    <div class="space-y-4">
        <!-- Add Student Button -->
        <div class="flex justify-end mb-4">
            <button wire:click="openStudentModal" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium">
                + Add Student
            </button>
        </div>

        <!-- Students List -->
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <h3 class="text-sm font-medium text-gray-700 mb-3">Students</h3>
            <div class="space-y-2">
                @forelse($mahasiswa as $student)
                <div class="flex items-center gap-3 p-3 hover:bg-gray-50 rounded-lg">
                    <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center text-xs font-medium flex-shrink-0">
                        {{ substr($student->name, 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="text-sm font-medium text-gray-900 truncate">{{ $student->name }}</h4>
                        <p class="text-xs text-gray-500 truncate">{{ $student->nim }}</p>
                    </div>
                    <button wire:click="hapusMahasiswaKelas({{ $student->id }})" 
                            wire:confirm="Hapus mahasiswa dari kelas?"
                            class="px-3 py-1 text-red-600 hover:bg-red-50 rounded text-xs">
                        Remove
                    </button>
                </div>
                @empty
                <p class="text-sm text-gray-500 py-4">No students yet</p>
                @endforelse
            </div>
        </div>
    </div>
    @endif

    {{-- Material Modal --}}
    @if($showMaterialModal)
    <div class="fixed top-0 left-0 w-full h-full bg-black/50 z-[1000] flex items-center justify-center p-4">
        <div class="bg-white p-8 rounded-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <h2 class="text-2xl font-semibold mb-6">{{ $editingMaterialId ? 'Edit Materi' : 'Tambah Materi' }}</h2>
            <form wire:submit="saveMaterial">
                <div class="mb-6">
                    <label class="block mb-2 font-semibold">Judul</label>
                    <input type="text" wire:model="material_title" required class="w-full p-3 border-2 border-gray-200 rounded-lg">
                    @error('material_title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="mb-6">
                    <label class="block mb-2 font-semibold">Tipe</label>
                    <select wire:model="material_type" class="w-full p-3 border-2 border-gray-200 rounded-lg">
                        <option value="pdf">PDF</option>
                        <option value="document">Document</option>
                        <option value="link">Link</option>
                        <option value="video">Video</option>
                    </select>
                </div>
                @if(in_array($material_type, ['pdf', 'document']))
                <div class="mb-6">
                    <label class="block mb-2 font-semibold">File</label>
                    <input type="file" wire:model="material_file" class="w-full p-3 border-2 border-gray-200 rounded-lg">
                    @error('material_file') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                @endif
                @if($material_type === 'link')
                <div class="mb-6">
                    <label class="block mb-2 font-semibold">URL</label>
                    <input type="url" wire:model="material_link" class="w-full p-3 border-2 border-gray-200 rounded-lg">
                    @error('material_link') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                @endif
                <div class="mb-6">
                    <label class="block mb-2 font-semibold">Deskripsi</label>
                    <textarea wire:model="material_description" class="w-full p-3 border-2 border-gray-200 rounded-lg"></textarea>
                </div>
                <div class="flex gap-4">
                    <button type="button" wire:click="closeMaterialModal" class="flex-1 p-3 bg-gray-200 text-gray-700 rounded-lg">Batal</button>
                    <button type="submit" class="flex-1 p-3 bg-indigo-600 text-white rounded-lg">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    {{-- Assignment Modal --}}
    @if($showAssignmentModal)
    <div class="fixed top-0 left-0 w-full h-full bg-black/50 z-[1000] flex items-center justify-center p-4">
        <div class="bg-white p-8 rounded-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <h2 class="text-2xl font-semibold mb-6">Tambah Tugas</h2>
            <form wire:submit="saveAssignment">
                <div class="mb-6">
                    <label class="block mb-2 font-semibold">Judul</label>
                    <input type="text" wire:model="assignment_title" required class="w-full p-3 border-2 border-gray-200 rounded-lg">
                </div>
                <div class="mb-6">
                    <label class="block mb-2 font-semibold">Deskripsi</label>
                    <textarea wire:model="assignment_description" required class="w-full p-3 border-2 border-gray-200 rounded-lg"></textarea>
                </div>
                <div class="mb-6">
                    <label class="block mb-2 font-semibold">Deadline</label>
                    <input type="datetime-local" wire:model="assignment_deadline" required class="w-full p-3 border-2 border-gray-200 rounded-lg">
                </div>
                <div class="mb-6">
                    <label class="block mb-2 font-semibold">Bobot (%)</label>
                    <input type="number" wire:model="assignment_weight" min="0" max="100" required class="w-full p-3 border-2 border-gray-200 rounded-lg">
                </div>
                <div class="flex gap-4">
                    <button type="button" wire:click="closeAssignmentModal" class="flex-1 p-3 bg-gray-200 text-gray-700 rounded-lg">Batal</button>
                    <button type="submit" class="flex-1 p-3 bg-green-600 text-white rounded-lg">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    {{-- Student Modal --}}
    @if($showStudentModal)
    <div class="fixed top-0 left-0 w-full h-full bg-black/50 z-[1000] flex items-center justify-center p-4">
        <div class="bg-white p-8 rounded-xl max-w-md w-full">
            <h2 class="text-2xl font-semibold mb-6">Tambah Mahasiswa</h2>
            <form wire:submit="tambahMahasiswaKelas">
                <div class="mb-6">
                    <label class="block mb-2 font-semibold">NIM atau Email</label>
                    <input type="text" wire:model="student_identifier" required class="w-full p-3 border-2 border-gray-200 rounded-lg" placeholder="Masukkan NIM atau Email">
                </div>
                <div class="flex gap-4">
                    <button type="button" wire:click="closeStudentModal" class="flex-1 p-3 bg-gray-200 text-gray-700 rounded-lg">Batal</button>
                    <button type="submit" class="flex-1 p-3 bg-purple-600 text-white rounded-lg">Tambah</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    {{-- Post Modal --}}
    @if($showPostModal)
    <div class="fixed top-0 left-0 w-full h-full bg-black/50 z-[1000] flex items-center justify-center p-4" wire:click="closePostModal">
        <div class="bg-white p-8 rounded-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto" wire:click.stop>
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold">{{ $post_type === 'announcement' ? 'Create Announcement' : 'Create Discussion' }}</h2>
                <button wire:click="closePostModal" class="text-2xl text-gray-500 hover:text-gray-800">✕</button>
            </div>
            <form wire:submit.prevent="createPost">
                @if($post_type === 'discussion')
                <div class="mb-6">
                    <label class="block mb-2 font-semibold">Title</label>
                    <input type="text" wire:model="post_title" required class="w-full p-3 border-2 border-gray-200 rounded-lg">
                    @error('post_title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                @endif
                <div class="mb-6">
                    <label class="block mb-2 font-semibold">Content</label>
                    <textarea wire:model="post_content" rows="6" required class="w-full p-3 border-2 border-gray-200 rounded-lg"></textarea>
                    @error('post_content') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="flex gap-3">
                    <button type="button" wire:click="closePostModal" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg font-semibold hover:bg-gray-200">
                        Cancel
                    </button>
                    <button type="submit" class="flex-1 px-6 py-3 bg-gradient-to-r from-purple-600 to-purple-800 text-white rounded-lg font-semibold">
                        Post
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>

