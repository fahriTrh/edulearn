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
            @if(!$this->isAdmin)
            <div class="flex gap-2">
                <button wire:click="openPostModal('announcement')" 
                        class="flex-1 flex items-center justify-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium">
                    <x-heroicon-s-megaphone class="w-5 h-5" />
                    Announcement
                </button>
                <button wire:click="openPostModal('discussion')" 
                        class="flex-1 flex items-center justify-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium">
                    <x-heroicon-s-chat-bubble-left-right class="w-5 h-5" />
                    Discussion
                </button>
            </div>
            @endif
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
                                    <span class="flex items-center gap-1 px-2 py-0.5 bg-blue-100 text-blue-600 rounded text-xs font-medium">
                                        <x-heroicon-s-map-pin class="w-3 h-3" />
                                        Pinned
                                    </span>
                                @endif
                                @if($post['type'] === 'announcement')
                                    <span class="flex items-center gap-1 px-2 py-0.5 bg-blue-100 text-blue-600 rounded text-xs font-medium">
                                        <x-heroicon-s-megaphone class="w-3 h-3" />
                                        Announcement
                                    </span>
                                @else
                                    <span class="flex items-center gap-1 px-2 py-0.5 bg-green-100 text-green-600 rounded text-xs font-medium">
                                        <x-heroicon-s-chat-bubble-left-right class="w-3 h-3" />
                                        Discussion
                                    </span>
                                @endif
                            </div>
                            <span class="text-xs text-gray-500">{{ $post['created_at_human'] }}</span>
                        </div>
                    </div>
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="text-gray-400 hover:text-gray-600">
                            <x-heroicon-m-ellipsis-vertical class="w-5 h-5" />
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10 border border-gray-100">
                            <button wire:click="togglePinPost({{ $post['id'] }})" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                {{ $post['is_pinned'] ? 'Unpin' : 'Pin' }} Post
                            </button>
                            <button wire:click="deletePost({{ $post['id'] }})" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                Delete Post
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="mb-4 text-gray-800 whitespace-pre-wrap">{{ $post['content'] }}</div>

                <!-- Reaction & Reply Action -->
                <div class="flex items-center gap-4 text-sm text-gray-500 border-t border-gray-100 pt-3">
                    <button wire:click="addReply({{ $post['id'] }})" class="flex items-center gap-1 hover:text-blue-600">
                        <x-heroicon-o-chat-bubble-left class="w-4 h-4" />
                        {{ count($post['replies']) }} Replies
                    </button>
                </div>
                
                <!-- Replies Section -->
                @if(count($post['replies']) > 0)
                <div class="mt-4 pl-4 border-l-2 border-gray-100 space-y-3">
                    @foreach($post['replies'] as $reply)
                    <div class="flex gap-3">
                        <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center text-xs font-semibold">
                            {{ $reply['user']['initial'] }}
                        </div>
                        <div class="flex-1 bg-gray-50 p-3 rounded-lg">
                            <div class="flex justify-between items-start mb-1">
                                <span class="font-semibold text-sm">{{ $reply['user']['name'] }}</span>
                                <div class="flex items-center gap-2">
                                    <span class="text-xs text-gray-500">{{ $reply['created_at_human'] }}</span>
                                    <button wire:click="deleteReply({{ $reply['id'] }})" class="text-gray-400 hover:text-red-500">
                                        <x-heroicon-s-x-mark class="w-3 h-3" />
                                    </button>
                                </div>
                            </div>
                            <p class="text-sm text-gray-700">{{ $reply['content'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
                
                <!-- Reply Input -->
                @if(isset($reply_content[$post['id']])) 
                <div class="mt-3 flex gap-3">
                    <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center text-xs font-semibold">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="flex-1">
                        <form wire:submit.prevent="addReply({{ $post['id'] }})">
                            <input type="text" 
                                   wire:model="reply_content.{{ $post['id'] }}"
                                   class="w-full px-3 py-2 text-sm bg-gray-50 border border-gray-200 rounded-full focus:outline-none focus:ring-1 focus:ring-blue-500"
                                   placeholder="Write a reply...">
                        </form>
                    </div>
                </div>
                @endif
            </div>
            @empty
            <div class="text-center py-12 bg-white border border-gray-200 rounded-lg border-dashed">
                <x-heroicon-o-chat-bubble-bottom-center-text class="w-12 h-12 text-gray-400 mx-auto mb-3" />
                <h3 class="text-lg font-medium text-gray-900">No posts yet</h3>
                <p class="text-gray-500">Start the conversation by creating a new post.</p>
            </div>
            @endforelse
        </div>
    </div>
    @endif

    <!-- Classwork Tab -->
    @if($activeTab === 'classwork')
    <div class="space-y-8">
        <!-- Materials Section -->
        <div>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Materials</h2>
                <button wire:click="openMaterialModal" class="flex items-center gap-2 px-3 py-2 bg-indigo-600 text-white rounded-lg text-sm hover:bg-indigo-700">
                    <x-heroicon-s-plus class="w-4 h-4" /> Add Material
                </button>
            </div>
            <div class="bg-white rounded-lg border border-gray-200 divide-y divide-gray-100">
                @forelse($class->materials as $material)
                <div class="p-4 flex items-start gap-4 hover:bg-gray-50 transition-colors group">
                    <div class="p-2 bg-indigo-100 text-indigo-600 rounded-lg">
                        @if($material->type === 'link')
                            <x-heroicon-s-link class="w-6 h-6" />
                        @elseif($material->type === 'video')
                            <x-heroicon-s-video-camera class="w-6 h-6" />
                        @else
                            <x-heroicon-s-document-text class="w-6 h-6" />
                        @endif
                    </div>
                    <div class="flex-1">
                        <h3 class="font-medium text-gray-900">{{ $material->title }}</h3>
                        <p class="text-sm text-gray-500 mb-2">{{ Str::limit($material->description, 150) }}</p>
                        @if($material->link)
                            <a href="{{ $material->link }}" target="_blank" class="text-indigo-600 hover:underline text-sm inline-flex items-center gap-1">
                                Open Link <x-heroicon-s-arrow-top-right-on-square class="w-3 h-3" />
                            </a>
                        @endif
                        @if($material->file_path)
                            <a href="{{ Storage::url($material->file_path) }}" target="_blank" class="text-indigo-600 hover:underline text-sm inline-flex items-center gap-1">
                                Download File <x-heroicon-s-arrow-down-tray class="w-3 h-3" />
                            </a>
                        @endif
                    </div>
                    <div class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                        <button wire:click="editMaterial({{ $material->id }})" class="p-1 text-gray-400 hover:text-blue-600">
                            <x-heroicon-s-pencil-square class="w-4 h-4" />
                        </button>
                        <button wire:click="deleteMaterial({{ $material->id }})" wire:confirm="Are you sure?" class="p-1 text-gray-400 hover:text-red-600">
                            <x-heroicon-s-trash class="w-4 h-4" />
                        </button>
                    </div>
                </div>
                @empty
                <div class="p-8 text-center text-gray-500">
                    No materials uploaded yet.
                </div>
                @endforelse
            </div>
        </div>

        <!-- Assignments Section -->
        <div>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Assignments</h2>
                <button wire:click="$set('showAssignmentModal', true)" class="flex items-center gap-2 px-3 py-2 bg-green-600 text-white rounded-lg text-sm hover:bg-green-700">
                    <x-heroicon-s-plus class="w-4 h-4" /> Add Assignment
                </button>
            </div>
            <div class="bg-white rounded-lg border border-gray-200 divide-y divide-gray-100">
                @forelse($class->assignments as $assignment)
                <div class="p-4 hover:bg-gray-50 transition-colors" x-data="{ expanded: false }">
                    <div class="flex items-start gap-4 cursor-pointer" @click="expanded = !expanded">
                        <div class="p-2 bg-green-100 text-green-600 rounded-lg">
                            <x-heroicon-s-clipboard-document-list class="w-6 h-6" />
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                <h3 class="font-medium text-gray-900">{{ $assignment->title }}</h3>
                                <span class="text-xs font-medium px-2 py-1 bg-gray-100 rounded text-gray-600">
                                    Due: {{ \Carbon\Carbon::parse($assignment->deadline)->format('d M Y, H:i') }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-500 mt-1">{{ Str::limit($assignment->description, 100) }}</p>
                        </div>
                        <div>
                            <x-heroicon-s-chevron-down class="w-5 h-5 text-gray-400 transition-transform" ::class="expanded ? 'rotate-180' : ''" />
                        </div>
                    </div>
                    
                    <!-- Expanded Details (Submissions) -->
                    <div x-show="expanded" x-collapse class="mt-4 pl-14 border-t border-gray-100 pt-4">
                         <div class="flex justify-between items-center mb-4">
                             <h4 class="text-sm font-semibold text-gray-700">Submissions ({{ $assignment->submissions->count() }})</h4>
                             <div class="flex gap-2">
                                <button class="text-xs text-blue-600 hover:underline">Edit Assignment</button>
                             </div>
                         </div>
                         
                         @if($assignment->submissions->count() > 0)
                         <div class="overflow-x-auto">
                             <table class="w-full text-sm text-left">
                                 <thead class="text-xs text-gray-500 uppercase bg-gray-50">
                                     <tr>
                                         <th class="px-4 py-2">Student</th>
                                         <th class="px-4 py-2">Date</th>
                                         <th class="px-4 py-2">File/Link</th>
                                         <th class="px-4 py-2">Grade</th>
                                         <th class="px-4 py-2">Action</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     @foreach($assignment->submissions as $submission)
                                     <tr class="border-b">
                                         <td class="px-4 py-2 font-medium">{{ $submission->user->name }}</td>
                                         <td class="px-4 py-2">{{ \Carbon\Carbon::parse($submission->submitted_at)->format('d/m H:i') }}</td>
                                         <td class="px-4 py-2">
                                             @if($submission->file_path)
                                                 <a href="{{ Storage::url($submission->file_path) }}" target="_blank" class="text-blue-600 hover:underline">Download</a>
                                             @elseif($submission->submission_link)
                                                 <a href="{{ $submission->submission_link }}" target="_blank" class="text-blue-600 hover:underline">Link</a>
                                             @endif
                                         </td>
                                         <td class="px-4 py-2">
                                             <span class="font-bold {{ $submission->score ? 'text-green-600' : 'text-gray-400' }}">
                                                 {{ $submission->score ?? '-' }}
                                             </span>
                                         </td>
                                         <td class="px-4 py-2">
                                             <div class="flex items-center gap-2">
                                                 <input type="number" 
                                                        class="w-16 px-2 py-1 text-xs border rounded" 
                                                        placeholder="0-100"
                                                        wire:blur="updateNilaiTugas({{ $submission->id }}, $event.target.value)"
                                                        value="{{ $submission->score }}">
                                             </div>
                                         </td>
                                     </tr>
                                     @endforeach
                                 </tbody>
                             </table>
                         </div>
                         @else
                             <p class="text-sm text-gray-500 italic">No submissions yet.</p>
                         @endif
                    </div>
                </div>
                @empty
                <div class="p-8 text-center text-gray-500">
                    No assignments created yet.
                </div>
                @endforelse
            </div>
        </div>
    </div>
    @endif

    <!-- People Tab -->
    @if($activeTab === 'people')
    <div class="bg-white rounded-lg border border-gray-200">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">Students</h2>
            <button wire:click="$set('showStudentModal', true)" class="flex items-center gap-2 px-3 py-2 bg-purple-600 text-white rounded-lg text-sm hover:bg-purple-700">
                <x-heroicon-s-user-plus class="w-4 h-4" /> Add Student
            </button>
        </div>
        <div class="divide-y divide-gray-100">
            @forelse($class->students as $student)
            <div class="p-4 flex items-center justify-between hover:bg-gray-50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center font-bold">
                        {{ substr($student->name, 0, 1) }}
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-900">{{ $student->name }}</h3>
                        <p class="text-xs text-gray-500">{{ $student->email }}</p>
                    </div>
                </div>
                <button wire:click="hapusMahasiswaKelas({{ $student->id }})" wire:confirm="Remove this student?" class="text-red-500 hover:bg-red-50 p-2 rounded-lg text-sm font-medium">
                    Remove
                </button>
            </div>
            @empty
            <div class="p-12 text-center text-gray-500">
                No students joined yet.
            </div>
            @endforelse
        </div>
    </div>
    @endif

    {{-- Material Modal --}}
    @if($showMaterialModal)
    <div class="fixed top-0 left-0 w-full h-full bg-black/50 z-1000 flex items-center justify-center p-4">
        <div class="bg-white p-8 rounded-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <h2 class="text-2xl font-semibold mb-6">Materi Pembelajaran</h2>
            <form wire:submit="saveMaterial">
                <div class="mb-6">
                    <label class="block mb-2 font-semibold">Judul</label>
                    <input type="text" wire:model="material_title" required class="w-full p-3 border-2 border-gray-200 rounded-lg">
                    @error('material_title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="mb-6">
                    <label class="block mb-2 font-semibold">Tipe</label>
                    <select wire:model.live="material_type" class="w-full p-3 border-2 border-gray-200 rounded-lg">
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
    <div class="fixed top-0 left-0 w-full h-full bg-black/50 z-1000 flex items-center justify-center p-4">
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
    <div class="fixed top-0 left-0 w-full h-full bg-black/50 z-1000 flex items-center justify-center p-4">
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
    <div class="fixed top-0 left-0 w-full h-full bg-black/50 z-1000 flex items-center justify-center p-4" wire:click="closePostModal">
        <div class="bg-white p-8 rounded-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto" wire:click.stop>
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold">{{ $post_type === 'announcement' ? 'Create Announcement' : 'Create Discussion' }}</h2>
                <button wire:click="closePostModal" class="text-gray-500 hover:text-gray-800">
                    <x-heroicon-s-x-mark class="w-6 h-6" />
                </button>
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
                    <button type="submit" class="flex-1 px-6 py-3 bg-linear-to-r from-purple-600 to-purple-800 text-white rounded-lg font-semibold">
                        Post
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
