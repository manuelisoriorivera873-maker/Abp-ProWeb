<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // IMPORTANTE: Importar el modelo User
use Illuminate\Support\Facades\Hash; // IMPORTANTE: Para encriptar contraseñas

class LoginController extends Controller
{
    public function index() {
        if (Auth::check()) return redirect()->intended('/');
        return view('auth.login');
    }

    // --- NUEVO: Mostrar formulario de registro ---
    public function showRegister() {
        if (Auth::check()) return redirect()->intended('/');
        return view('auth.register');
    }

    // --- NUEVO: Lógica de registro ---
    public function storeRegister(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed', // 'confirmed' busca un campo password_confirmation
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        //Auth::login($user);
        return redirect()->route('login')->with('success', 'Cuenta creada. Ahora inicia sesión.');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors(['email' => 'Credenciales incorrectas.']);
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}