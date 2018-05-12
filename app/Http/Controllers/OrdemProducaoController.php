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
use App\DAO\SetorDAO;
use App\DAO\UsuarioDAO;
use App\Entities\OrdemProducao;
use App\Entities\Programacao;
use App\Entities\UnidadeMedida;
use DateTime;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
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
    private $usuarioDAO;

    public function __construct() {
        $this->ordemProducaoDAO = new OrdemProducaoDAO();
        $this->produtoDAO = new ProdutoDAO();
        $this->usuarioDAO = new UsuarioDAO();
        $this->setorDAO = new SetorDAO();
        $this->operacaoDAO = new OperacaoDAO();
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
        $operacoes = $request->input('operacao');
        $recursos = $request->input('recurso');
        $dataInicio = $request->input('dataInicioPrevista');
        $dataFim = $request->input('dataInicioPrevista');

        $ordemProducao = new OrdemProducao($produto, $quantidade, $prazo, $responsavel);

        for ($i = 0; $i <= $operacoes->count(); $i++) {
            $operacao = $this->operacaoDAO->pesquisar($operacoes[$i]);
            $recurso = $this->operacaoDAO->pesquisar($recursos[$i]);
            $dataInicioPrevista = $dataInicio[$i];
            $programacao = new Programacao($ordemProducao, $operacao, $recurso, $dataInicioPrevista);
            $ordemProducao->adicionarProgramacao($programacao);
        }


        try {
            $this->ordemProducaoDAO->salvar($ordemProducao);
            return redirect('ordem/form')->with('success', 'Ordem de Produção nº' . $ordemProducao->getId() . ' Emitida com Sucesso !!!');
        } catch (Exception $ex) {
            return redirect('ordem/form')->with('error', 'Erro ao Emitir Ordem de Produção ' . $ex->getMessage());
        }
    }

    public function cancel(Request $request) {
        $id = $request->input('id');
        $descricao = $request->input('descricao');
        $sigla = $request->input('sigla');

        $unidade = new UnidadeMedida($descricao, $sigla);
        $unidade->setId($id);

        try {
            $this->ordemProducaoDAO->alterar($unidade);
            return redirect()->action('RetiradaProdutoController@edit', ['id' => $unidade->getId()])->with('success', 'Ordem de Produção Cancelada com Sucesso !!!');
        } catch (Exception $ex) {
            return redirect()->action('RetiradaProdutoController@edit', ['id' => $unidade->getId()])->with('error', 'Falha Ao Cancelar Ordem de Produção !!!' . $ex->getMessage());
        }
    }

    public function edit($id) {
        $ordemProducao = $this->ordemProducaoDAO->pesquisar($id);
        return view('ordem.editar')->with('ordem', $ordemProducao);
    }

    public function show() {
        $ordens = $this->ordemProducaoDAO->listar();
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
