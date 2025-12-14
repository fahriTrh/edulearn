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
    // activeTab is handled by Alpine.js now

    // Post properties
    public $post_type = 'discussion';
    public $post_title = '';
    public $post_content = '';
    public $reply_content = [];

    // Assignment submission modal properties
    public $selectedAssignmentId = null;
    public $selectedAssignment = null;
    public $submission_text = '';
    public $submission_file;
    public $submission_link = '';

    public $isSubmitted = false;

    // Edit/Delete State
    public $editingPostId = null;
    public $editingReplyId = null;
    public $reply_content_edit = '';

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
        // No need to reload class if we just update UI state, but re-render is fine
    }

    public function getAssignmentDetails($assignmentId)
    {
        // Clear previous data immediately to show loading state
        $this->selectedAssignment = null;
        $this->selectedAssignmentId = $assignmentId;
        $this->submission_text = '';
        $this->submission_link = '';
        $this->submission_file = null;
        $this->isSubmitted = false;

        $this->selectedAssignment = Assignment::findOrFail($assignmentId);

        // Check if already submitted
        $existingSubmission = AssignmentSubmission::where('assignment_id', $assignmentId)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingSubmission) {
            $this->submission_text = $existingSubmission->submission_text ?? '';
            $this->submission_link = $existingSubmission->submission_link ?? '';
            $this->isSubmitted = true;
        } else {
            $this->isSubmitted = false; // Ensure explicit false
        }

        // The modal visibility will be handled by Alpine
    }

    public function cancelSubmission()
    {
        $submission = AssignmentSubmission::where('assignment_id', $this->selectedAssignmentId)
            ->where('user_id', Auth::id())
            ->first();

        if ($submission) {
            // Optional: Delete file if exists on disk
            if ($submission->file_path && file_exists(public_path($submission->file_path))) {
                @unlink(public_path($submission->file_path));
            }

            $submission->delete();

            $this->isSubmitted = false;
            $this->submission_text = '';
            $this->submission_link = '';

            session()->flash('success', 'Pengiriman dibatalkan.');
            $this->loadClass(); // Refresh main list
        }
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
            $this->dispatch('close-submission-modal'); // Dispatch event for Alpine
            $this->loadClass(); // Refresh data
        } catch (\Exception $e) {
            Log::error('Gagal submit tugas: ' . $e->getMessage());
            session()->flash('error', 'Terjadi kesalahan saat mengumpulkan tugas.');
        }
    }

    public function markAsDone()
    {
        $assignment = Assignment::findOrFail($this->selectedAssignmentId);
        $user = Auth::user();

        // Check if late
        $isLate = now() > $assignment->deadline;

        try {
            AssignmentSubmission::updateOrCreate(
                [
                    'assignment_id' => $assignment->id,
                    'user_id' => $user->id,
                ],
                [
                    'submission_text' => 'Ditandai selesai oleh siswa',
                    'file_path' => null,
                    'file_name' => null,
                    'file_size' => null,
                    'submission_link' => null,
                    'submitted_at' => now(),
                    'is_late' => $isLate,
                    'status' => 'submitted',
                ]
            );

            session()->flash('success', 'Tugas ditandai selesai!');
            $this->dispatch('close-submission-modal');
            $this->loadClass();
        } catch (\Exception $e) {
            Log::error('Gagal menandai selesai: ' . $e->getMessage());
            session()->flash('error', 'Gagal menandai selesai.');
        }
    }

    // Post methods
    public function editPost($postId)
    {
        $post = Post::where('id', $postId)->where('user_id', Auth::id())->firstOrFail();
        $this->editingPostId = $post->id;
        $this->post_content = $post->content;
        $this->post_title = $post->title;
        $this->dispatch('open-post-modal');
    }

    public function updatePost()
    {
        $this->validate([
            'post_content' => 'required|string',
        ]);

        $post = Post::where('id', $this->editingPostId)->where('user_id', Auth::id())->firstOrFail();

        $post->update([
            'content' => $this->post_content,
        ]);

        $this->editingPostId = null;
        $this->post_content = '';
        $this->post_title = '';

        $this->loadClass();
        $this->dispatch('close-post-modal');
        session()->flash('success', 'Postingan diperbarui!');
    }

    public function deletePost($postId)
    {
        $post = Post::where('id', $postId)->where('user_id', Auth::id())->firstOrFail();
        $post->delete();
        $this->loadClass();
        session()->flash('success', 'Postingan dihapus.');
    }

    public function editReply($replyId)
    {
        $reply = \App\Models\PostReply::where('id', $replyId)->where('user_id', Auth::id())->firstOrFail();
        $this->editingReplyId = $reply->id;
        $this->reply_content_edit = $reply->content;
        $this->dispatch('open-reply-modal');
    }

    public function updateReply()
    {
        $this->validate([
            'reply_content_edit' => 'required|string',
        ]);

        $reply = \App\Models\PostReply::where('id', $this->editingReplyId)->where('user_id', Auth::id())->firstOrFail();

        $reply->update([
            'content' => $this->reply_content_edit,
        ]);

        $this->editingReplyId = null;
        $this->reply_content_edit = '';

        $this->loadClass();
        $this->dispatch('close-reply-modal');
        session()->flash('success', 'Komentar diperbarui!');
    }

    public function deleteReply($replyId)
    {
        $reply = \App\Models\PostReply::where('id', $replyId)->where('user_id', Auth::id())->firstOrFail();
        $reply->delete();
        $this->loadClass();
        session()->flash('success', 'Komentar dihapus.');
    }

    public function createPost()
    {
        if ($this->editingPostId) {
            $this->updatePost();
            return;
        }

        $this->validate([
            'post_title' => 'nullable|string|max:255',
            'post_content' => 'required|string',
        ]);

        try {
            Post::create([
                'class_id' => $this->classId,
                'user_id' => Auth::id(),
                'type' => 'discussion',
                'title' => $this->post_title ?: 'Postingan Baru', // Default title if empty
                'content' => $this->post_content,
            ]);

            session()->flash('success', 'Diskusi berhasil dibuat!');
            $this->post_title = '';
            $this->post_content = '';
            $this->dispatch('close-post-modal'); // Dispatch event for Alpine
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

        // 1. Fetch Completion Helper (For Classwork)
        $completedMaterialIds = MaterialCompletion::where('user_id', $user->id)
            ->whereIn('material_id', $this->class->materials->pluck('id'))
            ->where('is_completed', true)
            ->pluck('material_id')
            ->toArray();

        // 2. Fetch Submissions (For Classwork and Upcoming)
        $submissions = AssignmentSubmission::where('user_id', $user->id)
            ->whereIn('assignment_id', $this->class->assignments->pluck('id'))
            ->get()
            ->keyBy('assignment_id');

        // 3. Format Materials (Classwork)
        $materials = $this->class->materials->where('is_published', true)->map(function ($item) use ($completedMaterialIds) {
            $isCompleted = in_array($item->id, $completedMaterialIds);

            $fileUrl = $item->type !== 'link' ? asset($item->file_path) : null;
            $link = $item->type === 'link' ? $item->file_url : null;

            return [
                'id' => $item->id,
                'title' => $item->title,
                'type' => $item->type,
                'link' => $link,
                'fileUrl' => $fileUrl,
                'uploadDate' => $item->created_at->format('Y-m-d'),
                'description' => $item->description ?? '',
                'is_completed' => $isCompleted,
            ];
        });

        // 4. Format Assignments (Classwork & Upcoming)
        $assignments = Assignment::where('class_id', $this->classId)
            ->where('status', 'published')
            ->orderBy('deadline', 'asc')
            ->get()
            ->map(function ($assignment) use ($submissions) {
                $submission = $submissions->get($assignment->id);
                $deadline = \Carbon\Carbon::parse($assignment->deadline);
                $now = now()->startOfDay(); // Use start of day for accurate day diff
                $deadlineDate = $deadline->copy()->startOfDay();

                $diffDays = (int)$now->diffInDays($deadlineDate, false);

                // Format deadline display
                $deadlineDisplay = '';

                if ($diffDays == 0) {
                    $deadlineDisplay = 'Hari ini, ' . $deadline->format('H:i');
                } elseif ($diffDays == 1) {
                    $deadlineDisplay = 'Besok, ' . $deadline->format('H:i');
                } elseif ($diffDays == -1) {
                    $deadlineDisplay = 'Kemarin, ' . $deadline->format('H:i');
                } elseif ($diffDays == -2) {
                    $deadlineDisplay = '2 hari lalu, ' . $deadline->format('H:i');
                } elseif ($diffDays == -3) {
                    $deadlineDisplay = '3 hari lalu, ' . $deadline->format('H:i');
                } elseif ($diffDays < -3) {
                    $deadlineDisplay = $deadline->locale('id')->translatedFormat('d M Y, H:i');
                } else {
                    $deadlineDisplay = $diffDays . ' hari lagi, ' . $deadline->format('H:i');
                }

                // Determine logic for "Late" check (UI purpose)
                // If submitted late OR not submitted and passed deadline
                $isLateLogic = $submission ? $submission->is_late : ($diffDays < 0);

                return [
                    'id' => $assignment->id,
                    'title' => $assignment->title,
                    'description' => $assignment->description,
                    'deadline' => $deadlineDisplay,
                    'deadline_raw' => $assignment->deadline,
                    'deadline' => $deadlineDisplay,
                    'deadline_raw' => $assignment->deadline,
                    'deadline_date' => $deadline->locale('id')->translatedFormat('l, d F Y'),
                    'deadline_time' => $deadline->format('H:i'),
                    'days_left' => $diffDays,
                    'weight' => $assignment->weight_percentage,
                    'status' => $assignment->status,
                    'submission_type' => $assignment->submission_type,
                    'has_submission' => $submission !== null,
                    'submission' => $submission,
                    'is_late' => $isLateLogic,
                ];
            });

        // 5. Get Classmates (People)
        $classmates = $this->class->students()
            ->where('users.id', '!=', $user->id)
            ->select('users.id', 'users.name', 'users.nim', 'users.email')
            ->get();

        // 6. Get Posts (Stream)
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
                    'created_at_human' => $post->created_at->locale('id')->diffForHumans(),
                    'is_edited' => $post->created_at != $post->updated_at,
                    'replies' => $post->replies->map(function ($reply) {
                        return [
                            'id' => $reply->id,
                            'content' => $reply->content,
                            'user' => [
                                'id' => $reply->user->id,
                                'name' => $reply->user->name,
                                'initial' => substr($reply->user->name, 0, 1),
                            ],
                            'created_at_human' => $reply->created_at->locale('id')->diffForHumans(),
                            'is_edited' => $reply->created_at != $reply->updated_at,
                        ];
                    }),
                ];
            });

        // 7. Get Upcoming Deadlines (Stream Sidebar)
        $upcomingAssignments = $assignments->filter(function ($a) {
            return !$a['has_submission'] && $a['days_left'] >= 0;
        })->sortBy('days_left')->take(5);

        $title = $this->class->title;
        $sub_title = $this->class->description ?? '';

        /** @var \Illuminate\View\View|mixed $view */
        $view = view('livewire.student.detail-kursus', [
            'materials' => $materials,
            'assignments' => $assignments,
            'classmates' => $classmates,
            'posts' => $posts,
            'upcomingAssignments' => $upcomingAssignments,
        ]);

        return $view->layoutData([
            'title' => $title,
            'sub_title' => $sub_title,
        ]);
    }
}
