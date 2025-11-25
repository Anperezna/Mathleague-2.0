<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('register');
    }
    
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

        return redirect()->route('juegos')->with('success', 'Registro exitoso. Ahora puedes iniciar sesión.');
    }
}
