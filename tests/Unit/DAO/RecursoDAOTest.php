<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Tests\Unit;

use App\DAO\RecursoDAO;
use App\DAO\SetorDAO;
use App\Entities\Recurso;
use App\Entities\Setor;
use LaravelDoctrine\ORM\Facades\EntityManager;
use Tests\TestCase;

/**
 * Description of PerfilTest
 *
 * @author HOME-PC
 */
class RecursoDAOTest extends TestCase {

    public static function reset() {
        $sql = "SET FOREIGN_KEY_CHECKS = 0;
                                    TRUNCATE TABLE recurso;
                                    TRUNCATE TABLE setor;
                                    SET FOREIGN_KEY_CHECKS = 1;";
        EntityManager::getConnection()->prepare($sql)->execute();
    }

    public function testInserirRecurso() {
        self::reset();
        $setorDAO = new SetorDAO();
        $recursoDAO = new RecursoDAO();
        $setor = new Setor("ESTAMPARIA");
        $setorDAO->salvar($setor);
        $recurso = new Recurso("PRENSA", $setor);
        $this->assertNotNull($recursoDAO->salvar($recurso));
    }

    public function testAlterarRecurso() {
        self::reset();
        $setorDAO = new SetorDAO();
        $recursoDAO = new RecursoDAO();
        $setor = new Setor("PINTURA");
        $setorDAO->salvar($setor);
        $recurso = new Recurso("OPERADOR 1", $setor);
        $recursoDAO->salvar($recurso);
        $alterado = new Recurso("OPERADOR 1", $setor);
        $alterado->setId($recurso->getId());
        $this->assertNotNull($recursoDAO->alterar($alterado));
    }

    public function testRemoverRecurso() {
        self::reset();
        $setorDAO = new SetorDAO();
        $recursoDAO = new RecursoDAO();
        $setor = new Setor("AJUSTAGEM");
        $setorDAO->salvar($setor);
        $recurso = new Recurso("FURADEIRA VERTICAL", $setor);
        $recursoDAO->salvar($recurso);
        $recursoDAO->remover($recurso);
    }

    public function testListarRecurso() {
        $setorDAO = new SetorDAO();
        $recursoDAO = new RecursoDAO();

        $setor = new Setor("USINAGEM");
        $setorDAO->salvar($setor);

        $recurso = new Recurso("TORNO VERTICAL", $setor);
        $recursoDAO->salvar($recurso);

        $recursos = $recursoDAO->listar();
        $this->assertNotNull($recursos);
    }

    public static function tearDownAfterClass() {
        parent::tearDownAfterClass();
    }

}
