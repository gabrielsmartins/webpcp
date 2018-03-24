<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

use App\DAO\MaterialDAO;
use App\DAO\UnidadeMedidaDAO;
use App\Entities\Material;
use App\Entities\Operacao;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use function redirect;
use function view;

class MaterialController extends Controller {
    

    private $unidadeDAO;
    private $materialDAO;
    
    
    public function __construct() {
        $this->unidadeDAO = new UnidadeMedidaDAO();
        $this->materialDAO = new MaterialDAO();
    }

    public function form() {
        $unidades = $this->unidadeDAO->listar();
        return view('material.cadastro')->with('unidades',$unidades);
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
     
        $material = new Material($descricao, $unidadeMedida, $valorUnitario, $leadTime, $quantidadeEstoque, $quantidadeMinima);
        
        $material->setCodigoInterno($codigoInterno);
        $material->setSituacao($situacao);
        $material->setPeso($peso);
        $material->setComprimento($comprimento);
        $material->setLargura($largura);
        $material->setAltura($altura);
        
        try{
             $this->materialDAO->salvar($material);
             return redirect('material/form')->with('success', 'Material Salvo com Sucesso !!!');
        } catch (Exception $ex) {
              return redirect('material/form')->with('error', 'Material Já Cadastrado !!!');
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
        
        $material = new Material($descricao, $unidadeMedida, $valorUnitario, $leadTime, $quantidadeEstoque, $quantidadeMinima);
        
        $material->setId($id);
        $material->setCodigoInterno($codigoInterno);
        $material->setSituacao($situacao);
        $material->setPeso($peso);
        $material->setComprimento($comprimento);
        $material->setLargura($largura);
        $material->setAltura($altura);
        
        try{
             $this->materialDAO->alterar($material);
             return redirect()->action('MaterialController@edit', ['id' => $material->getId()])->with('success', 'Material Alterado com Sucesso !!!');
        } catch (Exception $ex) {
             return redirect()->action('MaterialController@edit', ['id' => $material->getId()])->with('error', 'Falha Ao Alterar Material !!!' . $ex->getMessage());
        }
    }
    
    public function edit($id){
        $unidades = $this->unidadeDAO->listar();
        $material = $this->materialDAO->pesquisar($id);
        $data = array('unidades' =>$unidades,'material' =>$material);
        return view('material.editar')->with($data);
    }
    
    
    public function show(){
        $materiais = $this->materialDAO->listar();
        return view('material.lista')->with('materiais', $materiais);
    }
    
    

}
