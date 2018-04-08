<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

use App\DAO\RecebimentoMaterialDAO;
use App\DAO\RequisicaoMaterialDAO;
use App\DAO\UsuarioDAO;
use App\Entities\ItemRetirada;
use App\Entities\RetiradaProduto;
use App\Entities\UnidadeMedida;
use App\Http\Controllers\Controller;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use function redirect;
use function response;
use function view;

class RecebimentoMaterialController extends Controller {
    
    private $recebimentoDAO;
    private $requisicaoDAO;
    private $materialDAO;
    private $usuarioDAO;
    
    public function __construct() {
        $this->recebimentoDAO = new RecebimentoMaterialDAO();
         $this->requisicaoDAO = new RequisicaoMaterialDAO();
        $this->materialDAO = new MaterialDAO();
        $this->usuarioDAO = new UsuarioDAO();
    }

    public function form() {
        $produtos = $this->materialDAO->listar();
        $data = array('requisicoes' => $produtos);
        return view('recebimento.cadastro')->with($data);
    }
    

    public function store(Request $request) {
        $dataRetirada = new DateTime(date( 'Y-m-d',  strtotime(str_replace("/", "-",$request->input('dataRetirada')) )));
        $responsavel = $this->usuarioDAO->pesquisar(Session::get('idUsuarioLogado'));
        $itens = $request->input('item');
        
     
        
        $retirada = new RetiradaProduto($responsavel);
        $retirada->setData($dataRetirada);
        
        foreach ($itens as $item) {
           list($idProduto, $quantidade) = explode(';', $item);
           $produto = $this->materialDAO->pesquisar($idProduto);
           $itemRetirada = new ItemRetirada($retirada, $produto, $quantidade);
           $retirada->adicionarItem($itemRetirada);
        }
        

        try{
             $this->recebimentoDAO->salvar($retirada);
             return redirect('retirada/form')->with('success', 'Retirada de Produto nº' . $retirada->getId() . ' Registrada com Sucesso !!!');
        } catch (Exception $ex) {
              return redirect('retirada/form')->with('error', 'Erro ao Registrar Retirada do Estoque ' . $ex->getMessage());
        }
    }
    
    
    public function cancel(Request $request) {
        $id = $request->input('id');
        $descricao = $request->input('descricao');
        $sigla = $request->input('sigla');

        $unidade = new UnidadeMedida($descricao, $sigla);
        $unidade->setId($id);

        try{
             $this->recebimentoDAO->alterar($unidade);
             return redirect()->action('RetiradaProdutoController@edit', ['id' => $unidade->getId()])->with('success', 'Unidade Alterada com Sucesso !!!');
        } catch (Exception $ex) {
             return redirect()->action('RetiradaProdutoController@edit', ['id' => $unidade->getId()])->with('error', 'Falha Ao Alterar Unidade !!!' . $ex->getMessage());
        }
    }
    
    public function edit($id){
        $unidade = $this->recebimentoDAO->pesquisar($id);
        return view('unidade.editar')->with('unidade', $unidade);
    }
    
    
    public function show(){
        $retiradas = $this->recebimentoDAO->listar();
        return view('retirada.lista')->with('retiradas', $retiradas);
    }
    
    
    public function searchProduto(Request $request) {
        $id = $request->input('id');

        $produto = $this->materialDAO->pesquisar($id);
        
        return response()->json($produto);
    }
    
    public function pesquisarPorCriterio(Request $request){
        $criterio = $request->input('criterio');
        $valor = $request->input('valor');
        $unidades = $this->recebimentoDAO->pesquisarPorCriterio($criterio, $valor);
        return view('unidade.lista')->with('unidades', $unidades);
    }
    
    

}
