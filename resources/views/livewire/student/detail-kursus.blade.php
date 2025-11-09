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
        <h1 class="text-2xl font-semibold text-gray-900 mb-1">{{ $class->title ?? 'Kursus' }}</h1>
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
                <div class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center text-white font-semibold">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="flex-1">
                    <input type="text" 
                           wire:click="openPostModal"
                           placeholder="Ask a question or start a discussion..." 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 cursor-pointer"
                           readonly>
                </div>
            </div>
            <button wire:click="openPostModal" 
                    class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium">
                <x-heroicon-s-chat-bubble-left-right class="w-5 h-5" />
                Create Discussion
            </button>
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
                            <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($post['created_at'])->diffForHumans() }}</p>
                        </div>
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
                           class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                    <button wire:click="addReply({{ $post['id'] }})" 
                            class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium">
                        Reply
                    </button>
                </div>
            </div>
            @empty
            <div class="bg-white rounded-lg border border-gray-200 p-6 text-center text-gray-500">
                <p>No posts yet. Start a discussion!</p>
            </div>
            @endforelse
        </div>
    </div>
    @endif

    <!-- Classwork Tab -->
    @if($activeTab === 'classwork')
    <div class="space-y-4">
        <!-- Materials Section -->
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <h3 class="text-sm font-medium text-gray-700 mb-3">Materials</h3>
            <div class="space-y-2">
                @forelse($materials as $material)
                <div class="flex items-center gap-3 p-3 hover:bg-gray-50 rounded-lg group">
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <x-heroicon-s-document class="w-5 h-5 text-blue-600" />
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2">
                            <h4 class="text-sm font-medium text-gray-900 truncate">{{ $material['title'] }}</h4>
                            @if($material['is_completed'])
                                <x-heroicon-s-check-circle class="w-4 h-4 text-green-600" />
                            @endif
                        </div>
                        <p class="text-xs text-gray-500">{{ $material['type'] }} • {{ $material['uploadDate'] }}</p>
                    </div>
                    <div class="flex gap-2">
                        @if($material['fileUrl'])
                            <a href="{{ $material['fileUrl'] }}" target="_blank" 
                               class="px-3 py-1.5 text-blue-600 hover:bg-blue-50 rounded text-xs font-medium">
                                Download
                            </a>
                        @elseif($material['link'])
                            <a href="{{ $material['link'] }}" target="_blank" 
                               class="px-3 py-1.5 text-blue-600 hover:bg-blue-50 rounded text-xs font-medium">
                                Open Link
                            </a>
                        @endif
                        @if(!$material['is_completed'])
                            <button wire:click="markMaterialComplete({{ $material['id'] }})" 
                                    class="px-3 py-1.5 text-green-600 hover:bg-green-50 rounded text-xs font-medium">
                                Mark Complete
                            </button>
                        @endif
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
                @forelse($assignments as $assignment)
                <div class="flex items-center gap-3 p-3 hover:bg-gray-50 rounded-lg group">
                    <div class="w-10 h-10 {{ $assignment['has_submission'] ? 'bg-green-100' : 'bg-orange-100' }} rounded-full flex items-center justify-center flex-shrink-0">
                        <x-heroicon-s-document-text class="w-5 h-5 {{ $assignment['has_submission'] ? 'text-green-600' : 'text-orange-600' }}" />
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="text-sm font-medium text-gray-900 truncate">{{ $assignment['title'] }}</h4>
                        <p class="text-xs text-gray-500">
                            Due: {{ $assignment['deadline'] }}
                            @if($assignment['has_submission'])
                                @if($assignment['submission']['score'] !== null)
                                    • Score: {{ $assignment['submission']['score'] }}/100
                                @else
                                    • Submitted
                                @endif
                            @else
                                • Not submitted
                            @endif
                        </p>
                    </div>
                    <button wire:click="openSubmissionModal({{ $assignment['id'] }})" 
                            class="px-3 py-1.5 {{ $assignment['has_submission'] ? 'bg-green-50 text-green-700 hover:bg-green-100' : 'bg-blue-50 text-blue-700 hover:bg-blue-100' }} rounded text-xs font-medium">
                        {{ $assignment['has_submission'] ? 'View/Edit' : 'Submit' }}
                    </button>
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
        <!-- Instructor -->
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <h3 class="text-sm font-medium text-gray-700 mb-3">Teacher</h3>
            <div class="flex items-center gap-3 p-3">
                <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-semibold flex-shrink-0">
                    {{ $class->instructor ? substr($class->instructor->name, 0, 1) : 'T' }}
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="text-sm font-medium text-gray-900 truncate">{{ $class->instructor->name ?? 'N/A' }}</h4>
                    <p class="text-xs text-gray-500 truncate">{{ $class->instructor->email ?? '' }}</p>
                </div>
            </div>
        </div>

        <!-- Classmates -->
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <h3 class="text-sm font-medium text-gray-700 mb-3">Classmates</h3>
            <div class="space-y-2">
                @forelse($classmates as $classmate)
                <div class="flex items-center gap-3 p-3 hover:bg-gray-50 rounded-lg">
                    <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center text-xs font-medium flex-shrink-0">
                        {{ substr($classmate->name, 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="text-sm font-medium text-gray-900 truncate">{{ $classmate->name }}</h4>
                        <p class="text-xs text-gray-500 truncate">{{ $classmate->nim }}</p>
                    </div>
                </div>
                @empty
                <p class="text-sm text-gray-500 py-4">No classmates yet</p>
                @endforelse
            </div>
        </div>
    </div>
    @endif

    <!-- Assignment Submission Modal -->
    @if($showSubmissionModal && $selectedAssignment)
    <div class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4" wire:click.self="closeSubmissionModal">
        <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">
                    {{ $selectedAssignment->title }}
                </h3>
                <button wire:click="closeSubmissionModal" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <div class="p-6">
                <!-- Assignment Info -->
                <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <p class="text-sm text-gray-700 mb-2">{{ $selectedAssignment->description }}</p>
                    <div class="flex items-center gap-4 text-xs text-gray-600">
                        <span class="flex items-center gap-1">
                            <x-heroicon-s-calendar class="w-3 h-3" />
                            Deadline: {{ \Carbon\Carbon::parse($selectedAssignment->deadline)->format('d M Y, H:i') }}
                        </span>
                        <span class="flex items-center gap-1">
                            <x-heroicon-s-chart-bar class="w-3 h-3" />
                            Weight: {{ $selectedAssignment->weight_percentage }}%
                        </span>
                        <span class="flex items-center gap-1">
                            <x-heroicon-s-paper-clip class="w-3 h-3" />
                            Type: {{ ucfirst($selectedAssignment->submission_type) }}
                        </span>
                    </div>
                </div>

                <form wire:submit.prevent="submitAssignment">
                    @if($selectedAssignment->submission_type === 'file')
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Upload File <span class="text-red-500">*</span>
                            </label>
                            <input type="file" wire:model="submission_file" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('submission_file') 
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p> 
                            @enderror
                            @php
                                $currentSubmission = \App\Models\AssignmentSubmission::where('assignment_id', $selectedAssignmentId)
                                    ->where('user_id', Auth::id())
                                    ->first();
                            @endphp
                            @if($currentSubmission && $currentSubmission->file_name)
                                <p class="mt-2 text-sm text-gray-600">
                                    Current file: <a href="{{ asset($currentSubmission->file_path) }}" target="_blank" class="text-blue-600 hover:underline">{{ $currentSubmission->file_name }}</a>
                                </p>
                            @endif
                            <p class="mt-1 text-xs text-gray-500">Max 10MB. Or provide a link below.</p>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Or Submit via Link
                            </label>
                            <input type="url" wire:model="submission_link" 
                                   placeholder="https://example.com/submission"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('submission_link') 
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p> 
                            @enderror
                        </div>
                    @endif

                    @if($selectedAssignment->submission_type === 'text')
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Submission Text <span class="text-red-500">*</span>
                            </label>
                            <textarea wire:model="submission_text" rows="8" 
                                      placeholder="Tulis jawaban atau submission Anda di sini..."
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                            @error('submission_text') 
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p> 
                            @enderror
                        </div>
                    @endif

                    @if($selectedAssignment->submission_type === 'link')
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Submission Link <span class="text-red-500">*</span>
                            </label>
                            <input type="url" wire:model="submission_link" 
                                   placeholder="https://example.com/submission"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('submission_link') 
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p> 
                            @enderror
                        </div>
                    @endif

                    <!-- Show existing submission info -->
                    @php
                        $existingSubmission = null;
                        if ($selectedAssignmentId) {
                            $existingSubmission = \App\Models\AssignmentSubmission::where('assignment_id', $selectedAssignmentId)
                                ->where('user_id', Auth::id())
                                ->first();
                        }
                    @endphp

                    @if($existingSubmission)
                        <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                            <p class="text-sm font-medium text-blue-900 mb-1">Current Submission:</p>
                            <p class="text-xs text-blue-700">
                                Submitted: {{ \Carbon\Carbon::parse($existingSubmission->submitted_at)->format('d M Y, H:i') }}
                                @if($existingSubmission->is_late)
                                    <span class="text-red-600">(Late)</span>
                                @endif
                            </p>
                            @if($existingSubmission->score !== null)
                                <p class="text-xs text-blue-700 mt-1">Score: {{ $existingSubmission->score }}/100</p>
                            @endif
                        </div>
                    @endif

                    <div class="flex gap-3 justify-end">
                        <button type="button" wire:click="closeSubmissionModal" 
                                class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg font-medium">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium">
                            {{ $existingSubmission ? 'Update Submission' : 'Submit Assignment' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    {{-- Post Modal --}}
    @if($showPostModal)
    <div class="fixed top-0 left-0 w-full h-full bg-black/50 z-50 flex items-center justify-center p-4" wire:click="closePostModal">
        <div class="bg-white p-8 rounded-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto" wire:click.stop>
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold">Create Discussion</h2>
                <button wire:click="closePostModal" class="text-gray-500 hover:text-gray-800">
                    <x-heroicon-s-x-mark class="w-6 h-6" />
                </button>
            </div>
            <form wire:submit.prevent="createPost">
                <div class="mb-6">
                    <label class="block mb-2 font-semibold">Title</label>
                    <input type="text" wire:model="post_title" required class="w-full p-3 border-2 border-gray-200 rounded-lg">
                    @error('post_title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="mb-6">
                    <label class="block mb-2 font-semibold">Content</label>
                    <textarea wire:model="post_content" rows="6" required class="w-full p-3 border-2 border-gray-200 rounded-lg"></textarea>
                    @error('post_content') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="flex gap-3">
                    <button type="button" wire:click="closePostModal" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg font-semibold hover:bg-gray-200">
                        Cancel
                    </button>
                    <button type="submit" class="flex-1 px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold">
                        Post Discussion
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
