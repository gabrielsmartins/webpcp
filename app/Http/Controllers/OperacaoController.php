<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

use App\DAO\OperacaoDAO;
use App\DAO\SetorDAO;
use App\Entities\Operacao;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use function redirect;
use function view;

class OperacaoController extends Controller {
    
    private $setorDAO;
    private $operacaoDAO;
    
    public function __construct() {
        $this->setorDAO = new SetorDAO();
        $this->operacaoDAO = new OperacaoDAO();
    }

    public function form() {
        $setores = $this->setorDAO->listar();
        return view('operacao.cadastro')->with('setores',$setores);
    }
    

    public function store(Request $request) {
        $descricao = mb_strtoupper($request->input('descricao'),'UTF-8');
        $instrucao = mb_strtoupper($request->input('instrucao'),'UTF-8');
        $setor = $this->setorDAO->pesquisar($request->input('setor'));
        
        
        $operacao = new Operacao($descricao, $instrucao, $setor);

        try{
             $this->operacaoDAO->salvar($operacao);
             return redirect('operacao/form')->with('success', 'Operação Salva com Sucesso !!!');
        } catch (Exception $ex) {
              return redirect('operacao/form')->with('error', 'Operação Já Cadastrada !!!')->withInput();
        }
    }
    
    
    public function update(Request $request) {
        $id = $request->input('id');
        $instrucao = mb_strtoupper($request->input('instrucao'),'UTF-8');
        $descricao = mb_strtoupper($request->input('descricao'),'UTF-8');
        
        $setor = $this->setorDAO->pesquisar($request->input('setor'));
        
        $operacao = new Operacao($descricao, $instrucao, $setor);
        $operacao->setId($id);

        try{
             $this->operacaoDAO->alterar($operacao);
             return redirect()->action('OperacaoController@edit', ['id' => $operacao->getId()])->with('success', 'Operação Alterada com Sucesso !!!');
        } catch (Exception $ex) {
             return redirect()->action('OperacaoController@edit', ['id' => $operacao->getId()])->with('error', 'Falha Ao Alterar Operação !!!' . $ex->getMessage());
        }
    }
    
    public function edit($id){
        $setores = $this->setorDAO->listar();
        $operacao = $this->operacaoDAO->pesquisar($id);
        $data = array('setores' =>$setores,'operacao' =>$operacao);
        return view('operacao.editar')->with($data);
    }
    
    
     public function show(Request $request){
        $page = (int)  $request->input('page');
        if($page!=0){
            $operacoes = $this->operacaoDAO->listarComPaginacao(10,$page);
        }else{
            $operacoes = $this->operacaoDAO->listarComPaginacao();
        }
        return view('operacao.lista')->with('operacoes', $operacoes);
    }
    
    
    public function delete(Request $request){
        $recurso = $this->operacaoDAO->pesquisar($request->input('id'));

       try{
             $this->operacaoDAO->remover($recurso);
             return redirect()->action('OperacaoController@show')->with('success', 'Operação Excluída com Sucesso !!!');
        } catch (Exception $ex) {
             return redirect()->action('OperacaoController@show')->with('error', 'Falha Ao Excluir Operação. Operação já é utilizado por algum Roteiro de Fabricação');
        }
    }
    
    public function pesquisarPorCriterio(Request $request){
        $criterio = $request->input('criterio');
        $valor = $request->input('valor');
        $limit = (int) $request->input('limit');
        $page = (int) $request->input('page');
        $operacoes = $this->operacaoDAO->pesquisarPorCriterio($criterio,$valor,$limit,$page);
        
        $data = array('operacoes'=>$operacoes,'criterio'=>$criterio,'valor'=>$valor,'limit'=>$limit,'page'=>$page);
        return view('operacao.lista')->with($data);
    }
    
    
    

}
