<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

use App\DAO\OrdemProducaoDAO;
use App\DAO\ProdutoDAO;
use App\DAO\UsuarioDAO;
use App\Entities\ItemRetirada;
use App\Entities\OrdemProducao;
use App\Entities\UnidadeMedida;
use DateTime;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use function redirect;
use function response;
use function view;

/**
 * Description of OrdemProducaoController
 *
 * @author HOME-PC
 */
class OrdemProducaoController extends Controller {
   
    
    private $ordemProducaoDAO;
    private $produtoDAO;
    private $usuarioDAO;
    
    public function __construct() {
        $this->ordemProducaoDAO = new OrdemProducaoDAO();
        $this->produtoDAO = new ProdutoDAO();
        $this->usuarioDAO = new UsuarioDAO();
    }

    public function form() {
        $produtos = $this->produtoDAO->listar();
        $data = array('produtos' => $produtos);
        return view('ordem.cadastro')->with($data);
    }
    

    public function store(Request $request) {
        $produto = $this->produtoDAO->pesquisar($request->input('produto'));
        $quantidade = $request->input('quantidade');
        $prazo = new DateTime(date( 'Y-m-d',  strtotime(str_replace("/", "-",$request->input('prazo')))));
        $responsavel = $this->usuarioDAO->pesquisar(Session::get('idUsuarioLogado'));

       
        $ordemProducao = new OrdemProducao($produto, $quantidade, $prazo, $responsavel);
     

        try{
             $this->ordemProducaoDAO->salvar($ordemProducao);
             return redirect('ordem/form')->with('success', 'Ordem de Produção nº' . $ordemProducao->getId() . ' Registrada com Sucesso !!!');
        } catch (Exception $ex) {
              return redirect('ordem/form')->with('error', 'Erro ao Emitir Ordem de Produção ' . $ex->getMessage());
        }
    }
    
    
    public function cancel(Request $request) {
        $id = $request->input('id');
        $descricao = $request->input('descricao');
        $sigla = $request->input('sigla');

        $unidade = new UnidadeMedida($descricao, $sigla);
        $unidade->setId($id);

        try{
             $this->ordemProducaoDAO->alterar($unidade);
             return redirect()->action('RetiradaProdutoController@edit', ['id' => $unidade->getId()])->with('success', 'Ordem de Produção Cancelada com Sucesso !!!');
        } catch (Exception $ex) {
             return redirect()->action('RetiradaProdutoController@edit', ['id' => $unidade->getId()])->with('error', 'Falha Ao Cancelar Ordem de Produção !!!' . $ex->getMessage());
        }
    }
    
    public function edit($id){
        $ordemProducao = $this->ordemProducaoDAO->pesquisar($id);
        return view('ordem.editar')->with('ordem', $ordemProducao);
    }
    
    
    public function show(){
        $ordens = $this->ordemProducaoDAO->listar();
        return view('ordem.lista')->with('ordens', $ordens);
    }
    
    
    public function searchProduto(Request $request) {
        $id = $request->input('id');

        $produto = $this->produtoDAO->pesquisar($id);
        
        return response()->json($produto);
    }
    
    public function pesquisarPorCriterio(Request $request){
        $criterio = $request->input('criterio');
        $valor = $request->input('valor');
        $ordens = $this->ordemProducaoDAO->pesquisarPorCriterio($criterio, $valor);
        return view('ordem.lista')->with('ordens', $ordens);
    }
    
    public function importarRoteiro(Request $request){
        $produto = $this->produtoDAO->pesquisar($request->input('id'));
        
         return response()->json($produto);
    }
}
