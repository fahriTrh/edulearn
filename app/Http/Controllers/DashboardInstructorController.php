<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
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
        // Cari kelas berdasarkan ID
        $class = ClassModel::with(['students', 'assignments', 'materials'])->find($id);

        // Jika kelas tidak ditemukan, redirect ke /kelas/saya
        if (!$class) {
            return redirect('/kelas/saya')->with('error', 'Kelas tidak ditemukan.');
        }

        // Ambil data untuk tampilan
        $title = $class->title;
        $sub_title = $class->description ?? '';
        $instructor_name = Auth::user()->name;

        // Kirim data ke view
        return view('dosen.detail-kelas-saya', compact('title', 'sub_title', 'instructor_name', 'class'));
    }
}
