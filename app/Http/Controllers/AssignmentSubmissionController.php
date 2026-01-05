<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class AssignmentSubmissionController extends Controller
{
    public function store(Request $request, Assignment $assignment)
    {
        $request->validate([
            'file' => 'nullable|file|max:10240|mimes:pdf,doc,docx,zip,jpg,jpeg,png',
            'note' => 'nullable|string|max:5000',
        ], [
            'file.max' => 'File tidak boleh lebih dari 10MB',
        ]);

        try {
            $user = Auth::user();

            // Ensure student is enrolled in the assignment's class
            if (!$assignment->students()->where('users.id', $user->id)->exists()) {
                return response()->json(['message' => 'Anda tidak diperbolehkan mengirim tugas ini.'], 403);
            }

            $filePath = null;
            $fileName = null;
            $fileSize = null;

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $originalName = $file->getClientOriginalName();
                $filename = time() . '_' . Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();

                $file->storeAs('submissions', $filename, 'public');

                $filePath = 'storage/submissions/' . $filename;
                $fileName = $originalName;
                $fileSize = round($file->getSize() / 1024);

                // Delete previous submission file if exists
                $existing = AssignmentSubmission::where('assignment_id', $assignment->id)
                    ->where('user_id', $user->id)
                    ->first();
                if ($existing && $existing->file_path) {
                    $publicExisting = public_path($existing->file_path);
                    $storageExisting = storage_path('app/public/' . ltrim(str_replace('storage/', '', $existing->file_path), '/'));
                    if (file_exists($publicExisting)) {
                        @unlink($publicExisting);
                    } elseif (file_exists($storageExisting)) {
                        @unlink($storageExisting);
                    }
                }
            }

            $isLate = now() > $assignment->deadline;

            AssignmentSubmission::updateOrCreate(
                [
                    'assignment_id' => $assignment->id,
                    'user_id' => $user->id,
                ],
                [
                    'submission_text' => $request->input('note') ?: null,
                    'file_path' => $filePath,
                    'file_name' => $fileName,
                    'file_size' => $fileSize,
                    'submission_link' => null,
                    'submitted_at' => now(),
                    'is_late' => $isLate,
                    'status' => 'submitted',
                ]
            );

            return response()->json(['message' => 'Tugas berhasil dikumpulkan'], 200);
        } catch (\Exception $e) {
            Log::error('Gagal submit tugas (controller): ' . $e->getMessage());
            return response()->json(['message' => 'Gagal menyimpan pengiriman.'], 500);
        }
    }
}
