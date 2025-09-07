<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\UseCases\Login\Login;
use App\UseCases\Login\LoginInput;

class LoginController extends Controller
{
    public function __construct(
        private Login $login
    ) {}

    public function __invoke(Request $request)
    {
        // Validação dos dados
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'Por favor, insira um email válido.',
            'password.required' => 'O campo senha é obrigatório.',
            'password.min' => 'A senha deve ter pelo menos 6 caracteres.',
        ]);

        $credentials = $request->only('email', 'password');

        $user = $this->login->execute(new LoginInput(
            email: $credentials['email'],
            password: $credentials['password']
        ));

        if (!$user) {
            return back()->withErrors([
                'email' => 'As credenciais fornecidas não correspondem aos nossos registros.',
                'password' => 'As credenciais fornecidas não correspondem aos nossos registros.',
            ])->withInput($request->except('password'));
        }

        $request->session()->regenerate();
        
        return redirect()->intended('/dashboard')->with('success', 'Login realizado com sucesso!');
    }
}
