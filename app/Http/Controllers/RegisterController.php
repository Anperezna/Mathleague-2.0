<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    //
    public function showRegistrationForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
       $request ->validate([
           'username' => 'required|string|max:255',
           'email' => 'required|string|email|max:255|unique:users',
           'contraseña' => 'required|string|min:6|confirmed',
       ]);
    
       $usuario = new \App\Models\Usuario();
       $usuario->username = $request->input('username');
       $usuario->email = $request->input('email');
       $usuario->contraseña = Hash::make($request->input('contraseña'));
       $usuario->fecha_registro = now();
       $usuario->save();
       
       return redirect()->route('juegos')->with('success', 'Registro exitoso. Ahora puedes iniciar sesión.');
    }

}
