<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

use App\DAO\ProdutoDAO;
use App\DAO\RetiradaProdutoDAO;
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

class RetiradaProdutoController extends Controller {
    
    private $retiradaDAO;
    private $produtoDAO;
    private $usuarioDAO;
    
    public function __construct() {
        $this->retiradaDAO = new RetiradaProdutoDAO();
        $this->produtoDAO = new ProdutoDAO();
        $this->usuarioDAO = new UsuarioDAO();
    }

    public function form() {
        $produtos = $this->produtoDAO->listar();
        $data = array('produtos' => $produtos);
        return view('retirada.cadastro')->with($data);
    }
    

    public function store(Request $request) {
        $dataRetirada = new DateTime(date( 'Y-m-d',  strtotime(str_replace("/", "-",$request->input('dataRetirada')) )));
        $responsavel = $this->usuarioDAO->pesquisar(Session::get('idUsuarioLogado'));
        $itens = $request->input('item');
        
     
        
        $retirada = new RetiradaProduto($responsavel);
        $retirada->setData($dataRetirada);
        
        foreach ($itens as $item) {
           list($idProduto, $quantidade) = explode(';', $item);
           $produto = $this->produtoDAO->pesquisar($idProduto);
           $itemRetirada = new ItemRetirada($retirada, $produto, $quantidade);
           $retirada->adicionarItem($itemRetirada);
        }
        

        try{
             $this->retiradaDAO->salvar($retirada);
             return redirect('retirada/form')->with('success', 'Retirada de Produto nº' . $retirada->getId() . ' Registrada com Sucesso !!!');
        } catch (Exception $ex) {
              return redirect('retirada/form')->with('error', 'Erro ao Registrar Retirada do Estoque ' . $ex->getMessage())->withInput();
        }
    }
    
    
    public function cancel(Request $request) {
        $id = $request->input('id');
        $descricao = $request->input('descricao');
        $sigla = $request->input('sigla');

        $unidade = new UnidadeMedida($descricao, $sigla);
        $unidade->setId($id);

        try{
             $this->retiradaDAO->alterar($unidade);
             return redirect()->action('RetiradaProdutoController@edit', ['id' => $unidade->getId()])->with('success', 'Unidade Alterada com Sucesso !!!');
        } catch (Exception $ex) {
             return redirect()->action('RetiradaProdutoController@edit', ['id' => $unidade->getId()])->with('error', 'Falha Ao Alterar Unidade !!!' . $ex->getMessage());
        }
    }
    
    public function edit($id){
        $retirada = $this->retiradaDAO->pesquisar($id);
        return view('retirada.editar')->with('retirada', $retirada);
    }
    
    
    public function show(Request $request){
        $page = (int)  $request->input('page');
        if($page!=0){
            $retiradas = $this->retiradaDAO->listarComPaginacao(10,$page);
        }else{
            $retiradas = $this->retiradaDAO->listarComPaginacao();
        }
        return view('retirada.lista')->with('retiradas', $retiradas);
    }
    
    
    public function searchProduto(Request $request) {
        $id = $request->input('id');

        $produto = $this->produtoDAO->pesquisar($id);
        
        return response()->json($produto);
    }
    
    public function pesquisarPorCriterio(Request $request){
        $criterio = $request->input('criterio');
        $valor = $request->input('valor');
        $unidades = $this->retiradaDAO->pesquisarPorCriterio($criterio, $valor);
        return view('unidade.lista')->with('unidades', $unidades);
    }
    
    

}
