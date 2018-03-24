<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Model;

use Doctrine\ORM\Mapping AS ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="unidade")
 */
class UnidadeMedida {
    
    
     /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer",name="unid_id")
     */
    private $id;
    
    /**
     * @ORM\Column(type="string",name="unid_desc")
     */
    private $descricao;
    
    
    /**
     * @ORM\Column(type="string",name="unid_sig")
     */
    private $sigla;
    
    
    function __construct($descricao, $sigla) {
        $this->descricao = $descricao;
        $this->sigla = $sigla;
    }

    function getId() {
        return $this->id;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function getSigla() {
        return $this->sigla;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function setSigla($sigla) {
        $this->sigla = $sigla;
    }


  
}
