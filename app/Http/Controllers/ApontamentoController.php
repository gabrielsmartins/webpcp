<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

use App\DAO\ApontamentoDAO;
use App\DAO\OrdemProducaoDAO;
use App\DAO\UsuarioDAO;
use App\Entities\OrdemProducao;
use App\Entities\Programacao;
use DateTime;
use Exception;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Request;
use function redirect;
use function view;

/**
 * Description of OrdemProducaoController
 *
 * @author HOME-PC
 */
class ApontamentoController extends Controller {

    private $ordemProducaoDAO;
    private $apontamentoDAO;
    private $usuarioDAO;

    public function __construct() {
        $this->ordemProducaoDAO = new OrdemProducaoDAO();
        $this->usuarioDAO = new UsuarioDAO();
        $this->apontamentoDAO = new ApontamentoDAO();
    }

    public function form() {
        $ordens = $this->ordemProducaoDAO->listar();
        $data = array('ordens' => $ordens);
        return view('apontamento.cadastro')->with($data);
    }

    public function store(Request $request) {
        $produto = $this->produtoDAO->pesquisar($request->input('produto'));
        $quantidade = $request->input('quantidade');
        $prazo = new DateTime(date('Y-m-d', strtotime(str_replace("/", "-", $request->input('prazo')))));
        $responsavel = $this->usuarioDAO->pesquisar(Session::get('idUsuarioLogado'));
        $recursos = $request->input('recurso');

        $ordemProducao = new OrdemProducao($produto, $quantidade, $prazo, $responsavel);
        $roteiros = $produto->getRoteiros();
        for ($i = 0; $i < $roteiros->count(); $i++) {
            $recurso = $this->recursoDAO->pesquisar($recursos[$i]);
            $programacao = new Programacao($ordemProducao, ($i + 1), $roteiros[$i], $recurso);
            $ordemProducao->adicionarProgramacao($programacao);
        }


        try {
            $this->ordemProducaoDAO->salvar($ordemProducao);
            return redirect('ordem/form')->with('success', 'Ordem de Produção nº' . $ordemProducao->getId() . ' Emitida com Sucesso !!!');
        } catch (Exception $ex) {
            return redirect('ordem/form')->with('error', 'Erro ao Emitir Ordem de Produção ' . $ex->getMessage());
        }
    }

 

    public function edit($id) {
        $apontamento = $this->apontamentoDAO->pesquisar($id);
        return view('apontamento.editar')->with('apontamento', $apontamento);
    }

    public function find(Request $request) {
        $ordemProducao = $this->ordemProducaoDAO->pesquisar($request->input('id'));


        $programacoes = array();

        foreach ($ordemProducao->getProgramacoes() as $programacao) {
            array_push($programacoes, $programacao);
        }

        return json_encode($programacoes, JSON_PRETTY_PRINT);
    }

    public function show(Request $request) {
        $page = (int) $request->input('page');
        if ($page != 0) {
            $apontamentos = $this->apontamentoDAO->listarComPaginacao(10, $page);
        } else {
            $apontamentos = $this->apontamentoDAO->listarComPaginacao();
        }
        return view('apontamento.lista')->with('apontamentos', $apontamentos);
    }



    public function pesquisarPorCriterio(Request $request) {
        $criterio = $request->input('criterio');
        $valor = $request->input('valor');
        $apontamentos= $this->apontamentoDAO->pesquisarPorCriterio($criterio, $valor);
        return view('apontamento.lista')->with('apontamentos', $apontamentos);
    }

}
