<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="usuario")
 */
class Usuario {
  
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer",name="usr_id")
     */
    private $id;
    
     /**
     * @ORM\Column(type="string",name="usr_nome")
     */
    private $nome;
    
     /**
     * @ORM\Column(type="string",name="usr_login")
     */
    private $login;
    
     /**
     * @ORM\Column(type="string",name="usr_pwd")
     */
    private $senha;
    
    
     /**
     *@ORM\ManyToOne(targetEntity="Perfil")
     *@ORM\JoinColumn(name="usr_perf_id", referencedColumnName="perf_id")
     */
    private $perfil;
    
    function __construct($nome, $login, $senha, $perfil) {
        $this->nome = $nome;
        $this->login = $login;
        $this->senha = $senha;
        $this->perfil = $perfil;
    }

    
    function getId() {
        return $this->id;
    }

    function getNome() {
        return $this->nome;
    }

    function getLogin() {
        return $this->login;
    }

    function getSenha() {
        return $this->senha;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setLogin($login) {
        $this->login = $login;
    }

    function setSenha($senha) {
        $this->senha = $senha;
    }
    function getPerfil() {
        return $this->perfil;
    }
    

    function setPerfil($perfil) {
        $this->perfil = $perfil;
    }





}
