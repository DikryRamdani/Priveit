<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Login logic
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('username', $request->username)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // Berhasil login
            Auth::login($user);
            return redirect('/dashboardUser'); // ganti ke halaman dashboard lo
        }

        return back()->with('error', 'Username atau Password salah!');
    }

    // Register logic
    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'username' => 'required|unique:users,username',
            'password' => 'required|min:6'
        ]);
        if ('password' < 6) {
            return 'pasword minimal 6 karakter';
        }

        User::create([
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password)
        ]);

        return redirect('/login')->with('success', 'Berhasil registrasi, silakan login.');
    }

    // public function logout() {
    //     Auth::logout();
    //     return redirect('/landingPage');
    // }

    public function logout(Request $request)
    {
        Auth::logout();

        // Hapus session-nya
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect ke login atau landing page
        return redirect('/login')->with('success', 'Berhasil logout');
    }
}
