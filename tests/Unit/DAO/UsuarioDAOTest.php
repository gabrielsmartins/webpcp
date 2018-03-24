<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Tests\Unit;

use App\DAO\PerfilDAO;
use App\DAO\UsuarioDAO;
use App\Entities\Perfil;
use App\Entities\Usuario;
use LaravelDoctrine\ORM\Facades\EntityManager;
use Tests\TestCase;


/**
 * Description of PerfilTest
 *
 * @author HOME-PC
 */
class UsuarioDAOTest extends TestCase {
    

    public static function reset(){
         $sql = "SET FOREIGN_KEY_CHECKS = 0;
                                    TRUNCATE TABLE usuario;
                                    TRUNCATE TABLE perfil;
                                    SET FOREIGN_KEY_CHECKS = 1;";
        EntityManager::getConnection()->prepare($sql)->execute();
    }

   
    public function testInserirUsuario() {
       self::reset();
       $perfilDAO = new PerfilDAO();
       $usuarioDAO = new UsuarioDAO();
       $perfil = new Perfil("ENGENHARIA");
       $this->assertNotNull($perfilDAO->salvar($perfil));
       $usuario = new Usuario("Usuario 1", "user1", "12345",$perfil);
       $this->assertNotNull($usuarioDAO->salvar($usuario));
       
    }

    public function testAlterarUsuario() {
        self::reset();
        $perfilDAO = new PerfilDAO();
        $usuarioDAO = new UsuarioDAO();
        $perfil = new Perfil("ALMOXARIFADO");
        $this->assertNotNull($perfilDAO->salvar($perfil));
        $usuario = new Usuario("Usuario 2", "user2", "12345",$perfil);
        $this->assertNotNull($usuarioDAO->salvar($usuario));
        
        $alterado =  new Usuario("Usuario 3", "user3", "12345",$perfil);
        $alterado->setId($usuario->getId());
        $this->assertNotNull($usuarioDAO->alterar($alterado));
    }

    public function testRemoverUsuario() {
        self::reset();
        $perfilDAO = new PerfilDAO();
        $usuarioDAO = new UsuarioDAO();
        $perfil = new Perfil("GERENTE PCP");
        $perfilDAO->salvar($perfil);
        $usuario = new Usuario("Usuario 4", "user4", "12345",$perfil);
        $usuarioDAO->salvar($usuario);
        $usuarioDAO->remover($usuario);
    }
    
    public function testPesquisarUsuario() {
        self::reset();
        $perfilDAO = new PerfilDAO();
        $usuarioDAO = new UsuarioDAO();
        $perfil = new Perfil("GERENTE PCP");
        $perfilDAO->salvar($perfil);
        $usuario = new Usuario("Usuario 4", "user4", "12345",$perfil);
        $usuarioDAO->salvar($usuario);
        $encontrado = $usuarioDAO->pesquisar($usuario->getId());
        $this->assertNotNull($encontrado);
    }

    public function testListarUsuario() {
        $perfilDAO = new PerfilDAO();
        $usuarioDAO = new UsuarioDAO();
        $perfil = new Perfil("PCP");
        $perfilDAO->salvar($perfil);
        $usuario = new Usuario("Usuario 5", "user5", "12345",$perfil);
        $usuarioDAO->salvar($usuario);
        $usuarios = $usuarioDAO->listar();
        $this->assertNotNull($usuarios);
    }

   
    public static function tearDownAfterClass() {
        parent::tearDownAfterClass();
    }

}
