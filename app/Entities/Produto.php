<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 */
class Produto extends Componente {
    

    /**
     * @ORM\OneToMany(targetEntity="ItemEstrutura", mappedBy="produto",cascade={"persist"})
     */
    private $itens;
    

    /**
     * @ORM\OneToMany(targetEntity="Roteiro", mappedBy="produto",cascade={"persist"})
     */
    private $roteiros;
    
    public function __construct($descricao, $unidadeMedida, $valorUnitario, $leadTime, $quantidadeEstoque, $quantidadeMinima) {
        parent::__construct($descricao, $unidadeMedida, $valorUnitario, $leadTime, $quantidadeEstoque, $quantidadeMinima);
        $this->itens = new ArrayCollection();
        $this->roteiros = new ArrayCollection();
    }
    
       public function adicionarComponente(ItemEstrutura $itemEstrutura) {
		$this->itens->add($itemEstrutura);
	}

        public function removerComponente($key) {
		$this->itens->remove($key);
	}
	
	public function adicionarRoteiro(Roteiro $roteiro) {
		$this->roteiros->add($roteiro);
	}
        
        public function removerRoteiro(Roteiro $roteiro) {
		$this->roteiros->remove($roteiro);
	}
    
    function getItens() {
        return $this->itens;
    }

    function getRoteiros() {
        return $this->roteiros;
    }

    function setItens($estrutura) {
        $this->itens = $estrutura;
    }

    function setRoteiros($roteiros) {
        $this->roteiros = $roteiros;
    }


    
    
   
}
