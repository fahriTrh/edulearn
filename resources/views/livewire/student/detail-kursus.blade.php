<div class="min-h-screen bg-white -mx-4 lg:-mx-8 -mt-4 lg:-mt-8" x-data="{ 
    activeTab: 'stream', 
    postModal: false, 
    activeTab: 'stream', 
    postModal: false, 
    submissionModal: false,
    replyModal: false,
    selectedAssignment: null,
    
    init() {
        // Listen for livewire events to control modals
        Livewire.on('close-post-modal', () => { this.postModal = false });
        Livewire.on('close-submission-modal', () => { this.submissionModal = false });
        Livewire.on('close-reply-modal', () => { this.replyModal = false });
        Livewire.on('open-post-modal', () => { this.postModal = true });
        Livewire.on('open-reply-modal', () => { this.replyModal = true });
    },

    openAssignment(assignment) {
        this.selectedAssignment = assignment;
        this.submissionModal = true;
        
        // Hydrate Livewire form models exclusively for editing
        // We use defer: true to avoid extra requests if possible, or just set it
        // Since we are inside the component, we can interact with $wire
        // but $wire inside x-data needs @this or similar usually, but purely client side:
        
        let text = assignment.submission?.submission_text || '';
        let link = assignment.submission?.submission_link || '';
        
        // We trigger the backend to sync state (for security/file inputs)
        // AND we pre-fill the local inputs if using wire:model
        $wire.set('selectedAssignmentId', assignment.id, false);
        $wire.set('submission_text', text, false);
        $wire.set('submission_link', link, false);
        
        // Also call the full details fetch to get the 'isSubmitted' state logic correct on backend
        // This runs in background while modal is already visible with data!
        $wire.getAssignmentDetails(assignment.id);
    }
}">
    <!-- Top Navigation Tabs (Google Classroom Style) -->
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


            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                <!-- Sidebar (Upcoming) -->
                <div class="hidden lg:block lg:col-span-1 space-y-4">
                    <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                        <h3 class="font-medium text-gray-700 mb-4">Mendatang</h3>
                        @if($upcomingAssignments->count() > 0)
                            <div class="space-y-3">
                                @foreach($upcomingAssignments as $assignment)
                                    <div class="text-sm">
                                        <div class="text-gray-500 text-xs mb-1">
                                            {{ $assignment['days_left'] == 0 ? 'Hari ini' : ($assignment['days_left'] == 1 ? 'Besok' : $assignment['deadline_date']) }}
                                        </div>
                                        <a href="#" @click.prevent="activeTab = 'classwork'" class="text-gray-800 hover:text-indigo-600 font-medium flex items-center gap-2 group">
                                            <x-heroicon-o-clipboard-document-list class="w-4 h-4 text-gray-400 group-hover:text-indigo-600 shrink-0" />
                                            <span class="truncate">{{ $assignment['title'] }}</span>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                            <div class="mt-4 pt-3 border-t border-gray-100 text-right">
                                <a href="#" @click.prevent="activeTab = 'classwork'" class="text-xs font-semibold text-indigo-600 hover:underline">Lihat semua</a>
                            </div>
                        @else
                            <p class="text-xs text-gray-500">Tidak ada tugas yang perlu segera diselesaikan</p>
                            <div class="mt-4 pt-3 border-t border-gray-100 text-right">
                                <a href="#" @click.prevent="activeTab = 'classwork'" class="text-xs font-semibold text-gray-400 hover:text-indigo-600">Lihat semua</a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Feed -->
                <div class="lg:col-span-3 space-y-6">
                    <!-- Create Post Trigger -->
                    <div 
                        @click="postModal = true"
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
                        <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm group hover:border-indigo-300 transition-colors">
                            <!-- Header -->
                            <div class="flex items-start justify-between mb-2">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 {{ $post['type'] === 'announcement' ? 'bg-indigo-600' : 'bg-emerald-600' }} rounded-full flex items-center justify-center text-white font-bold shrink-0">
                                        {{ $post['user']['initial'] }}
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <h3 class="font-semibold text-gray-900 truncate">{{ $post['user']['name'] }}</h3>
                                            <span class="text-[10px] uppercase font-bold tracking-wider px-2 py-0.5 rounded-full {{ $post['type'] === 'announcement' ? 'bg-indigo-100 text-indigo-700' : 'bg-emerald-100 text-emerald-700' }}">
                                                {{ $post['type'] === 'announcement' ? 'Pengumuman' : 'Diskusi' }}
                                            </span>
                                            @if($post['is_pinned'])
                                                <x-heroicon-s-map-pin class="w-3 h-3 text-gray-400" />
                                            @endif
                                        </div>
                                        <div class="flex items-center text-xs text-gray-500 gap-2 mt-0.5">
                                            <span>{{ $post['created_at_human'] }}</span>
                                            @if(isset($post['is_edited']) && $post['is_edited'])
                                                <span class="text-gray-400 italic">(diedit)</span>
                                            @endif
                                            
                                            <!-- Post Actions Dropdown -->
                                            @if($post['user']['id'] === Auth::id())
                                                <div x-data="{ open: false }" class="relative ml-2">
                                                    <button @click="open = !open" @click.away="open = false" class="p-1 hover:bg-gray-100 rounded-full transition-colors text-gray-400 hover:text-gray-600">
                                                        <x-heroicon-m-ellipsis-vertical class="w-4 h-4" />
                                                    </button>
                                                    <div x-show="open" x-cloak class="absolute right-0 mt-1 w-32 bg-white rounded-md shadow-lg py-1 border border-gray-100 z-10" role="menu">
                                                        <button 
                                                            @click="open = false"
                                                            wire:click="editPost({{ $post['id'] }})"
                                                            class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center gap-2"
                                                        >
                                                            <x-heroicon-s-pencil class="w-4 h-4" /> Edit
                                                        </button>
                                                        <button 
                                                            @click="open = false; if(confirm('Hapus postingan ini?')) $wire.deletePost({{ $post['id'] }})" 
                                                            class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center gap-2"
                                                        >
                                                            <x-heroicon-s-trash class="w-4 h-4" /> Hapus
                                                        </button>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-4 text-gray-800 text-sm whitespace-pre-wrap leading-relaxed">{{ $post['content'] }}</div>
                            
                            <div class="pt-4 border-t border-gray-100">
                                <!-- Replies -->
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
                                                    <div class="flex items-center gap-2">
                                                        @if(isset($reply['is_edited']) && $reply['is_edited'])
                                                            <span class="text-[10px] text-gray-400 italic">(diedit)</span>
                                                        @endif
                                                        
                                                        <!-- Reply Actions Dropdown -->
                                                        @if($reply['user']['id'] === Auth::id())
                                                            <div x-data="{ open: false }" class="relative">
                                                                <button @click="open = !open" @click.away="open = false" class="p-0.5 hover:bg-gray-200 rounded-full transition-colors text-gray-400 hover:text-gray-600">
                                                                    <x-heroicon-m-ellipsis-vertical class="w-4 h-4" />
                                                                </button>
                                                                <div x-show="open" x-cloak class="absolute right-0 mt-1 w-32 bg-white rounded-md shadow-lg py-1 border border-gray-100 z-10" role="menu">
                                                                    <button 
                                                                        @click="open = false"
                                                                        wire:click="editReply({{ $reply['id'] }})"
                                                                        class="w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-50 flex items-center gap-2"
                                                                    >
                                                                        <x-heroicon-s-pencil class="w-3 h-3" /> Edit
                                                                    </button>
                                                                    <button 
                                                                        @click="open = false; if(confirm('Hapus komentar ini?')) $wire.deleteReply({{ $reply['id'] }})" 
                                                                        class="w-full text-left px-4 py-2 text-xs text-red-600 hover:bg-red-50 flex items-center gap-2"
                                                                    >
                                                                        <x-heroicon-s-trash class="w-3 h-3" /> Hapus
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
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
                            <p class="text-gray-500 text-sm">Belum ada diskusi di kelas ini.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- CLASSWORK TAB -->
        <div x-show="activeTab === 'classwork'" x-cloak x-transition.opacity.duration.200ms class="max-w-4xl mx-auto space-y-8">
            <!-- Filter / Topics (Mockup for now) -->
             <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-semibold text-gray-800">Tugas Kelas</h2>
                <div class="text-sm text-gray-500">Lihat semua tugas dan materi Anda</div>
            </div>

            <!-- Assignments Section -->
            @if($assignments->count() > 0)
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-700 border-b border-gray-200 pb-2 mb-4 flex items-center gap-2">
                        <x-heroicon-o-clipboard-document-list class="w-5 h-5" />
                        Tugas
                    </h3>
                    @foreach($assignments as $assignment)
                        <!-- Date Separator -->
                        @if($loop->first || $assignment['deadline_date'] !== $assignments[$loop->index - 1]['deadline_date'])
                            <div class="flex items-center gap-4 py-2">
                                <div class="h-px bg-gray-300 flex-1"></div>
                                <span class="text-sm font-medium text-gray-500 bg-white px-2 rounded-full border border-gray-200">
                                    {{ $assignment['deadline_date'] }}
                                </span>
                                <div class="h-px bg-gray-300 flex-1"></div>
                            </div>
                        @endif

                        <div 
                            @click="activeTab = 'classwork'; openAssignment(@js($assignment))"
                            class="group bg-white border border-gray-200 rounded-lg p-4 hover:bg-gray-50 hover:border-indigo-300 transition-all cursor-pointer flex items-center gap-4"
                        >
                            <div class="w-10 h-10 rounded-full {{ $assignment['has_submission'] ? 'bg-green-100 text-green-600' : 'bg-indigo-100 text-indigo-600' }} flex items-center justify-center shrink-0">
                                <x-heroicon-s-clipboard-document class="w-5 h-5" />
                            </div>
                            <div class="flex-1">
                                <h4 class="font-medium text-gray-800 group-hover:text-indigo-600">{{ $assignment['title'] }}</h4>
                                <div class="text-xs flex gap-2 mt-1 {{ $assignment['is_late'] ? 'text-red-600 font-medium' : 'text-gray-500' }}">
                                    <span>Tenggat: {{ $assignment['deadline'] }}</span>
                                    @if($assignment['is_late'])
                                        <span class="font-bold">• Terlambat</span>
                                    @endif
                                </div>
                            </div>
                            <!-- Status Badge -->
                            <!-- Status Badge & Grade -->
                            <!-- Status Badge & Grade -->
                             <div class="flex flex-col items-end gap-1">
                                 @if($assignment['has_submission'])
                                    @if($assignment['is_late'])
                                        <span class="text-xs font-medium text-yellow-700 bg-yellow-100 border border-yellow-200 px-2 py-1 rounded">Diserahkan | Terlambat</span>
                                    @else
                                        <span class="text-xs font-medium text-green-700 bg-green-100 border border-green-200 px-2 py-1 rounded">Diserahkan</span>
                                    @endif
                                    
                                    <div class="text-xl font-bold text-gray-800">
                                        {{ $assignment['submission']['score'] ?? '--' }}/100
                                    </div>
                                 @else
                                    @if($assignment['days_left'] < 0)
                                        <span class="text-xs font-medium text-red-700 bg-red-100 border border-red-200 px-2 py-1 rounded">Ditugaskan | Terlambat</span>
                                    @else
                                        <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2 py-1 rounded">Ditugaskan</span>
                                    @endif
                                 @endif
                             </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Materials Section -->
            @if($materials->count() > 0)
                <div class="space-y-4 mt-8">
                    <h3 class="text-lg font-medium text-gray-700 border-b border-gray-200 pb-2 mb-4 flex items-center gap-2">
                        <x-heroicon-o-book-open class="w-5 h-5" />
                        Materi
                    </h3>
                    @foreach($materials as $material)
                        <div class="group bg-white border border-gray-200 rounded-lg p-4 hover:bg-gray-50 hover:border-gray-300 transition-all flex items-start gap-4">
                            <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 shrink-0">
                                <x-heroicon-s-document-text class="w-5 h-5" />
                            </div>
                            <div class="flex-1">
                                <h4 class="font-medium text-gray-800">{{ $material['title'] }}</h4>
                                <p class="text-sm text-gray-500 mt-1 mb-3">{{ $material['description'] }}</p>
                                
                                <div class="flex gap-3">
                                    @if($material['type'] === 'link')
                                        <a href="{{ $material['link'] }}" target="_blank" class="inline-flex items-center gap-1 text-sm text-blue-600 hover:underline border border-blue-200 bg-blue-50 px-3 py-1.5 rounded-md">
                                            <x-heroicon-s-link class="w-4 h-4" />
                                            Buka Link
                                        </a>
                                    @else
                                        <a href="{{ $material['fileUrl'] }}" target="_blank" class="inline-flex items-center gap-1 text-sm text-gray-700 hover:bg-gray-200 border border-gray-300 bg-white px-3 py-1.5 rounded-md transition-colors">
                                            <x-heroicon-s-arrow-down-tray class="w-4 h-4" />
                                            Download Materi
                                        </a>
                                    @endif

                                    @if(!$material['is_completed'])
                                        <button wire:click="markMaterialComplete({{ $material['id'] }})" class="text-xs text-gray-400 hover:text-green-600 underline">
                                            Tandai Selesai
                                        </button>
                                    @else
                                        <span class="text-xs text-green-600 flex items-center gap-1">
                                            <x-heroicon-s-check class="w-3 h-3" /> Selesai
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- PEOPLE TAB -->
        <div x-show="activeTab === 'people'" x-cloak x-transition.opacity.duration.200ms class="max-w-4xl mx-auto space-y-8">
            <!-- Teachers -->
            <div>
                <h2 class="text-2xl font-semibold text-indigo-600 border-b border-indigo-200 pb-3 mb-4">Pengajar</h2>
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
            </div>

            <!-- Classmates -->
             <div>
                <div class="flex items-center justify-between border-b border-indigo-200 pb-3 mb-4">
                     <h2 class="text-2xl font-semibold text-indigo-600">Peserta</h2>
                     <span class="text-sm text-gray-500">{{ $classmates->count() }} siswa</span>
                </div>
                
                <div class="space-y-1">
                    @foreach($classmates as $classmate)
                        <div class="flex items-center gap-4 py-3 hover:bg-gray-50 rounded-lg px-2 text-sm">
                            <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center text-gray-600 font-medium shrink-0">
                                {{ substr($classmate->name, 0, 1) }}
                            </div>
                            <div class="flex-1 font-medium text-gray-800">{{ $classmate->name }}</div>
                            <div class="text-gray-400 invisible group-hover:visible">
                                <x-heroicon-o-envelope class="w-5 h-5" />
                            </div>
                        </div>
                    @endforeach
                </div>
             </div>
        </div>
    </div>

    <!-- POST MODAL (Alpine) -->
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
                    <h3 class="text-xl font-normal text-gray-800 mb-6 font-sans">Postingan</h3>
                    <form wire:submit.prevent="createPost">
                        <!-- Hidden Title (Optional) -->
                        <div class="hidden">
                             <input type="text" wire:model="post_title">
                        </div>

                        <div class="bg-gray-50 rounded-lg p-4 mb-4 border border-gray-100">
                             <textarea 
                                wire:model="post_content" 
                                class="w-full bg-transparent border-none focus:ring-0 text-gray-700 text-base resize-none p-0 placeholder-gray-500" 
                                rows="5" 
                                placeholder="Umumkan sesuatu kepada kelas Anda"
                            ></textarea>
                            <div class="flex items-center gap-4 mt-3 border-t border-gray-200 pt-3">
                                <button type="button" class="p-1 text-gray-500 hover:bg-gray-200 rounded font-bold hover:text-gray-700 transition-colors" title="Bold">
                                    B
                                </button>
                                <button type="button" class="p-1 text-gray-500 hover:bg-gray-200 rounded italic hover:text-gray-700 transition-colors" title="Italic">
                                    I
                                </button>
                                <button type="button" class="p-1 text-gray-500 hover:bg-gray-200 rounded underline hover:text-gray-700 transition-colors" title="Underline">
                                    U
                                </button>
                                <button type="button" class="p-1 text-gray-500 hover:bg-gray-200 rounded hover:text-gray-700 transition-colors" title="Bulleted List">
                                    <x-heroicon-s-list-bullet class="w-5 h-5" />
                                </button>
                                <button type="button" class="p-1 text-gray-500 hover:bg-gray-200 rounded hover:text-gray-700 transition-colors" title="Clear Formatting">
                                    <x-heroicon-s-x-mark class="w-5 h-5" />
                                </button>
                            </div>
                        </div>
                        @error('post_content') <p class="text-red-500 text-xs italic mb-2">{{ $message }}</p> @enderror

                        <div class="flex justify-end gap-3 mt-6">
                            <button type="button" @click="postModal = false" class="px-5 py-2 text-gray-600 font-medium hover:bg-gray-100 rounded-md transition-colors">Batal</button>
                            <button type="submit" wire:loading.attr="disabled" wire:loading.class="opacity-50 cursor-not-allowed" class="px-6 py-2 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700 shadow-sm transition-colors disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center">
                                <span wire:loading.remove wire:target="createPost">Posting</span>
                                <span wire:loading.class.remove="hidden" wire:target="createPost" class="hidden flex items-center gap-2">
                                    <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Posting...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- SUBMISSION MODAL (Alpine) -->
    <div 
        x-show="submissionModal" 
        x-cloak
        class="fixed inset-0 z-50 overflow-y-auto" 
        aria-labelledby="modal-title" 
        role="dialog" 
        aria-modal="true"
    >
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="submissionModal" x-transition.opacity class="fixed inset-0 bg-black/35 transition-opacity" @click="submissionModal = false"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div 
                x-show="submissionModal" 
                x-transition.scale 
                class="relative z-50 inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl w-full"
            >
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6" x-show="selectedAssignment">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-xl font-bold text-gray-900" x-text="selectedAssignment?.title"></h3>
                        <button @click="submissionModal = false" class="text-gray-400 hover:text-gray-500">
                            <span class="sr-only">Close</span>
                            <x-heroicon-o-x-mark class="w-6 h-6" />
                        </button>
                    </div>
                    
                    <div class="prose max-w-none text-base text-gray-900 mb-6 bg-gray-50 p-4 rounded-lg border border-gray-100" 
                         x-show="selectedAssignment?.description"
                         x-text="selectedAssignment?.description">
                    </div>

                    <!-- Instructions / Attachment -->
                    <template x-if="selectedAssignment?.instructions">
                        <div class="bg-white rounded-lg p-4 border border-gray-200 mb-6 shadow-sm">
                            <h4 class="text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                                <x-heroicon-o-paper-clip class="w-4 h-4" />
                                Lampiran / Instruksi
                            </h4>
                            <div class="flex items-center gap-3 bg-gray-50 p-3 rounded-lg border border-gray-100">
                                <div class="w-10 h-10 rounded-full bg-indigo-50 flex items-center justify-center border border-indigo-100 text-indigo-600 shrink-0">
                                    <x-heroicon-s-document-text class="w-5 h-5" />
                                </div>
                                <div class="flex-1 min-w-0">
                                     <h4 class="font-medium text-gray-900 truncate" x-text="selectedAssignment.instructions.split('/').pop()"></h4>
                                     <p class="text-xs text-gray-500">Klik tombol di samping untuk membuka/mengunduh</p>
                                </div>
                                <template x-if="selectedAssignment.instructions.match(/^http/i)">
                                    <a :href="selectedAssignment.instructions" target="_blank" class="shrink-0 px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 hover:text-indigo-600 transition-colors shadow-sm flex items-center gap-2">
                                        <x-heroicon-s-link class="w-4 h-4" />
                                        <span>Buka Link</span>
                                    </a>
                                </template>
                                <template x-if="!selectedAssignment.instructions.match(/^http/i)">
                                    <a :href="'/' + selectedAssignment.instructions" target="_blank" class="shrink-0 px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 hover:text-indigo-600 transition-colors shadow-sm flex items-center gap-2">
                                        <x-heroicon-s-arrow-down-tray class="w-4 h-4" />
                                        <span>Download</span>
                                    </a>
                                </template>
                            </div>
                        </div>
                    </template>

                    <div class="mb-6 flex items-center gap-2 text-sm text-gray-600 bg-blue-50 p-3 rounded-lg border border-blue-100">
                        <x-heroicon-s-clock class="w-5 h-5 text-blue-600" />
                        <span class="font-medium text-blue-900">Tenggat Waktu:</span>
                        <span x-text="selectedAssignment?.deadline_date + ' ' + selectedAssignment?.deadline_time"></span>
                    </div>

                    <form wire:submit.prevent="submitAssignment" class="space-y-4" x-data="{isUploading:false, progress: 0, fileName: '', fileSize: ''}" x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-progress="progress = $event.detail.progress" x-on:livewire-upload-finish="isUploading = false; progress = 0" x-on:livewire-upload-error="isUploading = false; progress = 0">
                        <!-- Text Submission -->
                        <div x-show="selectedAssignment?.submission_type === 'text'">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jawaban Teks</label>
                            <textarea wire:model="submission_text" rows="6" class="shadow-sm block w-full focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border border-gray-300 rounded-md" placeholder="Ketik jawaban Anda di sini..."></textarea>
                            @error('submission_text') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- File Submission -->
                        <div x-show="selectedAssignment?.submission_type === 'file'">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Upload File</label>
                            <input type="file" wire:model="submission_file" @change="let f = $event.target.files[0]; if(f){ fileName = f.name; fileSize = Math.round(f.size/1024) + ' KB'; } else { fileName = ''; fileSize = ''; }" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            <p class="mt-1 text-xs text-gray-500">Max 10MB. Format: PDF, DOCX, ZIP, JPG, PNG.</p>
                            @error('submission_file') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

                            <!-- Selected file name and size (shown when a file is chosen) -->
                            <div x-show="fileName" x-cloak class="mt-2 text-sm text-gray-700">
                                <span class="font-medium">File dipilih:</span>
                                <span class="ml-2 text-gray-900" x-text="fileName"></span>
                                <span class="ml-2 text-gray-500" x-text="'(' + fileSize + ')'" ></span>
                            </div>

                            <!-- Upload progress (shows only when an actual file upload is in progress) -->
                            <div x-show="isUploading" x-cloak class="mt-3 w-full">
                                <div class="flex items-center gap-2 text-sm text-gray-600 mb-2">
                                    <svg class="animate-spin h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                                    <span>Mengunggah file... <span class="font-semibold" x-text="progress + '%'">0%</span></span>
                                </div>

                                <div class="w-full h-2 bg-gray-200 rounded overflow-hidden">
                                    <div class="h-full bg-indigo-600 transition-all" :style="'width: ' + progress + '%'" role="progressbar" :aria-valuenow="progress" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>

                            <!-- Existing File Warning/Display -->
                            <div x-show="selectedAssignment?.submission?.file_path" class="mt-2 text-sm text-gray-600 flex items-center gap-2 bg-gray-50 p-2 rounded">
                                <x-heroicon-s-paper-clip class="w-4 h-4 text-gray-400"/>
                                <span>File sebelumnya: </span>
                                <a :href="'/' + selectedAssignment?.submission?.file_path" target="_blank" class="text-indigo-600 hover:underline truncate max-w-[200px]" x-text="selectedAssignment?.submission?.file_name"></a>
                            </div>
                        </div>

                        <!-- Link Submission -->
                        <div x-show="selectedAssignment?.submission_type === 'link'">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Link Tugas</label>
                            <input type="url" wire:model="submission_link" class="shadow-sm block w-full focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border border-gray-300 rounded-md" placeholder="https://...">
                            @error('submission_link') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense px-6 pb-6">
                            <!-- Buttons Logic (using Livewire $isSubmitted but synced with Alpine logic visually if needed) -->
                            <!-- Note: $isSubmitted is updated by the background getAssignmentDetails call. 
                                 For instant feedback, we might rely on Alpine, but button actions (submit/cancel) are backend. 
                                 We'll keep using Livewire's $isSubmitted for safety/consistency. 
                            -->
                            @if($isSubmitted)
                                <!-- Cancel Submission Button -->
                                <button type="button" wire:click="cancelSubmission" wire:confirm="Batal kirim tugas? jika kamu kirim tugas lewat waktu, kamu akan ditandai terlambat" wire:loading.attr="disabled" class="w-full inline-flex justify-center items-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-red-600 hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:col-start-1 sm:col-span-2 sm:text-sm h-10">
                                    <span wire:loading.remove wire:target="cancelSubmission">Batal Pengiriman</span>
                                    <span wire:loading.class.remove="hidden" wire:target="cancelSubmission" class="hidden flex items-center gap-2">
                                        <svg class="animate-spin h-4 w-4 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Membatalkan...
                                    </span>
                                </button>
                            @else
                                <!-- Submit Button -->
                                <button type="button" wire:click="submitAssignment" wire:loading.attr="disabled" wire:loading.class="opacity-50 cursor-not-allowed" :disabled="isUploading" class="w-full inline-flex justify-center items-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:col-start-2 sm:text-sm disabled:opacity-50 disabled:cursor-not-allowed h-10">
                                    <span wire:loading.remove wire:target="submitAssignment">Kirim Tugas</span>
                                    <span wire:loading.class.remove="hidden" wire:target="submitAssignment" class="hidden flex items-center gap-2">
                                        <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Mengirim...
                                    </span>
                                </button>
                                
                                <!-- Mark as Done Button -->
                                <button type="button" wire:click="markAsDone" wire:loading.attr="disabled" class="mt-3 w-full inline-flex justify-center items-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:col-start-1 sm:text-sm h-10">
                                    <span wire:loading.remove wire:target="markAsDone">Tandai Selesai</span>
                                    <span wire:loading.class.remove="hidden" wire:target="markAsDone" class="hidden flex items-center gap-2">
                                         <svg class="animate-spin h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Memproses...
                                    </span>
                                </button>
                            @endif
                            <button type="button" @click="submissionModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:col-span-2 sm:text-sm h-10">
                                Tutup
                            </button>
                        </div>
                </div>
                <div x-show="!selectedAssignment" class="p-6 text-center">
                    <p>Memuat data...</p>
                </div>
            </div>
        </div>
    </div>
    <!-- REPLY EDIT MODAL (Alpine) -->
    <div 
        x-show="replyModal" 
        x-cloak
        class="fixed inset-0 z-50 overflow-y-auto" 
        aria-labelledby="modal-title" 
        role="dialog" 
        aria-modal="true"
    >
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="replyModal" x-transition.opacity class="fixed inset-0 bg-black/35 transition-opacity" @click="replyModal = false"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div 
                x-show="replyModal" 
                x-transition.scale 
                class="relative z-50 inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full"
            >
                <div class="bg-white p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Edit Komentar</h3>
                    <form wire:submit.prevent="updateReply">
                        <textarea 
                            wire:model="reply_content_edit" 
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" 
                            rows="3"
                            placeholder="Tulis balasan..."
                        ></textarea>
                        @error('reply_content_edit') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

                        <div class="mt-4 flex justify-end gap-3">
                            <button type="button" @click="replyModal = false" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">Batal</button>
                            <button type="submit" class="px-4 py-2 text-sm bg-indigo-600 text-white rounded-md hover:bg-indigo-700 disabled:opacity-50">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
