<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

use App\DAO\OperacaoDAO;
use App\DAO\OrdemProducaoDAO;
use App\DAO\ProdutoDAO;
use App\DAO\RecursoDAO;
use App\DAO\SetorDAO;
use App\DAO\UsuarioDAO;
use App\Entities\OrdemProducao;
use App\Entities\Programacao;
use App\Entities\StatusOrdemProducao;
use DateTime;
use Exception;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Request;
use function redirect;
use function response;
use function view;

/**
 * Description of OrdemProducaoController
 *
 * @author HOME-PC
 */
class OrdemProducaoController extends Controller {

    private $ordemProducaoDAO;
    private $produtoDAO;
    private $setorDAO;
    private $operacaoDAO;
    private $recursoDAO;
    private $usuarioDAO;

    public function __construct() {
        $this->ordemProducaoDAO = new OrdemProducaoDAO();
        $this->produtoDAO = new ProdutoDAO();
        $this->usuarioDAO = new UsuarioDAO();
        $this->setorDAO = new SetorDAO();
        $this->operacaoDAO = new OperacaoDAO();
        $this->recursoDAO = new RecursoDAO();
    }

    public function form() {
        $produtos = $this->produtoDAO->listar();
        $data = array('produtos' => $produtos);
        return view('ordem.cadastro')->with($data);
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
            return redirect('ordem/form')->with('error', 'Erro ao Emitir Ordem de Produção ' . $ex->getMessage())->withInput();
        }
    }

    public function cancel(Request $request) {
        $ordem = $this->ordemProducaoDAO->pesquisar($request->input('id'));
        $ordem->setStatus(StatusOrdemProducao::CANCELADA);
        try {
            $this->ordemProducaoDAO->alterar($ordem );
            return redirect()->action('OrdemProducaoController@edit', ['id' => $ordem ->getId()])->with('success', 'Ordem de Produção Cancelada com Sucesso !!!');
        } catch (Exception $ex) {
            return redirect()->action('OrdemProducaoController@edit', ['id' => $ordem ->getId()])->with('error', 'Falha Ao Cancelar Ordem de Produção !!!' . $ex->getMessage());
        }
    }

    public function edit($id) {
        $ordemProducao = $this->ordemProducaoDAO->pesquisar($id);
        return view('ordem.editar')->with('ordem', $ordemProducao);
    }

    public function show(Request $request) {
        $page = (int) $request->input('page');
        if ($page != 0) {
            $ordens = $this->ordemProducaoDAO->listarComPaginacao(10, $page);
        } else {
            $ordens = $this->ordemProducaoDAO->listarComPaginacao();
        }
        return view('ordem.lista')->with('ordens', $ordens);
    }

    public function searchProduto(Request $request) {
        $id = $request->input('id');

        $produto = $this->produtoDAO->pesquisar($id);

        return response()->json($produto);
    }

    public function pesquisarPorCriterio(Request $request) {
        $criterio = $request->input('criterio');
        $valor = $request->input('valor');
        $ordens = $this->ordemProducaoDAO->pesquisarPorCriterio($criterio, $valor);
        return view('ordem.lista')->with('ordens', $ordens);
    }

    public function importarRoteiro(Request $request) {
        $produto = $this->produtoDAO->pesquisar($request->input('id'));

        $roteiros = array();



        foreach ($produto->getRoteiros() as $roteiro) {
            array_push($roteiros, $roteiro);
        }

        return json_encode($roteiros, JSON_PRETTY_PRINT);
    }

    public function importarEstrutura(Request $request) {
        $produto = $this->produtoDAO->pesquisar($request->input('id'));

        $itens = array();



        foreach ($produto->getItens() as $item) {
            array_push($itens, $item);
        }

        return json_encode($itens, JSON_PRETTY_PRINT);
    }

    public function carregaRecursos(Request $request) {
        $setor = $this->setorDAO->pesquisar($request->input('id'));

        $recursos = array();



        foreach ($setor->getRecursos() as $recurso) {
            array_push($recursos, $recurso);
        }

        return json_encode($recursos, JSON_PRETTY_PRINT);
    }

}
