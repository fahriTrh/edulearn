<div>
    <!-- Page Header -->
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Kelola Jadwal</h1>
            <p class="text-gray-600">Kelola jadwal kelas Anda</p>
        </div>
        <button wire:click="openModal" class="px-6 py-3 bg-gradient-to-r from-purple-600 to-purple-800 text-white rounded-lg font-semibold hover:shadow-lg transition-all">
            + Tambah Jadwal
        </button>
    </div>

    <!-- Schedules List -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-6">Daftar Jadwal</h2>
            
            <div class="space-y-4">
                @forelse($schedules as $schedule)
                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-all">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <h3 class="text-lg font-semibold text-gray-900">{{ $schedule['title'] }}</h3>
                                <span class="px-3 py-1 {{ $schedule['type'] === 'live_session' ? 'bg-blue-100 text-blue-600' : ($schedule['type'] === 'webinar' ? 'bg-green-100 text-green-600' : 'bg-orange-100 text-orange-600') }} rounded-full text-xs font-semibold">
                                    {{ ucfirst(str_replace('_', ' ', $schedule['type'])) }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-600 mb-2">
                                <span class="font-medium">{{ $schedule['class_name'] }}</span> ({{ $schedule['class_code'] }})
                            </p>
                            <div class="flex flex-wrap gap-4 text-sm text-gray-600">
                                <div class="flex items-center gap-1">
                                    <x-heroicon-s-clock class="w-4 h-4" />
                                    <span>{{ \Carbon\Carbon::parse($schedule['start_time'])->format('d M Y, H:i') }}</span>
                                    @if($schedule['end_time'])
                                        <span> - {{ \Carbon\Carbon::parse($schedule['end_time'])->format('H:i') }}</span>
                                    @endif
                                </div>
                                @if($schedule['location'])
                                    <div class="flex items-center gap-1">
                                        <x-heroicon-s-map-pin class="w-4 h-4" />
                                        <span>{{ $schedule['location'] }}</span>
                                    </div>
                                @endif
                                @if($schedule['is_online'] && $schedule['platform'])
                                    <div class="flex items-center gap-1">
                                        <x-heroicon-s-computer-desktop class="w-4 h-4" />
                                        <span>{{ $schedule['platform'] }}</span>
                                    </div>
                                @endif
                            </div>
                            @if($schedule['description'])
                                <p class="text-sm text-gray-600 mt-2">{{ Str::limit($schedule['description'], 100) }}</p>
                            @endif
                        </div>
                        <div class="flex gap-2">
                            <button wire:click="edit({{ $schedule['id'] }})" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg font-semibold hover:bg-gray-200 transition-colors">
                                Edit
                            </button>
                            <button wire:click="delete({{ $schedule['id'] }})" wire:confirm="Apakah Anda yakin ingin menghapus jadwal ini?" class="px-4 py-2 bg-red-100 text-red-600 rounded-lg font-semibold hover:bg-red-200 transition-colors">
                                Hapus
                            </button>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-12 text-gray-500">
                    <div class="flex justify-center mb-4">
                        <x-heroicon-s-calendar class="w-16 h-16 text-gray-400" />
                    </div>
                    <p>Belum ada jadwal</p>
                    <button wire:click="openModal" class="mt-4 px-6 py-2 bg-purple-600 text-white rounded-lg font-semibold hover:bg-purple-700 transition-colors">
                        Tambah Jadwal Pertama
                    </button>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Modal -->
    @if($showModal)
    <div class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4" wire:click="closeModal">
        <div class="bg-white rounded-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto p-6" wire:click.stop>
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900">{{ $editingId ? 'Edit Jadwal' : 'Tambah Jadwal' }}</h2>
                <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                    <x-heroicon-s-x-mark class="w-6 h-6" />
                </button>
            </div>

            <form wire:submit.prevent="save" class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Kelas *</label>
                    <select wire:model="class_id" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-purple-600 focus:outline-none">
                        <option value="">Pilih Kelas</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->code }} - {{ $class->title }}</option>
                        @endforeach
                    </select>
                    @error('class_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Judul Jadwal *</label>
                    <input type="text" wire:model="schedule_title" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-purple-600 focus:outline-none" placeholder="Contoh: Sesi Live Pemrograman Web">
                    @error('schedule_title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Deskripsi</label>
                    <textarea wire:model="description" rows="3" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-purple-600 focus:outline-none" placeholder="Deskripsi jadwal..."></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Tipe *</label>
                        <select wire:model="type" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-purple-600 focus:outline-none">
                            <option value="live_session">Live Session</option>
                            <option value="webinar">Webinar</option>
                            <option value="deadline">Deadline</option>
                            <option value="assignment">Assignment</option>
                        </select>
                        @error('type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">
                            <input type="checkbox" wire:model="is_online" class="mr-2">
                            Online
                        </label>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Waktu Mulai *</label>
                        <input type="datetime-local" wire:model="start_time" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-purple-600 focus:outline-none">
                        @error('start_time') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Waktu Selesai</label>
                        <input type="datetime-local" wire:model="end_time" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-purple-600 focus:outline-none">
                        @error('end_time') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                @if($is_online)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Platform</label>
                        <input type="text" wire:model="platform" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-purple-600 focus:outline-none" placeholder="Zoom, Google Meet, etc">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Meeting Link</label>
                        <input type="url" wire:model="meeting_link" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-purple-600 focus:outline-none" placeholder="https://...">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Meeting ID</label>
                        <input type="text" wire:model="meeting_id" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-purple-600 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Meeting Password</label>
                        <input type="text" wire:model="meeting_password" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-purple-600 focus:outline-none">
                    </div>
                </div>
                @else
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Lokasi</label>
                    <input type="text" wire:model="location" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-purple-600 focus:outline-none" placeholder="Lab Komputer 3, Ruang A301, etc">
                </div>
                @endif

                <div class="flex gap-3 pt-4">
                    <button type="submit" class="flex-1 px-6 py-3 bg-gradient-to-r from-purple-600 to-purple-800 text-white rounded-lg font-semibold hover:opacity-90 transition-opacity">
                        {{ $editingId ? 'Perbarui' : 'Simpan' }}
                    </button>
                    <button type="button" wire:click="closeModal" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg font-semibold hover:bg-gray-200 transition-colors">
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
