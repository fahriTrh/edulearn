<?php

namespace App\Livewire\Instructor;

use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\ClassModel;
use App\Models\ClassUser;
use App\Models\Material;
use App\Models\Post;
use App\Models\PostReply;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class DetailKelas extends Component
{
    use WithFileUploads;

    public $classId;
    public $class;
    public $activeTab = 'classwork'; // 'stream', 'classwork', 'people'
    
    // Material modal
    public $showMaterialModal = false;
    public $editingMaterialId = null;
    public $material_title = '';
    public $material_type = 'pdf';
    public $material_description = '';
    public $material_file;
    public $material_link = '';

    // Assignment modal
    public $showAssignmentModal = false;
    public $assignment_title = '';
    public $assignment_description = '';
    public $assignment_instruction_type = 'file';
    public $assignment_instruction_file;
    public $assignment_instruction_link = '';
    public $assignment_deadline = '';
    public $assignment_weight = 0;

    // Student modal
    public $showStudentModal = false;
    public $student_identifier = '';

    // Stream/Announcement
    public $announcement_text = '';
    public $post_type = 'announcement'; // 'announcement' or 'discussion'
    public $post_title = '';
    public $post_content = '';
    public $showPostModal = false;
    public $selectedPostId = null;
    public $reply_content = [];

    public function mount($id)
    {
        $this->classId = $id;
        $this->loadClass();
    }

    public function loadClass()
    {
        $this->class = ClassModel::where('id', $this->classId)
            ->where('instructor_id', Auth::user()->instructor->id)
            ->with(['students', 'assignments', 'materials'])
            ->firstOrFail();
    }

    public function switchTab($tab)
    {
        $this->activeTab = $tab;
    }

    // Material methods
    public function openMaterialModal()
    {
        $this->resetMaterialForm();
        $this->showMaterialModal = true;
    }

    public function closeMaterialModal()
    {
        $this->showMaterialModal = false;
        $this->resetMaterialForm();
    }

    public function resetMaterialForm()
    {
        $this->editingMaterialId = null;
        $this->material_title = '';
        $this->material_type = 'pdf';
        $this->material_description = '';
        $this->material_file = null;
        $this->material_link = '';
    }

    public function editMaterial($id)
    {
        $material = Material::findOrFail($id);
        $this->editingMaterialId = $id;
        $this->material_title = $material->title;
        $this->material_type = $material->type;
        $this->material_description = $material->description ?? '';
        $this->material_link = $material->file_url ?? '';
        $this->showMaterialModal = true;
    }

    public function saveMaterial()
    {
        if ($this->editingMaterialId) {
            $this->updateMaterial();
        } else {
            $this->storeMaterial();
        }
    }

    public function storeMaterial()
    {
        $validated = $this->validate([
            'material_title' => 'required|string|max:255',
            'material_type' => 'required|in:pdf,document,link,video',
            'material_description' => 'nullable|string',
            'material_file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'material_link' => 'nullable|url',
        ]);

        if (in_array($this->material_type, ['pdf', 'document']) && !$this->material_file) {
            $this->addError('material_file', 'File materi wajib diunggah untuk tipe PDF/Document.');
            return;
        }

        if ($this->material_type === 'link' && empty($this->material_link)) {
            $this->addError('material_link', 'URL materi wajib diisi untuk tipe Link/Video.');
            return;
        }

        try {
            $material = new Material();
            $material->class_id = $this->classId;
            $material->created_by = Auth::id();
            $material->title = $this->material_title;
            $material->description = $this->material_description;
            $material->type = $this->material_type;

            if ($this->material_file) {
                $originalName = $this->material_file->getClientOriginalName();
                $sizeKB = round($this->material_file->getSize() / 1024);
                $filename = time() . '_' . $originalName;

                $this->material_file->move(public_path('materials'), $filename);

                $material->file_path = 'materials/' . $filename;
                $material->file_name = $originalName;
                $material->file_size = $sizeKB;
            }

            if ($this->material_type === 'link') {
                $material->file_url = $this->material_link;
            }

            $material->save();
            $this->loadClass();
            session()->flash('success', 'Materi berhasil ditambahkan!');
            $this->closeMaterialModal();
        } catch (\Exception $e) {
            Log::error('Gagal menambahkan materi: ' . $e->getMessage());
            session()->flash('error', 'Terjadi kesalahan saat menambahkan materi.');
        }
    }

    public function updateMaterial()
    {
        $validated = $this->validate([
            'material_title' => 'required|string|max:255',
            'material_description' => 'nullable|string',
            'material_type' => 'required|in:pdf,document,link',
            'material_file' => 'nullable|file|max:20480',
            'material_link' => 'nullable|url',
        ]);

        try {
            $material = Material::findOrFail($this->editingMaterialId);
            $material->title = $this->material_title;
            $material->description = $this->material_description;
            $material->type = $this->material_type;

            if ($this->material_type === 'link') {
                $material->file_path = null;
                $material->file_name = null;
                $material->file_size = null;
                $material->file_url = $this->material_link;
            }

            if ($this->material_file) {
                if ($material->file_path && file_exists(public_path($material->file_path))) {
                    unlink(public_path($material->file_path));
                }

                $fileName = time() . '_' . $this->material_file->getClientOriginalName();
                $filePath = 'uploads/materials/' . $fileName;

                $this->material_file->move(public_path('uploads/materials'), $fileName);

                $material->file_path = $filePath;
                $material->file_url = null;
                $material->file_name = $this->material_file->getClientOriginalName();
                $material->file_size = round(filesize(public_path($filePath)) / 1024);
            }

            $material->save();
            $this->loadClass();
            session()->flash('success', 'Materi berhasil diperbarui.');
            $this->closeMaterialModal();
        } catch (\Exception $e) {
            Log::error('Gagal update materi: ' . $e->getMessage());
            session()->flash('error', 'Gagal memperbarui materi: ' . $e->getMessage());
        }
    }

    public function deleteMaterial($id)
    {
        try {
            $material = Material::findOrFail($id);

            if ($material->file_path && file_exists(public_path($material->file_path))) {
                unlink(public_path($material->file_path));
            }

            $material->delete();
            $this->loadClass();
            session()->flash('success', 'Materi berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus materi: ' . $e->getMessage());
            session()->flash('error', 'Gagal menghapus materi: ' . $e->getMessage());
        }
    }

    // Assignment methods
    public function openAssignmentModal()
    {
        $this->resetAssignmentForm();
        $this->showAssignmentModal = true;
    }

    public function closeAssignmentModal()
    {
        $this->showAssignmentModal = false;
        $this->resetAssignmentForm();
    }

    public function resetAssignmentForm()
    {
        $this->assignment_title = '';
        $this->assignment_description = '';
        $this->assignment_instruction_type = 'file';
        $this->assignment_instruction_file = null;
        $this->assignment_instruction_link = '';
        $this->assignment_deadline = '';
        $this->assignment_weight = 0;
    }

    public function saveAssignment()
    {
        $validated = $this->validate([
            'assignment_title' => 'required|string|max:255',
            'assignment_description' => 'required|string',
            'assignment_instruction_type' => 'required|in:file,text,link',
            'assignment_instruction_file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx|max:10240',
            'assignment_instruction_link' => 'nullable|url',
            'assignment_deadline' => 'required|date',
            'assignment_weight' => 'required|integer|min:0|max:100',
        ]);

        try {
            $data = [
                'class_id' => $this->classId,
                'created_by' => Auth::id(),
                'title' => $this->assignment_title,
                'description' => $this->assignment_description,
                'deadline' => $this->assignment_deadline,
                'weight_percentage' => $this->assignment_weight,
                'submission_type' => $this->assignment_instruction_type,
                'status' => 'published',
            ];

            if ($this->assignment_instruction_type === 'file' && $this->assignment_instruction_file) {
                $filename = time() . '_' . uniqid() . '.' . $this->assignment_instruction_file->getClientOriginalExtension();
                $destinationPath = public_path('assignments');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }
                $this->assignment_instruction_file->move($destinationPath, $filename);
                $data['instructions'] = 'assignments/' . $filename;
            } elseif ($this->assignment_instruction_type === 'link') {
                $data['instructions'] = $this->assignment_instruction_link;
            } else {
                $data['instructions'] = $this->assignment_description;
            }

            Assignment::create($data);
            $this->loadClass();
            session()->flash('success', 'Tugas baru berhasil dibuat!');
            $this->closeAssignmentModal();
        } catch (\Exception $e) {
            Log::error('Gagal menambahkan tugas: ' . $e->getMessage());
            session()->flash('error', 'Terjadi kesalahan saat menambahkan tugas.');
        }
    }

    public function updateNilaiTugas($submissionId, $grade)
    {
        try {
            $submission = AssignmentSubmission::findOrFail($submissionId);
            $submission->score = $grade;
            $submission->graded_at = now();
            $submission->graded_by = Auth::user()->id;
            $submission->save();

            $this->loadClass();
            session()->flash('success', 'Grade saved!');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menyimpan nilai.');
        }
    }

    // Student methods
    public function openStudentModal()
    {
        $this->student_identifier = '';
        $this->showStudentModal = true;
    }

    public function closeStudentModal()
    {
        $this->showStudentModal = false;
        $this->student_identifier = '';
    }

    public function tambahMahasiswaKelas()
    {
        $this->validate([
            'student_identifier' => 'required|string',
        ]);

        try {
            $student = User::where('nim', $this->student_identifier)
                ->orWhere('email', $this->student_identifier)
                ->first();

            if (!$student) {
                session()->flash('error', 'Mahasiswa tidak ditemukan.');
                return;
            }

            $alreadyExists = $this->class->students()
                ->where('user_id', $student->id)
                ->exists();

            if ($alreadyExists) {
                session()->flash('warning', 'Mahasiswa sudah terdaftar di kelas ini.');
                return;
            }

            $this->class->students()->attach($student->id);
            $this->loadClass();
            session()->flash('success', 'Mahasiswa berhasil ditambahkan ke kelas.');
            $this->closeStudentModal();
        } catch (\Exception $e) {
            Log::error('Gagal menambahkan mahasiswa: ' . $e->getMessage());
            session()->flash('error', 'Terjadi kesalahan saat menambahkan mahasiswa.');
        }
    }

    public function hapusMahasiswaKelas($userId)
    {
        try {
            DB::table('class_user')
                ->where('class_id', $this->classId)
                ->where('user_id', $userId)
                ->delete();

            $this->loadClass();
            session()->flash('success', 'Mahasiswa berhasil dihapus dari kelas.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus mahasiswa dari kelas', [
                'class_id' => $this->classId,
                'user_id' => $userId,
                'error' => $e->getMessage(),
            ]);
            session()->flash('error', 'Terjadi kesalahan saat menghapus mahasiswa dari kelas.');
        }
    }

    // Post methods
    public function openPostModal($type = 'announcement')
    {
        $this->post_type = $type;
        $this->post_title = '';
        $this->post_content = '';
        $this->showPostModal = true;
    }

    public function closePostModal()
    {
        $this->showPostModal = false;
        $this->post_type = 'announcement';
        $this->post_title = '';
        $this->post_content = '';
    }

    public function createPost()
    {
        $this->validate([
            'post_content' => 'required|string',
            'post_title' => $this->post_type === 'discussion' ? 'required|string|max:255' : 'nullable',
        ]);

        try {
            Post::create([
                'class_id' => $this->classId,
                'user_id' => Auth::id(),
                'type' => $this->post_type,
                'title' => $this->post_type === 'discussion' ? $this->post_title : null,
                'content' => $this->post_content,
            ]);

            session()->flash('success', $this->post_type === 'announcement' ? 'Pengumuman berhasil dibuat!' : 'Diskusi berhasil dibuat!');
            $this->closePostModal();
        } catch (\Exception $e) {
            Log::error('Gagal membuat post: ' . $e->getMessage());
            session()->flash('error', 'Terjadi kesalahan saat membuat post.');
        }
    }

    public function deletePost($postId)
    {
        try {
            $post = Post::where('id', $postId)
                ->where('class_id', $this->classId)
                ->firstOrFail();

            $post->delete();
            session()->flash('success', 'Post berhasil dihapus!');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus post: ' . $e->getMessage());
            session()->flash('error', 'Terjadi kesalahan saat menghapus post.');
        }
    }

    public function togglePinPost($postId)
    {
        try {
            $post = Post::where('id', $postId)
                ->where('class_id', $this->classId)
                ->firstOrFail();

            $post->is_pinned = !$post->is_pinned;
            $post->save();
        } catch (\Exception $e) {
            Log::error('Gagal toggle pin post: ' . $e->getMessage());
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

    public function deleteReply($replyId)
    {
        try {
            $reply = PostReply::findOrFail($replyId);
            $post = Post::findOrFail($reply->post_id);

            // Only allow deletion if user is the author or instructor
            if ($reply->user_id === Auth::id() || $this->class->instructor_id === Auth::user()->instructor->id) {
                $reply->delete();
                session()->flash('success', 'Balasan berhasil dihapus!');
            } else {
                session()->flash('error', 'Anda tidak memiliki izin untuk menghapus balasan ini.');
            }
        } catch (\Exception $e) {
            Log::error('Gagal menghapus reply: ' . $e->getMessage());
            session()->flash('error', 'Terjadi kesalahan saat menghapus balasan.');
        }
    }

    public function render()
    {
        if (!$this->class) {
            return view('livewire.instructor.detail-kelas', [
                'class' => null,
                'materials' => collect(),
                'mahasiswa' => collect(),
                'formatted_assignments' => collect(),
            ]);
        }

        $materials = $this->class->materials->map(function ($item) {
            if ($item->type === 'link') {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'type' => $item->type,
                    'link' => $item->file_url,
                    'fileUrl' => null,
                    'uploadDate' => $item->created_at->format('Y-m-d'),
                    'downloads' => 0,
                    'description' => $item->description ?? ''
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
                    'description' => $item->description ?? ''
                ];
            }
        });

        $assignments = Assignment::where('class_id', $this->classId)
            ->withCount('submissions')
            ->get();

        $formatted_assignments = $assignments->map(function ($item) {
            $formatted_submissions = $item->submissions->map(function ($submission) {
                return [
                    'id' => $submission->id,
                    'student_name' => $submission->user->name,
                    'student_nim' => $submission->user->nim,
                    'student_id' => $submission->user_id,
                    'submitted_at' => \Carbon\Carbon::parse($submission->submitted_at)->format('d M Y H:i'),
                    'is_late' => $submission->is_late,
                    'submission_type' => $submission->file_path ? 'file' : 'text',
                    'file_url' => $submission->file_path ? asset($submission->file_path) : null,
                    'file_name' => $submission->file_name,
                    'submission_text' => $submission->submission_text,
                    'submission_link' => $submission->submission_link,
                    'grade' => $submission->score,
                    'feedback' => $submission->feedback,
                    'status' => $submission->status,
                    'assignment_id' => $submission->assignment_id
                ];
            });

            return [
                'id' => $item->id,
                'title' => $item->title,
                'deadline' => \Carbon\Carbon::parse($item->deadline)->format('d M Y H:i'),
                'deadline_raw' => \Carbon\Carbon::parse($item->deadline)->format('Y-m-d\TH:i'),
                'weight' => $item->weight_percentage,
                'description' => $item->description,
                'submissions' => $item->submissions_count,
                'total' => $this->class->students()->count(),
                'status' => $item->status,
                'instruction_type' => $item->submission_type,
                'submissions_data' => $formatted_submissions
            ];
        });

        $mahasiswa = DB::table('class_user')
            ->join('users', 'class_user.user_id', '=', 'users.id')
            ->where('class_user.class_id', $this->classId)
            ->where('users.role', 'student')
            ->select(
                'users.id',
                'users.nim',
                'users.name',
                'users.email',
                'class_user.class_id'
            )
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
        
        // Fetch instructor name directly from database
        $user = User::find(Auth::id());
        $instructor_name = $user && $user->name ? $user->name : 'Instructor';

        return view('livewire.instructor.detail-kelas', [
            'materials' => $materials,
            'mahasiswa' => $mahasiswa,
            'formatted_assignments' => $formatted_assignments,
            'posts' => $posts,
        ])->layout('dosen.app', [
            'title' => $title,
            'sub_title' => $sub_title,
            'instructor_name' => $instructor_name,
        ]);
    }
}

