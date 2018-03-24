<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Tests\Unit;

use App\DAO\MaterialDAO;
use App\DAO\UnidadeMedidaDAO;
use App\Entities\Material;
use App\Entities\UnidadeMedida;
use LaravelDoctrine\ORM\Facades\EntityManager;
use Tests\TestCase;

/**
 * Description of PerfilTest
 *
 * @author HOME-PC
 */
class MaterialDAOTest extends TestCase {

    public static function reset() {
        $sql = "SET FOREIGN_KEY_CHECKS = 0;
                                    TRUNCATE TABLE estrutura_produto;
                                     TRUNCATE TABLE produto;
                                    TRUNCATE TABLE unidade;
                                    SET FOREIGN_KEY_CHECKS = 1;";
        EntityManager::getConnection()->prepare($sql)->execute();
    }

    public function testInserirMaterial() {
        self::reset();
        $unidadeMedidaDAO = new UnidadeMedidaDAO();
        $materialDAO = new MaterialDAO();
        
        $unidadeMedida = new UnidadeMedida("UNIDADE", "UN");
        $unidadeMedidaDAO->salvar($unidadeMedida);
        $material = new Material("CHAPA ACO INOX #20",$unidadeMedida, 75.00, 5, 100.00, 85.00);
        
	$material->setCodigoInterno("CHI-50");
	$material->setPeso(0.2);
	$material->setAltura(0.2);
	$material->setComprimento(200.00);
	$material->setLargura(200.00);
	$this->assertNotNull($materialDAO->salvar($material));
    }

    public function testAlterarMaterial() {
        self::reset();
        $unidadeMedidaDAO = new UnidadeMedidaDAO();
        $materialDAO = new MaterialDAO();
        
        $unidadeMedida = new UnidadeMedida("UNIDADE", "UN");
        $unidadeMedidaDAO->salvar($unidadeMedida);
        
        $material = new Material("CHAPA ACO INOX #18",$unidadeMedida, 65.00, 7, 75.00, 55.00);
	$material->setPeso(0.35);
	$material->setAltura(0.2);
        $material->setComprimento(300.00);
	$material->setLargura(250.00);
	$materialDAO->salvar($material);
		
	$materialAlterado = new Material("CHAPA ACO INOX #10",$unidadeMedida, 95.00, 3, 15.00, 5.00);
	$materialAlterado->setPeso(0.3);
	$materialAlterado->setAltura(0.2);
	$materialAlterado->setComprimento(350.00);
	$materialAlterado->setLargura(150.00);

	$materialAlterado->setId($material->getId());
	$this->assertNotNull($materialDAO->alterar($materialAlterado));
    }

    public function testRemoverMaterial() {
        self::reset();
        $unidadeMedidaDAO = new UnidadeMedidaDAO();
        $materialDAO = new MaterialDAO();
        
        $unidadeMedida = new UnidadeMedida("UNIDADE", "UN");
        $unidadeMedidaDAO->salvar($unidadeMedida);
        
         $material = new Material("PARAFUSO 3/8 \"\" x 100mm",$unidadeMedida, 95.00, 3, 15.00, 5.00);
	 $materialDAO->salvar($material);
	 $materialDAO->remover($material);
    }
    
    public function testPesquisarMaterial() {
        self::reset();
        $unidadeMedidaDAO = new UnidadeMedidaDAO();
        $materialDAO = new MaterialDAO();
        
        $unidadeMedida = new UnidadeMedida("UNIDADE", "UN");
        $unidadeMedidaDAO->salvar($unidadeMedida);
        
         $material = new Material("PARAFUSO 1/2 \"\" x 50mm",$unidadeMedida, 95.00, 3, 15.00, 10.00);
	 $materialDAO->salvar($material);
	 $encontrado = $materialDAO->pesquisar($material->getId());
         $this->assertNotNull($encontrado);
    }

    public function testListarMaterial() {
        self::reset();
        $unidadeMedidaDAO = new UnidadeMedidaDAO();
        $materialDAO = new MaterialDAO();
        
        $unidadeMedida = new UnidadeMedida("UNIDADE", "UN");
        $unidadeMedidaDAO->salvar($unidadeMedida);
        
         $material = new Material("PARAFUSO 3/8 \"\" x 100mm",$unidadeMedida, 95.00, 3, 15.00, 5.00);
	 $materialDAO->salvar($material);
        $materiais = $materialDAO->listar();
        $this->assertNotNull($materiais);
    }

    public static function tearDownAfterClass() {
        parent::tearDownAfterClass();
    }

}
