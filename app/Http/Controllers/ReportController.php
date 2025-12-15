<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Instructor;
use App\Models\ClassModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ReportController extends Controller
{
    public function exportMahasiswa()
    {
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=laporan_mahasiswa_" . date('Y-m-d') . ".csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');

            // Header
            fputcsv($file, ['ID', 'Nama', 'Email', 'Tanggal Bergabung', 'Jumlah Kelas']);

            // Data
            // Fix: Use 'classes' relationship for students (enrolled classes)
            $students = User::where('role', 'student')->withCount('classes')->get();

            foreach ($students as $student) {
                fputcsv($file, [
                    $student->id,
                    $student->name,
                    $student->email,
                    $student->created_at->format('Y-m-d H:i'),
                    $student->classes_count // Correct attribute
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    public function exportInstruktur()
    {
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=laporan_dosen_" . date('Y-m-d') . ".csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');

            // Header
            fputcsv($file, ['ID', 'Nama', 'Email', 'Tanggal Bergabung', 'Total Kelas']);

            // Data
            // Fix: Query Instructor model to get taught courses count
            $instructors = Instructor::with('user')->withCount('courses')->get();

            foreach ($instructors as $instructor) {
                if ($instructor->user) {
                    fputcsv($file, [
                        $instructor->user->id,
                        $instructor->user->name,
                        $instructor->user->email,
                        $instructor->user->created_at->format('Y-m-d H:i'),
                        $instructor->courses_count
                    ]);
                }
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    public function exportKelas()
    {
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=laporan_kelas_" . date('Y-m-d') . ".csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');

            // Header
            fputcsv($file, ['ID', 'Judul Kelas', 'Kode', 'Instruktur', 'Jumlah Mahasiswa', 'Tanggal Dibuat']);

            // Data
            // Fix: Load instructor.user to get name
            $classes = ClassModel::with(['instructor.user'])->withCount('students')->get();

            foreach ($classes as $class) {
                fputcsv($file, [
                    $class->id,
                    $class->title,
                    $class->enrollment_password,
                    $class->instructor->user->name ?? 'N/A',
                    $class->students_count,
                    $class->created_at->format('Y-m-d H:i')
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    public function printMahasiswa()
    {
        $students = User::where('role', 'student')->withCount('classes')->get();

        $data = $students->map(function ($student) {
            return [
                $student->id,
                $student->name,
                $student->email,
                $student->created_at->format('Y-m-d H:i'),
                $student->classes_count
            ];
        });

        return view('admin.reports.print', [
            'title' => 'Laporan Mahasiswa',
            'headers' => ['ID', 'Nama', 'Email', 'Tanggal Bergabung', 'Jumlah Kelas'],
            'data' => $data
        ]);
    }

    public function printInstruktur()
    {
        $instructors = Instructor::with('user')->withCount('courses')->get();

        $data = $instructors->filter(function ($instructor) {
            return $instructor->user != null;
        })->map(function ($instructor) {
            return [
                $instructor->user->id,
                $instructor->user->name,
                $instructor->user->email,
                $instructor->user->created_at->format('Y-m-d H:i'),
                $instructor->courses_count
            ];
        })->values();

        return view('admin.reports.print', [
            'title' => 'Laporan Dosen',
            'headers' => ['ID', 'Nama', 'Email', 'Tanggal Bergabung', 'Total Kelas'],
            'data' => $data
        ]);
    }

    public function printKelas()
    {
        $classes = ClassModel::with(['instructor.user'])->withCount('students')->get();

        $data = $classes->map(function ($class) {
            return [
                $class->id,
                $class->title,
                $class->enrollment_password,
                $class->instructor->user->name ?? 'N/A',
                $class->students_count,
                $class->created_at->format('Y-m-d H:i')
            ];
        });

        return view('admin.reports.print', [
            'title' => 'Laporan Kelas',
            'headers' => ['ID', 'Judul Kelas', 'Kode', 'Instruktur', 'Jumlah Mahasiswa', 'Tanggal Dibuat'],
            'data' => $data
        ]);
    }
}
