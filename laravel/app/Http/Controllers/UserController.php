<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.create',[
            'title'=>'Register'
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => [
                'required',
                'string',
                'unique:users',
                'regex:/^[a-zA-Z0-9-]+$/',
                'max:20',
            ],
            'password' => 'required|string|min:8|confirmed',
        ], [
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah terdaftar.',
            'username.regex' => 'Username hanya boleh terdiri dari huruf, angka, dan tanda -.',
            'username.max' => 'Username tidak boleh lebih dari 20 karakter.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password harus terdiri dari minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::create([
            'name' => $request->username,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect()->route('home')->with('success', 'Registration successful');
    }
    public function showLoginForm()
    {
        return view('auth.login',[
            'title'=> 'Login'
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => [
                'required',
                'string',
                'regex:/^[a-zA-Z0-9-]+$/',
                'max:20',
            ],
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            return redirect()->route('home')->with('success', 'Login successful');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah',
        ]);
    }

    // Edit Profile
    public function showEditForm()
    {
        return view('auth.edit');
    }

    public function edit(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return back()->with('success', 'Profile updated successfully');
    }

    // Menampilkan profil pengguna
    public function showProfile()
    {
        $user = Auth::user(); // Mengambil pengguna yang sedang login

        return view('auth.show', [
            'title' => 'Profile',
            'user' => $user, // Mengirimkan data pengguna ke tampilan
        ]);
    }

    // Logout user
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'You have been logged out');
    }
}
