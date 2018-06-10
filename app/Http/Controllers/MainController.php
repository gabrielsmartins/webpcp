<?php

namespace App\Http\Controllers;

use App\DAO\OrdemProducaoDAO;
use App\DAO\RequisicaoMaterialDAO;
use Illuminate\Http\Request;
use function redirect;
use function view;

class MainController extends Controller {

    private $ordemProducaoDAO;
    private $requisicaoDAO;
    

    public function __construct() {
        $this->ordemProducaoDAO = new OrdemProducaoDAO();
         $this->requisicaoDAO = new RequisicaoMaterialDAO();
    }

    public function index(Request $request) {

        $user = $request->session()->get('usuarioLogado');
        if ($user == null) {
            return view('usuario.login');
        } else {
            return redirect('home');
        }
    }

    public function home(Request $request) {
        $user = $request->session()->get('usuarioLogado');
        if ($user == null) {
            return redirect('/');
        }

        $page = (int) $request->input('page');
        if ($page != 0) {
            $ordens = $this->ordemProducaoDAO->listarComPaginacao(10, $page);
        } else {
            $ordens = $this->ordemProducaoDAO->listarComPaginacao();
        }

        
        $ordens = $this->ordemProducaoDAO->listarComPaginacao();
        $data = array('ordens' => $ordens);

        return view('main.home')->with($data);
    }
    
    
    
     public function pesquisarPorCriterio(Request $request) {
        $criterio = $request->input('criterio');
        $valor = $request->input('valor');
        $ordens = $this->ordemProducaoDAO->pesquisarPorCriterio($criterio, $valor);
        return view('main.home')->with('ordens', $ordens);
    }

}
