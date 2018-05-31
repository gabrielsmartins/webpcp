<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

use App\DAO\MaterialDAO;
use App\DAO\ProdutoDAO;
use App\DAO\RecebimentoMaterialDAO;
use App\DAO\RequisicaoMaterialDAO;
use App\DAO\UsuarioDAO;
use App\Entities\ItemRecebimento;
use App\Entities\RecebimentoMaterial;
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
    private $produtoDAO;
    private $usuarioDAO;
    
    public function __construct() {
        $this->recebimentoDAO = new RecebimentoMaterialDAO();
        $this->requisicaoDAO = new RequisicaoMaterialDAO();
        $this->materialDAO = new MaterialDAO();
        $this->produtoDAO = new ProdutoDAO();
        $this->usuarioDAO = new UsuarioDAO();
    }

    public function form() {
        $requisicoes = $this->requisicaoDAO->listar();
        return view('recebimento.cadastro')->with('requisicoes',$requisicoes);
    }
    

    public function store(Request $request) {
        $dataRecebimento = new DateTime(date( 'Y-m-d',  strtotime(str_replace("/", "-",$request->input('dataRetirada')) )));
        $responsavel = $this->usuarioDAO->pesquisar(Session::get('idUsuarioLogado'));
        $itens = $request->input('itens');
        

        
        $recebimento = new RecebimentoMaterial($responsavel);
        $recebimento->setData($dataRecebimento);
        

        foreach ($itens as $item) {
           list($idRequisicao,$reqItem, $quantidade) = explode(';', $item);
           $requisicao = $this->requisicaoDAO->pesquisar($idRequisicao);
           $key = explode(".",$reqItem);
           
           $itemRequisicao = $requisicao->getItens()->get(($key[1]-1));
           
  
           $itemRecebimento = new ItemRecebimento($recebimento, $itemRequisicao, $quantidade);
           $recebimento->adicionarItem($itemRecebimento);
        }
        

        try{
             $this->recebimentoDAO->salvar($recebimento);
             return redirect('recebimento/form')->with('success', 'Recebimento de Material nº' . $recebimento->getId() . ' Registrado com Sucesso !!!');
        } catch (Exception $ex) {
              return redirect('recebimento/form')->with('error', 'Erro ao Registrar Recebimento de Material ' . $ex->getMessage())->withInput();
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
    
    
    public function show(Request $request){
         $page = (int)  $request->input('page');
        if($page!=0){
            $recebimentos = $this->recebimentoDAO->listarComPaginacao(10,$page);
        }else{
            $recebimentos = $this->recebimentoDAO->listarComPaginacao();
        }
        return view('recebimento.lista')->with('recebimentos', $recebimentos);
        

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
