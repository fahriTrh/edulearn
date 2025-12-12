<div>
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Tugas Kuliah</h1>
        <p class="text-gray-600 text-lg">Kelola dan selesaikan tugas kuliah Anda</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-8">
        <div class="bg-white p-4 md:p-6 rounded-xl shadow-sm flex items-center gap-4">
            <div class="w-14 h-14 md:w-16 md:h-16 bg-red-100 rounded-xl flex items-center justify-center">
                <x-heroicon-s-exclamation-triangle class="w-8 h-8 md:w-10 md:h-10 text-red-600" />
            </div>
            <div>
                <h3 class="text-2xl md:text-3xl font-bold text-purple-600">{{ $urgentCount }}</h3>
                <p class="text-gray-600 text-sm">Mendesak</p>
            </div>
        </div>
        <div class="bg-white p-4 md:p-6 rounded-xl shadow-sm flex items-center gap-4">
            <div class="w-14 h-14 md:w-16 md:h-16 bg-orange-100 rounded-xl flex items-center justify-center">
                <x-heroicon-s-clock class="w-8 h-8 md:w-10 md:h-10 text-orange-600" />
            </div>
            <div>
                <h3 class="text-2xl md:text-3xl font-bold text-purple-600">{{ $pendingCount }}</h3>
                <p class="text-gray-600 text-sm">Pending</p>
            </div>
        </div>
        <div class="bg-white p-4 md:p-6 rounded-xl shadow-sm flex items-center gap-4">
            <div class="w-14 h-14 md:w-16 md:h-16 bg-green-100 rounded-xl flex items-center justify-center">
                <x-heroicon-s-check-circle class="w-8 h-8 md:w-10 md:h-10 text-green-600" />
            </div>
            <div>
                <h3 class="text-2xl md:text-3xl font-bold text-purple-600">{{ $submittedCount }}</h3>
                <p class="text-gray-600 text-sm">Terkirim</p>
            </div>
        </div>
        <div class="bg-white p-4 md:p-6 rounded-xl shadow-sm flex items-center gap-4">
            <div class="w-14 h-14 md:w-16 md:h-16 bg-blue-100 rounded-xl flex items-center justify-center">
                <x-heroicon-s-chart-bar class="w-8 h-8 md:w-10 md:h-10 text-blue-600" />
            </div>
            <div>
                <h3 class="text-2xl md:text-3xl font-bold text-purple-600">{{ $gradedCount }}</h3>
                <p class="text-gray-600 text-sm">Dinilai</p>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white p-4 md:p-6 rounded-xl shadow-sm mb-8 flex flex-wrap gap-3">
        <button wire:click="filterAssignments('all')" class="px-5 py-2 rounded-full font-medium transition-all {{ $filter === 'all' ? 'bg-gradient-to-r from-purple-600 to-purple-800 text-white' : 'border-2 border-gray-200 text-gray-600 hover:border-purple-600 hover:text-purple-600' }}">
            Semua
        </button>
        <button wire:click="filterAssignments('urgent')" class="px-5 py-2 rounded-full font-medium transition-all {{ $filter === 'urgent' ? 'bg-gradient-to-r from-purple-600 to-purple-800 text-white' : 'border-2 border-gray-200 text-gray-600 hover:border-purple-600 hover:text-purple-600' }}">
            Mendesak
        </button>
        <button wire:click="filterAssignments('pending')" class="px-5 py-2 rounded-full font-medium transition-all {{ $filter === 'pending' ? 'bg-gradient-to-r from-purple-600 to-purple-800 text-white' : 'border-2 border-gray-200 text-gray-600 hover:border-purple-600 hover:text-purple-600' }}">
            Pending
        </button>
        <button wire:click="filterAssignments('submitted')" class="px-5 py-2 rounded-full font-medium transition-all {{ $filter === 'submitted' ? 'bg-gradient-to-r from-purple-600 to-purple-800 text-white' : 'border-2 border-gray-200 text-gray-600 hover:border-purple-600 hover:text-purple-600' }}">
            Terkirim
        </button>
        <button wire:click="filterAssignments('graded')" class="px-5 py-2 rounded-full font-medium transition-all {{ $filter === 'graded' ? 'bg-gradient-to-r from-purple-600 to-purple-800 text-white' : 'border-2 border-gray-200 text-gray-600 hover:border-purple-600 hover:text-purple-600' }}">
            Dinilai
        </button>
    </div>

    <!-- Assignments Container -->
    <div class="space-y-6">
        @forelse($assignments as $assignment)
        <div class="bg-white rounded-xl shadow-sm p-4 md:p-6 border-l-4 {{ $assignment['status'] === 'urgent' ? 'border-red-500' : ($assignment['status'] === 'graded' ? 'border-purple-600' : ($assignment['status'] === 'submitted' ? 'border-green-500' : 'border-orange-500')) }}">
            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4 mb-4">
                <div class="flex-1">
                    <h3 class="text-lg md:text-xl font-semibold text-gray-800 mb-2">{{ $assignment['title'] }}</h3>
                    <span class="inline-block px-3 py-1 bg-purple-100 text-purple-600 rounded-full text-xs font-semibold">
                        {{ $assignment['class_name'] }}
                    </span>
                </div>
                <span class="inline-block px-4 py-2 {{ $assignment['status'] === 'urgent' ? 'bg-red-100 text-red-600' : ($assignment['status'] === 'graded' ? 'bg-purple-100 text-purple-600' : ($assignment['status'] === 'submitted' ? 'bg-green-100 text-green-600' : 'bg-orange-100 text-orange-600')) }} rounded-full text-sm font-semibold whitespace-nowrap">
                    {{ $assignment['status'] === 'urgent' ? 'Mendesak' : ($assignment['status'] === 'graded' ? 'Dinilai' : ($assignment['status'] === 'submitted' ? 'Terkirim' : 'Pending')) }}
                </span>
            </div>

            <div class="flex flex-wrap gap-4 mb-4 text-sm">
                <div class="flex items-center gap-2 {{ $assignment['days_left'] <= 3 && $assignment['days_left'] >= 0 ? 'text-red-600' : 'text-gray-600' }} font-semibold">
                    <x-heroicon-s-clock class="w-4 h-4" />
                    <span>
                        @if($assignment['days_left'] < 0)
                            Terlambat {{ abs($assignment['days_left']) }} hari
                            @elseif($assignment['days_left']===0)
                            Deadline: Hari ini, {{ \Carbon\Carbon::parse($assignment['deadline'])->format('H:i') }}
                            @elseif($assignment['days_left']===1)
                            Deadline: Besok, {{ \Carbon\Carbon::parse($assignment['deadline'])->format('H:i') }}
                            @else
                            Deadline: {{ $assignment['days_left'] }} hari lagi, {{ \Carbon\Carbon::parse($assignment['deadline'])->format('H:i') }}
                            @endif
                            </span>
                </div>
                <div class="flex items-center gap-2 text-gray-600">
                    <x-heroicon-s-paper-clip class="w-4 h-4" />
                    <span>{{ ucfirst($assignment['submission_type']) }} Upload</span>
                </div>
            </div>

            @if($assignment['description'])
            <p class="text-gray-600 mb-4 leading-relaxed">{{ \Illuminate\Support\Str::limit($assignment['description'], 200) }}</p>
            @endif

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pt-4 border-t border-gray-200">
                <div class="flex items-center gap-2 text-gray-600 text-sm">
                    <x-heroicon-s-chart-bar class="w-4 h-4" />
                    <span>Bobot: {{ $assignment['weight_percentage'] }}%</span>
                </div>
                <div class="flex gap-2">
                    @if($assignment['status'] === 'graded')
                    <div class="flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-purple-600 to-purple-800 text-white rounded-full font-semibold">
                        <x-heroicon-s-trophy class="w-5 h-5" />
                        <span>Nilai: {{ $assignment['score'] }}/100</span>
                    </div>
                    <button class="px-4 py-2 bg-gray-100 text-purple-600 rounded-lg font-semibold hover:bg-gray-200 transition-colors">
                        Lihat Feedback
                    </button>
                    @elseif($assignment['status'] === 'submitted')
                    <button class="flex items-center justify-center gap-2 flex-1 sm:flex-initial px-4 py-2 bg-green-500 text-white rounded-lg font-semibold">
                        <x-heroicon-s-check-circle class="w-5 h-5" />
                        Sudah Dikirim
                    </button>
                    <button class="flex-1 sm:flex-initial px-4 py-2 bg-gray-100 text-purple-600 rounded-lg font-semibold hover:bg-gray-200 transition-colors">
                        Lihat Kiriman
                    </button>
                    @else
                    <!-- <a href="{{ route('mahasiswa.detail-kursus', $assignment['class_id']) }}" class="flex-1 sm:flex-initial px-4 py-2 bg-gradient-to-r from-purple-600 to-purple-800 text-white rounded-lg font-semibold hover:opacity-90 transition-opacity">
                        Upload Tugas
                    </a> -->
                    <a href="{{ route('mahasiswa.detail-kursus', $assignment['class_id']) }}" class="flex-1 sm:flex-initial px-4 py-2 bg-gray-100 text-purple-600 rounded-lg font-semibold hover:bg-gray-200 transition-colors">
                        Detail
                    </a>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-xl shadow-sm p-12 text-center">
            <div class="flex justify-center mb-4">
                <x-heroicon-s-clipboard-document-list class="w-16 h-16 text-gray-400" />
            </div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Tidak ada tugas</h3>
            <p class="text-gray-600">Belum ada tugas untuk ditampilkan</p>
        </div>
        @endforelse
    </div>
</div>