<?php

namespace App\Http\Controllers;

use App\DAO\UsuarioDAO;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use function redirect;

class LoginController extends Controller {

    private $usuarioDAO;

    public function __construct() {
        $this->usuarioDAO = new UsuarioDAO();
    }

    public function login(Request $request) {
        $login = $request->input('login');
        $senha = md5($request->input('senha'));

        $usuario = $this->usuarioDAO->autenticarUsuario($login, $senha);

        if ($usuario != null) {
            $request->session()->put('usuarioLogado', $usuario->getNome());
            return redirect('home');
        } else {
            return redirect("/")->with('error', 'Usuario ou Senha Inválidos !!!');
        }
    }

    public function logout(Request $request) {
        $request->session()->forget('usuarioLogado');
        $request->session()->flush();
         return redirect("/")->with('success', 'Obrigado por utilizar o PCPWeb !!!');
    }

}
