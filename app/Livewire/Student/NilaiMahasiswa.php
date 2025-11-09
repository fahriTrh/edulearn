<?php

namespace App\Livewire\Student;

use App\Models\FinalGrade;
use App\Models\Grade;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('mahasiswa.app')]
class NilaiMahasiswa extends Component
{
    public $title = 'Nilai';
    public $sub_title = 'Pantau pencapaian dan progres belajar Anda di setiap kursus';

    public function render()
    {
        $user = Auth::user();
        $enrolledClasses = $user->classes()->with('instructor')->get();

        // Get final grades
        $finalGrades = FinalGrade::where('user_id', $user->id)
            ->where('status', 'published')
            ->with('class')
            ->get();

        // Calculate stats
        $avgGrade = FinalGrade::where('user_id', $user->id)
            ->where('status', 'published')
            ->avg('total_score');
        
        if (!$avgGrade) {
            $avgGrade = Grade::where('user_id', $user->id)->avg('score');
        }

        $completedCourses = $finalGrades->count();
        $activeCourses = $enrolledClasses->where('status', 'active')->count();

        // Process courses with grades and certificates
        $coursesWithGrades = $enrolledClasses->map(function ($class) use ($user, $finalGrades) {
            $finalGrade = $finalGrades->where('class_id', $class->id)->first();
            
            // Get grade breakdown from grades table
            $grades = Grade::where('user_id', $user->id)
                ->where('class_id', $class->id)
                ->get();

            // Check if eligible for certificate (score >= 70)
            $hasCertificate = $finalGrade && $finalGrade->total_score >= 70;
            $certificateNumber = $hasCertificate ? 'CERT-' . $finalGrade->id . '-' . date('Y') : null;
            $completedDate = $finalGrade ? $finalGrade->created_at->format('d F Y') : null;

            return [
                'id' => $class->id,
                'title' => $class->title,
                'code' => $class->code,
                'instructor' => $class->instructor->name ?? 'N/A',
                'final_score' => $finalGrade ? $finalGrade->total_score : null,
                'status' => $finalGrade ? 'completed' : ($class->status === 'active' ? 'active' : 'inactive'),
                'grades' => $grades,
                'has_certificate' => $hasCertificate,
                'certificate_number' => $certificateNumber,
                'completed_date' => $completedDate,
                'letter_grade' => $finalGrade ? $finalGrade->letter_grade : null,
            ];
        });

        // Calculate certificate stats
        $totalCertificates = $coursesWithGrades->where('has_certificate', true)->count();
        $gradeACertificates = $coursesWithGrades->filter(function ($course) {
            return $course['has_certificate'] && $course['final_score'] >= 85;
        })->count();

        return view('livewire.student.nilai-mahasiswa', [
            'avgGrade' => $avgGrade ? number_format($avgGrade, 1) : '0.0',
            'completedCourses' => $completedCourses,
            'activeCourses' => $activeCourses,
            'totalCertificates' => $totalCertificates,
            'gradeACertificates' => $gradeACertificates,
            'coursesWithGrades' => $coursesWithGrades,
        ]);
    }
}
