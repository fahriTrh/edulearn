<div>
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Review & Grading</h1>
        <p class="text-gray-600">Review dan berikan nilai untuk tugas mahasiswa</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Assignments List -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Daftar Tugas</h2>
                <div class="space-y-3 max-h-[600px] overflow-y-auto">
                    @forelse($assignments as $assignment)
                    <button 
                        wire:click="selectAssignment({{ $assignment['id'] }})"
                        class="w-full text-left p-4 border-2 rounded-lg transition-all {{ $selectedAssignmentId == $assignment['id'] ? 'border-purple-600 bg-purple-50' : 'border-gray-200 hover:border-purple-300 hover:bg-gray-50' }}"
                    >
                        <h3 class="font-semibold text-gray-900 mb-1">{{ $assignment['title'] }}</h3>
                        <p class="text-sm text-gray-600 mb-2">{{ $assignment['class_name'] }}</p>
                        <div class="flex gap-4 text-xs text-gray-500 mb-2">
                            <span class="flex items-center gap-1">
                                <x-heroicon-s-calendar class="w-3 h-3" />
                                {{ \Carbon\Carbon::parse($assignment['deadline'])->format('d M Y') }}
                            </span>
                        </div>
                        <div class="flex gap-3 text-xs">
                            <span class="px-2 py-1 bg-blue-100 text-blue-600 rounded">{{ $assignment['total_submissions'] }} Submit</span>
                            <span class="px-2 py-1 bg-green-100 text-green-600 rounded">{{ $assignment['graded_submissions'] }} Dinilai</span>
                            <span class="px-2 py-1 bg-orange-100 text-orange-600 rounded">{{ $assignment['pending_submissions'] }} Pending</span>
                        </div>
                    </button>
                    @empty
                    <div class="text-center py-8 text-gray-500">
                        <p>Belum ada tugas</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Submissions List -->
        <div class="lg:col-span-2">
            @if($selectedAssignmentId && $selectedAssignment)
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800">{{ $selectedAssignment->title }}</h2>
                        <p class="text-sm text-gray-600">{{ $selectedAssignment->class->title ?? 'N/A' }}</p>
                    </div>
                    <button wire:click="clearSelection" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg font-semibold hover:bg-gray-200 transition-colors">
                        ← Kembali
                    </button>
                </div>

                <!-- Filter Tabs -->
                <div class="flex gap-2 mb-6 pb-4 border-b border-gray-200">
                    <button wire:click="filterSubmissions('all')" class="px-4 py-2 rounded-lg font-medium transition-all {{ $filter === 'all' ? 'bg-purple-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        Semua
                    </button>
                    <button wire:click="filterSubmissions('pending')" class="px-4 py-2 rounded-lg font-medium transition-all {{ $filter === 'pending' ? 'bg-purple-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        Pending
                    </button>
                    <button wire:click="filterSubmissions('submitted')" class="px-4 py-2 rounded-lg font-medium transition-all {{ $filter === 'submitted' ? 'bg-purple-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        Terkirim
                    </button>
                    <button wire:click="filterSubmissions('graded')" class="px-4 py-2 rounded-lg font-medium transition-all {{ $filter === 'graded' ? 'bg-purple-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        Dinilai
                    </button>
                </div>

                <!-- Submissions -->
                <div class="space-y-4">
                    @forelse($submissions as $submission)
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-all">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="font-semibold text-gray-900">{{ $submission['student_name'] }}</h3>
                                <p class="text-sm text-gray-600">{{ $submission['student_nim'] }} • {{ $submission['student_email'] }}</p>
                            </div>
                            <div class="text-right">
                                @if($submission['score'] !== null)
                                    <span class="inline-block px-3 py-1 bg-green-100 text-green-600 rounded-full text-sm font-semibold">
                                        {{ $submission['score'] }}/100
                                    </span>
                                @else
                                    <span class="inline-block px-3 py-1 bg-orange-100 text-orange-600 rounded-full text-sm font-semibold">
                                        Belum Dinilai
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="flex gap-4 text-sm text-gray-600 mb-4">
                            <div class="flex items-center gap-1">
                                <x-heroicon-s-calendar class="w-4 h-4" />
                                <span>Dikirim: {{ \Carbon\Carbon::parse($submission['submitted_at'])->format('d M Y, H:i') }}</span>
                            </div>
                            @if($submission['is_late'])
                                <div class="flex items-center gap-1 text-red-600">
                                    <x-heroicon-s-exclamation-triangle class="w-4 h-4" />
                                    <span>Terlambat {{ $submission['days_late'] }} hari</span>
                                </div>
                            @endif
                        </div>

                        @if($submission['file_path'])
                            <div class="mb-4">
                                <a href="{{ asset($submission['file_path']) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-200 transition-colors">
                                    <x-heroicon-s-paper-clip class="w-5 h-5" />
                                    <span>{{ $submission['file_name'] ?? 'Download File' }}</span>
                                </a>
                            </div>
                        @endif

                        @if($submission['submission_text'])
                            <div class="mb-4 p-3 bg-gray-50 rounded-lg">
                                <p class="text-sm text-gray-700">{{ $submission['submission_text'] }}</p>
                            </div>
                        @endif

                        @if($submission['submission_link'])
                            <div class="mb-4">
                                <a href="{{ $submission['submission_link'] }}" target="_blank" class="flex items-center gap-2 text-blue-600 hover:underline text-sm">
                                    <x-heroicon-s-link class="w-4 h-4" />
                                    {{ $submission['submission_link'] }}
                                </a>
                            </div>
                        @endif

                        @if($submission['feedback'])
                            <div class="mb-4 p-3 bg-purple-50 rounded-lg border-l-4 border-purple-600">
                                <p class="text-sm font-semibold text-purple-900 mb-1">Feedback:</p>
                                <p class="text-sm text-gray-700">{{ $submission['feedback'] }}</p>
                            </div>
                        @endif

                        <button 
                            wire:click="openGradingModal({{ $submission['id'] }})"
                            class="w-full px-4 py-2 bg-gradient-to-r from-purple-600 to-purple-800 text-white rounded-lg font-semibold hover:opacity-90 transition-opacity"
                        >
                            {{ $submission['score'] !== null ? 'Edit Nilai' : 'Beri Nilai' }}
                        </button>
                    </div>
                    @empty
                    <div class="text-center py-12 text-gray-500">
                        <div class="flex justify-center mb-4">
                            <x-heroicon-s-document-text class="w-16 h-16 text-gray-400" />
                        </div>
                        <p>Belum ada submission untuk tugas ini</p>
                    </div>
                    @endforelse
                </div>
            </div>
            @else
            <div class="bg-white rounded-xl shadow-sm p-12 text-center">
                <div class="flex justify-center mb-4">
                    <x-heroicon-s-clipboard-document-list class="w-16 h-16 text-gray-400" />
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Pilih Tugas</h3>
                <p class="text-gray-600">Pilih tugas dari daftar di sebelah kiri untuk melihat submission</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Grading Modal -->
    @if($showGradingModal)
    <div class="fixed inset-0 bg-black/50 z-[70] flex items-center justify-center p-4" wire:click="closeGradingModal">
        <div class="relative z-[80] bg-white rounded-2xl max-w-lg w-full p-6" wire:click.stop>
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Beri Nilai</h2>
                <button wire:click="closeGradingModal" class="text-gray-400 hover:text-gray-600">
                    <x-heroicon-s-x-mark class="w-6 h-6" />
                </button>
            </div>

            <form wire:submit.prevent="saveGrade" class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Nilai (0-100) *</label>
                    <input type="number" wire:model="score" min="0" max="100" step="0.01" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-purple-600 focus:outline-none" placeholder="Masukkan nilai">
                    @error('score') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Feedback</label>
                    <textarea wire:model="feedback" rows="4" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-purple-600 focus:outline-none resize-none" placeholder="Berikan feedback untuk mahasiswa..."></textarea>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="submit" class="flex-1 px-6 py-3 bg-gradient-to-r from-purple-600 to-purple-800 text-white rounded-lg font-semibold hover:opacity-90 transition-opacity">
                        Simpan Nilai
                    </button>
                    <button type="button" wire:click="closeGradingModal" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg font-semibold hover:bg-gray-200 transition-colors">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    @if(session()->has('success'))
        <script>
            setTimeout(() => {
                showNotification('{{ session('success') }}', 'success');
            }, 100);
        </script>
    @endif
</div>
