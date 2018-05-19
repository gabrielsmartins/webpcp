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
use App\Entities\UnidadeMedida;
use DateTime;
use Exception;
use Illuminate\Routing\Controller;
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
            $programacao = new Programacao($ordemProducao,($i+1), $roteiros[$i], $recurso);
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
            return redirect()->action('OrdemProducaoController@edit', ['id' => $unidade->getId()])->with('success', 'Ordem de Produção Cancelada com Sucesso !!!');
        } catch (Exception $ex) {
            return redirect()->action('OrdemProducaoController@edit', ['id' => $unidade->getId()])->with('error', 'Falha Ao Cancelar Ordem de Produção !!!' . $ex->getMessage());
        }
    }

    public function edit($id) {
        $ordemProducao = $this->ordemProducaoDAO->pesquisar($id);
        return view('ordem.editar')->with('ordem', $ordemProducao);
    }

    public function show(Request $request) {
         $page = (int)  $request->input('page');
        if($page!=0){
            $requisicoes = $this->ordemProducaoDAO->listarComPaginacao(10,$page);
        }else{
            $requisicoes = $this->ordemProducaoDAO->listarComPaginacao();
        }
        return view('ordem.lista')->with('ordens', $requisicoes);
    }

    public function delete(Request $request){
        $setor = $this->ordemProducaoDAO->pesquisar($request->input('id'));

       try{
             $this->ordemProducaoDAO->remover($setor);
             return redirect()->action('OrdemProducaoController@show')->with('success', 'Ordem de Produção Excluída com Sucesso !!!');
        } catch (Exception $ex) {
             return redirect()->action('OrdemProducaoController@show')->with('error', 'Não foi possível excluir, Ordem de Produção já Iniciada');
        }
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
