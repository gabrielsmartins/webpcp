<?php

namespace App\Http\Controllers;

class MainController extends Controller{
    
    
    
    public function home(){
        return view('main.home');
    }
    
    
    public function teste(){
        return view('admin.dashboard');
    }
    
}
