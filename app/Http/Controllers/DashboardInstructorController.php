<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class DashboardInstructorController extends Controller
{
    public function index()
    {
        $title = 'Dashboard Instruktur';
        $sub_title = 'Anda memiliki 5 tugas yang perlu dinilai';
        $instructor_name = Auth::user()->name;

        return view('dosen.dashboard-dosen', [
            'title' => $title,
            'instructor_name' => $instructor_name,
            'sub_title' => $sub_title,
        ]);
    }

    public function kelasSaya()
    {
        $title = 'Kelas Saya';
        $sub_title = 'Kelola semua kelas yang Anda ajar';
        $instructor_name = Auth::user()->name;

        try {
            $classes = ClassModel::withCount(['materials', 'assignments'])
                ->where('instructor_id', Auth::user()->instructor->id)
                ->get()
                ->map(function ($class) {
                    return [
                        'id' => $class->id,
                        'name' => $class->title,
                        'code' => $class->code,
                        'desc' => $class->description,
                        'students' => 0, // belum pakai tabel relasi mahasiswa
                        'materials' => $class->materials_count,
                        'assignments' => $class->assignments_count,
                        'semester' => $class->semester,
                        'status' => $class->status,
                        'color' => collect(['blue', 'green', 'orange', 'purple', 'red'])->random(),
                        'icon' => collect(['💻', '🔢', '🗄️', '📱', '🧠', '📘'])->random(),
                        'coverImage' => $class->cover_image ? asset($class->cover_image) : null,
                    ];
                });

            return view('dosen.kelas-saya', [
                'title' => $title,
                'instructor_name' => $instructor_name,
                'sub_title' => $sub_title,
                'classes' => $classes
            ]);
        } catch (\Throwable $e) {
            Log::error('Gagal mengambil data kelas', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
            ]);
            abort(500, 'Terjadi kesalahan saat mengambil data kelas.');
        }
    }

    public function tambahKelas(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'title' => 'required|string|max:255',
                'code' => 'required|string|max:50|unique:classes,code',
                'description' => 'nullable|string',
                'semester' => 'required|string|max:50',
                'status' => 'required|in:active,inactive,archived',
                'max_students' => 'nullable|integer|min:1',
                'cover_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $coverPath = null;

            // Upload file cover (langsung ke public)
            if ($request->hasFile('cover_image')) {
                $file = $request->file('cover_image');
                $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('covers');

                // Buat folder jika belum ada
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                // Pindahkan file
                $file->move($destinationPath, $filename);
                $coverPath = 'covers/' . $filename;
            }

            // Simpan data ke database
            $class = ClassModel::create([
                'instructor_id' => Auth::user()->instructor->id,
                'code' => $request->code,
                'title' => $request->title,
                'description' => $request->description,
                'semester' => $request->semester,
                'status' => $request->status,
                'max_students' => $request->max_students ?? 50,
                'cover_image' => $coverPath,
            ]);

            return redirect()->back()->with('success', 'Kelas berhasil dibuat!');
        } catch (\Exception $e) {
            // Catat error ke log Laravel
            Log::error('Gagal menambahkan kelas: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::id(),
                'request_data' => $request->all(),
            ]);

            // Beri pesan ke user tanpa detail teknis
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan kelas. Silakan coba lagi.');
        }
    }

    public function updateKelas(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:classes,id',
                'title' => 'required|string|max:255',
                'code' => 'required|string|max:100',
                'description' => 'required|string',
                'semester' => 'required|string',
                'status' => 'required|in:active,inactive',
                'cover_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $class = ClassModel::findOrFail($request->id);

            $class->title = $request->title;
            $class->code = $request->code;
            $class->description = $request->description;
            $class->semester = $request->semester;
            $class->status = $request->status;

            // Handle cover image
            if ($request->hasFile('cover_image')) {
                // Hapus file lama jika ada
                if ($class->cover_image && file_exists(public_path('covers/' . $class->cover_image))) {
                    unlink(public_path('covers/' . $class->cover_image));
                }

                $file = $request->file('cover_image');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('covers'), $filename);
                $class->cover_image = $filename;
            }

            $class->save();

            return redirect()
                ->back()
                ->with('success', 'Kelas berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error('Gagal update kelas: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::id(),
                'class_id' => $request->id ?? null,
            ]);

            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui kelas. Silakan coba lagi.');
        }
    }

    public function deleteKelas($id)
    {
        try {

            $class = ClassModel::findOrFail($id);

            // Hapus cover image jika ada
            if ($class->cover_image && file_exists(public_path('covers/' . $class->cover_image))) {
                unlink(public_path('covers/' . $class->cover_image));
            }

            // Hapus data kelas
            $class->delete();

            return redirect()
                ->back()
                ->with('success', 'Kelas berhasil dihapus!');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus kelas: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::id(),
                'class_id' => $id ?? null,
            ]);

            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat menghapus kelas. Silakan coba lagi.');
        }
    }

    public function detailKelas($id)
    {
        // Cari kelas berdasarkan ID beserta relasi
        $class = ClassModel::with(['students', 'assignments', 'materials'])->find($id);

        if (!$class) {
            return redirect('/kelas/saya')->with('error', 'Kelas tidak ditemukan.');
        }

        // Ambil data materials dan ubah formatnya agar siap dilempar ke FE
        $materials = $class->materials->map(function ($item) {
            if ($item->type === 'link') {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'type' => $item->type,
                    'link' => $item->file_url,
                    'fileUrl' => null,
                    'uploadDate' => $item->created_at->format('Y-m-d'),
                    'downloads' => 0,
                    'description' => $item->description ?? '' // tambahkan deskripsi
                ];
            } else {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'type' => $item->type,
                    'fileUrl' => asset($item->file_path),
                    'link' => null,
                    'uploadDate' => $item->created_at->format('Y-m-d'),
                    'downloads' => 0,
                    'description' => $item->description ?? '' // tambahkan deskripsi
                ];
            }
        });

        // dd($materials);

        $title = $class->title;
        $sub_title = $class->description ?? '';
        $instructor_name = Auth::user()->name;

        // dd($materials);

        return view('dosen.detail-kelas-saya', compact('title', 'sub_title', 'instructor_name', 'class', 'materials'));
    }


    public function tambahMateri(Request $request)
    {
        try {
            // Validasi dasar
            $request->validate([
                'class_id' => 'required|exists:classes,id',
                'title' => 'required|string|max:255',
                'type' => 'required|in:pdf,document,link,video',
                'description' => 'nullable|string',
                'file' => 'nullable|file|mimes:pdf,doc,docx|max:5120', // hanya untuk pdf/document
                'link' => 'nullable|url', // hanya untuk tipe link/video eksternal
            ]);

            // Validasi kondisional
            if (in_array($request->type, ['pdf', 'document']) && !$request->hasFile('file')) {
                return back()->withErrors(['file' => 'File materi wajib diunggah untuk tipe PDF/Document.']);
            }

            if ($request->type === 'link' && empty($request->link)) {
                return back()->withErrors(['link' => 'URL materi wajib diisi untuk tipe Link/Video.']);
            }

            $material = new Material();
            $material->class_id = $request->class_id;
            $material->created_by = Auth::id();
            $material->title = $request->title;
            $material->description = $request->description;
            $material->type = $request->type;

            // Simpan file jika ada
            if ($request->hasFile('file')) {
                $file = $request->file('file');

                // Ambil info sebelum dipindahkan
                $originalName = $file->getClientOriginalName();
                $sizeKB = round($file->getSize() / 1024); // KB
                $filename = time() . '_' . $originalName;

                // Pindahkan file ke folder public/materials
                $file->move(public_path('materials'), $filename);

                // Simpan info di database
                $material->file_path = 'materials/' . $filename;
                $material->file_name = $originalName;
                $material->file_size = $sizeKB;
            }


            // Simpan link untuk tipe link/video
            if ($request->type === 'link') {
                $material->file_url = $request->link;
            }

            $material->save();

            return redirect()->back()->with('success', 'Materi berhasil ditambahkan!');
        } catch (\Exception $e) {
            Log::error('Gagal menambahkan materi: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);

            return back()->with('error', 'Terjadi kesalahan saat menambahkan materi. Silakan cek log.');
        }
    }
}
