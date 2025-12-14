<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'identifier' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $credentials['identifier'])
            ->orWhere('nim', $credentials['identifier'])
            ->first();

        if (!$user) {
            return back()->withErrors([
                'identifier' => 'User not found!'
            ]);
        }

        // Cek password
        if (!Auth::attempt(['email' => $user->email, 'password' => $credentials['password']])) {
            return back()->withErrors([
                'password' => 'Password salah.',
            ]);
        }

        // Redirect sesuai role
        return match ($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'instructor' => redirect()->route('dosen.dashboard'),
            'student' => redirect()->route('mahasiswa.dashboard'),
            default => redirect()->route('login'),
        };
    }

    public function logout(Request $request)
    {
        Auth::logout(); // logout user

        $request->session()->invalidate(); // hapus session lama
        $request->session()->regenerateToken(); // regenerasi CSRF token

        return redirect('/login'); // arahkan ke halaman login
    }
}
