<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Tests\Unit;

use App\DAO\OperacaoDAO;
use App\DAO\SetorDAO;
use App\Entities\Operacao;
use App\Entities\Setor;
use LaravelDoctrine\ORM\Facades\EntityManager;
use Tests\TestCase;

/**
 * Description of PerfilTest
 *
 * @author HOME-PC
 */
class OperacaoDAOTest extends TestCase {

    public static function reset() {
        $sql = "SET FOREIGN_KEY_CHECKS = 0;
                                    TRUNCATE TABLE operacao;
                                    TRUNCATE TABLE setor;
                                    SET FOREIGN_KEY_CHECKS = 1;";
        EntityManager::getConnection()->prepare($sql)->execute();
    }

    public function testInserirOperacao() {
        self::reset();
        $setorDAO = new SetorDAO();
        $operacaoDAO = new OperacaoDAO();
        $setor = new Setor("USINAGEM");
        $setorDAO->salvar($setor);
        $operacao = new Operacao("TORNEAR", "TORNEAR NO COMPRIMENTO", $setor);
        $this->assertNotNull($operacaoDAO->salvar($operacao));
    }

    public function testAlterarOperacao() {
        self::reset();
        $setorDAO = new SetorDAO();
        $operacaoDAO = new OperacaoDAO();
        $setor = new Setor("CORTE");
        $setorDAO->salvar($setor);
        $operacao = new Operacao("CORTAR", "CORTAR NA MEDIDA", $setor);
        $operacaoDAO->salvar($operacao);
        $alterado = new Operacao("CORTE PERSONALIZADO", "CORTAR LATERAIS", $setor);
        $alterado->setId($setor->getId());
        $this->assertNotNull($operacaoDAO->alterar($alterado));
    }

    public function testRemoverRecurso() {
        self::reset();
        $setorDAO = new SetorDAO();
        $operacaoDAO = new OperacaoDAO();
        $setor = new Setor("MONTAGEM");
        $setorDAO->salvar($setor);
        $operacao = new Operacao("MONTAR", "MONTAR CONFORME DESENHO", $setor);
        $operacaoDAO->salvar($operacao);
        $operacaoDAO->remover($operacao);
    }
    
    
    public function testPesquisasrRecurso() {
        self::reset();
        $setorDAO = new SetorDAO();
        $operacaoDAO = new OperacaoDAO();
        $setor = new Setor("ESTAMPARIA");
        $setorDAO->salvar($setor);
        $operacao = new Operacao("DOBRAR", "DOBRAR CONFORME DESENHO", $setor);
        $operacaoDAO->salvar($operacao);
        $encontrado = $operacaoDAO->pesquisar($operacao->getId());
        $this->assertNotNull($encontrado);
    }

    public function testListarRecurso() {
        $setorDAO = new SetorDAO();
        $operacaoDAO = new OperacaoDAO();

        $setor = new Setor("USINAGEM");
        $setorDAO->salvar($setor);

        $operacao = new Operacao("TORNEAR", "TORNEAR CONFORME DESENHO", $setor);
        $operacaoDAO->salvar($operacao);

        $operacoes = $operacaoDAO->listar();
        $this->assertNotNull($operacoes);
    }

    public static function tearDownAfterClass() {
        parent::tearDownAfterClass();
    }

}
