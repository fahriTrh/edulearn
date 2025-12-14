<?php

namespace App\Livewire\Student;

use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\ClassModel;
use App\Models\Material;
use App\Models\MaterialCompletion;
use App\Models\Post;
use App\Models\PostReply;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;

#[Layout('mahasiswa.app')]

class DetailKursus extends Component
{
    use WithFileUploads;

    public $classId;
    public $class;
    public $activeTab = 'classwork'; // 'stream', 'classwork', 'people'

    // Post properties
    public $post_type = 'discussion';
    public $post_title = '';
    public $post_content = '';
    public $showPostModal = false;
    public $reply_content = [];

    // Assignment submission modal
    public $showSubmissionModal = false;
    public $selectedAssignmentId = null;
    public $selectedAssignment = null;
    public $submission_text = '';
    public $submission_file;
    public $submission_link = '';

    public function mount($id)
    {
        $this->classId = $id;
        $this->loadClass();
    }

    public function loadClass()
    {
        // Verify student is enrolled in this class
        $user = Auth::user();
        $this->class = ClassModel::where('id', $this->classId)
            ->whereHas('students', function ($query) use ($user) {
                $query->where('users.id', $user->id);
            })
            ->with(['instructor.user', 'materials', 'assignments', 'students'])
            ->firstOrFail();
    }

    public function switchTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function markMaterialComplete($materialId)
    {
        $user = Auth::user();

        MaterialCompletion::updateOrCreate(
            [
                'user_id' => $user->id,
                'material_id' => $materialId,
            ],
            [
                'is_completed' => true,
                'completed_at' => now(),
            ]
        );

        session()->flash('success', 'Materi ditandai sebagai selesai!');
    }

    public function openSubmissionModal($assignmentId)
    {
        $this->selectedAssignmentId = $assignmentId;
        $this->selectedAssignment = Assignment::findOrFail($assignmentId);

        // Check if already submitted
        $existingSubmission = AssignmentSubmission::where('assignment_id', $assignmentId)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingSubmission) {
            $this->submission_text = $existingSubmission->submission_text ?? '';
            $this->submission_link = $existingSubmission->submission_link ?? '';
        } else {
            $this->submission_text = '';
            $this->submission_link = '';
        }

        $this->submission_file = null;
        $this->showSubmissionModal = true;
    }

    public function closeSubmissionModal()
    {
        $this->showSubmissionModal = false;
        $this->selectedAssignmentId = null;
        $this->selectedAssignment = null;
        $this->submission_text = '';
        $this->submission_file = null;
        $this->submission_link = '';
    }

    public function submitAssignment()
    {
        $this->validate([
            'submission_text' => 'nullable|string',
            'submission_file' => 'nullable|file|max:10240', // 10MB max
            'submission_link' => 'nullable|url',
        ], [
            'submission_file.max' => 'File tidak boleh lebih dari 10MB',
            'submission_link.url' => 'Link harus berupa URL yang valid',
        ]);

        $assignment = Assignment::findOrFail($this->selectedAssignmentId);
        $user = Auth::user();

        // Validate submission type
        if ($assignment->submission_type === 'file' && !$this->submission_file && !$this->submission_link) {
            $this->addError('submission_file', 'File atau link wajib diisi untuk tipe submission file.');
            return;
        }

        if ($assignment->submission_type === 'text' && empty($this->submission_text)) {
            $this->addError('submission_text', 'Teks submission wajib diisi.');
            return;
        }

        if ($assignment->submission_type === 'link' && empty($this->submission_link)) {
            $this->addError('submission_link', 'Link submission wajib diisi.');
            return;
        }

        try {
            $filePath = null;
            $fileName = null;
            $fileSize = null;

            // Handle file upload
            if ($this->submission_file) {
                $filename = time() . '_' . uniqid() . '.' . $this->submission_file->getClientOriginalExtension();
                $destinationPath = public_path('submissions');

                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }

                $this->submission_file->move($destinationPath, $filename);
                $filePath = 'submissions/' . $filename;
                $fileName = $this->submission_file->getClientOriginalName();
                $fileSize = round($this->submission_file->getSize() / 1024); // KB
            }

            // Check if late
            $isLate = now() > $assignment->deadline;

            // Update or create submission
            AssignmentSubmission::updateOrCreate(
                [
                    'assignment_id' => $assignment->id,
                    'user_id' => $user->id,
                ],
                [
                    'submission_text' => $this->submission_text ?: null,
                    'file_path' => $filePath,
                    'file_name' => $fileName,
                    'file_size' => $fileSize,
                    'submission_link' => $this->submission_link ?: null,
                    'submitted_at' => now(),
                    'is_late' => $isLate,
                    'status' => 'submitted',
                ]
            );

            session()->flash('success', 'Tugas berhasil dikumpulkan!');
            $this->closeSubmissionModal();
            $this->loadClass();
        } catch (\Exception $e) {
            Log::error('Gagal submit tugas: ' . $e->getMessage());
            session()->flash('error', 'Terjadi kesalahan saat mengumpulkan tugas.');
        }
    }

    // Post methods
    public function openPostModal()
    {
        $this->post_type = 'discussion';
        $this->post_title = '';
        $this->post_content = '';
        $this->showPostModal = true;
    }

    public function closePostModal()
    {
        $this->showPostModal = false;
        $this->post_title = '';
        $this->post_content = '';
    }

    public function createPost()
    {
        $this->validate([
            'post_title' => 'required|string|max:255',
            'post_content' => 'required|string',
        ]);

        try {
            Post::create([
                'class_id' => $this->classId,
                'user_id' => Auth::id(),
                'type' => 'discussion',
                'title' => $this->post_title,
                'content' => $this->post_content,
            ]);

            session()->flash('success', 'Diskusi berhasil dibuat!');
            $this->closePostModal();
        } catch (\Exception $e) {
            Log::error('Gagal membuat post: ' . $e->getMessage());
            session()->flash('error', 'Terjadi kesalahan saat membuat diskusi.');
        }
    }

    public function addReply($postId)
    {
        $this->validate([
            "reply_content.{$postId}" => 'required|string',
        ]);

        try {
            PostReply::create([
                'post_id' => $postId,
                'user_id' => Auth::id(),
                'content' => $this->reply_content[$postId] ?? '',
            ]);

            $this->reply_content[$postId] = '';
            session()->flash('success', 'Balasan berhasil ditambahkan!');
        } catch (\Exception $e) {
            Log::error('Gagal menambahkan reply: ' . $e->getMessage());
            session()->flash('error', 'Terjadi kesalahan saat menambahkan balasan.');
        }
    }

    public function render()
    {
        $user = Auth::user();

        // Batch fetch completion helpers for this single class
        $completedMaterialIds = MaterialCompletion::where('user_id', $user->id)
            ->whereIn('material_id', $this->class->materials->pluck('id'))
            ->where('is_completed', true)
            ->pluck('material_id')
            ->toArray();

        // Batch fetch assignment submissions for this single class
        $submissions = AssignmentSubmission::where('user_id', $user->id)
            ->whereIn('assignment_id', $this->class->assignments->pluck('id'))
            ->get()
            ->keyBy('assignment_id');

        // Format materials (only published)
        $materials = $this->class->materials->where('is_published', true)->map(function ($item) use ($user, $completedMaterialIds) {
            // Check in_array (O(N) but N is small per class, and in_array is fast enough for <100, can use hash map if bigger)
            // Or better, flip the array once if we care, but toArray() is list of IDs.
            // For optimal perf, flip it:
            // But here let's just use in_array which is fast enough for typical class size.
            $isCompleted = in_array($item->id, $completedMaterialIds);

            if ($item->type === 'link') {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'type' => $item->type,
                    'link' => $item->file_url,
                    'fileUrl' => null,
                    'uploadDate' => $item->created_at->format('Y-m-d'),
                    'description' => $item->description ?? '',
                    'is_completed' => $isCompleted,
                ];
            } else {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'type' => $item->type,
                    'fileUrl' => asset($item->file_path),
                    'link' => null,
                    'uploadDate' => $item->created_at->format('Y-m-d'),
                    'description' => $item->description ?? '',
                    'is_completed' => $isCompleted,
                ];
            }
        });

        // Format assignments with submission status
        $assignments = Assignment::where('class_id', $this->classId)
            ->where('status', 'published')
            ->get()
            ->map(function ($assignment) use ($user, $submissions) {
                // Lookup in keyed collection
                $submission = $submissions->get($assignment->id);

                // Calculate days left properly (rounded, not float)
                $deadline = \Carbon\Carbon::parse($assignment->deadline);
                $now = now();
                // Calculate days difference: positive = days left, negative = days overdue
                $daysLeft = (int) floor($now->diffInDays($deadline, false));

                // Format deadline display
                $deadlineDisplay = '';
                if ($daysLeft < 0) {
                    $deadlineDisplay = 'Terlambat ' . abs($daysLeft) . ' hari, ' . $deadline->format('H:i');
                } elseif ($daysLeft == 0) {
                    $deadlineDisplay = 'Hari ini, ' . $deadline->format('H:i');
                } elseif ($daysLeft == 1) {
                    $deadlineDisplay = 'Besok, ' . $deadline->format('H:i');
                } else {
                    $deadlineDisplay = $daysLeft . ' hari lagi, ' . $deadline->format('H:i');
                }

                return [
                    'id' => $assignment->id,
                    'title' => $assignment->title,
                    'description' => $assignment->description,
                    'deadline' => $deadlineDisplay,
                    'deadline_raw' => $assignment->deadline,
                    'deadline_date' => $deadline->format('d M Y'),
                    'deadline_time' => $deadline->format('H:i'),
                    'days_left' => $daysLeft,
                    'weight' => $assignment->weight_percentage,
                    'status' => $assignment->status,
                    'submission_type' => $assignment->submission_type,
                    'has_submission' => $submission !== null,
                    'submission' => $submission ? [
                        'id' => $submission->id,
                        'submitted_at' => $submission->submitted_at,
                        'score' => $submission->score,
                        'feedback' => $submission->feedback,
                        'status' => $submission->status,
                        'file_path' => $submission->file_path,
                        'file_name' => $submission->file_name,
                        'submission_text' => $submission->submission_text,
                        'submission_link' => $submission->submission_link,
                    ] : null,
                    'is_late' => $submission ? $submission->is_late : ($daysLeft < 0),
                ];
            });

        // Get classmates
        $classmates = $this->class->students()
            ->where('users.id', '!=', $user->id)
            ->select('users.id', 'users.name', 'users.nim', 'users.email')
            ->get();

        // Get posts (pinned first, then by date)
        $posts = Post::where('class_id', $this->classId)
            ->with(['user', 'replies.user'])
            ->orderBy('is_pinned', 'desc')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($post) {
                return [
                    'id' => $post->id,
                    'type' => $post->type,
                    'title' => $post->title,
                    'content' => $post->content,
                    'is_pinned' => $post->is_pinned,
                    'user' => [
                        'id' => $post->user->id,
                        'name' => $post->user->name,
                        'initial' => substr($post->user->name, 0, 1),
                    ],
                    'created_at' => $post->created_at->format('Y-m-d H:i:s'),
                    'created_at_carbon' => $post->created_at,
                    'replies' => $post->replies->map(function ($reply) {
                        return [
                            'id' => $reply->id,
                            'content' => $reply->content,
                            'user' => [
                                'id' => $reply->user->id,
                                'name' => $reply->user->name,
                                'initial' => substr($reply->user->name, 0, 1),
                            ],
                            'created_at' => $reply->created_at->format('Y-m-d H:i:s'),
                            'created_at_carbon' => $reply->created_at,
                        ];
                    }),
                ];
            });

        $title = $this->class->title;
        $sub_title = $this->class->description ?? '';

        // Fetch student name directly from database
        $dbUser = User::find(Auth::id());
        $student_name = $dbUser && $dbUser->name ? $dbUser->name : 'Student';

        /** @var \Illuminate\View\View|mixed $view */
        $view = view('livewire.student.detail-kursus', [
            'materials' => $materials,
            'assignments' => $assignments,
            'classmates' => $classmates,
            'posts' => $posts,
        ]);

        return $view->layoutData([
            'title' => $title,
            'sub_title' => $sub_title,
        ]);
    }
}
