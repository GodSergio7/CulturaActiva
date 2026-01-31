<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Mostrar formulario de registro
    public function mostrarRegistro()
    {
        return view('auth.register');
    }

    // Procesar registro
    public function registro(Request $request)
    {
        // Validar datos
        $request->validate([
            'nombre' => 'required|string|max:50',
            'apellidos' => 'required|string|max:80',
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required|min:6|confirmed',
        ]);

        // Crear usuario
        Usuario::create([
            'nombre' => $request->nombre,
            'apellidos' => $request->apellidos,
            'email' => $request->email,
            'contrasena' => Hash::make($request->password),
            'rol' => 'cliente', // Por defecto cliente
            'activo' => 1
        ]);

        return redirect()->route('login')->with('success', '¡Registro exitoso! Ya puedes iniciar sesión.');
    }

    // Mostrar formulario de login
    public function mostrarLogin()
    {
        return view('auth.login');
    }

    // Procesar login
    public function login(Request $request)
    {
        // Validar datos
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Buscar usuario
        $usuario = Usuario::where('email', $request->email)->first();

        // Verificar si existe y la contraseña es correcta
        if ($usuario && Hash::check($request->password, $usuario->contrasena)) {
            // Verificar si está activo
            if (!$usuario->activo) {
                return back()->withErrors(['email' => 'Tu cuenta está inactiva.']);
            }

            // Iniciar sesión
            Auth::login($usuario);

            // Redirigir según rol
            if ($usuario->rol === 'admin') {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('home');
            }
        }

        // Si falla
        return back()->withErrors(['email' => 'Credenciales incorrectas.']);
    }

    // Cerrar sesión
    public function logout()
    {
        Auth::logout();
        return redirect()->route('home')->with('success', 'Sesión cerrada correctamente.');
    }
}