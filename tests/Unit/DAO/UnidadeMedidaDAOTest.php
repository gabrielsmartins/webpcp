<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Tests\Unit;

use App\DAO\UnidadeMedidaDAO;
use App\Entities\UnidadeMedida;
use LaravelDoctrine\ORM\Facades\EntityManager;
use Tests\TestCase;


/**
 * Description of PerfilTest
 *
 * @author HOME-PC
 */
class UnidadeMedidaDAOTest extends TestCase {
    

    public static function reset(){
         $sql = "SET FOREIGN_KEY_CHECKS = 0;
                                    TRUNCATE TABLE unidade;
                                    SET FOREIGN_KEY_CHECKS = 1;";
        EntityManager::getConnection()->prepare($sql)->execute();
    }

   
    public function testInserirUnidadeMedida() {
       self::reset();
       $unidadeDAO = new UnidadeMedidaDAO();
       $unidade = new UnidadeMedida("UNIDADE", "UN");
       $this->assertNotNull($unidadeDAO->salvar($unidade));
       
    }

    public function testAlterarUnidade() {
        self::reset();
        $unidadeDAO = new UnidadeMedidaDAO();
        $unidade = new UnidadeMedida("CAIXA", "CX");
        $this->assertNotNull($unidadeDAO->salvar($unidade));
        $alterado = new UnidadeMedida("FARDO", "FD");
        $alterado->setId($unidade->getId());
        $this->assertNotNull($unidadeDAO->alterar($alterado));
    }

    public function testRemoverUnidade() {
        self::reset();
        $unidadeDAO = new UnidadeMedidaDAO();
        $unidade = new UnidadeMedida("LITRO", "L");
        $unidadeDAO->salvar($unidade);
        $unidadeDAO->remover($unidade);
    }
    
     public function testPesquisarUnidade() {
        self::reset();
        $unidadeDAO = new UnidadeMedidaDAO();
        $unidade = new UnidadeMedida("METRO", "M");
        $unidadeDAO->salvar($unidade);
        $encontrada = $unidadeDAO->pesquisar($unidade->getId());
        $this->assertNotNull($encontrada);
    }

    public function testListarUnidade() {
        $unidadeDAO = new UnidadeMedidaDAO();
        $unidade = new UnidadeMedida("QUILOGRAMA", "KG");
        $unidadeDAO->salvar($unidade);
        $unidades = $unidadeDAO->listar();
        $this->assertNotNull($unidades);
    }

   
    public static function tearDownAfterClass() {
        parent::tearDownAfterClass();
    }

}
