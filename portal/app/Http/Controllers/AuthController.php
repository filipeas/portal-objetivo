<?php

namespace App\Http\Controllers;

use App\Http\Requests\Login;
use App\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Método responsável por retornar view de login.
     * 
     */
    public function auth()
    {
        return view('login');
    }

    /**
     * Método responsável por realizar login.
     * 
     */
    public function login(Login $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = User::find(Auth::user()->id);

            if ($user->type)
                return redirect()->route('student.home');
            else
                return redirect()->route('admin.home');
        } else {
            return redirect()->route('login')->with([
                'error' => true,
                'status' => 404,
                'message' => 'Verifique seu e-mail ou senha e tente novamente.',
            ]);
        }
    }

    /**
     * Método responsável por realizar logout.
     */
    public function logout()
    {
        Auth::logout();

        return redirect()->route('login')->with([
            'error' => false,
            'message' => 'Volte sempre.',
        ]);
    }
}
