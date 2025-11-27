<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

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
}
