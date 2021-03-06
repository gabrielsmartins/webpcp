<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

use App\DAO\MaterialDAO;
use App\DAO\OperacaoDAO;
use App\DAO\ProdutoDAO;
use App\DAO\UnidadeMedidaDAO;
use App\Entities\ItemEstrutura;
use App\Entities\Produto;
use App\Entities\Roteiro;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use function mb_strtoupper;
use function redirect;
use function response;
use function view;

class ProdutoController extends Controller {

    private $unidadeDAO;
    private $materialDAO;
    private $produtoDAO;
    private $operacaoDAO;

    public function __construct() {
        $this->unidadeDAO = new UnidadeMedidaDAO();
        $this->materialDAO = new MaterialDAO();
        $this->produtoDAO = new ProdutoDAO();
        $this->operacaoDAO = new OperacaoDAO();
    }

    public function form() {
        $unidades = $this->unidadeDAO->listar();
        $materiais = $this->materialDAO->listar();
        $produtos = $this->produtoDAO->listar();
        $operacoes = $this->operacaoDAO->listar();

        $data = array('unidades' => $unidades, 'materiais' => $materiais, 'produtos' => $produtos, 'operacoes' => $operacoes);
        return view('produto.cadastro')->with($data);
    }

    public function store(Request $request) {
        $codigoInterno = mb_strtoupper($request->input('codigoInterno'), 'UTF-8');
        $descricao = mb_strtoupper($request->input('descricao'), 'UTF-8');
        $situacao = $request->input('situacao');
        $unidadeMedida = $this->unidadeDAO->pesquisar($request->input('unidadeMedida'));
        $valorUnitario = $request->input('valorUnitario');
        $leadTime = $request->input('leadTime');
        $quantidadeEstoque = $request->input('quantidadeEstoque');
        $quantidadeMinima = $request->input('quantidadeMinima');
        $peso = $request->input('peso');
        $comprimento = $request->input('comprimento');
        $largura = $request->input('largura');
        $altura = $request->input('altura');

        $produto = new Produto($descricao, $unidadeMedida, $valorUnitario, $leadTime, $quantidadeEstoque, $quantidadeMinima);

        $produto->setCodigoInterno($codigoInterno);
        $produto->setSituacao($situacao);
        $produto->setPeso($peso);
        $produto->setComprimento($comprimento);
        $produto->setLargura($largura);
        $produto->setAltura($altura);

        $componentes = $request->input('item');
        $operacoes = $request->input('operacao');


        if ($operacoes == null || $componentes = null) {
            return redirect('produto/form')->with('error', 'Estrutura ou Roteiro Não Informados')->withInput();
        }

        foreach ($componentes as $comp) {
            list($idComp, $quantidade, $tipo) = explode(';', $comp);

            if ($tipo == 'material') {
                $componente = $this->materialDAO->pesquisar($idComp);
            } else {
                $componente = $this->produtoDAO->pesquisar($idComp);
            }

            $itemEstrutura = new ItemEstrutura($produto, $componente, $quantidade);
            $produto->adicionarComponente($itemEstrutura);
        }


        $sequencia = 0;
        foreach ($operacoes as $oper) {
            $sequencia++;
            list($idOper, $tempoSetup, $tempoProducao, $tempoFinalizacao) = explode(';', $oper);
            $operacao = $this->operacaoDAO->pesquisar($idOper);
            $roteiro = new Roteiro($produto, $sequencia, $operacao, $tempoSetup, $tempoProducao, $tempoFinalizacao);
            $produto->adicionarRoteiro($roteiro);
        }



        try {
            $this->produtoDAO->salvar($produto);
            return redirect('produto/form')->with('success', 'Produto Salvo com Sucesso !!!');
        } catch (Exception $ex) {
            return redirect('produto/form')->with('error', 'Produto Já Cadastrado !!!' . $ex->getMessage())->withInput();
        }
    }

    public function update(Request $request) {
        $id = $request->input('id');
        $codigoInterno = mb_strtoupper($request->input('codigoInterno'), 'UTF-8');
        $descricao = mb_strtoupper($request->input('descricao'), 'UTF-8');
        $situacao = $request->input('situacao');
        $unidadeMedida = $this->unidadeDAO->pesquisar($request->input('unidadeMedida'));
        $valorUnitario = $request->input('valorUnitario');
        $leadTime = $request->input('leadTime');
        $quantidadeEstoque = $request->input('quantidadeEstoque');
        $quantidadeMinima = $request->input('quantidadeMinima');
        $peso = $request->input('peso');
        $comprimento = $request->input('comprimento');
        $largura = $request->input('largura');
        $altura = $request->input('altura');

        $produto = $this->produtoDAO->pesquisar($id);

        $produto->setDescricao($descricao);
        $produto->setUnidadeMedida($unidadeMedida);
        $produto->setCodigoInterno($codigoInterno);
        $produto->setSituacao($situacao);
        $produto->setValorUnitario($valorUnitario);
        $produto->setPeso($peso);
        $produto->setComprimento($comprimento);
        $produto->setLargura($largura);
        $produto->setAltura($altura);
        $produto->setLeadTime($leadTime);
        $produto->setQuantidadeEstoque($quantidadeEstoque);
        $produto->setQuantidadeMinima($quantidadeMinima);

        $produto->getItens()->clear();
        $produto->getRoteiros()->clear();

        $this->produtoDAO->alterar($produto);

        $componentes = $request->input('item');
        $operacoes = $request->input('operacao');



        if ($operacoes == null || $componentes = null) {
            return redirect()->action('ProdutoController@edit', ['id' => $produto->getId()])->with('error', 'Estrutura ou Roteiro Não Informados')->withInput();
        }



        if (is_array($componentes) || is_object($componentes)) {
            foreach ($componentes as $comp) {
                list($idComp, $quantidade, $tipo) = explode(';', $comp);

                if ($tipo == 'material') {
                    $componente = $this->materialDAO->pesquisar($idComp);
                } else {
                    $componente = $this->produtoDAO->pesquisar($idComp);
                }
                $itemEstrutura = new ItemEstrutura($produto, $componente, $quantidade);
                $produto->adicionarComponente($itemEstrutura);
            }
        }


        $sequencia = 0;
        if (is_array($componentes) || is_object($componentes)) {
            foreach ($operacoes as $oper) {
                $sequencia++;
                list($idOper, $tempoSetup, $tempoProducao, $tempoFinalizacao) = explode(';', $oper);
                $operacao = $this->operacaoDAO->pesquisar($idOper);

                $roteiro = new Roteiro($produto, $sequencia, $operacao, $tempoSetup, $tempoProducao, $tempoFinalizacao);
                $produto->adicionarRoteiro($roteiro);
            }
        }


        try {
            $this->produtoDAO->alterar($produto);
            return redirect()->action('ProdutoController@edit', ['id' => $produto->getId()])->with('success', 'Produto Alterado com Sucesso !!!');
        } catch (Exception $ex) {
            return redirect()->action('ProdutoController@edit', ['id' => $produto->getId()])->with('error', 'Falha Ao Alterar Produto !!!' . $ex->getMessage());
        }
    }

    public function edit($id) {
        $produto = $this->produtoDAO->pesquisar($id);
        $unidades = $this->unidadeDAO->listar();
        $materiais = $this->materialDAO->listar();
        $produtos = $this->produtoDAO->listar();
        $operacoes = $this->operacaoDAO->listar();

        $data = array('unidades' => $unidades, 'materiais' => $materiais, 'produtos' => $produtos, 'operacoes' => $operacoes, 'produto' => $produto);
        return view('produto.editar')->with($data);
    }

    public function show(Request $request) {
        $page = (int) $request->input('page');
        if ($page != 0) {
            $materiais = $this->produtoDAO->listarComPaginacao(10, $page);
        } else {
            $materiais = $this->produtoDAO->listarComPaginacao();
        }
        return view('produto.lista')->with('produtos', $materiais);
    }

    public function delete(Request $request) {
        $material = $this->produtoDAO->pesquisar($request->input('id'));

        try {
            $this->produtoDAO->remover($material);
            return redirect()->action('ProdutoController@show')->with('success', 'Produto Excluído com Sucesso !!!');
        } catch (Exception $ex) {
            return redirect()->action('ProdutoController@show')->with('error', 'Falha Ao Excluir Produto. Produto já está sendo utilizado');
        }
    }

    public function pesquisarPorCriterio(Request $request) {
        $criterio = $request->input('criterio');
        $valor = $request->input('valor');
        $limit = (int) $request->input('limit');
        $page = (int) $request->input('page');
        $produtos = $this->produtoDAO->pesquisarPorCriterio($criterio, $valor, $limit, $page);

        $data = array('produtos' => $produtos, 'criterio' => $criterio, 'valor' => $valor, 'limit' => $limit, 'page' => $page);
        return view('produto.lista')->with($data);
    }

    public function searchComponente(Request $request) {
        $id = $request->input('id');
        $tipo = $request->input('tipo');
        if ($tipo == 'material') {
            $componente = $this->materialDAO->pesquisar($id);
        } else {
            $componente = $this->produtoDAO->pesquisar($id);
        }
        return response()->json($componente);
    }

    public function searchOperacao(Request $request) {
        $id = $request->input('id');
        $operacao = $this->operacaoDAO->pesquisar($id);
        return response()->json($operacao);
    }

}
