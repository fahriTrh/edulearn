@extends('mahasiswa.app')

@section('title', 'Jadwal')

@section('content')
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Jadwal Pembelajaran</h1>
        <p class="text-gray-600">Kelola jadwal sesi live, webinar, dan deadline tugas Anda</p>
    </div>

    <!-- View Toggle -->
    <div class="bg-white rounded-xl shadow-sm p-4 mb-6 flex gap-2">
        <button onclick="changeView('calendar')" class="view-btn px-6 py-2 rounded-full font-medium transition-all bg-gradient-to-r from-indigo-600 to-purple-700 text-white">
            📅 Kalender
        </button>
        <button onclick="changeView('list')" class="view-btn px-6 py-2 rounded-full font-medium transition-all border-2 border-gray-200 text-gray-600 hover:border-indigo-600">
            📋 Daftar
        </button>
    </div>

    <!-- Calendar Header -->
    <div class="bg-white rounded-xl shadow-sm p-6 mb-6 flex flex-col md:flex-row justify-between items-center gap-4">
        <div class="flex items-center gap-4">
            <button class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center hover:bg-indigo-600 hover:text-white transition-colors">
                ◀
            </button>
            <div class="text-xl font-semibold text-gray-900">November 2024</div>
            <button class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center hover:bg-indigo-600 hover:text-white transition-colors">
                ▶
            </button>
        </div>
        <button class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-purple-700 text-white rounded-full font-semibold hover:shadow-lg transition-all">
            Hari Ini
        </button>
    </div>

    <!-- Calendar View -->
    <div id="calendarView" class="bg-white rounded-xl shadow-sm p-6">
        <div class="grid grid-cols-7 gap-2">
            <!-- Day Headers -->
            <div class="text-center py-4 font-semibold text-indigo-600 border-b-2 border-gray-200">Min</div>
            <div class="text-center py-4 font-semibold text-indigo-600 border-b-2 border-gray-200">Sen</div>
            <div class="text-center py-4 font-semibold text-indigo-600 border-b-2 border-gray-200">Sel</div>
            <div class="text-center py-4 font-semibold text-indigo-600 border-b-2 border-gray-200">Rab</div>
            <div class="text-center py-4 font-semibold text-indigo-600 border-b-2 border-gray-200">Kam</div>
            <div class="text-center py-4 font-semibold text-indigo-600 border-b-2 border-gray-200">Jum</div>
            <div class="text-center py-4 font-semibold text-indigo-600 border-b-2 border-gray-200">Sab</div>

            <!-- Calendar Days -->
            <div class="min-h-[120px] border border-gray-200 rounded-lg p-2 opacity-30">
                <div class="font-semibold mb-2">30</div>
            </div>
            <div class="min-h-[120px] border border-gray-200 rounded-lg p-2 opacity-30">
                <div class="font-semibold mb-2">31</div>
            </div>
            <div class="min-h-[120px] border border-gray-200 rounded-lg p-2 hover:bg-gray-50 hover:border-indigo-600 transition-all cursor-pointer">
                <div class="font-semibold mb-2">1</div>
            </div>
            <div class="min-h-[120px] border border-gray-200 rounded-lg p-2 hover:bg-gray-50 hover:border-indigo-600 transition-all cursor-pointer">
                <div class="font-semibold mb-2">2</div>
                <div class="bg-gradient-to-r from-indigo-600 to-purple-700 text-white text-xs px-2 py-1 rounded mb-1 truncate">Live: Web Dev</div>
                <div class="bg-gradient-to-r from-blue-400 to-cyan-400 text-white text-xs px-2 py-1 rounded truncate">Webinar AI</div>
            </div>
            <div class="min-h-[120px] border border-gray-200 rounded-lg p-2 hover:bg-gray-50 hover:border-indigo-600 transition-all cursor-pointer">
                <div class="font-semibold mb-2">3</div>
                <div class="bg-gradient-to-r from-indigo-600 to-purple-700 text-white text-xs px-2 py-1 rounded truncate">Live: ML Dasar</div>
            </div>
            <div class="min-h-[120px] border border-gray-200 rounded-lg p-2 hover:bg-gray-50 hover:border-indigo-600 transition-all cursor-pointer">
                <div class="font-semibold mb-2">4</div>
            </div>
            <div class="min-h-[120px] border border-gray-200 rounded-lg p-2 hover:bg-gray-50 hover:border-indigo-600 transition-all cursor-pointer">
                <div class="font-semibold mb-2">5</div>
            </div>

            <div class="min-h-[120px] border border-gray-200 rounded-lg p-2 hover:bg-gray-50 hover:border-indigo-600 transition-all cursor-pointer">
                <div class="font-semibold mb-2">6</div>
            </div>
            <div class="min-h-[120px] border border-gray-200 rounded-lg p-2 hover:bg-gray-50 hover:border-indigo-600 transition-all cursor-pointer">
                <div class="font-semibold mb-2">7</div>
                <div class="bg-gradient-to-r from-indigo-600 to-purple-700 text-white text-xs px-2 py-1 rounded truncate">Live: UI/UX</div>
            </div>
            <div class="min-h-[120px] border border-indigo-600 bg-indigo-50 rounded-lg p-2 cursor-pointer">
                <div class="font-semibold mb-2">8</div>
                <div class="bg-gradient-to-r from-indigo-600 to-purple-700 text-white text-xs px-2 py-1 rounded mb-1 truncate">Live: Web Dev</div>
                <div class="bg-gradient-to-r from-pink-400 to-yellow-400 text-white text-xs px-2 py-1 rounded truncate">Deadline: Tugas</div>
            </div>
            <div class="min-h-[120px] border border-gray-200 rounded-lg p-2 hover:bg-gray-50 hover:border-indigo-600 transition-all cursor-pointer">
                <div class="font-semibold mb-2">9</div>
                <div class="bg-gradient-to-r from-green-400 to-cyan-400 text-white text-xs px-2 py-1 rounded truncate">Workshop DB</div>
            </div>
            <div class="min-h-[120px] border border-gray-200 rounded-lg p-2 hover:bg-gray-50 hover:border-indigo-600 transition-all cursor-pointer">
                <div class="font-semibold mb-2">10</div>
                <div class="bg-gradient-to-r from-pink-400 to-yellow-400 text-white text-xs px-2 py-1 rounded truncate">Deadline: ML</div>
            </div>
            <div class="min-h-[120px] border border-gray-200 rounded-lg p-2 hover:bg-gray-50 hover:border-indigo-600 transition-all cursor-pointer">
                <div class="font-semibold mb-2">11</div>
            </div>
            <div class="min-h-[120px] border border-gray-200 rounded-lg p-2 hover:bg-gray-50 hover:border-indigo-600 transition-all cursor-pointer">
                <div class="font-semibold mb-2">12</div>
            </div>

            <!-- Repeat for more weeks -->
            <div class="min-h-[120px] border border-gray-200 rounded-lg p-2 hover:bg-gray-50 hover:border-indigo-600 transition-all cursor-pointer">
                <div class="font-semibold mb-2">13</div>
            </div>
            <div class="min-h-[120px] border border-gray-200 rounded-lg p-2 hover:bg-gray-50 hover:border-indigo-600 transition-all cursor-pointer">
                <div class="font-semibold mb-2">14</div>
                <div class="bg-gradient-to-r from-indigo-600 to-purple-700 text-white text-xs px-2 py-1 rounded truncate">Live: UI/UX</div>
            </div>
            <div class="min-h-[120px] border border-gray-200 rounded-lg p-2 hover:bg-gray-50 hover:border-indigo-600 transition-all cursor-pointer">
                <div class="font-semibold mb-2">15</div>
                <div class="bg-gradient-to-r from-indigo-600 to-purple-700 text-white text-xs px-2 py-1 rounded truncate">Live: Web Dev</div>
            </div>
            <div class="min-h-[120px] border border-gray-200 rounded-lg p-2 hover:bg-gray-50 hover:border-indigo-600 transition-all cursor-pointer">
                <div class="font-semibold mb-2">16</div>
                <div class="bg-gradient-to-r from-green-400 to-cyan-400 text-white text-xs px-2 py-1 rounded truncate">Webinar DevOps</div>
            </div>
            <div class="min-h-[120px] border border-gray-200 rounded-lg p-2 hover:bg-gray-50 hover:border-indigo-600 transition-all cursor-pointer">
                <div class="font-semibold mb-2">17</div>
                <div class="bg-gradient-to-r from-indigo-600 to-purple-700 text-white text-xs px-2 py-1 rounded truncate">Live: ML</div>
            </div>
            <div class="min-h-[120px] border border-gray-200 rounded-lg p-2 hover:bg-gray-50 hover:border-indigo-600 transition-all cursor-pointer">
                <div class="font-semibold mb-2">18</div>
            </div>
            <div class="min-h-[120px] border border-gray-200 rounded-lg p-2 hover:bg-gray-50 hover:border-indigo-600 transition-all cursor-pointer">
                <div class="font-semibold mb-2">19</div>
            </div>

            <!-- More days... -->
            <div class="min-h-[120px] border border-gray-200 rounded-lg p-2 hover:bg-gray-50 hover:border-indigo-600 transition-all cursor-pointer">
                <div class="font-semibold mb-2">20</div>
            </div>
            <div class="min-h-[120px] border border-gray-200 rounded-lg p-2 hover:bg-gray-50 hover:border-indigo-600 transition-all cursor-pointer">
                <div class="font-semibold mb-2">21</div>
                <div class="bg-gradient-to-r from-indigo-600 to-purple-700 text-white text-xs px-2 py-1 rounded truncate">Live: UI/UX</div>
            </div>
            <div class="min-h-[120px] border border-gray-200 rounded-lg p-2 hover:bg-gray-50 hover:border-indigo-600 transition-all cursor-pointer">
                <div class="font-semibold mb-2">22</div>
                <div class="bg-gradient-to-r from-indigo-600 to-purple-700 text-white text-xs px-2 py-1 rounded mb-1 truncate">Live: Web Dev</div>
                <div class="bg-gradient-to-r from-pink-400 to-yellow-400 text-white text-xs px-2 py-1 rounded truncate">Deadline Quiz</div>
            </div>
            <div class="min-h-[120px] border border-gray-200 rounded-lg p-2 hover:bg-gray-50 hover:border-indigo-600 transition-all cursor-pointer">
                <div class="font-semibold mb-2">23</div>
                <div class="bg-gradient-to-r from-green-400 to-cyan-400 text-white text-xs px-2 py-1 rounded truncate">Webinar Security</div>
            </div>
            <div class="min-h-[120px] border border-gray-200 rounded-lg p-2 hover:bg-gray-50 hover:border-indigo-600 transition-all cursor-pointer">
                <div class="font-semibold mb-2">24</div>
            </div>
            <div class="min-h-[120px] border border-gray-200 rounded-lg p-2 hover:bg-gray-50 hover:border-indigo-600 transition-all cursor-pointer">
                <div class="font-semibold mb-2">25</div>
            </div>
            <div class="min-h-[120px] border border-gray-200 rounded-lg p-2 hover:bg-gray-50 hover:border-indigo-600 transition-all cursor-pointer">
                <div class="font-semibold mb-2">26</div>
            </div>

            <!-- Last week -->
            <div class="min-h-[120px] border border-gray-200 rounded-lg p-2 hover:bg-gray-50 hover:border-indigo-600 transition-all cursor-pointer">
                <div class="font-semibold mb-2">27</div>
            </div>
            <div class="min-h-[120px] border border-gray-200 rounded-lg p-2 hover:bg-gray-50 hover:border-indigo-600 transition-all cursor-pointer">
                <div class="font-semibold mb-2">28</div>
                <div class="bg-gradient-to-r from-indigo-600 to-purple-700 text-white text-xs px-2 py-1 rounded truncate">Live: UI/UX</div>
            </div>
            <div class="min-h-[120px] border border-gray-200 rounded-lg p-2 hover:bg-gray-50 hover:border-indigo-600 transition-all cursor-pointer">
                <div class="font-semibold mb-2">29</div>
                <div class="bg-gradient-to-r from-indigo-600 to-purple-700 text-white text-xs px-2 py-1 rounded truncate">Live: Web Dev</div>
            </div>
            <div class="min-h-[120px] border border-gray-200 rounded-lg p-2 hover:bg-gray-50 hover:border-indigo-600 transition-all cursor-pointer">
                <div class="font-semibold mb-2">30</div>
                <div class="bg-gradient-to-r from-green-400 to-cyan-400 text-white text-xs px-2 py-1 rounded truncate">Webinar Cloud</div>
            </div>
            <div class="min-h-[120px] border border-gray-200 rounded-lg p-2 opacity-30">
                <div class="font-semibold mb-2">1</div>
            </div>
            <div class="min-h-[120px] border border-gray-200 rounded-lg p-2 opacity-30">
                <div class="font-semibold mb-2">2</div>
            </div>
            <div class="min-h-[120px] border border-gray-200 rounded-lg p-2 opacity-30">
                <div class="font-semibold mb-2">3</div>
            </div>
        </div>
    </div>

    <!-- List View -->
    <div id="listView" class="hidden space-y-6">
        <!-- Day Section 1 -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex justify-between items-center pb-4 mb-4 border-b-2 border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">Kamis, 7 November 2024</h2>
            </div>

            <div class="space-y-4">
                <div class="border-l-4 border-indigo-600 bg-white rounded-lg p-4 shadow-sm hover:translate-x-1 hover:shadow-md transition-all cursor-pointer">
                    <div class="flex items-center gap-2 text-indigo-600 font-semibold text-sm mb-2">
                        <span>🕐</span>
                        <span>08:00 - 10:00 WIB</span>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Sesi Live: Pemrograman Web Lanjut</h3>
                    <div class="flex flex-wrap gap-4 text-sm text-gray-600 mb-3">
                        <div class="flex items-center gap-1">
                            <span>👨‍🏫</span>
                            <span>Dr. Budi Santoso</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <span>📹</span>
                            <span>Zoom Meeting</span>
                        </div>
                    </div>
                    <span class="inline-block px-3 py-1 bg-blue-100 text-blue-600 rounded-full text-xs font-semibold mb-2">Live Session</span>
                    <button class="block w-full md:w-auto px-6 py-2 bg-gradient-to-r from-indigo-600 to-purple-700 text-white rounded-lg font-semibold hover:shadow-lg transition-all">
                        Gabung Sekarang
                    </button>
                </div>
            </div>
        </div>

        <!-- Day Section 2 - Today -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex justify-between items-center pb-4 mb-4 border-b-2 border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">Jumat, 8 November 2024 <span class="text-indigo-600">• Hari Ini</span></h2>
            </div>

            <div class="space-y-4">
                <div class="border-l-4 border-indigo-600 bg-white rounded-lg p-4 shadow-sm hover:translate-x-1 hover:shadow-md transition-all cursor-pointer">
                    <div class="flex items-center gap-2 text-indigo-600 font-semibold text-sm mb-2">
                        <span>🕐</span>
                        <span>08:00 - 10:00 WIB</span>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Sesi Live: Pemrograman Web Lanjut</h3>
                    <div class="flex flex-wrap gap-4 text-sm text-gray-600 mb-3">
                        <div class="flex items-center gap-1">
                            <span>👨‍🏫</span>
                            <span>Dr. Budi Santoso</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <span>📹</span>
                            <span>Zoom Meeting</span>
                        </div>
                    </div>
                    <span class="inline-block px-3 py-1 bg-blue-100 text-blue-600 rounded-full text-xs font-semibold mb-2">Live Session</span>
                    <button class="block w-full md:w-auto px-6 py-2 bg-gradient-to-r from-indigo-600 to-purple-700 text-white rounded-lg font-semibold hover:shadow-lg transition-all">
                        Gabung Sekarang
                    </button>
                </div>

                <div class="border-l-4 border-pink-400 bg-white rounded-lg p-4 shadow-sm hover:translate-x-1 hover:shadow-md transition-all cursor-pointer">
                    <div class="flex items-center gap-2 text-pink-500 font-semibold text-sm mb-2">
                        <span>⏰</span>
                        <span>Deadline: 23:59 WIB</span>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Deadline: Project Website E-Commerce</h3>
                    <div class="flex flex-wrap gap-4 text-sm text-gray-600 mb-3">
                        <div class="flex items-center gap-1">
                            <span>📋</span>
                            <span>Tugas Akhir</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <span>💻</span>
                            <span>Pemrograman Web Lanjut</span>
                        </div>
                    </div>
                    <span class="inline-block px-3 py-1 bg-red-100 text-red-600 rounded-full text-xs font-semibold">Deadline Hari Ini</span>
                </div>
            </div>
        </div>

        <!-- Day Section 3 -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex justify-between items-center pb-4 mb-4 border-b-2 border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">Sabtu, 9 November 2024</h2>
            </div>

            <div class="space-y-4">
                <div class="border-l-4 border-green-400 bg-white rounded-lg p-4 shadow-sm hover:translate-x-1 hover:shadow-md transition-all cursor-pointer">
                    <div class="flex items-center gap-2 text-green-600 font-semibold text-sm mb-2">
                        <span>🕐</span>
                        <span>14:00 - 16:00 WIB</span>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Workshop: Database Design Best Practices</h3>
                    <div class="flex flex-wrap gap-4 text-sm text-gray-600 mb-3">
                        <div class="flex items-center gap-1">
                            <span>👨‍🏫</span>
                            <span>Ir. Joko Widodo, M.T</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <span>🌐</span>
                            <span>Microsoft Teams</span>
                        </div>
                    </div>
                    <span class="inline-block px-3 py-1 bg-green-100 text-green-600 rounded-full text-xs font-semibold mb-2">Workshop</span>
                    <button class="block w-full md:w-auto px-6 py-2 bg-gradient-to-r from-indigo-600 to-purple-700 text-white rounded-lg font-semibold hover:shadow-lg transition-all">
                        Daftar Workshop
                    </button>
                </div>
            </div>
        </div>

        <!-- Day Section 4 -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex justify-between items-center pb-4 mb-4 border-b-2 border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">Minggu, 10 November 2024</h2>
            </div>

            <div class="space-y-4">
                <div class="border-l-4 border-pink-400 bg-white rounded-lg p-4 shadow-sm hover:translate-x-1 hover:shadow-md transition-all cursor-pointer">
                    <div class="flex items-center gap-2 text-pink-500 font-semibold text-sm mb-2">
                        <span>⏰</span>
                        <span>Deadline: 23:59 WIB</span>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Deadline: Tugas Machine Learning</h3>
                    <div class="flex flex-wrap gap-4 text-sm text-gray-600 mb-3">
                        <div class="flex items-center gap-1">
                            <span>📝</span>
                            <span>Tugas Praktikum</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <span>🤖</span>
                            <span>Machine Learning Dasar</span>
                        </div>
                    </div>
                    <span class="inline-block px-3 py-1 bg-red-100 text-red-600 rounded-full text-xs font-semibold">Deadline</span>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function changeView(view) {
        const calendarView = document.getElementById('calendarView');
        const listView = document.getElementById('listView');
        const btns = document.querySelectorAll('.view-btn');
        
        btns.forEach(btn => {
            btn.classList.remove('bg-gradient-to-r', 'from-indigo-600', 'to-purple-700', 'text-white');
            btn.classList.add('border-2', 'border-gray-200', 'text-gray-600');
        });
        
        event.target.classList.remove('border-2', 'border-gray-200', 'text-gray-600');
        event.target.classList.add('bg-gradient-to-r', 'from-indigo-600', 'to-purple-700', 'text-white');
        
        if (view === 'calendar') {
            calendarView.classList.remove('hidden');
            listView.classList.add('hidden');
        } else {
            calendarView.classList.add('hidden');
            listView.classList.remove('hidden');
        }
    }
</script>
@endpush