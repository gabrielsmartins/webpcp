<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

use App\DAO\UnidadeMedidaDAO;
use App\Entities\UnidadeMedida;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use function redirect;
use function view;

class UnidadeMedidaController extends Controller {
    
    private $unidadeDAO;
    
    public function __construct() {
        $this->unidadeDAO = new UnidadeMedidaDAO();
    }

    public function form() {
        return view('unidade.cadastro');
    }
    

    public function store(Request $request) {
        $descricao = strtoupper($request->input('descricao'));
        $sigla = strtoupper($request->input('sigla'));

        $unidade = new UnidadeMedida($descricao, $sigla);

        try{
             $this->unidadeDAO->salvar($unidade);
             return redirect('unidade/form')->with('success', 'Unidade Salva com Sucesso !!!');
        } catch (Exception $ex) {
              return redirect('unidade/form')->with('error', 'Unidade Já Cadastrada !!!')->withInput();
        }
    }
    
    
    public function update(Request $request) {
        $id = $request->input('id');
        $descricao = strtoupper($request->input('descricao'));
        $sigla = strtoupper($request->input('sigla'));

        $unidade = new UnidadeMedida($descricao, $sigla);
        $unidade->setId($id);

        try{
             $this->unidadeDAO->alterar($unidade);
             return redirect()->action('UnidadeMedidaController@edit', ['id' => $unidade->getId()])->with('success', 'Unidade Alterada com Sucesso !!!');
        } catch (Exception $ex) {
             return redirect()->action('UnidadeMedidaController@edit', ['id' => $unidade->getId()])->with('error', 'Falha Ao Alterar Unidade !!!' . $ex->getMessage());
        }
    }
    
    public function edit($id){
        $unidade = $this->unidadeDAO->pesquisar($id);
        return view('unidade.editar')->with('unidade', $unidade);
    }
    
    
    public function show(Request $request){
        $page = (int)  $request->input('page');
        if($page!=0){
            $unidades = $this->unidadeDAO->listarComPaginacao(10,$page);
        }else{
            $unidades = $this->unidadeDAO->listarComPaginacao();
        }
        
        return view('unidade.lista')->with('unidades', $unidades);
    }
    
    public function delete(Request $request){
        $unidade = $this->unidadeDAO->pesquisar($request->input('id'));

       try{
             $this->unidadeDAO->remover($unidade);
             return redirect()->action('UnidadeMedidaController@show')->with('success', 'Unidade de Medida Excluída com Sucesso !!!');
        } catch (Exception $ex) {
             return redirect()->action('UnidadeMedidaController@show')->with('error', 'Falha Ao Excluir Unidade de Medida. Unidade já é utilizada por algum Produto ou Material');
        }
    }
    
    public function pesquisarPorCriterio(Request $request){
        $criterio = $request->input('criterio');
        $valor = $request->input('valor');
        $limit = (int) $request->input('limit');
        $page = (int) $request->input('page');
        $unidades = $this->unidadeDAO->pesquisarPorCriterio($criterio,$valor,$limit,$page);
        
        $data = array('unidades'=>$unidades,'criterio'=>$criterio,'valor'=>$valor,'limit'=>$limit,'page'=>$page);
        return view('unidade.lista')->with($data);
    }
    
    

}
