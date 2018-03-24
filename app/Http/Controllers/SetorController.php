<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

use App\DAO\SetorDAO;
use App\Entities\Setor;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use function redirect;
use function view;

class SetorController extends Controller {
    
    private $setorDAO;
    
    public function __construct() {
        $this->setorDAO = new SetorDAO();
    }

    public function form() {
        return view('setor.cadastro');
    }
    

    public function store(Request $request) {
        $descricao = $request->input('descricao');

        $setor = new Setor($descricao);

        try{
             $this->setorDAO->salvar($setor);
             return redirect('setor/form')->with('success', 'Setor Salvo com Sucesso !!!');
        } catch (Exception $ex) {
              return redirect('setor/form')->with('error', 'Setor Já Cadastrado !!!');
        }
    }
    
    
    public function update(Request $request) {
        $id = $request->input('id');
        $descricao = $request->input('descricao');

        $setor = new Setor($descricao);
        $setor->setId($id);

        try{
             $this->setorDAO->alterar($setor);
             return redirect()->action('SetorController@edit', ['id' => $setor->getId()])->with('success', 'Setor Alterado com Sucesso !!!');
        } catch (Exception $ex) {
             return redirect()->action('SetorController@edit', ['id' => $setor->getId()])->with('error', 'Falha Ao Alterar Setor !!!' . $ex->getMessage());
        }
    }
    
    public function edit($id){
        $setor = $this->setorDAO->pesquisar($id);
        return view('setor.editar')->with('setor', $setor);
    }
    
    
    public function show(){
        $setores = $this->setorDAO->listar();
        return view('setor.lista')->with('setores', $setores);
    }
    
     public function pesquisarPorCriterio(Request $request){
        $criterio = $request->input('criterio');
        $valor = $request->input('valor');
        $setores = $this->setorDAO->pesquisarPorCriterio($criterio, $valor);
        return view('setor.lista')->with('setores', $setores);
    }

}
