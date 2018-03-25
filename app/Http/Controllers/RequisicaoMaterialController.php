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
use App\Entities\UnidadeMedida;
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
        $id = $request->input('id');
        $descricao = $request->input('descricao');
        $sigla = $request->input('sigla');

        $unidade = new UnidadeMedida($descricao, $sigla);
        $unidade->setId($id);

        try{
             $this->requisicaoDAO->alterar($unidade);
             return redirect()->action('RequisicaoMaterialController@edit', ['id' => $unidade->getId()])->with('success', 'Unidade Alterada com Sucesso !!!');
        } catch (Exception $ex) {
             return redirect()->action('RequisicaoMaterialController@edit', ['id' => $unidade->getId()])->with('error', 'Falha Ao Alterar Unidade !!!' . $ex->getMessage());
        }
    }
    
    public function edit($id){
        $unidade = $this->requisicaoDAO->pesquisar($id);
        return view('unidade.editar')->with('unidade', $unidade);
    }
    
    
    public function show(){
        $requisicoes = $this->requisicaoDAO->listar();
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
