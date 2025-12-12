<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\FinalGrade;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{
    /**
     * Display a listing of certificates.
     */
    public function index()
    {
        $certificates = FinalGrade::with(['class.instructor', 'user'])
            ->where('user_id', Auth::id())
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('total_score', '>=', 70) // ⬅️ Tambahkan ini
            ->orderBy('published_at', 'desc')
            ->paginate(9);


        return view('mahasiswa.certificates.index', compact('certificates'));
    }

    /**
     * Display the specified certificate.
     */
    public function show($id)
    {
        $certificate = FinalGrade::with(['class.instructor', 'user'])
            ->where('user_id', Auth::id())
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->findOrFail($id);

        return view('mahasiswa.certificates.show', compact('certificate'));
    }

    /**
     * Download certificate as PDF.
     */
    public function download($id)
    {
        $certificate = FinalGrade::with(['class.instructor', 'user'])
            ->where('user_id', Auth::id())
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->findOrFail($id);

        $pdf = Pdf::loadView('mahasiswa.certificates.pdf', compact('certificate'))
            ->setPaper('a4', 'landscape')
            ->setOption('margin-top', 0)
            ->setOption('margin-bottom', 0)
            ->setOption('margin-left', 0)
            ->setOption('margin-right', 0);

        $filename = 'Certificate-' . str_replace(' ', '-', $certificate->class->name) . '-' . $certificate->user->name . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Verify certificate authenticity.
     */
    public function verify($certificateId)
    {
        $certificate = FinalGrade::with(['class.instructor', 'user'])
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('id', $certificateId)
            ->first();

        if (!$certificate) {
            return view('mahasiswa.certificates.verify', [
                'valid' => false,
                'message' => 'Sertifikat tidak ditemukan atau belum dipublikasikan.'
            ]);
        }

        return view('mahasiswa.certificates.verify', [
            'valid' => true,
            'certificate' => $certificate,
            'message' => 'Sertifikat valid dan terverifikasi.'
        ]);
    }
}
