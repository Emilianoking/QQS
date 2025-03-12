<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/usuario';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // Personalizar el campo de contraseña si usas "contraseña" en lugar de "password"
    protected function credentials(Request $request)
    {
        return [
            'email' => $request->input('email'),
            'password' => $request->input('contraseña'),
        ];
    }

    // Redirigir según el rol después de autenticar
    protected function authenticated(Request $request, $user)
    {
        if ($user->rol === 'administrador') {
            return redirect('/adm');
        }
        return redirect('/usuario');
    }
}