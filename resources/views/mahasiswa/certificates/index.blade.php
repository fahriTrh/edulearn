@extends('mahasiswa.app')

@section('title', 'Sertifikat')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Sertifikat Saya</h1>
        <p class="text-gray-600 mt-2">Koleksi sertifikat dari kursus yang telah Anda selesaikan</p>
    </div>

    @if($certificates->isEmpty())
    <!-- Empty State -->
    <div class="bg-white rounded-2xl shadow-sm p-12 text-center">
        <div class="w-24 h-24 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-12 h-12 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
        </div>
        <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Sertifikat</h3>
        <p class="text-gray-600 mb-6">Selesaikan kursus untuk mendapatkan sertifikat</p>
        <a href="{{ route('mahasiswa.kursus') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
            Lihat Kursus
        </a>
    </div>
    @else
    <!-- Certificates Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($certificates as $cert)
        <div class="bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden group">
            <!-- Certificate Preview -->
            <div class="relative bg-gradient-to-br from-purple-50 to-blue-50 p-6 h-48 flex items-center justify-center">
                <div class="text-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-600 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                        </svg>
                    </div>
                    <div class="text-sm font-semibold text-gray-700">CERTIFICATE</div>
                    <div class="text-xs text-gray-600 mt-1">of Achievement</div>
                </div>

                <!-- Grade Badge -->
                <div class="absolute top-4 right-4 px-3 py-1 rounded-full text-xs font-bold {{ $cert->letter_grade === 'A' ? 'bg-green-100 text-green-700' : ($cert->letter_grade === 'B' || $cert->letter_grade === 'B+' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-700') }}">
                    Grade {{ $cert->letter_grade }}
                </div>
            </div>

            <!-- Certificate Info -->
            <div class="p-6">
                <h3 class="font-bold text-lg text-gray-900 mb-2 line-clamp-2 group-hover:text-purple-600 transition-colors">
                    {{ $cert->class->title }}
                </h3>

                <div class="flex items-center gap-2 text-sm text-gray-600 mb-4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span>{{ $cert->class->instructor->name }}</span>
                </div>

                <!-- Score Info -->
                <div class="flex items-center justify-between mb-4 p-3 bg-gray-50 rounded-lg">
                    <div class="text-center flex-1">
                        <div class="text-2xl font-bold text-purple-600">{{ number_format($cert->total_score, 2) }}</div>
                        <div class="text-xs text-gray-600 mt-1">Nilai Akhir</div>
                    </div>
                    <div class="w-px h-12 bg-gray-300"></div>
                    <div class="text-center flex-1">
                        <div class="text-2xl font-bold text-blue-600">{{ number_format($cert->grade_point, 2) }}</div>
                        <div class="text-xs text-gray-600 mt-1">Grade Point</div>
                    </div>
                </div>

                <div class="text-xs text-gray-500 mb-4">
                    <div class="flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Diterbitkan: {{ \Carbon\Carbon::parse($cert->published_at)->format('d M Y') }}
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-2">
                    <a href="{{ route('sertifikat.lihat', $cert->id) }}"
                        class="flex-1 flex items-center justify-center gap-2 px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors text-sm font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Lihat
                    </a>
                    <!-- <a href="{{ route('sertifikat.unduh', $cert->id) }}"
                        class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors text-sm font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                    </a> -->
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $certificates->links() }}
    </div>
    @endif
</div>
@endsection