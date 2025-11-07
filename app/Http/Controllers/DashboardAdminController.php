<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\Instructor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardAdminController extends Controller
{
    public function index()
    {
        $title = 'Dashboard Admin';
        $sub_title = 'Selamat datang kembali, Admin! ';
        $admin_name = Auth::user()->name;
        $total_mahasiswa = User::where('role', 'student')
            ->where('status', 'active')
            ->count();

        $total_instructor = User::where('role', 'instructor')
            ->where('status', 'active')
            ->count();

        $total_class = ClassModel::count();

        return view('admin.dashboard-admin', [
            'title' => $title,
            'admin_name' => $admin_name,
            'sub_title' => $sub_title,
            'total_mahasiswa' => $total_mahasiswa,
            'total_instructor' => $total_instructor,
            'total_class' => $total_class
        ]);
    }

    public function kelolaMahasiswa()
    {
        $title = 'Kelola Mahasiswa';
        $admin_name = Auth::user()->name;
        $sub_title = 'Manajemen data mahasiswa';

        $mahasiswas = User::where('role', 'student')
            ->orderBy('created_at', 'desc')
            ->get([
                'id',
                'name',
                'email',
                'nim',
                'created_at',
                'status'
            ]);

        // Format joinedDate seperti contoh
        $mahasiswas = $mahasiswas->map(function ($m) {
            return [
                'id' => $m->id,
                'name' => $m->name,
                'email' => $m->email,
                'nim' => $m->nim,
                'joinedDate' => $m->created_at->format('M Y'),
                'status' => $m->status,
            ];
        });

        return view('admin.kelola-mahasiswa', [
            'title' => $title,
            'admin_name' => $admin_name,
            'sub_title' => $sub_title,
            'mahasiswas' => $mahasiswas,
        ]);
    }

    public function tambahMahasiswa(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'nim' => 'required|string|unique:users,nim',
            'status' => ['required', Rule::in(['active', 'inactive', 'suspended'])],
        ]);

        // Buat mahasiswa baru
        $mahasiswa = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'nim' => $validated['nim'],
            'status' => $validated['status'],
            'role' => 'student',             // otomatis student
            'password' => Hash::make($validated['nim']), // default password
        ]);

        return redirect()->back()->with('success', 'Mahasiswa berhasil ditambahkan!');
    }

    public function updateMahasiswa(Request $request)
    {
        // Validasi input
        $request->validate([
            'id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $request->id,
            'nim' => 'nullable|string|max:20',
            'status' => ['required', Rule::in(['active', 'inactive', 'suspended'])],
        ]);

        // Ambil data mahasiswa berdasarkan ID
        $mahasiswa = User::findOrFail($request->id);

        // Update data mahasiswa
        $mahasiswa->update([
            'name' => $request->name,
            'email' => $request->email,
            'nim' => $request->nim,
            'status' => $request->status
        ]);

        // Redirect ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Data mahasiswa berhasil diperbarui!');
    }


    public function deleteMahasiswa($id)
    {
        $mahasiswa = User::findOrFail($id);
        $mahasiswa->delete();

        return redirect()->back()->with('success', 'Data mahasiswa berhasil dihapus!');
    }

    public function kelolaInstruktur()
    {
        $title = 'Kelola Instruktur';
        $admin_name = Auth::user()->name;
        $sub_title = 'Manajemen data instruktur';

        // ambil semua instructor dengan relasi user
        $instructors = Instructor::with('user')->get();

        // mapping supaya nama key sesuai yang ingin dipakai di JS
        $instructorsJs = $instructors->map(function ($instr) {
            return [
                'id' => $instr->id,
                'name' => $instr->user->name,
                'email' => $instr->user->email,
                'specialty' => $instr->specialization,
                'courses' => $instr->total_courses,
                'students' => $instr->total_students,
                'rating' => $instr->rating,
                'status' => $instr->user->status,
                'bio' => $instr->description, // disesuaikan
            ];
        });

        return view('admin.kelola-instruktur', [
            'title' => $title,
            'admin_name' => $admin_name,
            'sub_title' => $sub_title,
            'instructors' => $instructorsJs
        ]);
    }

    public function tambahInstruktur(Request $request)
    {

        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'title' => 'nullable|string|max:50',
            'specialization' => 'required|string',
            'description' => 'nullable|string',
        ]);

        // Gunakan transaksi agar user & instructor sinkron
        DB::beginTransaction();
        try {
            // 1️⃣ Buat user dulu
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->email),
                'role' => 'instructor',
                'status' => 'active',
            ]);

            // 2️⃣ Buat instruktur
            $instructor = Instructor::create([
                'user_id' => $user->id,
                'title' => $request->title,
                'specialization' => $request->specialization,
                'description' => $request->description,
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Instruktur baru berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollback();

            Log::error('Gagal membuat instruktur: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'input' => $request->all(),
            ]);

            return redirect()->back()->with('error', 'Gagal membuat instruktur: ' . $e->getMessage());
        }
    }

    public function updateInstruktur(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:instructors,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'status' => 'required|in:active,inactive,suspended',
            'title' => 'nullable|string|max:50',
            'specialization' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $id = $request->id;

        DB::beginTransaction();
        try {
            $instructor = Instructor::with('user')->findOrFail($id);

            // update user
            $instructor->user->update([
                'name' => $request->name,
                'email' => $request->email,
                'status' => $request->status,
            ]);

            // update instructor
            $instructor->update([
                'title' => $request->title,
                'specialization' => $request->specialization,
                'description' => $request->description,
            ]);

            DB::commit();

            return redirect()->route('instructors.index')->with('success', 'Instruktur berhasil diupdate!');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Gagal update instructor: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'input' => $request->all()
            ]);
            return redirect()->back()->with('error', 'Gagal mengupdate instruktur, silakan cek log.');
        }
    }

    public function deleteInstruktur($id)
    {
        DB::beginTransaction();
        try {
            $instructor = Instructor::with('user')->findOrFail($id);

            // hapus user terkait (otomatis juga hapus instructor karena foreign key cascade)
            $instructor->user->delete();

            DB::commit();

            return redirect()->route('instructors.index')->with('success', 'Instruktur berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Gagal hapus instructor: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'instructor_id' => $id
            ]);
            return redirect()->back()->with('error', 'Gagal menghapus instruktur, silakan cek log.');
        }
    }
}
