@extends('mahasiswa.app')

@section('title', 'Sertifikat - ' . $certificate->class->name)

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('sertifikat.index') }}"
            class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span class="font-medium">Kembali ke Sertifikat</span>
        </a>
    </div>

    <!-- Certificate Container -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden" id="certificate-container">
        <!-- Certificate Design -->
        <div class="relative bg-white p-8 md:p-12 lg:p-16" style="aspect-ratio: 1.414/1;">
            <!-- Decorative Border -->
            <div class="absolute inset-4 border-8 border-double border-purple-600 rounded-lg"></div>
            <div class="absolute inset-6 border-2 border-purple-300 rounded-lg"></div>

            <!-- Decorative Corners -->
            <div class="absolute top-8 left-8 w-16 h-16 border-t-4 border-l-4 border-purple-600 rounded-tl-lg"></div>
            <div class="absolute top-8 right-8 w-16 h-16 border-t-4 border-r-4 border-purple-600 rounded-tr-lg"></div>
            <div class="absolute bottom-8 left-8 w-16 h-16 border-b-4 border-l-4 border-purple-600 rounded-bl-lg"></div>
            <div class="absolute bottom-8 right-8 w-16 h-16 border-b-4 border-r-4 border-purple-600 rounded-br-lg"></div>

            <!-- Content -->
            <div class="relative z-10 h-full flex flex-col items-center justify-center text-center space-y-6">
                <!-- Logo/Badge -->
                <div class="w-20 h-20 bg-gradient-to-br from-purple-600 to-blue-600 rounded-full flex items-center justify-center shadow-lg">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                    </svg>
                </div>

                <!-- Title -->
                <div>
                    <h2 class="text-4xl md:text-5xl font-serif font-bold text-gray-800 tracking-wide">
                        CERTIFICATE
                    </h2>
                    <p class="text-lg text-gray-600 mt-2 tracking-widest">OF ACHIEVEMENT</p>
                </div>

                <!-- Divider -->
                <div class="w-24 h-1 bg-gradient-to-r from-transparent via-purple-600 to-transparent"></div>

                <!-- Text -->
                <div class="space-y-4">
                    <p class="text-gray-700 text-sm md:text-base">This is to certify that</p>
                    <h1 class="text-3xl md:text-4xl font-serif font-bold text-purple-900">
                        {{ $certificate->user->name }}
                    </h1>
                    <p class="text-gray-700 text-sm md:text-base">has successfully completed the course</p>
                    <h3 class="text-2xl md:text-3xl font-semibold text-gray-800 px-8">
                        {{ $certificate->class->title }}
                    </h3>
                </div>

                <!-- Grade Display -->
                <div class="flex items-center justify-center gap-8 py-4">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-purple-600">{{ $certificate->letter_grade }}</div>
                        <div class="text-sm text-gray-600 mt-1">Grade</div>
                    </div>
                    <div class="w-px h-16 bg-gray-300"></div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-blue-600">{{ number_format($certificate->grade_point, 2) }}</div>
                        <div class="text-sm text-gray-600 mt-1">GPA</div>
                    </div>
                    <div class="w-px h-16 bg-gray-300"></div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-green-600">{{ number_format($certificate->total_score, 2) }}</div>
                        <div class="text-sm text-gray-600 mt-1">Score</div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="pt-8 space-y-6 w-full">
                    <!-- Date -->
                    <p class="text-sm text-gray-600">
                        Issued on {{ \Carbon\Carbon::parse($certificate->published_at)->format('F d, Y') }}

                    </p>

                    <!-- Signatures -->
                    <div class="flex justify-around items-end px-8 md:px-16">
                        <!-- Instructor Signature -->
                        <div class="text-center">
                            <div class="border-t-2 border-gray-800 pt-2 px-8 mb-2">
                                <p class="font-semibold text-gray-800">{{ $certificate->class->instructor->name }}</p>
                            </div>
                            <p class="text-xs text-gray-600">Course Instructor</p>
                        </div>

                        <!-- Institution Signature -->
                        <div class="text-center">
                            <div class="border-t-2 border-gray-800 pt-2 px-8 mb-2">
                                <p class="font-semibold text-gray-800">EduLearn</p>
                            </div>
                            <p class="text-xs text-gray-600">Learning Platform</p>
                        </div>
                    </div>

                    <!-- Certificate ID -->
                    <p class="text-xs text-gray-500 tracking-wider">
                        Certificate ID: EDU-{{ str_pad($certificate->id, 8, '0', STR_PAD_LEFT) }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Score Breakdown -->
    <div class="mt-8 bg-white rounded-2xl shadow-sm p-6 md:p-8">
        <h3 class="text-xl font-bold text-gray-900 mb-6">Detail Penilaian</h3>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @if($certificate->assignment_score)
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-4 text-center">
                <div class="text-2xl font-bold text-blue-700">{{ number_format($certificate->assignment_score, 2) }}</div>
                <div class="text-xs text-gray-700 mt-1">Tugas</div>
            </div>
            @endif

            @if($certificate->quiz_score)
            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-4 text-center">
                <div class="text-2xl font-bold text-green-700">{{ number_format($certificate->quiz_score, 2) }}</div>
                <div class="text-xs text-gray-700 mt-1">Kuis</div>
            </div>
            @endif

            @if($certificate->midterm_score)
            <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl p-4 text-center">
                <div class="text-2xl font-bold text-yellow-700">{{ number_format($certificate->midterm_score, 2) }}</div>
                <div class="text-xs text-gray-700 mt-1">UTS</div>
            </div>
            @endif

            @if($certificate->final_score)
            <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-xl p-4 text-center">
                <div class="text-2xl font-bold text-red-700">{{ number_format($certificate->final_score, 2) }}</div>
                <div class="text-xs text-gray-700 mt-1">UAS</div>
            </div>
            @endif

            @if($certificate->project_score)
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-4 text-center">
                <div class="text-2xl font-bold text-purple-700">{{ number_format($certificate->project_score, 2) }}</div>
                <div class="text-xs text-gray-700 mt-1">Proyek</div>
            </div>
            @endif

            @if($certificate->participation_score)
            <div class="bg-gradient-to-br from-pink-50 to-pink-100 rounded-xl p-4 text-center">
                <div class="text-2xl font-bold text-pink-700">{{ number_format($certificate->participation_score, 2) }}</div>
                <div class="text-xs text-gray-700 mt-1">Partisipasi</div>
            </div>
            @endif
        </div>

        @if($certificate->notes)
        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
            <h4 class="font-semibold text-gray-900 mb-2">Catatan:</h4>
            <p class="text-gray-700 text-sm">{{ $certificate->notes }}</p>
        </div>
        @endif
    </div>

    <!-- Action Buttons -->
    <div class="mt-6 flex flex-col sm:flex-row gap-4">
        <!-- <a href="{{ route('sertifikat.unduh', $certificate->id) }}"
            class="flex-1 flex items-center justify-center gap-2 px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
            </svg>
            Unduh Sertifikat (PDF)
        </a> -->

        <button onclick="printCertificate()"
            class="flex-1 flex items-center justify-center gap-2 px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
            </svg>
            Cetak
        </button>

        <button onclick="shareCertificate()"
            class="flex items-center justify-center gap-2 px-6 py-3 bg-white border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
            </svg>
            Bagikan
        </button>
    </div>
</div>

@push('scripts')
<script>
    function printCertificate() {
        window.print();
    }

    function shareCertificate() {
        if (navigator.share) {
            navigator.share({
                title: 'Sertifikat - {{ $certificate->class->name }}',
                text: 'Saya telah menyelesaikan kursus {{ $certificate->class->name }} dengan nilai {{ $certificate->letter_grade }}!',
                url: window.location.href
            }).catch(err => console.log('Error sharing:', err));
        } else {
            // Fallback: Copy link to clipboard
            navigator.clipboard.writeText(window.location.href).then(() => {
                alert('Link sertifikat telah disalin ke clipboard!');
            });
        }
    }
</script>

<style>
    @media print {
        body * {
            visibility: hidden;
        }

        #certificate-container,
        #certificate-container * {
            visibility: visible;
        }

        #certificate-container {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
    }
</style>
@endpush
@endsection