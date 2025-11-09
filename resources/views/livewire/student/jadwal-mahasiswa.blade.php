<div>
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Jadwal Pembelajaran</h1>
        <p class="text-gray-600">Kelola jadwal sesi live, webinar, dan deadline tugas Anda</p>
    </div>

    <!-- View Toggle -->
    <div class="bg-white rounded-xl shadow-sm p-4 mb-6 flex gap-2">
        <button wire:click="changeView('calendar')" class="px-6 py-2 rounded-full font-medium transition-all {{ $view === 'calendar' ? 'bg-gradient-to-r from-indigo-600 to-purple-700 text-white' : 'border-2 border-gray-200 text-gray-600 hover:border-indigo-600' }}">
            📅 Kalender
        </button>
        <button wire:click="changeView('list')" class="px-6 py-2 rounded-full font-medium transition-all {{ $view === 'list' ? 'bg-gradient-to-r from-indigo-600 to-purple-700 text-white' : 'border-2 border-gray-200 text-gray-600 hover:border-indigo-600' }}">
            📋 Daftar
        </button>
    </div>

    @if($view === 'calendar')
    <!-- Calendar View -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="text-center py-8 text-gray-500 text-sm">
            <p>Fitur kalender akan segera hadir</p>
            <p class="mt-2">Gunakan tampilan daftar untuk melihat jadwal Anda</p>
        </div>
    </div>
    @else
    <!-- List View -->
    <div class="space-y-6">
        @php
            $groupedEvents = $allEvents->groupBy(function($event) {
                if ($event['type'] === 'deadline') {
                    return \Carbon\Carbon::parse($event['deadline'])->format('Y-m-d');
                }
                return $event['start_time']->format('Y-m-d');
            });
        @endphp

        @forelse($groupedEvents as $date => $events)
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex justify-between items-center pb-4 mb-4 border-b-2 border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">
                    {{ \Carbon\Carbon::parse($date)->locale('id')->translatedFormat('l, d F Y') }}
                    @if($date === now()->format('Y-m-d'))
                        <span class="text-indigo-600">• Hari Ini</span>
                    @endif
                </h2>
            </div>

            <div class="space-y-4">
                @foreach($events as $event)
                <div class="border-l-4 {{ $event['type'] === 'deadline' ? 'border-pink-400' : ($event['type'] === 'webinar' ? 'border-green-400' : 'border-indigo-600') }} bg-white rounded-lg p-4 shadow-sm hover:translate-x-1 hover:shadow-md transition-all">
                    <div class="flex items-center gap-2 {{ $event['type'] === 'deadline' ? 'text-pink-500' : ($event['type'] === 'webinar' ? 'text-green-600' : 'text-indigo-600') }} font-semibold text-sm mb-2">
                        <span>{{ $event['type'] === 'deadline' ? '⏰' : '🕐' }}</span>
                        <span>
                            @if($event['type'] === 'deadline')
                                Deadline: {{ \Carbon\Carbon::parse($event['deadline'])->format('H:i') }} WIB
                            @else
                                {{ \Carbon\Carbon::parse($event['start_time'])->format('H:i') }} - {{ $event['end_time'] ? \Carbon\Carbon::parse($event['end_time'])->format('H:i') : '' }} WIB
                            @endif
                        </span>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">
                        @if($event['type'] === 'deadline')
                            Deadline: {{ $event['title'] }}
                        @else
                            {{ $event['type'] === 'webinar' ? 'Webinar: ' : 'Sesi Live: ' }}{{ $event['class_name'] }}
                        @endif
                    </h3>
                    <div class="flex flex-wrap gap-4 text-sm text-gray-600 mb-3">
                        <div class="flex items-center gap-1">
                            <span>📚</span>
                            <span>{{ $event['class_name'] }}</span>
                        </div>
                        @if($event['type'] !== 'deadline')
                            @if($event['is_online'])
                                <div class="flex items-center gap-1">
                                    <span>📹</span>
                                    <span>{{ $event['platform'] ?? 'Online' }}</span>
                                </div>
                            @else
                                <div class="flex items-center gap-1">
                                    <span>📍</span>
                                    <span>{{ $event['location'] ?? 'Offline' }}</span>
                                </div>
                            @endif
                        @endif
                    </div>
                    <span class="inline-block px-3 py-1 {{ $event['type'] === 'deadline' ? 'bg-red-100 text-red-600' : ($event['type'] === 'webinar' ? 'bg-green-100 text-green-600' : 'bg-blue-100 text-blue-600') }} rounded-full text-xs font-semibold mb-2">
                        {{ $event['type'] === 'deadline' ? 'Deadline' : ($event['type'] === 'webinar' ? 'Webinar' : 'Live Session') }}
                    </span>
                    @if($event['type'] !== 'deadline' && $event['meeting_link'])
                        <a href="{{ $event['meeting_link'] }}" target="_blank" class="block w-full md:w-auto mt-2 px-6 py-2 bg-gradient-to-r from-indigo-600 to-purple-700 text-white rounded-lg font-semibold hover:shadow-lg transition-all">
                            {{ $event['type'] === 'webinar' ? 'Daftar Webinar' : 'Gabung Sekarang' }}
                        </a>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @empty
        <div class="bg-white rounded-xl shadow-sm p-12 text-center">
            <div class="text-6xl mb-4">📅</div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Tidak ada jadwal</h3>
            <p class="text-gray-600">Belum ada jadwal untuk ditampilkan</p>
        </div>
        @endforelse
    </div>
    @endif
</div>
