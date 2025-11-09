<?php

namespace App\Livewire\Instructor;

use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\ClassModel;
use App\Models\FinalGrade as FinalGradeModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('dosen.app')]
class Nilai extends Component
{
    public $title = 'Nilai';
    public $sub_title = 'Kelola semua nilai mahasiswa';
    public $instructor_name = '';

    // Active tab: 'review', 'daftar', 'final'
    public $activeTab = 'review';

    // Tab 1: Review & Grading
    public $selectedAssignmentId = null;
    public $filter = 'all'; // all, submitted, graded, pending
    public $showGradingModal = false;
    public $gradingSubmissionId = null;
    public $score = '';
    public $feedback = '';

    // Tab 2: Daftar Nilai
    public $selectedClassId = null;
    public $selectedAssignmentIdDaftar = null;
    public $viewMode = 'class'; // 'class' or 'assignment'

    // Tab 3: Final Grade
    public $selectedClassIdFinal = null;

    public function mount()
    {
        $this->instructor_name = Auth::user()->name;
    }

    public function switchTab($tab)
    {
        $this->activeTab = $tab;
        // Reset selections when switching tabs
        $this->selectedAssignmentId = null;
        $this->selectedClassId = null;
        $this->selectedClassIdFinal = null;
    }

    // ========== TAB 1: Review & Grading Methods ==========
    public function selectAssignment($assignmentId)
    {
        $this->selectedAssignmentId = $assignmentId;
        $this->filter = 'all';
    }

    public function clearSelectionReview()
    {
        $this->selectedAssignmentId = null;
        $this->filter = 'all';
    }

    public function filterSubmissions($status)
    {
        $this->filter = $status;
    }

    public function openGradingModal($submissionId)
    {
        $submission = AssignmentSubmission::findOrFail($submissionId);
        $this->gradingSubmissionId = $submissionId;
        $this->score = $submission->score ?? '';
        $this->feedback = $submission->feedback ?? '';
        $this->showGradingModal = true;
    }

    public function closeGradingModal()
    {
        $this->showGradingModal = false;
        $this->gradingSubmissionId = null;
        $this->score = '';
        $this->feedback = '';
    }

    public function saveGrade()
    {
        $validated = $this->validate([
            'score' => 'required|numeric|min:0|max:100',
            'feedback' => 'nullable|string',
        ]);

        $submission = AssignmentSubmission::findOrFail($this->gradingSubmissionId);
        
        $assignment = $submission->assignment;
        $class = ClassModel::where('id', $assignment->class_id)
            ->where('instructor_id', Auth::user()->instructor->id)
            ->firstOrFail();

        $submission->update([
            'score' => $validated['score'],
            'feedback' => $validated['feedback'],
            'graded_at' => now(),
            'graded_by' => Auth::id(),
            'status' => 'graded',
        ]);

        session()->flash('success', 'Nilai berhasil disimpan!');
        $this->closeGradingModal();
    }

    // ========== TAB 2: Daftar Nilai Methods ==========
    public function selectClassDaftar($classId)
    {
        $this->selectedClassId = $classId;
        $this->selectedAssignmentIdDaftar = null;
        $this->viewMode = 'class';
    }

    public function selectAssignmentDaftar($assignmentId)
    {
        $this->selectedAssignmentIdDaftar = $assignmentId;
        $this->viewMode = 'assignment';
    }

    public function clearSelectionDaftar()
    {
        $this->selectedClassId = null;
        $this->selectedAssignmentIdDaftar = null;
        $this->viewMode = 'class';
    }

    // ========== TAB 3: Final Grade Methods ==========
    public function selectClassFinal($classId)
    {
        $this->selectedClassIdFinal = $classId;
    }

    public function clearSelectionFinal()
    {
        $this->selectedClassIdFinal = null;
    }

    public function calculateFinalGrades($classId)
    {
        $class = ClassModel::where('id', $classId)
            ->where('instructor_id', Auth::user()->instructor->id)
            ->with(['assignments', 'students'])
            ->firstOrFail();

        $assignments = $class->assignments()->where('status', 'published')->get();
        $students = $class->students;

        foreach ($students as $student) {
            $totalScore = 0;
            $totalWeight = 0;

            foreach ($assignments as $assignment) {
                $submission = AssignmentSubmission::where('assignment_id', $assignment->id)
                    ->where('user_id', $student->id)
                    ->whereNotNull('score')
                    ->first();

                if ($submission && $submission->score !== null) {
                    $weight = $assignment->weight_percentage ?? 0;
                    $totalScore += ($submission->score * $weight / 100);
                    $totalWeight += $weight;
                }
            }

            $finalScore = $totalWeight > 0 ? ($totalScore / $totalWeight) * 100 : 0;
            $finalScore = round($finalScore, 2);
            $letterGrade = $this->getLetterGrade($finalScore);

            FinalGradeModel::updateOrCreate(
                [
                    'class_id' => $classId,
                    'user_id' => $student->id,
                ],
                [
                    'total_score' => $finalScore,
                    'letter_grade' => $letterGrade,
                    'grade_point' => $this->getGradePoint($letterGrade),
                    'status' => 'draft',
                    'calculated_by' => Auth::id(),
                ]
            );
        }

        session()->flash('success', 'Nilai akhir berhasil dihitung!');
    }

    public function publishGrades($classId)
    {
        FinalGradeModel::where('class_id', $classId)
            ->update(['status' => 'published', 'published_at' => now()]);

        session()->flash('success', 'Nilai akhir berhasil dipublikasikan!');
    }

    public function unpublishGrades($classId)
    {
        FinalGradeModel::where('class_id', $classId)
            ->update(['status' => 'draft', 'published_at' => null]);

        session()->flash('success', 'Publikasi nilai akhir dibatalkan!');
    }

    private function getLetterGrade($score)
    {
        if ($score >= 90) return 'A';
        if ($score >= 80) return 'B';
        if ($score >= 70) return 'C';
        if ($score >= 60) return 'D';
        return 'E';
    }

    private function getGradePoint($letterGrade)
    {
        $gradePoints = [
            'A' => 4.00,
            'B' => 3.00,
            'C' => 2.00,
            'D' => 1.00,
            'E' => 0.00,
        ];
        return $gradePoints[$letterGrade] ?? 0.00;
    }

    public function render()
    {
        $instructorClasses = ClassModel::where('instructor_id', Auth::user()->instructor->id)
            ->with(['assignments', 'students'])
            ->get();

        // Tab 1: Review & Grading Data
        $assignments = collect();
        $submissions = collect();
        $selectedAssignment = null;

        if ($this->activeTab === 'review') {
            $assignments = Assignment::whereIn('class_id', $instructorClasses->pluck('id'))
                ->where('status', 'published')
                ->with(['class', 'submissions.user'])
                ->orderBy('deadline', 'desc')
                ->get()
                ->map(function ($assignment) {
                    $totalSubmissions = $assignment->submissions->count();
                    $gradedSubmissions = $assignment->submissions->whereNotNull('score')->count();
                    $pendingSubmissions = $assignment->submissions->whereNull('score')->count();

                    return [
                        'id' => $assignment->id,
                        'title' => $assignment->title,
                        'class_name' => $assignment->class->title ?? 'N/A',
                        'class_code' => $assignment->class->code ?? '',
                        'deadline' => $assignment->deadline,
                        'total_submissions' => $totalSubmissions,
                        'graded_submissions' => $gradedSubmissions,
                        'pending_submissions' => $pendingSubmissions,
                    ];
                });

            if ($this->selectedAssignmentId) {
                $assignment = Assignment::with(['class', 'submissions.user'])
                    ->find($this->selectedAssignmentId);
                
                if ($assignment) {
                    $class = ClassModel::where('id', $assignment->class_id)
                        ->where('instructor_id', Auth::user()->instructor->id)
                        ->first();

                    if ($class) {
                        $submissions = $assignment->submissions->map(function ($submission) use ($assignment) {
                            $daysLate = 0;
                            if ($submission->submitted_at > $assignment->deadline) {
                                $daysLate = $submission->submitted_at->diffInDays($assignment->deadline);
                            }

                            return [
                                'id' => $submission->id,
                                'student_name' => $submission->user->name ?? 'N/A',
                                'student_nim' => $submission->user->nim ?? 'N/A',
                                'student_email' => $submission->user->email ?? 'N/A',
                                'submitted_at' => $submission->submitted_at,
                                'is_late' => $submission->is_late,
                                'days_late' => $daysLate,
                                'score' => $submission->score,
                                'feedback' => $submission->feedback,
                                'status' => $submission->status,
                                'file_path' => $submission->file_path,
                                'file_name' => $submission->file_name,
                                'submission_text' => $submission->submission_text,
                                'submission_link' => $submission->submission_link,
                                'graded_at' => $submission->graded_at,
                            ];
                        });

                        if ($this->filter === 'submitted') {
                            $submissions = $submissions->where('status', 'submitted');
                        } elseif ($this->filter === 'graded') {
                            $submissions = $submissions->where('status', 'graded');
                        } elseif ($this->filter === 'pending') {
                            $submissions = $submissions->whereNull('score');
                        }

                        $selectedAssignment = $assignment;
                    }
                }
            }
        }

        // Tab 2: Daftar Nilai Data
        $classGrades = collect();
        $assignmentGrades = collect();
        $selectedClassDaftar = null;
        $selectedAssignmentDaftar = null;

        if ($this->activeTab === 'daftar') {
            if ($this->selectedClassId) {
                $selectedClassDaftar = ClassModel::where('id', $this->selectedClassId)
                    ->where('instructor_id', Auth::user()->instructor->id)
                    ->with(['assignments', 'students'])
                    ->first();

                if ($selectedClassDaftar && $this->viewMode === 'class') {
                    $assignmentsList = $selectedClassDaftar->assignments()->where('status', 'published')->get();
                    
                    $classGrades = $assignmentsList->map(function ($assignment) use ($selectedClassDaftar) {
                        $submissions = AssignmentSubmission::where('assignment_id', $assignment->id)
                            ->whereIn('user_id', $selectedClassDaftar->students->pluck('id'))
                            ->with('user')
                            ->get();

                        $gradedCount = $submissions->whereNotNull('score')->count();
                        $avgScore = $submissions->whereNotNull('score')->avg('score');

                        return [
                            'assignment_id' => $assignment->id,
                            'assignment_title' => $assignment->title,
                            'deadline' => $assignment->deadline,
                            'total_students' => $selectedClassDaftar->students->count(),
                            'submissions_count' => $submissions->count(),
                            'graded_count' => $gradedCount,
                            'avg_score' => $avgScore ? number_format($avgScore, 2) : '0.00',
                        ];
                    });
                }

                if ($this->selectedAssignmentIdDaftar) {
                    $selectedAssignmentDaftar = Assignment::with(['class', 'submissions.user'])
                        ->find($this->selectedAssignmentIdDaftar);

                    if ($selectedAssignmentDaftar) {
                        $class = ClassModel::where('id', $selectedAssignmentDaftar->class_id)
                            ->where('instructor_id', Auth::user()->instructor->id)
                            ->first();

                        if ($class) {
                            $assignmentGrades = AssignmentSubmission::where('assignment_id', $this->selectedAssignmentIdDaftar)
                                ->with('user')
                                ->orderBy('submitted_at', 'desc')
                                ->get()
                                ->map(function ($submission) {
                                    return [
                                        'id' => $submission->id,
                                        'student_name' => $submission->user->name ?? 'N/A',
                                        'student_nim' => $submission->user->nim ?? 'N/A',
                                        'student_email' => $submission->user->email ?? 'N/A',
                                        'score' => $submission->score,
                                        'feedback' => $submission->feedback,
                                        'submitted_at' => $submission->submitted_at,
                                        'graded_at' => $submission->graded_at,
                                        'is_late' => $submission->is_late,
                                        'file_name' => $submission->file_name,
                                    ];
                                });
                        }
                    }
                }
            }
        }

        // Tab 3: Final Grade Data
        $finalGrades = collect();
        $classSummary = null;
        $selectedClassFinal = null;

        if ($this->activeTab === 'final') {
            if ($this->selectedClassIdFinal) {
                $selectedClassFinal = ClassModel::where('id', $this->selectedClassIdFinal)
                    ->where('instructor_id', Auth::user()->instructor->id)
                    ->with(['assignments', 'students'])
                    ->first();

                if ($selectedClassFinal) {
                    $finalGrades = FinalGradeModel::where('class_id', $this->selectedClassIdFinal)
                        ->with('user')
                        ->orderBy('total_score', 'desc')
                        ->get();

                    $totalStudents = $selectedClassFinal->students->count();
                    $calculatedCount = FinalGradeModel::where('class_id', $this->selectedClassIdFinal)->count();
                    $publishedCount = FinalGradeModel::where('class_id', $this->selectedClassIdFinal)
                        ->where('status', 'published')
                        ->count();
                    $avgScore = FinalGradeModel::where('class_id', $this->selectedClassIdFinal)
                        ->avg('total_score');

                    $classSummary = [
                        'total_students' => $totalStudents,
                        'calculated_count' => $calculatedCount,
                        'published_count' => $publishedCount,
                        'avg_score' => $avgScore ? number_format($avgScore, 2) : '0.00',
                        'is_published' => FinalGradeModel::where('class_id', $this->selectedClassIdFinal)
                            ->where('status', 'published')
                            ->exists(),
                    ];
                }
            }
        }

        return view('livewire.instructor.nilai', [
            'classes' => $instructorClasses,
            // Tab 1
            'assignments' => $assignments,
            'submissions' => $submissions,
            'selectedAssignment' => $selectedAssignment,
            // Tab 2
            'classGrades' => $classGrades,
            'assignmentGrades' => $assignmentGrades,
            'selectedClassDaftar' => $selectedClassDaftar,
            'selectedAssignmentDaftar' => $selectedAssignmentDaftar,
            // Tab 3
            'finalGrades' => $finalGrades,
            'classSummary' => $classSummary,
            'selectedClassFinal' => $selectedClassFinal,
        ]);
    }
}
