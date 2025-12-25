<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // akun admin statis (AMAN UNTUK UAS)
        if (
            $request->username === 'admin' &&
            $request->password === 'admin123'
        ) {
            session(['admin' => true]);
            return redirect('/admin/inventaris');
        }

        return back()->with('error', 'Username atau password salah');
    }

    public function logout()
    {
        session()->forget('admin');
        return redirect('/login');
    }
}
