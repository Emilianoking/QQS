<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Mostrar el formulario de login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:usuarios',
            'telefono' => 'nullable|string|max:20',
            'grado' => 'nullable|string|max:50',
            'password' => 'required|string|min:8', // Correcto: usa "password"
        ]);

        $user = new Usuario();
        $user->nombre = $request->nombre;
        $user->email = $request->email;
        $user->telefono = $request->telefono;
        $user->grado = $request->grado;
        $user->password = Hash::make($request->password); // Correcto: usa "password"
        $user->rol = 'estudiante';
        $user->save();

        Auth::login($user);
        return redirect('/usuario');
    }

    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = Usuario::where('email', $request->email)->first();

    if ($user && Hash::check($request->password, $user->password)) {
        Auth::login($user);
        // Depuración: verificar si la autenticación persiste
        if (Auth::check()) {
            return $user->rol === 'administrador' ? redirect('/adm') : redirect('/usuario');
        } else {
            return back()->withErrors(['email' => 'Error al iniciar sesión, autenticación no persistió']);
        }
    }

    return back()->withErrors(['email' => 'Credenciales incorrectas'])->withInput();
}

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}