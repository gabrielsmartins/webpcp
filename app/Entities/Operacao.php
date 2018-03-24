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
 * @ORM\Table(name="operacao")
 */
class Operacao implements JsonSerializable {
    
     /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer",name="oper_id")
     */
    private $id;
    
    
    /**
     * @ORM\Column(type="string",name="oper_desc")
     */
    private $descricao;
    
    
    
    /**
     * @ORM\Column(type="string",name="oper_instr")
     */
    private $instrucao;
    
    
    /**
     *@ORM\ManyToOne(targetEntity="Setor", inversedBy="operacoes")
     *@ORM\JoinColumn(name="oper_setr_id", referencedColumnName="setr_id")
     */
    private $setor;
    
    
    function __construct($descricao, $instrucao, $setor) {
        $this->descricao = $descricao;
        $this->instrucao = $instrucao;
        $this->setor = $setor;
    }

    
    function getId() {
        return $this->id;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function getInstrucao() {
        return $this->instrucao;
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

    function setInstrucao($instrucao) {
        $this->instrucao = $instrucao;
    }

    function setSetor($setor) {
        $this->setor = $setor;
    }

    public function jsonSerialize() {
        
        return array(
            'id' => $this->id,
            'descricao' =>$this->descricao,
            'setor' =>$this->setor->getDescricao(),
            'instrucao' =>$this->instrucao,
        );
        
    }

}
