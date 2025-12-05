<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

/**
 * Controlador para el registro de nuevos usuarios
 * 
 * Gestiona la creación de nuevas cuentas de usuario validando
 * los datos del formulario y almacenando la información en la base de datos.
 * 
 * @package App\Http\Controllers
 * @author Math League Team
 * @version 1.0.0
 */
class RegisterController extends Controller
{
    /**
     * Muestra el formulario de registro
     * 
     * @return \Illuminate\View\View Vista del formulario de registro
     */
    public function showRegistrationForm()
    {
        return view('register');
    }
    
    /**
     * Procesa el registro de un nuevo usuario
     * 
     * Valida que el username y email sean únicos, la contraseña tenga
     * mínimo 6 caracteres y sea confirmada correctamente. Hashea la
     * contraseña antes de almacenarla en la base de datos.
     * 
     * @param \Illuminate\Http\Request $request Solicitud HTTP con datos del formulario
     * @return \Illuminate\Http\RedirectResponse Redirección a juegos con mensaje de éxito
     * 
     * @throws \Illuminate\Validation\ValidationException Si la validación falla
     * 
     * @see \App\Models\Usuario
     */
    public function register(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'username' => 'required|string|max:255|unique:usuario,username',
            'email' => 'required|string|email|max:255|unique:usuario,email',
            'contrasena' => 'required|string|min:6|confirmed',
        ]);

        // Crear un nuevo usuario
        $usuario = new \App\Models\Usuario();
        $usuario->username = $request->input('username');
        $usuario->email = $request->input('email');
        $usuario->contrasena = Hash::make($request->input('contrasena'));
        $usuario->fecha_registro = Carbon::now()->toDateTimeString();
        $usuario->save();

        return redirect()->route('login')->with('success', 'Registro exitoso. Ahora puedes iniciar sesión.');
    }
}
