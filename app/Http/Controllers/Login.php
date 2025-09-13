<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Login extends Controller
{
    public function view(){
        return view('login');
    }
    public function login(Request $request){
        $data = $request->validate(['name'=>['required'],'password'=>['required']]);
        if(Auth::attempt($data)){
            $request->session()->regenerate();
             $position = strtolower(auth()->user()->position);

        // redirect ke {position}/home
        return redirect()->intended("/{$position}/home");
    }

    // kalau gagal login
    return back()->withErrors([
        'name' => 'Nama atau password salah.',
    ])->onlyInput('name');
    }
}
