<?php

namespace App\Http\Controllers;

use App\DAO\ApontamentoDAO;
use App\DAO\OrdemProducaoDAO;
use App\DAO\RequisicaoMaterialDAO;
use DateTime;
use Illuminate\Http\Request;
use function redirect;
use function view;

class MainController extends Controller {

    private $ordemProducaoDAO;
    private $requisicaoDAO;
    private $apontamentoDAO;

    public function __construct() {
        $this->ordemProducaoDAO = new OrdemProducaoDAO();
        $this->requisicaoDAO = new RequisicaoMaterialDAO();
        $this->apontamentoDAO = new ApontamentoDAO();
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
        $dataInicio =  $request->input('dataInicio') == null? null : new DateTime(date('Y-m-d H:i:s', strtotime(str_replace("/", "-", $request->input('dataInicio')))));
        $dataFim =   $request->input('dataFim') == null? null :  new DateTime(date('Y-m-d H:i:s', strtotime(str_replace("/", "-", $request->input('dataFim')))));
        

        if ($page != 0) {
            $ordens = $this->ordemProducaoDAO->listarComPaginacao(10, $page);
        } else {
            $ordens = $this->ordemProducaoDAO->listarComPaginacao();
        }


        $ordens = $this->ordemProducaoDAO->listarComPaginacao();

        $apontamentos = $this->apontamentoDAO->obterApontamentosPorPeriodo($dataInicio, $dataFim);
        
        $producao = $this->apontamentoDAO->obterApontamentoPorSetor($dataInicio, $dataFim);

        $data = array('ordens' => $ordens,
                      'apontamentos'=> json_encode($apontamentos),
                      'producao' => json_encode($producao));

        return view('main.home')->with($data);
    }

    public function pesquisarPorCriterio(Request $request) {
        $page = (int) $request->input('page');
        $criterio = $request->input('criterio');
        $valor = $request->input('valor');
        
        if ($page != 0 || $valor ==null) {
            $ordens = $this->ordemProducaoDAO->listarComPaginacao(10, $page);
        } else {
            $ordens = $this->ordemProducaoDAO->listarComPaginacao();
        }
        
        $ordens = $this->ordemProducaoDAO->pesquisarPorCriterio($criterio, $valor);
        $apontamentos = $this->apontamentoDAO->obterApontamentosPorPeriodo(null, null);
        $producao = $this->apontamentoDAO->obterApontamentoPorSetor(null, null);
        $data = array('ordens' => $ordens,
                      'apontamentos'=> json_encode($apontamentos),
                      'producao' => json_encode($producao));
        return view('main.home')->with($data);
    }

}
