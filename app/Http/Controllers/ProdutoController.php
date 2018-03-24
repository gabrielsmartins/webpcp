<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

use App\DAO\MaterialDAO;
use App\DAO\OperacaoDAO;
use App\DAO\ProdutoDAO;
use App\DAO\UnidadeMedidaDAO;
use App\Entities\ItemEstrutura;
use App\Entities\Produto;
use App\Entities\Roteiro;
use App\Http\Controllers\Controller;
use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use Illuminate\Http\Request;
use function redirect;
use function response;
use function view;

class ProdutoController extends Controller {
    

    private $unidadeDAO;
    private $materialDAO;
    private $produtoDAO;
    private $operacaoDAO;
    
    
    public function __construct() {
        $this->unidadeDAO = new UnidadeMedidaDAO();
        $this->materialDAO = new MaterialDAO();
        $this->produtoDAO = new ProdutoDAO();
        $this->operacaoDAO = new OperacaoDAO();
    }

    public function form() {
        $unidades = $this->unidadeDAO->listar();
        $materiais = $this->materialDAO->listar();
        $produtos = $this->produtoDAO->listar();
        $operacoes = $this->operacaoDAO->listar();
        
        $data = array('unidades'=>$unidades,'materiais'=>$materiais,'produtos'=>$produtos,'operacoes'=>$operacoes);
        return view('produto.cadastro')->with($data);
    }
    

    public function store(Request $request) {
        $codigoInterno = $request->input('codigoInterno');
        $descricao = $request->input('descricao');
        $situacao = $request->input('situacao');
        $unidadeMedida = $this->unidadeDAO->pesquisar($request->input('unidadeMedida'));
        $valorUnitario = $request->input('valorUnitario');
        $leadTime =  $request->input('leadTime');
        $quantidadeEstoque = $request->input('quantidadeEstoque');
        $quantidadeMinima = $request->input('quantidadeMinima');
        $peso = $request->input('peso');
        $comprimento = $request->input('comprimento');
        $largura = $request->input('largura');
        $altura = $request->input('altura');
     
        $produto = new Produto($descricao, $unidadeMedida, $valorUnitario, $leadTime, $quantidadeEstoque, $quantidadeMinima);
        
        $produto->setCodigoInterno($codigoInterno);
        $produto->setSituacao($situacao);
        $produto->setPeso($peso);
        $produto->setComprimento($comprimento);
        $produto->setLargura($largura);
        $produto->setAltura($altura);
        
        $componentes = $request->input('item');
        $operacoes = $request->input('operacao');
        
        foreach ($componentes as $comp){
            list($idComp,$quantidade,$tipo) = explode(';',$comp);
            
            if($tipo == 'material'){
                $componente = $this->materialDAO->pesquisar($idComp);
            }else{
                 $componente = $this->produtoDAO->pesquisar($idComp);
            }
            
            $itemEstrutura = new ItemEstrutura($produto, $componente, $quantidade);
            $produto->adicionarComponente($itemEstrutura);
        }
        
        
        $sequencia = 0;
        foreach($operacoes as $oper){
            $sequencia++;
            list($idOper,$tempoSetup,$tempoProducao,$tempoFinalizacao) = explode(';',$oper);
            $operacao = $this->operacaoDAO->pesquisar($idOper);
            $roteiro = new Roteiro($produto, $sequencia, $operacao, $tempoSetup, $tempoProducao, $tempoFinalizacao);
            $produto->adicionarRoteiro($roteiro);
        }
        
        try{
             $this->produtoDAO->salvar($produto);
             return redirect('produto/form')->with('success', 'Produto Salvo com Sucesso !!!');
        } catch (Exception $ex) {
              return redirect('produto/form')->with('error', 'Produto Já Cadastrado !!!' . $ex->getMessage());
        }
    }
    
    
    public function update(Request $request) {
        $id = $request->input('id');
        $codigoInterno = $request->input('codigoInterno');
        $descricao = $request->input('descricao');
        $situacao = $request->input('situacao');
        $unidadeMedida = $this->unidadeDAO->pesquisar($request->input('unidadeMedida'));
        $valorUnitario = $request->input('valorUnitario');
        $leadTime =  $request->input('leadTime');
        $quantidadeEstoque = $request->input('quantidadeEstoque');
        $quantidadeMinima = $request->input('quantidadeMinima');
        $peso = $request->input('peso');
        $comprimento = $request->input('comprimento');
        $largura = $request->input('largura');
        $altura = $request->input('altura');
        
        $produto = $this->produtoDAO->pesquisar($id);
        
        $produto->setId($id);
        $produto->setDescricao($descricao);
        $produto->setUnidadeMedida($unidadeMedida);
        $produto->setCodigoInterno($codigoInterno);
        $produto->setSituacao($situacao);
        $produto->setValorUnitario($valorUnitario);
        $produto->setPeso($peso);
        $produto->setComprimento($comprimento);
        $produto->setLargura($largura);
        $produto->setAltura($altura);
        $produto->setLeadTime($leadTime);
        $produto->setQuantidadeEstoque($quantidadeEstoque);
        $produto->setQuantidadeMinima($quantidadeMinima);
        
        $produto->setItens(new ArrayCollection());
        $produto->setRoteiros(new ArrayCollection());
        
        
        
        $componentes = $request->input('item');
        $operacoes = $request->input('operacao');
        
   
        
        foreach ($componentes as $comp){
            list($idComp,$quantidade,$tipo) = explode(';',$comp);
            
            if($tipo == 'material'){
                $componente = $this->materialDAO->pesquisar($idComp);
            }else{
                 $componente = $this->produtoDAO->pesquisar($idComp);
            }
            
            $itemEstrutura = new ItemEstrutura($produto, $componente, $quantidade);
            $produto->adicionarComponente($itemEstrutura);
        }
        
        
       $sequencia = 0;
        foreach($operacoes as $oper){
            $sequencia++;
            list($idOper,$tempoSetup,$tempoProducao,$tempoFinalizacao) = explode(';',$oper);
            $operacao = $this->operacaoDAO->pesquisar($idOper);
            $roteiro = new Roteiro($produto, $sequencia, $operacao, $tempoSetup, $tempoProducao, $tempoFinalizacao);
            $produto->adicionarRoteiro($roteiro);
        }
        
        
        try{
             $this->produtoDAO->alterar($produto);
             return redirect()->action('ProdutoController@edit', ['id' => $produto->getId()])->with('success', 'Produto Alterado com Sucesso !!!');
        } catch (Exception $ex) {
             return redirect()->action('ProdutoController@edit', ['id' => $produto->getId()])->with('error', 'Falha Ao Alterar Produto !!!' . $ex->getMessage());
        }
    }
    
    public function edit($id){
        $produto = $this->produtoDAO->pesquisar($id);
         $unidades = $this->unidadeDAO->listar();
        $materiais = $this->materialDAO->listar();
        $produtos = $this->produtoDAO->listar();
        $operacoes = $this->operacaoDAO->listar();
        
        $data = array('unidades'=>$unidades,'materiais'=>$materiais,'produtos'=>$produtos,'operacoes'=>$operacoes,'produto'=>$produto);
        return view('produto.editar')->with($data);
    }
    
    
    public function show(){
        $produtos = $this->produtoDAO->listar();
        return view('produto.lista')->with('produtos', $produtos);
    }
    
    public function searchComponente(Request $request){
        $id = $request->input('id');
        $tipo = $request->input('tipo');
        if($tipo =='material'){
            $componente = $this->materialDAO->pesquisar($id);
        }else{
            $componente = $this->produtoDAO->pesquisar($id);
        }
        return response()->json($componente);
    }
    
    public function searchOperacao(Request $request){
        $id = $request->input('id');
        $operacao = $this->operacaoDAO->pesquisar($id);
        return response()->json($operacao);
    }
    

    
    

}
