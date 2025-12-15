<div class="space-y-6">
    {{-- Info Card --}}
    <div class="bg-indigo-50 border border-indigo-100 rounded-xl p-6">
        <div class="flex items-start gap-4">
            <div class="bg-indigo-100 p-2 rounded-lg text-indigo-600">
                <x-heroicon-m-information-circle class="w-6 h-6" />
            </div>
            <div>
                <h3 class="font-bold text-indigo-900">Pusat Laporan</h3>
                <p class="text-indigo-700 mt-1">
                    Silakan unduh laporan dalam format CSV untuk analisis lebih lanjut menggunakan Excel/Google Sheets, 
                    atau gunakan fitur Cetak untuk dokumen fisik/PDF siap cetak.
                </p>
            </div>
        </div>
    </div>

    {{-- Reports Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        {{-- Card 1: Mahasiswa --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
            <div class="p-6">
                <div class="w-14 h-14 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center mb-4">
                    <x-heroicon-s-users class="w-8 h-8" />
                </div>
                <h3 class="text-lg font-bold text-gray-900">Laporan Mahasiswa</h3>
                <p class="text-gray-500 text-sm mt-1">Data lengkap seluruh mahasiswa terdaftar termasuk tanggal bergabung dan aktivitas.</p>
                
                <div class="mt-6 flex flex-col gap-3">
                    <a href="{{ route('admin.laporan.mahasiswa') }}" class="flex items-center justify-center gap-2 w-full py-2.5 px-4 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium transition-colors">
                        <x-heroicon-m-document-arrow-down class="w-5 h-5" />
                        Unduh CSV
                    </a>
                    <a href="{{ route('admin.laporan.mahasiswa.print') }}" target="_blank" class="flex items-center justify-center gap-2 w-full py-2.5 px-4 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium transition-colors">
                        <x-heroicon-m-printer class="w-5 h-5" />
                        Cetak PDF
                    </a>
                </div>
            </div>
        </div>

        {{-- Card 2: Instruktur --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
            <div class="p-6">
                <div class="w-14 h-14 bg-green-100 text-green-600 rounded-xl flex items-center justify-center mb-4">
                    <x-heroicon-s-academic-cap class="w-8 h-8" />
                </div>
                <h3 class="text-lg font-bold text-gray-900">Laporan Dosen</h3>
                <p class="text-gray-500 text-sm mt-1">Data instruktur beserta statistik jumlah kelas yang diampu.</p>
                
                <div class="mt-6 flex flex-col gap-3">
                    <a href="{{ route('admin.laporan.instruktur') }}" class="flex items-center justify-center gap-2 w-full py-2.5 px-4 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium transition-colors">
                        <x-heroicon-m-document-arrow-down class="w-5 h-5" />
                        Unduh CSV
                    </a>
                    <a href="{{ route('admin.laporan.instruktur.print') }}" target="_blank" class="flex items-center justify-center gap-2 w-full py-2.5 px-4 bg-green-600 text-white rounded-lg hover:bg-green-700 font-medium transition-colors">
                        <x-heroicon-m-printer class="w-5 h-5" />
                        Cetak PDF
                    </a>
                </div>
            </div>
        </div>

        {{-- Card 3: Kelas --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
            <div class="p-6">
                <div class="w-14 h-14 bg-orange-100 text-orange-600 rounded-xl flex items-center justify-center mb-4">
                    <x-heroicon-s-book-open class="w-8 h-8" />
                </div>
                <h3 class="text-lg font-bold text-gray-900">Laporan Kelas</h3>
                <p class="text-gray-500 text-sm mt-1">Daftar semua kelas aktif dengan detail pendaftaran mahasiswa.</p>
                
                <div class="mt-6 flex flex-col gap-3">
                    <a href="{{ route('admin.laporan.kelas') }}" class="flex items-center justify-center gap-2 w-full py-2.5 px-4 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium transition-colors">
                        <x-heroicon-m-document-arrow-down class="w-5 h-5" />
                        Unduh CSV
                    </a>
                    <a href="{{ route('admin.laporan.kelas.print') }}" target="_blank" class="flex items-center justify-center gap-2 w-full py-2.5 px-4 bg-orange-600 text-white rounded-lg hover:bg-orange-700 font-medium transition-colors">
                        <x-heroicon-m-printer class="w-5 h-5" />
                        Cetak PDF
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>
