<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            // Cek role
            if (Auth::user()->role == 'ADMIN_GUDANG') {
                return redirect('retail');
            } else if (Auth::user()->role == 'ADMIN_MEKANIK') {
                return redirect('bengkel');
            } else {
                return redirect('/');
            }
            return redirect('dashboard');
        }
        return view('auth.login');
    }

    public function auth(Request $request)
    {
        $request->validate([
            'email' => 'required|exists:users',
            'password' => 'required',
        ]);

        $login = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        // CEK Role ADMIN
        $role = User::where('email', $request->email)->pluck('role')->first();
        if ($role == 'USER') {
            return back()->withErrors([
                'message' => 'Maaf, Anda Bukan Admin Edie Arta Motor!',
            ]);
        }

        // CEK LOGIN
        if (Auth::attempt($login)) {
            $user = Auth::getProvider()->retrieveByCredentials($login);
            if (Auth::user()->role == 'ADMIN_GUDANG') {
                return redirect('retail');
            } else if (Auth::user()->role == 'ADMIN_MEKANIK') {
                return redirect('bengkel');
            }
        } else {
            // Auth Gagal
            return back()->withErrors([
                'message' => 'Email atau Password Salah!',
            ])->withInput($request->only('email'));
        }
    }

    public function logout()
    {
        Session::flush();

        Auth::logout();

        return  redirect()->route('login');
    }
}
