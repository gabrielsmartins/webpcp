<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

use App\DAO\MaterialDAO;
use App\DAO\RequisicaoMaterialDAO;
use App\DAO\UsuarioDAO;
use App\Entities\ItemRequisicao;
use App\Entities\RequisicaoMaterial;
use App\Entities\StatusRequisicaoMaterial;
use App\Http\Controllers\Controller;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use function redirect;
use function response;
use function view;

class RequisicaoMaterialController extends Controller {
    
    private $requisicaoDAO;
    private $materialDAO;
    private $usuarioDAO;
    
    public function __construct() {
        $this->requisicaoDAO = new RequisicaoMaterialDAO();
        $this->materialDAO = new MaterialDAO();
        $this->usuarioDAO = new UsuarioDAO();
    }

    public function form() {
        $materiais = $this->materialDAO->listar();
        $data = array('materiais' => $materiais);
        return view('requisicao.cadastro')->with($data);
    }
    

    public function store(Request $request) {
        $prazo = new DateTime(date( 'Y-m-d',  strtotime(str_replace("/", "-",$request->input('prazo')) )));
        $responsavel = $this->usuarioDAO->pesquisar(Session::get('idUsuarioLogado'));
        $itens = $request->input('item');
        
     
        
        $requisicao = new RequisicaoMaterial($prazo, $responsavel);
        
        foreach ($itens as $item) {
           list($idMaterial, $quantidade) = explode(';', $item);
           $material = $this->materialDAO->pesquisar($idMaterial);
           $itemRequisicao = new ItemRequisicao($requisicao, $material, $quantidade);
           $requisicao->adicionarItem($itemRequisicao);
        }
        

        try{
             $this->requisicaoDAO->salvar($requisicao);
             return redirect('requisicao/form')->with('success', 'Requisição de Material nº' . $requisicao->getId() . ' Emitida com Sucesso !!!');
        } catch (Exception $ex) {
              return redirect('requisicao/form')->with('error', 'Erro ao Emitir Requisicao ' . $ex->getMessage());
        }
    }
    
    
    public function cancel(Request $request) {
        $requisicao = $this->requisicaoDAO->pesquisar($request->input('id'));
        $requisicao->setStatus(StatusRequisicaoMaterial::CANCELADA);

        try{
             $this->requisicaoDAO->alterar($requisicao);
             return redirect()->action('RequisicaoMaterialController@edit', ['id' => $requisicao->getId()])->with('success', 'Requisição de Material Cancelada com Sucesso !!!');
        } catch (Exception $ex) {
             return redirect()->action('RequisicaoMaterialController@edit', ['id' => $requisicao->getId()])->with('error', 'Falha Ao Cancelar Requisição de Material !!!' . $ex->getMessage());
        }
    }
    
    public function edit($id){
        $requisicao = $this->requisicaoDAO->pesquisar($id);
        return view('requisicao.editar')->with('requisicao', $requisicao);
    }
    

    
    public function show(Request $request){
        $page = (int)  $request->input('page');
        if($page!=0){
            $requisicoes = $this->requisicaoDAO->listarComPaginacao(10,$page);
        }else{
            $requisicoes = $this->requisicaoDAO->listarComPaginacao();
        }
        return view('requisicao.lista')->with('requisicoes', $requisicoes);
    }
    
    
    public function searchMaterial(Request $request) {
        $id = $request->input('id');

        $material = $this->materialDAO->pesquisar($id);
        
        return response()->json($material);
    }
    
    public function pesquisarPorCriterio(Request $request){
        $criterio = $request->input('criterio');
        $valor = $request->input('valor');
        $unidades = $this->requisicaoDAO->pesquisarPorCriterio($criterio, $valor);
        return view('unidade.lista')->with('unidades', $unidades);
    }
    
    

}
