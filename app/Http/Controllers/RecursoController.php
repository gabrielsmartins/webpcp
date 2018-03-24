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
        $descricao = $request->input('descricao');
       $setor = $this->setorDAO->pesquisar($request->input('setor'));
        
        $recurso = new Recurso($descricao, $setor);

        try{
             $this->recursoDAO->salvar($recurso);
             return redirect('recurso/form')->with('success', 'Recurso Salvo com Sucesso !!!');
        } catch (Exception $ex) {
              return redirect('recurso/form')->with('error', 'Recurso Já Cadastrado !!!');
        }
    }
    
    
    public function update(Request $request) {
        $id = $request->input('id');
        $descricao = $request->input('descricao');
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
    
    
    public function show(){
        $recursos = $this->recursoDAO->listar();
        return view('recurso.lista')->with('recursos', $recursos);
    }
    
    

}
