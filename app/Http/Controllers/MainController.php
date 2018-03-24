<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use function redirect;

class MainController extends Controller{
    
    
    public function index(Request $request){
        $user = $request->session()->get('usuarioLogado');
        if ($user == null){
            return view('usuario.login');
    }else{
        return redirect('home');
    }
       
    }
    
  
    public function home(Request $request){
        $user = $request->session()->get('usuarioLogado');
        if ($user == null){
           return redirect('/');
    }else{
         return view('main.home');
    }
       
    }
    
    

    
}
