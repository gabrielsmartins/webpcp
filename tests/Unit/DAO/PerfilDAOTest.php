<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Tests\Unit;

use App\DAO\PerfilDAO;
use App\Entities\Perfil;
use LaravelDoctrine\ORM\Facades\EntityManager;
use Tests\TestCase;


/**
 * Description of PerfilTest
 *
 * @author HOME-PC
 */
class PerfilDAOTest extends TestCase {
    

    public static function reset(){
         $sql = "SET FOREIGN_KEY_CHECKS = 0;
                                    TRUNCATE TABLE perfil;
                                    SET FOREIGN_KEY_CHECKS = 1;";
        EntityManager::getConnection()->prepare($sql)->execute();
    }

   
    public function testInserirPerfil() {
       self::reset();
       $perfilDAO = new PerfilDAO();
       $perfil = new Perfil("ENGENHARIA");
       $this->assertNotNull($perfilDAO->salvar($perfil));
       
    }

    public function testAlterarPerfil() {
        self::reset();
        $perfilDAO = new PerfilDAO();
        $perfil = new Perfil("ALMOXARIFADO");
        $this->assertNotNull($perfilDAO->salvar($perfil));
        $alterado = new Perfil("PRODUCAO");
        $alterado->setId($perfil->getId());
        $this->assertNotNull($perfilDAO->alterar($alterado));
    }

    public function testRemoverPerfil() {
        self::reset();
        $perfil = new Perfil("GERENTE PCP");
        $perfilDAO = new PerfilDAO();
        $perfilDAO->salvar($perfil);
        $perfilDAO->remover($perfil);
    }
    
    public function testPesquisarPerfil() {
        self::reset();
        $perfil = new Perfil("PRODUÇÃO");
        $perfilDAO = new PerfilDAO();
        $perfilDAO->salvar($perfil);
        $encontrado = $perfilDAO->pesquisar($perfil->getId());
        $this->assertNotNull($encontrado);
    }

    public function testListarPerfil() {
        $perfilDAO = new PerfilDAO();
        $perfil = new Perfil("PCP");
        $perfilDAO->salvar($perfil);
        $perfis = $perfilDAO->listar();
        $this->assertNotNull($perfis);
    }

   
    public static function tearDownAfterClass() {
        parent::tearDownAfterClass();
    }

}
