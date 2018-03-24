<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Tests\Unit;

use App\DAO\SetorDAO;
use App\Entities\Setor;
use LaravelDoctrine\ORM\Facades\EntityManager;
use Tests\TestCase;

/**
 * Description of PerfilTest
 *
 * @author HOME-PC
 */
class SetorDAOTest extends TestCase {

    public static function reset() {
        $sql = "SET FOREIGN_KEY_CHECKS = 0;
                                    TRUNCATE TABLE setor;
                                    SET FOREIGN_KEY_CHECKS = 1;";
        EntityManager::getConnection()->prepare($sql)->execute();
    }

    public function testInserirSetor() {
        self::reset();
        $setorDAO = new SetorDAO();
        $setor = new Setor("USINAGEM");
        $this->assertNotNull($setorDAO->salvar($setor));
    }

    public function testAlterarSetor() {
        self::reset();
        $setorDAO = new SetorDAO();
        $setor = new Setor("CORTE");
        $this->assertNotNull($setorDAO->salvar($setor));
        $alterado = new Setor("CORTE");
        $alterado->setId($setor->getId());
        $this->assertNotNull($setorDAO->alterar($alterado));
    }

    public function testRemoverSetor() {
        self::reset();
        $setorDAO = new SetorDAO();
        $setor = new Setor("MONTAGEM");
        $setorDAO->salvar($setor);
        $setorDAO->remover($setor);
    }
    
    
    public function testPesquisarSetor() {
        self::reset();
        $setorDAO = new SetorDAO();
        $setor = new Setor("USINAGEM");
        $setorDAO->salvar($setor);
        $encontrado = $setorDAO->pesquisar($setor->getId());
        $this->assertNotNull($encontrado);
    }

    public function testListarSetor() {
        $setorDAO = new SetorDAO();
        $setor = new Setor("ESTAMPARIA");
        $setorDAO->salvar($setor);
        $setores = $setorDAO->listar();
        $this->assertNotNull($setores);
    }

    public static function tearDownAfterClass() {
        parent::tearDownAfterClass();
    }

}
