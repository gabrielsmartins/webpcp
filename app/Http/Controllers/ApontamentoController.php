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
use App\Entities\Apontamento;
use App\Entities\ApontamentoTipo;
use DateTime;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
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

    public function form($op, $seq) {
        $ordem = $this->ordemProducaoDAO->pesquisar($op);

        $programacao = $ordem->getProgramacoes()->get($seq-1);
        $data = array('programacao' => $programacao);
        return view('apontamento.cadastro')->with($data);
    }

    public function store(Request $request) {
        $ordem = $request->input('op');
        $sequencia = $request->input('seq');
        $debitaEstoque = $request->input('debitaEstoque') == "true" ? true : false;

        switch ($request->input('tipo')) {
            case 'PRODUCAO':
                $tipo = ApontamentoTipo::PRODUCAO;
                break;

            case 'MANUTENCAO':
                $tipo = ApontamentoTipo::MANUTENCAO;
                break;

            case 'PARADA':
                $tipo = ApontamentoTipo::PARADA;
                break;

            case 'DESCARTE':
                $tipo = ApontamentoTipo::DESCARTE;
                break;
        }

        $quantidade = $request->input('quantidade');

        $dataInicio =  new DateTime(date('Y-m-d H:i:s', strtotime(str_replace("/", "-", $request->input('dataInicio')))));
        $dataFim = new DateTime(date('Y-m-d H:i:s', strtotime(str_replace("/", "-", $request->input('dataFim')))));
        $programacao = $this->ordemProducaoDAO->pesquisar($ordem)->getProgramacoes()->get($sequencia-1);
        $apontamento = new Apontamento($programacao, $tipo, $quantidade, $dataInicio, $dataFim,$debitaEstoque);


        try {
            $this->apontamentoDAO->salvar($apontamento);
            return redirect()->action('ApontamentoController@form', ['op' => $ordem, 'seq' => $sequencia])->with('success', 'Apontamento de Produção nº Registrado com Sucesso !!!');
        } catch (Exception $ex) {
            return redirect()->action('ApontamentoController@form', ['op' => $ordem, 'seq' => $sequencia])->with('error', 'Erro ao Registrar Apontamento de Produção ' . $ex->getMessage())->withInput();
        }
    }

    public function edit($id) {
        $apontamento = $this->apontamentoDAO->pesquisar($id);
        return view('apontamento.editar')->with('apontamento', $apontamento);
    }

    public function find(Request $request) {
        $ordemProducao = $this->ordemProducaoDAO->pesquisar($request->input('id'));
        $data = array('ordem' => $ordemProducao);
        return view('apontamento.cadastro')->with($data);
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
        $apontamentos = $this->apontamentoDAO->pesquisarPorCriterio($criterio, $valor);
        return view('apontamento.lista')->with('apontamentos', $apontamentos);
    }

}
