<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

use App\DAO\RecursoDAO;
use App\DAO\SetorDAO;
use App\Entities\Recurso;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use function mb_strtoupper;
use function redirect;
use function view;

class RecursoController extends Controller {
    
    private $setorDAO;
    private $recursoDAO;
    
    public function __construct() {
        $this->setorDAO = new SetorDAO();
        $this->recursoDAO = new RecursoDAO();
    }

    public function form() {
        $setores = $this->setorDAO->listar();
        return view('recurso.cadastro')->with('setores',$setores);
    }
    

    public function store(Request $request) {
        $descricao = mb_strtoupper($request->input('descricao'),'UTF-8');
       $setor = $this->setorDAO->pesquisar($request->input('setor'));
        
        $recurso = new Recurso($descricao, $setor);

        try{
             $this->recursoDAO->salvar($recurso);
             return redirect('recurso/form')->with('success', 'Recurso Salvo com Sucesso !!!');
        } catch (Exception $ex) {
              return redirect('recurso/form')->with('error', 'Recurso Já Cadastrado !!!')->withInput();
        }
    }
    
    
    public function update(Request $request) {
        $id = $request->input('id');
        $descricao = mb_strtoupper($request->input('descricao'),'UTF-8');
        $setor = $this->setorDAO->pesquisar($request->input('setor'));
        
        $recurso = new Recurso($descricao, $setor);
        $recurso->setId($id);

        try{
             $this->recursoDAO->alterar($recurso);
             return redirect()->action('RecursoController@edit', ['id' => $recurso->getId()])->with('success', 'Recurso Alterado com Sucesso !!!');
        } catch (Exception $ex) {
             return redirect()->action('RecursoController@edit', ['id' => $recurso->getId()])->with('error', 'Falha Ao Alterar Recurso !!!' . $ex->getMessage());
        }
    }
    
    public function edit($id){
         $setores = $this->setorDAO->listar();
        $recurso = $this->recursoDAO->pesquisar($id);
        $data = array('setores' =>$setores,'recurso' =>$recurso);
        return view('recurso.editar')->with($data);
    }
    
    
    public function show(Request $request){
        $page = (int)  $request->input('page');
        if($page!=0){
            $recursos = $this->recursoDAO->listarComPaginacao(10,$page);
        }else{
            $recursos = $this->recursoDAO->listarComPaginacao();
        }
        return view('recurso.lista')->with('recursos', $recursos);
    }
    
    
    public function delete(Request $request){
        $recurso = $this->recursoDAO->pesquisar($request->input('id'));

       try{
             $this->recursoDAO->remover($recurso);
             return redirect()->action('RecursoController@show')->with('success', 'Recurso Excluído com Sucesso !!!');
        } catch (Exception $ex) {
             return redirect()->action('RecursoController@show')->with('error', 'Falha Ao Excluir Recurso. Recurso já é utilizado por algum Roteiro de Fabricação');
        }
    }
    
    public function pesquisarPorCriterio(Request $request){
        $criterio = $request->input('criterio');
        $valor = $request->input('valor');
        $limit = (int) $request->input('limit');
        $page = (int) $request->input('page');
        $recursos = $this->recursoDAO->pesquisarPorCriterio($criterio,$valor,$limit,$page);
        
        $data = array('recursos'=>$recursos,'criterio'=>$criterio,'valor'=>$valor,'limit'=>$limit,'page'=>$page);
        return view('recurso.lista')->with($data);
    }
    
    

}
