<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
/**
 * @ORM\Entity
 * @ORM\Table(name="recurso")
 */
class Recurso implements JsonSerializable {
    
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer",name="recr_id")
     */
    private $id;
    
    /**
     * @ORM\Column(type="string",name="recr_desc")
     */
    private $descricao;
    
    /**
     *@ORM\ManyToOne(targetEntity="Setor", inversedBy="recursos")
     *@ORM\JoinColumn(name="recr_setr_id", referencedColumnName="setr_id")
     */
    private $setor;
    
    
    function __construct($descricao, $setor) {
        $this->descricao = $descricao;
        $this->setor = $setor;
    }

    
    function getId() {
        return $this->id;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function getSetor() {
        return $this->setor;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function setSetor($setor) {
        $this->setor = $setor;
    }

    public function jsonSerialize() {
        return array(
            'id' => $this->id,
            'descricao' => $this->descricao,
            'setorID' => $this->setor->getId(),
            'setor' => $this->setor->getDescricao(),
        );
    }

}
