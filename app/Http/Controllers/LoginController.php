<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * Controlador para la autenticación de usuarios
 * 
 * Maneja el proceso de inicio de sesión verificando las credenciales
 * del usuario y estableciendo la sesión autenticada.
 * 
 * @package App\Http\Controllers
 * @author Math League Team
 * @version 1.0.0
 */
class LoginController extends Controller
{
    /**
     * Muestra el formulario de inicio de sesión
     * 
     * @return \Illuminate\View\View Vista del formulario de login
     */
    public function showLoginForm()
    {
        return view('login');
    }

    /**
     * Procesa el intento de inicio de sesión
     * 
     * Valida las credenciales del usuario comparando el username y la
     * contraseña hasheada. Si las credenciales son válidas, autentica
     * al usuario y lo redirige a la página de juegos.
     * 
     * @param \Illuminate\Http\Request $request Solicitud HTTP con username y contrasena
     * @return \Illuminate\Http\RedirectResponse Redirección a juegos o back con error
     * 
     * @see \App\Models\Usuario
     */
    public function login(Request $request)
    {
        $usuario = Usuario::where('username', $request->input('username'))->first();

        if ($usuario && Hash::check($request->input('contrasena'), $usuario->contrasena)) { 
            Auth::login($usuario);
            $response = redirect('juegos');            
        } else {
            session()->flash('error', 'Credenciales inválidas');
            $response = redirect()->back()->withInput();
        }
        return $response; 
    }

    /**
     * Cierra la sesión del usuario autenticado
     * 
     * Termina la sesión actual del usuario y lo redirige
     * a la página de registro.
     * 
     * @return \Illuminate\Http\RedirectResponse Redirección a register
     */
    public function logout()
    {
        Auth::logout();
        session()->flush();
        return redirect()->route('login');
    }
}
