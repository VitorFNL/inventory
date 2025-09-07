<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            Auth::logout();
            
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return redirect('/login')->with('success', 'Logout realizado com sucesso!');
        } catch (\Exception $e) {
            return back()->withErrors([
                'logout' => 'Erro ao tentar fazer logout: ' . $e->getMessage(),
            ]);
        }
    }
}
