<div class="min-h-screen bg-white -mx-4 lg:-mx-8 -mt-4 lg:-mt-8" x-data="{ 
    activeTab: 'stream', 
    postModal: false, 
    materialModal: false,
    assignmentModal: false,
    studentModal: false,
    replyModal: false,
    
    init() {
        Livewire.on('close-post-modal', () => { this.postModal = false });
        Livewire.on('close-material-modal', () => { this.materialModal = false });
        Livewire.on('close-assignment-modal', () => { this.assignmentModal = false });
        Livewire.on('close-student-modal', () => { this.studentModal = false });
        Livewire.on('close-reply-modal', () => { this.replyModal = false });

        Livewire.on('open-post-modal', () => { this.postModal = true });
        
        // Listen for open events if triggered from backend, though mostly client-side now
        Livewire.on('open-material-modal', () => { this.materialModal = true });
        Livewire.on('open-assignment-modal', () => { this.assignmentModal = true });
    }
}">
    <!-- Global Notifications -->
    @if (session()->has('success'))
        <div class="fixed top-4 right-4 z-50 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg shadow-lg" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)">
            {{ session('success') }}
        </div>
    @endif
    
    @if (session()->has('error'))
        <div class="fixed top-4 right-4 z-50 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg shadow-lg" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)">
            {{ session('error') }}
        </div>
    @endif

    <!-- Top Navigation Tabs -->
    <div class="sticky top-[72px] z-30 bg-white border-b border-gray-200 shadow-sm w-full">
        <div class="w-full px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-start space-x-8 h-12">
                <button 
                    @click="activeTab = 'stream'" 
                    :class="{ 'border-b-4 border-indigo-600 text-indigo-600': activeTab === 'stream', 'border-transparent text-gray-500 hover:text-gray-700': activeTab !== 'stream' }"
                    class="h-full px-4 text-sm font-medium transition-colors duration-200"
                >
                    Forum
                </button>
                <button 
                    @click="activeTab = 'classwork'" 
                    :class="{ 'border-b-4 border-indigo-600 text-indigo-600': activeTab === 'classwork', 'border-transparent text-gray-500 hover:text-gray-700': activeTab !== 'classwork' }"
                    class="h-full px-4 text-sm font-medium transition-colors duration-200"
                >
                    Tugas Kelas
                </button>
                <button 
                    @click="activeTab = 'people'" 
                    :class="{ 'border-b-4 border-indigo-600 text-indigo-600': activeTab === 'people', 'border-transparent text-gray-500 hover:text-gray-700': activeTab !== 'people' }"
                    class="h-full px-4 text-sm font-medium transition-colors duration-200"
                >
                    Orang
                </button>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        
        <!-- STREAM TAB -->
        <div x-show="activeTab === 'stream'" x-transition.opacity.duration.200ms>
            <!-- Hero Banner -->
            <div class="relative w-full h-48 md:h-60 rounded-xl overflow-hidden mb-6 bg-linear-to-r from-indigo-500 to-purple-600 shadow-md">
                @if($class->cover_image)
                    <img src="{{ asset($class->cover_image) }}" class="w-full h-full object-cover opacity-50">
                @else
                    <div class="absolute inset-0 bg-pattern opacity-10"></div>
                @endif
                <div class="absolute bottom-0 left-0 p-6 text-white text-shadow">
                    <h1 class="text-3xl md:text-4xl font-bold mb-1">{{ $class->title }}</h1>
                    <p class="text-lg opacity-90">{{ $class->description }}</p>
                    <div class="mt-2 text-sm font-mono bg-black/20 inline-block px-3 py-1 rounded-md backdrop-blur-sm">
                        Kode Pendaftaran: {{ $class->enrollment_password }}
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                <!-- Sidebar (Upcoming) -->
                <div class="hidden lg:block lg:col-span-1 space-y-4">
                    <!-- Instructor Actions Sidebar -->
                    <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                        <h3 class="font-medium text-gray-700 mb-2">Kode Pendaftaran</h3>
                        <div class="flex items-center gap-2 bg-gray-50 p-2 rounded border border-gray-100">
                            <code class="text-lg font-bold text-indigo-600 flex-1">{{ $class->enrollment_password }}</code>
                            <button class="text-gray-400 hover:text-gray-600" onclick="navigator.clipboard.writeText('{{ $class->enrollment_password }}'); alert('Kode salin!')">
                                <x-heroicon-m-clipboard class="w-5 h-5" />
                            </button>
                        </div>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                        <h3 class="font-medium text-gray-700 mb-4">Mendatang</h3>
                        @if(collect($upcomingAssignments)->count() > 0)
                            <div class="space-y-3">
                                @foreach($upcomingAssignments as $assignment)
                                    <div class="text-sm">
                                        <div class="text-gray-500 text-xs mb-1">
                                            {{ $assignment['days_left'] == 0 ? 'Hari ini' : ($assignment['days_left'] == 1 ? 'Besok' : $assignment['deadline_date']) }}
                                        </div>
                                        <div class="text-gray-800 font-medium flex items-center gap-2">
                                            <x-heroicon-o-clipboard-document-list class="w-4 h-4 text-gray-400 shrink-0" />
                                            <span class="truncate">{{ $assignment['title'] }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-xs text-gray-500">Tidak ada tugas yang perlu segera diselesaikan</p>
                        @endif
                    </div>
                </div>

                <!-- Feed -->
                <div class="col-span-1 lg:col-span-3 space-y-4">
                    <!-- Instructor Composer (Student Style) -->
                     <div 
                        @click="postModal = true; $wire.set('post_type', 'announcement')"
                        class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm flex items-center gap-4 cursor-pointer hover:bg-gray-50 transition-colors"
                    >
                        <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold shrink-0">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div class="flex-1 text-gray-500 text-sm font-medium truncate">
                            Umumkan sesuatu ke kelas Anda...
                        </div>
                        <div class="p-2 rounded-full hover:bg-gray-200 text-gray-500">
                             <x-heroicon-o-arrow-path class="w-5 h-5" />
                        </div>
                    </div>

                    <!-- Posts List -->
                    @forelse($posts as $post)
                        <div class="bg-white rounded-lg border border-gray-200 p-6 shadow-sm hover:shadow-md transition-shadow duration-200 group">
                            <!-- Header -->
                            <div class="flex items-start justify-between mb-2">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 {{ $post['type'] === 'announcement' ? 'bg-indigo-600' : 'bg-emerald-600' }} rounded-full flex items-center justify-center text-white font-bold shadow-sm">
                                        {{ $post['user']['initial'] }}
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <h4 class="font-semibold text-gray-900">{{ $post['user']['name'] }}</h4>
                                            <span class="text-[10px] uppercase font-bold tracking-wider px-2 py-0.5 rounded-full {{ $post['type'] === 'announcement' ? 'bg-indigo-100 text-indigo-700' : 'bg-emerald-100 text-emerald-700' }}">
                                                {{ $post['type'] === 'announcement' ? 'Pengumuman' : 'Diskusi' }}
                                            </span>
                                            @if($post['is_pinned'])
                                                <x-heroicon-s-map-pin class="w-3 h-3 text-gray-400" />
                                            @endif
                                        </div>
                                        <div class="flex items-center text-xs text-gray-500 gap-2 mt-0.5">
                                            <span>{{ $post['created_at_human'] }}</span>
                                             <!-- Dropdown Action for Instructor -->
                                             <div x-data="{ open: false }" class="relative ml-2">
                                                <button @click="open = !open" @click.away="open = false" class="p-1 hover:bg-gray-100 rounded-full transition-colors text-gray-400 hover:text-gray-600">
                                                    <x-heroicon-m-ellipsis-vertical class="w-4 h-4" />
                                                </button>
                                                <div x-show="open" x-cloak class="absolute left-0 mt-1 w-32 bg-white rounded-md shadow-lg py-1 border border-gray-100 z-10">
                                                    <button wire:click="togglePinPost({{ $post['id'] }})" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center gap-2">
                                                        <x-heroicon-s-map-pin class="w-4 h-4" /> {{ $post['is_pinned'] ? 'Unpin' : 'Pin' }}
                                                    </button>
                                                    <button 
                                                        @click="open = false"
                                                        wire:click="editPost({{ $post['id'] }})"
                                                        class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center gap-2"
                                                    >
                                                        <x-heroicon-s-pencil class="w-4 h-4" /> Edit
                                                    </button>
                                                    <button 
                                                        class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center gap-2"
                                                        wire:confirm="Hapus postingan ini?"
                                                        wire:click="deletePost({{ $post['id'] }})"
                                                    >
                                                        <x-heroicon-s-trash class="w-4 h-4" /> Hapus
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-4 text-gray-800 text-sm whitespace-pre-wrap leading-relaxed">{{ $post['content'] }}</div>
                             
                            <!-- Replies -->
                            <div class="pt-4 border-t border-gray-100">
                                <div class="space-y-4">
                                    @foreach($post['replies'] as $reply)
                                        <div class="flex gap-3 pl-4 border-l-2 border-gray-100">
                                            <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold text-gray-600 shrink-0">
                                                {{ $reply['user']['initial'] }}
                                            </div>
                                            <div class="flex-1 bg-gray-50 rounded-lg p-3">
                                                <div class="flex items-center justify-between mb-1">
                                                    <div class="flex items-center gap-2">
                                                        <span class="font-semibold text-xs text-gray-900">{{ $reply['user']['name'] }}</span>
                                                        <span class="text-xs text-gray-500">{{ $reply['created_at_human'] }}</span>
                                                    </div>
                                                    <button 
                                                        wire:confirm="Hapus komentar ini?"
                                                        wire:click="deleteReply({{ $reply['id'] }})" 
                                                        class="text-gray-400 hover:text-red-500"
                                                    >
                                                        <x-heroicon-s-trash class="w-3 h-3" />
                                                    </button>
                                                </div>
                                                <p class="text-gray-700 text-sm">{{ $reply['content'] }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                
                                <!-- Reply Input -->
                                <form wire:submit.prevent="addReply({{ $post['id'] }})" class="mt-4 flex items-start gap-3">
                                    <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-xs font-bold text-indigo-700 shrink-0">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                    <div class="flex-1 relative">
                                        <input 
                                            type="text" 
                                            wire:model="reply_content.{{ $post['id'] }}" 
                                            class="w-full text-sm border border-gray-300 rounded-full px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 pr-10"
                                            placeholder="Tambahkan komentar kelas..."
                                        >
                                        <button type="submit" class="absolute right-2 top-1.5 p-1 text-indigo-600 hover:bg-indigo-50 rounded-full">
                                            <x-heroicon-s-paper-airplane class="w-4 h-4" />
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 bg-white border border-gray-200 rounded-lg border-dashed">
                             <div class="mx-auto w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                <x-heroicon-o-chat-bubble-left-right class="w-8 h-8 text-gray-400" />
                            </div>
                            <h3 class="text-lg font-medium text-gray-900">Belum ada aktivitas</h3>
                            <p class="text-gray-500 text-sm mt-1">Mulai diskusi atau buat pengumuman baru untuk kelas Anda.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- CLASSWORK TAB -->
        <div x-show="activeTab === 'classwork'" x-cloak x-transition.opacity.duration.200ms class="max-w-4xl mx-auto space-y-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                     <h2 class="text-2xl font-semibold text-gray-800">Tugas & Materi</h2>
                     <p class="text-sm text-gray-500">Kelola kurikulum dan penilaian kelas.</p>
                </div>
                <!-- Create Buttons -->
                <div class="flex gap-2">
                    <button @click="materialModal = true; $wire.resetMaterialForm()" class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium text-sm transition-colors shadow-sm">
                        <x-heroicon-o-document-plus class="w-5 h-5" />
                        Materi
                    </button>
                    <button @click="assignmentModal = true; $wire.resetAssignmentForm()" class="flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium text-sm transition-colors shadow-sm">
                        <x-heroicon-o-clipboard-document-list class="w-5 h-5" />
                        Tugas
                    </button>
                </div>
            </div>

            <div class="space-y-4">
                 @php $lastDeadline = null; @endphp
                 @foreach($class->assignments->sortBy('deadline') as $assignment)
                    @php 
                        $deadlineDate = \Carbon\Carbon::parse($assignment->deadline)->locale('id')->translatedFormat('l, d F Y');
                    @endphp

                    @if($deadlineDate !== $lastDeadline)
                        <div class="flex items-center gap-4 py-2 mt-4">
                            <div class="h-px bg-gray-300 flex-1"></div>
                            <span class="text-sm font-medium text-gray-500 bg-white px-2 rounded-full border border-gray-200">
                                {{ $deadlineDate }}
                            </span>
                            <div class="h-px bg-gray-300 flex-1"></div>
                        </div>
                        @php $lastDeadline = $deadlineDate; @endphp
                    @endif

                    <div class="group bg-white border border-gray-200 rounded-lg p-4 hover:border-indigo-300 transition-all flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center shrink-0">
                            <x-heroicon-s-clipboard-document class="w-5 h-5" />
                        </div>
                        <div class="flex-1">
                            <h4 class="font-medium text-gray-800">{{ $assignment->title }}</h4>
                            <div class="text-xs text-gray-500 mt-1">
                                Tenggat: {{ \Carbon\Carbon::parse($assignment->deadline)->locale('id')->format('d M Y H:i') }}
                            </div>
                        </div>
                        <!-- Delete/Edit Actions -->
                        <div class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                             <button class="text-red-500 hover:text-red-700 p-2" wire:confirm="Hapus tugas ini?" wire:click="deleteAssignment({{ $assignment->id }})" title="Hapus">
                                <x-heroicon-o-trash class="w-5 h-5" />
                            </button>
                        </div>
                    </div>
                 @endforeach
            </div>

             <!-- Materials -->
             @if($class->materials->count() > 0)
                <div class="space-y-4 mt-8">
                    <h3 class="text-lg font-medium text-gray-700 border-b border-gray-200 pb-2 mb-4 flex items-center gap-2">
                        <x-heroicon-o-book-open class="w-5 h-5" />
                        Materi Referensi
                    </h3>
                    @foreach($class->materials as $material)
                        <div class="group bg-white border border-gray-200 rounded-lg p-4 hover:border-gray-300 transition-all flex items-start gap-4">
                            <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 shrink-0">
                                <x-heroicon-s-document-text class="w-5 h-5" />
                            </div>
                            <div class="flex-1">
                                <h4 class="font-medium text-gray-800">{{ $material->title }}</h4>
                                <p class="text-sm text-gray-500 mt-1 mb-2">{{ Str::limit($material->description, 100) }}</p>
                                @if($material->type === 'link')
                                    <a href="{{ $material->link }}" target="_blank" class="text-xs text-blue-600 hover:underline flex items-center gap-1">
                                        <x-heroicon-s-link class="w-3 h-3" /> Buka Link
                                    </a>
                                @endif
                            </div>
                             <div class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <button class="text-red-500 hover:text-red-700 p-2" wire:confirm="Hapus materi ini?" wire:click="deleteMaterial({{ $material->id }})">
                                    <x-heroicon-o-trash class="w-5 h-5" />
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- PEOPLE TAB -->
         <div x-show="activeTab === 'people'" x-cloak x-transition.opacity.duration.200ms class="max-w-4xl mx-auto space-y-8">
             <div class="flex items-center justify-between mb-4 border-b border-indigo-200 pb-3">
                <h2 class="text-2xl font-semibold text-indigo-600">Pengajar</h2>
             </div>
             <div class="flex items-center gap-4 py-3">
                 <div class="w-12 h-12 bg-indigo-600 rounded-full flex items-center justify-center text-white font-bold text-lg shrink-0">
                    {{ $class->instructor && $class->instructor->user ? substr($class->instructor->user->name, 0, 1) : 'T' }}
                </div>
                <div>
                    <div class="font-medium text-gray-800">{{ $class->instructor->user->name ?? 'N/A' }}</div>
                    <div class="text-sm text-gray-500 flex items-center gap-1">
                        <x-heroicon-s-envelope class="w-4 h-4" />
                        {{ $class->instructor->user->email ?? '' }}
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <div class="flex items-center justify-between mb-4 border-b border-gray-200 pb-3">
                    <h2 class="text-2xl font-semibold text-indigo-600">Peserta</h2>
                    <div class="text-sm text-gray-500">{{ $class->students->count() }} siswa</div>
                     <!-- Add Student Button -->
                     <button @click="studentModal = true" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-full">
                        <x-heroicon-o-user-plus class="w-6 h-6" />
                    </button>
                </div>
                
                <div class="divide-y divide-gray-100">
                    @foreach($class->students as $student)
                        <div class="flex items-center justify-between py-3 hover:bg-gray-50 px-2 rounded-lg transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-700 font-bold shrink-0">
                                    {{ substr($student->name, 0, 1) }}
                                </div>
                                <div class="font-medium text-gray-700">{{ $student->name }}</div>
                            </div>
                            <button class="text-red-400 hover:text-red-600 p-1" wire:confirm="Keluarkan siswa ini?" wire:click="hapusMahasiswaKelas({{ $student->id }})">
                                <x-heroicon-o-trash class="w-5 h-5" />
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
         </div>
    </div>

    {{-- MODALS SECTION (ALPINE) --}}
    
    {{-- Material Modal --}}
    <div 
        x-show="materialModal" 
        x-cloak
        class="fixed inset-0 z-50 overflow-y-auto" 
        aria-labelledby="modal-title" 
        role="dialog" 
        aria-modal="true"
    >
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="materialModal" x-transition.opacity class="fixed inset-0 bg-black/35 transition-opacity" @click="materialModal = false"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div 
                x-show="materialModal" 
                x-transition.scale 
                class="relative z-50 inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl w-full"
            >
                <div class="bg-white p-6">
                    <h2 class="text-2xl font-semibold mb-6">Tambah Materi</h2>
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
                            <button type="button" @click="materialModal = false" class="flex-1 p-3 bg-gray-200 text-gray-700 rounded-lg">Batal</button>
                            <button type="submit" class="flex-1 p-3 bg-indigo-600 text-white rounded-lg">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Assignment Modal --}}
    <div 
        x-show="assignmentModal" 
        x-cloak
        class="fixed inset-0 z-50 overflow-y-auto" 
        aria-labelledby="modal-title" 
        role="dialog" 
        aria-modal="true"
    >
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="assignmentModal" x-transition.opacity class="fixed inset-0 bg-black/35 transition-opacity" @click="assignmentModal = false"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div 
                x-show="assignmentModal" 
                x-transition.scale 
                class="relative z-50 inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl w-full"
            >
                <div class="bg-white p-6">
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
                            <button type="button" @click="assignmentModal = false" class="flex-1 p-3 bg-gray-200 text-gray-700 rounded-lg">Batal</button>
                            <button type="submit" class="flex-1 p-3 bg-green-600 text-white rounded-lg">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Student Modal --}}
    <div 
        x-show="studentModal" 
        x-cloak
        class="fixed inset-0 z-50 overflow-y-auto" 
        aria-labelledby="modal-title" 
        role="dialog" 
        aria-modal="true"
    >
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="studentModal" x-transition.opacity class="fixed inset-0 bg-black/35 transition-opacity" @click="studentModal = false"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div 
                x-show="studentModal" 
                x-transition.scale 
                class="relative z-50 inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md w-full"
            >
                <div class="bg-white p-6">
                    <h2 class="text-2xl font-semibold mb-6">Tambah Mahasiswa</h2>
                    <form wire:submit="tambahMahasiswaKelas">
                        <div class="mb-6">
                            <label class="block mb-2 font-semibold">NIM atau Email</label>
                            <input type="text" wire:model="student_identifier" required class="w-full p-3 border-2 border-gray-200 rounded-lg" placeholder="Masukkan NIM atau Email">
                        </div>
                        <div class="flex gap-4">
                            <button type="button" @click="studentModal = false" class="flex-1 p-3 bg-gray-200 text-gray-700 rounded-lg">Batal</button>
                            <button type="submit" class="flex-1 p-3 bg-purple-600 text-white rounded-lg">Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Post Modal --}}
    <div 
        x-show="postModal" 
        x-cloak
        class="fixed inset-0 z-50 overflow-y-auto" 
        aria-labelledby="modal-title" 
        role="dialog" 
        aria-modal="true"
    >
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="postModal" x-transition.opacity class="fixed inset-0 bg-black/35 transition-opacity" @click="postModal = false"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div 
                x-show="postModal" 
                x-transition.scale 
                class="relative z-50 inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl w-full"
            >
                <div class="bg-white p-6">
                    <div class="flex justify-between items-center mb-6">
                         <!-- Toggle Buttons for Instructor -->
                        <div class="flex bg-gray-100 p-1 rounded-lg">
                            <button 
                                type="button"
                                class="px-4 py-2 text-sm font-medium rounded-md transition-all duration-200"
                                :class="$wire.post_type === 'announcement' ? 'bg-white text-indigo-700 shadow-sm' : 'text-gray-500 hover:text-gray-700'"
                                @click="$wire.set('post_type', 'announcement')"
                            >
                                Pengumuman
                            </button>
                            <button 
                                type="button"
                                class="px-4 py-2 text-sm font-medium rounded-md transition-all duration-200"
                                :class="$wire.post_type === 'discussion' ? 'bg-white text-emerald-700 shadow-sm' : 'text-gray-500 hover:text-gray-700'"
                                @click="$wire.set('post_type', 'discussion')"
                            >
                                Diskusi
                            </button>
                        </div>
                        <button @click="postModal = false" class="text-gray-500 hover:text-gray-800">
                            <x-heroicon-s-x-mark class="w-6 h-6" />
                        </button>
                    </div>

                    <form wire:submit.prevent="createPost">
                        <template x-if="$wire.post_type === 'discussion'">
                            <div class="mb-6">
                                <label class="block mb-2 font-semibold text-gray-700">Judul Diskusi</label>
                                <input type="text" wire:model="post_title" required class="w-full p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                @error('post_title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </template>

                        <div class="mb-6">
                            <label class="block mb-2 font-semibold text-gray-700" x-text="$wire.post_type === 'announcement' ? 'Isi Pengumuman' : 'Konten Diskusi'"></label>
                            <textarea wire:model="post_content" rows="6" required class="w-full p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                            @error('post_content') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex gap-3 justify-end">
                            <button type="button" @click="postModal = false" class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg font-semibold hover:bg-gray-200 transition-colors">
                                Batal
                            </button>
                            <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700 transition-colors flex items-center gap-2">
                                <span x-text="$wire.selectedPostId ? 'Simpan' : ($wire.post_type === 'announcement' ? 'Posting' : 'Mulai Diskusi')"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
