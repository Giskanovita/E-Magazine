<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }
    
    public function showRegister()
    {
        return view('auth.register');
    }
    
    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
        
        $user = User::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'siswa'
        ]);
        
        Auth::login($user);
        return redirect('/siswa/dashboard');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Find user by username only
        $user = User::where('username', $request->username)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            
            // Redirect berdasarkan role
            switch ($user->role) {
                case 'admin':
                    return redirect('/admin/dashboard');
                case 'guru':
                    return redirect('/guru/dashboard');
                case 'siswa':
                    return redirect('/siswa/dashboard');
                default:
                    return redirect('/dashboard');
            }
        }

        return back()->withErrors(['login' => 'Username atau password tidak sesuai'])->withInput($request->except('password'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
    

}