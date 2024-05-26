<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->input('email');

        $domain = explode('@', $email)[1];

        // Dobivanje na lozinkata od domenot
        $password = 'password'; 
        
        // Avtentikacija
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            return redirect()->intended('import.excel.get'); 
        } else {
    
            return back()->withErrors(['email' => 'Invalid credentials']);
        }
    }


    public function authenticateWithoutPassword()
    {
         $user = explode("@", $_SERVER['REMOTE_USER']);

        //$user = $_SERVER['REMOTE_USER'];
        
        // dd($user);
      
        // Proverka na korisnikot vo baza preku korisničko ime (username)
        if (Auth::attempt(['username' => $user[0]])) {
           
            return redirect()->intended('dashboard');
        }

        return "Нема корисник во базата";
    }
}
