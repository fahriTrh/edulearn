<?php

namespace App\Livewire\Instructor;

use App\Models\Instructor;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;

class Profile extends Component
{
    use WithFileUploads;

    public $title = 'Profile';
    public $sub_title = 'Kelola informasi profil dan kredensial Anda';

    // Active tab: 'profile', 'instructor', 'password'
    public $activeTab = 'profile';

    // Profile Information
    public $name = '';
    public $email = '';
    public $phone = '';
    public $bio = '';
    public $address = '';
    public $birth_date = '';
    public $avatar;

    // Instructor Information
    public $instructor_title = '';
    public $specialization = '';
    public $description = '';

    // Password Change
    public $current_password = '';
    public $new_password = '';
    public $new_password_confirmation = '';

    public function mount()
    {
        $this->loadProfile();
    }

    public function loadProfile()
    {
        $user = Auth::user();
        $instructor = $user->instructor;

        // Load user profile
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone ?? '';
        $this->bio = $user->bio ?? '';
        $this->address = $user->address ?? '';
        $this->birth_date = $user->birth_date ? $user->birth_date->format('Y-m-d') : '';

        // Load instructor info
        if ($instructor) {
            $this->instructor_title = $instructor->title ?? '';
            $this->specialization = $instructor->specialization ?? '';
            $this->description = $instructor->description ?? '';
        }
    }

    public function switchTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function saveProfile()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:500',
            'address' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        try {
            $user = Auth::user();
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->phone = $validated['phone'] ?? null;
            $user->bio = $validated['bio'] ?? null;
            $user->address = $validated['address'] ?? null;
            $user->birth_date = $validated['birth_date'] ?? null;

            if ($this->avatar) {
                $filename = time() . '_' . uniqid() . '.' . $this->avatar->getClientOriginalExtension();
                $destinationPath = public_path('avatars');
                
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                // Delete old avatar if exists
                if ($user->avatar && file_exists(public_path($user->avatar))) {
                    unlink(public_path($user->avatar));
                }

                $this->avatar->move($destinationPath, $filename);
                $user->avatar = 'avatars/' . $filename;
            }

            $user->save();

            session()->flash('success', 'Profil berhasil diperbarui!');
            $this->loadProfile();
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function saveInstructorInfo()
    {
        $validated = $this->validate([
            'instructor_title' => 'nullable|string|max:50',
            'specialization' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        try {
            $user = Auth::user();
            $instructor = $user->instructor;

            if (!$instructor) {
                $instructor = Instructor::create([
                    'user_id' => $user->id,
                    'title' => $validated['instructor_title'] ?? null,
                    'specialization' => $validated['specialization'],
                    'description' => $validated['description'] ?? null,
                ]);
            } else {
                $instructor->title = $validated['instructor_title'] ?? null;
                $instructor->specialization = $validated['specialization'];
                $instructor->description = $validated['description'] ?? null;
                $instructor->save();
            }

            session()->flash('success', 'Informasi instruktur berhasil diperbarui!');
            $this->loadProfile();
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function savePassword()
    {
        $this->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed|different:current_password',
            'new_password_confirmation' => 'required',
        ], [
            'current_password.required' => 'Password saat ini wajib diisi',
            'new_password.required' => 'Password baru wajib diisi',
            'new_password.min' => 'Password baru minimal 8 karakter',
            'new_password.confirmed' => 'Konfirmasi password tidak cocok',
            'new_password.different' => 'Password baru harus berbeda dengan password lama',
            'new_password_confirmation.required' => 'Konfirmasi password wajib diisi',
        ]);

        try {
            $user = Auth::user();

            if (!Hash::check($this->current_password, $user->password)) {
                $this->addError('current_password', 'Password saat ini salah');
                return;
            }

            $user->password = Hash::make($this->new_password);
            $user->save();

            $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
            session()->flash('success', 'Password berhasil diubah!');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $user = Auth::user();
        $instructor = $user->instructor;
        
        // Fetch instructor name directly from database
        $dbUser = User::find(Auth::id());
        $instructor_name = $dbUser && $dbUser->name ? $dbUser->name : 'Instructor';

        return view('livewire.instructor.profile', [
            'user' => $user,
            'instructor' => $instructor,
        ])->layout('dosen.app', [
            'title' => $this->title,
            'sub_title' => $this->sub_title,
            'instructor_name' => $instructor_name,
        ]);
    }
}
