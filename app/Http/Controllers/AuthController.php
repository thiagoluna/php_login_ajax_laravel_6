<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function dashboard()
    {
        if(Auth::check() === true){
            return view('admin.dashboard');
        }

        return redirect()->route('admin.login');
        
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        //Validar de email digitado está em formato de email
        if(!filter_var($request->email, FILTER_VALIDATE_EMAIL)){            
            $login['success'] = false;
            $login['message'] = 'Digite um email válido.';
            echo json_encode($login);
            return;
        }
        
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];
        
        if(Auth::attempt($credentials)){           
            $login['success'] = true;            
            echo json_encode($login); 
            return;          
        }

        $login['success'] = false;
        $login['message'] = 'Dados incorretos. Tente novamente.';
        echo json_encode($login);
        return;
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin');
    }
}
